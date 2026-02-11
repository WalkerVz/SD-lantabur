<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BiayaSpp;
use App\Models\MasterTahunAjaran;
use App\Models\MasterMapel;
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
<<<<<<< HEAD
        $mapels = []; // Akan dipindah ke menu baru

        return view('admin.settings.index', compact('tahunAjaranList', 'tahunAktif'));
=======
        $biayaSpp = BiayaSpp::all()->keyBy(fn ($r) => $r->tahun_ajaran . '-' . $r->kelas);
        $mapel1 = MasterMapel::where('kelas', 1)->orderBy('urutan')->get();
        $mapel2 = MasterMapel::where('kelas', 2)->orderBy('urutan')->get();

        return view('admin.settings.index', compact('tahunAjaranList', 'tahunAktif', 'biayaSpp', 'mapel1', 'mapel2'));
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
>>>>>>> b3f425f5dfdddef29492c353c9488dfb30f5d5a3
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

