<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BiayaSpp;
use App\Models\FeatureAccess;
use App\Models\MasterTahunAjaran;
use App\Models\MasterMapel;
use App\Models\TahunKelas;
use App\Models\StaffSdm;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class SettingsController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $tahunAjaranList = MasterTahunAjaran::orderBy('urutan')->orderByDesc('nama')->get();
        $tahunAktif = MasterTahunAjaran::getAktif();
        $tahunTerpilih = $request->get('tahun_ajaran');
        $mapels = []; // Akan dipindah ke menu baru
        
        // Ambil data Biaya SPP (Fitur Teman)
        $biayaSpp = BiayaSpp::all()->keyBy(fn ($r) => $r->tahun_ajaran . '-' . $r->kelas);

        $tahunNamaList = $tahunAjaranList->pluck('nama')->filter()->values()->all();
        if (!$tahunTerpilih || !in_array($tahunTerpilih, $tahunNamaList, true)) {
            $tahunTerpilih = $tahunAktif;
        }

        // Ambil data Wali Kelas hanya untuk tahun ajaran yang dipilih
        $waliKelasTahun = TahunKelas::with('waliKelas')
            ->where('tahun_ajaran', $tahunTerpilih)
            ->get()
            ->keyBy(fn ($r) => $r->tahun_ajaran . '-' . $r->kelas);
        $staffList = StaffSdm::orderBy('nama')->get();

        return view('admin.settings.index', compact('tahunAjaranList', 'tahunAktif', 'tahunTerpilih', 'biayaSpp', 'waliKelasTahun', 'staffList'));
    }

    public function accounts()
    {
        $users = User::orderBy('name')->get();
        $roles = [
            'admin' => 'Admin',
            'guru' => 'Guru',
            'bendahara' => 'Bendahara',
            'kepsek' => 'Kepala Sekolah',
        ];

        return view('admin.settings.accounts', compact('users', 'roles'));
    }

    public function storeAccount(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users,username',
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => 'required|string|in:admin,guru,bendahara,kepsek',
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

    public function resetAccountPassword(Request $request, $id)
    {
        $request->validate([
            'reset_password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'password' => Hash::make($request->reset_password),
        ]);

        return redirect()->route('admin.settings.accounts')->with('success', 'Password akun ' . $user->name . ' berhasil direset.');
    }

    public function updateAccount(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'role' => 'required|in:admin,guru,bendahara,kepsek',
        ], [
            'username.unique' => 'Username sudah digunakan oleh akun lain.',
        ]);

        // Prevent changing own role if admin
        if ($user->id === auth()->id() && $request->role !== 'admin' && $user->role === 'admin') {
            return back()->withErrors(['role' => 'Anda tidak bisa mengubah role Anda sendiri dari Admin.']);
        }

        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'role' => $request->role,
        ]);

        return redirect()->route('admin.settings.accounts')->with('success', 'Data akun berhasil diperbarui.');
    }

    public function destroyAccount($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.settings.accounts')->with('success', 'Akun berhasil dihapus.');
    }

    public function accessibility()
    {
        $roles = [
            'admin' => 'Admin',
            'guru' => 'Guru',
            'bendahara' => 'Bendahara',
            'kepsek' => 'Kepala Sekolah',
        ];

        $features = [
            'dashboard' => ['label' => 'Dashboard', 'icon' => 'fas fa-home', 'actions' => ['view' => 'Lihat Dashboard']],
            'sdm' => ['label' => 'Manajemen SDM', 'icon' => 'fas fa-users', 'actions' => [
                'view' => 'Lihat Data SDM', 'create' => 'Tambah SDM', 'edit' => 'Edit SDM', 'delete' => 'Hapus SDM'
            ]],
            'siswa' => ['label' => 'Data Siswa', 'icon' => 'fas fa-user-graduate', 'actions' => [
                'view' => 'Lihat Data Siswa', 'create' => 'Tambah Siswa', 'edit' => 'Edit Siswa', 'delete' => 'Hapus Siswa', 'export' => 'Ekspor/Cetak PDF'
            ]],
            'pembayaran' => ['label' => 'Pembayaran SPP', 'icon' => 'fas fa-wallet', 'actions' => [
                'view' => 'Lihat Riwayat', 'create' => 'Tambah Pembayaran', 'edit' => 'Edit Pembayaran', 'delete' => 'Hapus Pembayaran', 'cetak_kwitansi' => 'Cetak Kwitansi', 'rekap' => 'Rekap PDF'
            ]],
            'raport' => ['label' => 'Raport', 'icon' => 'fas fa-file-contract', 'actions' => [
                'view' => 'Lihat Raport', 'create' => 'Input Nilai/Raport', 'edit' => 'Edit Nilai', 'delete' => 'Hapus Raport', 'cetak' => 'Cetak Raport'
            ]],
            'mapel' => ['label' => 'Mata Pelajaran', 'icon' => 'fas fa-book', 'actions' => [
                'view' => 'Lihat Mapel', 'create' => 'Tambah Mapel', 'edit' => 'Edit Mapel', 'delete' => 'Hapus Mapel'
            ]],
            'halaman_depan' => ['label' => 'Manajemen Halaman Depan', 'icon' => 'fas fa-globe', 'actions' => [
                'view' => 'Akses Menu News/Gallery/Slider/Video'
            ]],
            'settings' => ['label' => 'Pengaturan Basis', 'icon' => 'fas fa-cogs', 'actions' => [
                'view' => 'Akses Pengaturan (Tahun Ajaran, Biaya,dll)', 'accounts' => 'Kelola Akun', 'contact' => 'Pengaturan Kontak', 'accessibility' => 'Aksesibilitas'
            ]],
        ];

        $existing = FeatureAccess::all()
            ->groupBy('role')
            ->map(fn ($group) => $group->keyBy('feature'));

        return view('admin.settings.accessibility', compact('roles', 'features', 'existing'));
    }

    public function saveAccessibility(Request $request)
    {
        $roles = ['admin', 'guru', 'bendahara', 'kepsek'];
        
        $features = [
            'dashboard' => ['view'],
            'sdm' => ['view', 'create', 'edit', 'delete'],
            'siswa' => ['view', 'create', 'edit', 'delete', 'export'],
            'pembayaran' => ['view', 'create', 'edit', 'delete', 'cetak_kwitansi', 'rekap'],
            'raport' => ['view', 'create', 'edit', 'delete', 'cetak'],
            'mapel' => ['view', 'create', 'edit', 'delete'],
            'halaman_depan' => ['view'],
            'settings' => ['view', 'accounts', 'contact', 'accessibility'],
        ];

        $rulesKeyMap = [];
        $rawRules = $request->all();
        // Since input names like rules[guru][dashboard.view] get parsed as arrays, let's flat fetch them
        if (isset($rawRules['rules'])) {
            $rulesKeyMap = $rawRules['rules'];
        }
        
        \Log::info("Rules payload:", $rulesKeyMap);

        foreach ($roles as $role) {
             $roleRules = $rulesKeyMap[$role] ?? [];
             foreach ($features as $menuKey => $actions) {
                foreach ($actions as $action) {
                    $fullKey = $menuKey . '.' . $action;

                    if ($role === 'admin') {
                        FeatureAccess::updateOrCreate(
                            ['role' => $role, 'feature' => $fullKey],
                            ['allowed' => true]
                        );
                        continue;
                    }

                    // Laravel preserves the dots in keys when handling form inputs as nested arrays gracefully depending on how it's sent. Let's check both for safety.
                    $inputKey = $fullKey;
                    $inputKeyUnderscore = str_replace('.', '_', $fullKey);
                    
                    $allowed = !empty($roleRules[$inputKey]) || !empty($roleRules[$inputKeyUnderscore]);
                    
                    FeatureAccess::updateOrCreate(
                        ['role' => $role, 'feature' => $fullKey],
                        ['allowed' => $allowed]
                    );
                }
            }
        }

        FeatureAccess::clearCache();

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

    public function storeWaliKelas(Request $request)
    {
        $request->validate([
            'tahun_ajaran' => 'required|string|max:20',
            'kelas' => 'required|integer|in:1,2,3,4,5,6',
            'wali_kelas_id' => 'nullable|exists:staff_sdm,id',
        ]);

        TahunKelas::updateOrCreate(
            ['tahun_ajaran' => $request->tahun_ajaran, 'kelas' => $request->kelas],
            ['wali_kelas_id' => $request->wali_kelas_id]
        );

        return redirect()
            ->route('admin.settings.index', ['tahun_ajaran' => $request->tahun_ajaran])
            ->with('success', 'Wali kelas berhasil disimpan untuk tahun ajaran ' . $request->tahun_ajaran . '.');
    }

    public function updatePredicateRanges(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:master_tahun_ajaran,id',
            'min_a' => 'required|integer|min:0|max:100',
            'min_b' => 'required|integer|min:0|max:100',
            'min_c' => 'required|integer|min:0|max:100',
        ]);

        $tahun = MasterTahunAjaran::findOrFail($request->id);
        $tahun->update($request->only('min_a', 'min_b', 'min_c'));

        return back()->with('success', 'Rentang predikat untuk tahun ' . $tahun->nama . ' berhasil diperbarui.');
    }

    public function contact()
    {
        return view('admin.settings.contact');
    }

    public function updateContact(Request $request)
    {
        $settings = $request->except(['_token', '_method']);

        foreach ($settings as $key => $value) {
            \App\Models\Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return back()->with('success', 'Pengaturan kontak berhasil diperbarui.');
    }
}

