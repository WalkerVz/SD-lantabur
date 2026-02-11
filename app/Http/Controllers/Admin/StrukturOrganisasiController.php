<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StrukturOrganisasi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StrukturOrganisasiController extends Controller
{
    public function index()
    {
        $items = StrukturOrganisasi::orderBy('level')->orderBy('urutan')->get();
        return view('admin.struktur.index', compact('items'));
    }

    public function create()
    {
        return view('admin.struktur.form', ['item' => null]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'email' => 'nullable|email',
            'nomor_hp' => 'nullable|string|max:20',
            'level' => 'nullable|integer|min:1|max:10',
            'urutan' => 'nullable|integer|min:0',
            'foto' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['nama', 'jabatan', 'email', 'nomor_hp', 'level', 'urutan']);
        $data['aktif'] = $request->boolean('aktif');
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('struktur_organisasi', 'public');
        }
        StrukturOrganisasi::create($data);
        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('admin.struktur.index')->with('success', 'Struktur berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $item = StrukturOrganisasi::findOrFail($id);
        return view('admin.struktur.form', ['item' => $item]);
    }

    public function update(Request $request, string $id)
    {
        $item = StrukturOrganisasi::findOrFail($id);
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'email' => 'nullable|email',
            'nomor_hp' => 'nullable|string|max:20',
            'level' => 'nullable|integer|min:1|max:10',
            'urutan' => 'nullable|integer|min:0',
            'foto' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['nama', 'jabatan', 'email', 'nomor_hp', 'level', 'urutan']);
        $data['aktif'] = $request->boolean('aktif');
        if ($request->hasFile('foto')) {
            if ($item->foto) {
                Storage::disk('public')->delete($item->foto);
            }
            $data['foto'] = $request->file('foto')->store('struktur_organisasi', 'public');
        }
        $item->update($data);
        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('admin.struktur.index')->with('success', 'Struktur berhasil diubah.');
    }

    public function destroy(string $id, Request $request)
    {
        $item = StrukturOrganisasi::findOrFail($id);
        if ($item->foto) {
            Storage::disk('public')->delete($item->foto);
        }
        $item->delete();
        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('admin.struktur.index')->with('success', 'Struktur berhasil dihapus.');
    }

    public function exportPdf()
    {
        try {
            $rows = StrukturOrganisasi::orderBy('level')->orderBy('urutan')->get();
            $pdf = Pdf::loadView('admin.export.struktur-pdf', compact('rows'));
            return $pdf->download('struktur_organisasi_' . date('Y-m-d_His') . '.pdf');
        } catch (\Throwable $e) {
            report($e);
            return redirect()->route('admin.struktur.index')->with('error', 'Export gagal: ' . $e->getMessage());
        }
    }
}
