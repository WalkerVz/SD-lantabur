<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BiayaSpp;
use App\Models\FeatureAccess;
use App\Models\MasterTahunAjaran;
use App\Models\MasterMapel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class SettingsController extends Controller
{
    public function index()
    {
        $tahunAjaranList = MasterTahunAjaran::orderBy('urutan')->orderByDesc('nama')->get();
        $tahunAktif = MasterTahunAjaran::getAktif();
        $mapels = []; // Akan dipindah ke menu baru
        
        // Ambil data Biaya SPP (Fitur Teman)
        $biayaSpp = BiayaSpp::all()->keyBy(fn ($r) => $r->tahun_ajaran . '-' . $r->kelas);

        return view('admin.settings.index', compact('tahunAjaranList', 'tahunAktif', 'biayaSpp'));
    }

    public function accounts()
    {
        $users = User::orderBy('name')->get();
        $roles = [
            'admin' => 'Admin',
            'guru' => 'Guru',
        ];

        return view('admin.settings.accounts', compact('users', 'roles'));
    }

    public function storeAccount(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users,username',
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => 'required|string|in:admin,guru',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => null,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.settings.accounts')->with('success', 'Akun baru berhasil dibuat.');
    }

    public function accessibility()
    {
        $roles = [
            'admin' => 'Admin',
            'guru' => 'Guru',
        ];

        $features = [
            'dashboard' => 'Dashboard',
            'sdm' => 'Manajemen SDM',
            'siswa' => 'Data Siswa',
            'pembayaran' => 'Pembayaran',
            'raport' => 'Raport',
            'mapel' => 'Mata Pelajaran',
            'halaman_depan' => 'Halaman Depan',
            'settings' => 'Pengaturan',
        ];

        $existing = FeatureAccess::all()
            ->groupBy('role')
            ->map(fn ($group) => $group->keyBy('feature'));

        return view('admin.settings.accessibility', compact('roles', 'features', 'existing'));
    }

    public function saveAccessibility(Request $request)
    {
        $roles = ['admin', 'guru'];
        $features = [
            'dashboard',
            'sdm',
            'siswa',
            'pembayaran',
            'raport',
            'mapel',
            'halaman_depan',
            'settings',
        ];

        $rules = $request->input('rules', []);

        foreach ($roles as $role) {
            foreach ($features as $feature) {
                if ($role === 'admin') {
                    FeatureAccess::updateOrCreate(
                        ['role' => $role, 'feature' => $feature],
                        ['allowed' => true]
                    );
                    continue;
                }

                $allowed = (bool) data_get($rules, $role . '.' . $feature, false);
                FeatureAccess::updateOrCreate(
                    ['role' => $role, 'feature' => $feature],
                    ['allowed' => $allowed]
                );
            }
        }

        return redirect()->route('admin.settings.accessibility')->with('success', 'Pengaturan akses berhasil disimpan.');
    }

    public function storeBiayaSpp(Request $request)
    {
        $request->validate([
            'tahun_ajaran' => 'required|string|max:20',
            'kelas' => 'required|integer|in:1,2,3,4,5,6',
            'nominal' => 'required|numeric|min:0',
        ]);

        BiayaSpp::updateOrCreate(
            ['tahun_ajaran' => $request->tahun_ajaran, 'kelas' => $request->kelas],
            ['nominal' => (int) round($request->nominal)]
        );

        return back()->with('success', 'Biaya SPP berhasil disimpan.');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $user->update(['name' => $request->name]);
        return back()->with('success', 'Nama berhasil diubah.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => ['required', 'confirmed', Password::defaults()],
        ], [
            'current_password.current_password' => 'Password saat ini tidak cocok.',
        ]);

        Auth::user()->update(['password' => Hash::make($request->password)]);
        return back()->with('success', 'Password berhasil diubah.');
    }

    public function storeTahunAjaran(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:20|regex:/^\d{2}\/\d{2}$/',
        ], [
            'nama.regex' => 'Format tahun ajaran: XX/XX (contoh: 25/26).',
        ]);

        $exists = MasterTahunAjaran::where('nama', $request->nama)->exists();
        if ($exists) {
            return back()->with('error', 'Tahun ajaran ' . $request->nama . ' sudah ada.');
        }

        $maxUrutan = MasterTahunAjaran::max('urutan') ?? 0;
        MasterTahunAjaran::create([
            'nama' => $request->nama,
            'is_aktif' => MasterTahunAjaran::count() === 0,
            'urutan' => $maxUrutan + 1,
        ]);

        return back()->with('success', 'Tahun ajaran ' . $request->nama . ' berhasil ditambahkan.');
    }


    public function setAktifTahunAjaran(Request $request)
    {
        $request->validate(['id' => 'required|exists:master_tahun_ajaran,id']);

        MasterTahunAjaran::query()->update(['is_aktif' => false]);
        MasterTahunAjaran::where('id', $request->id)->update(['is_aktif' => true]);

        // Clear session agar view otomatis update ke tahun aktif yang baru
        session()->forget('selected_tahun_ajaran');

        return back()->with('success', 'Tahun ajaran aktif berhasil diubah.');
    }
}

