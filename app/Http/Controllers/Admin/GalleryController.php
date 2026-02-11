<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $query = Gallery::orderBy('urutan')->orderByDesc('created_at');
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }
        $items = $query->get();
        return view('admin.gallery.index', compact('items'));
    }

    public function create()
    {
        return view('admin.gallery.form', ['item' => null]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'nullable|string|max:50',
            'gambar' => 'required|image|max:4096',
            'urutan' => 'nullable|integer|min:0',
        ]);

        $path = $request->file('gambar')->store('gallery', 'public');
        Gallery::create([
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'gambar' => $path,
            'urutan' => $request->urutan ?? 0,
        ]);
        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('admin.gallery.index')->with('success', 'Foto galeri berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $item = Gallery::findOrFail($id);
        return view('admin.gallery.form', ['item' => $item]);
    }

    public function update(Request $request, string $id)
    {
        $item = Gallery::findOrFail($id);
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'nullable|string|max:50',
            'gambar' => 'nullable|image|max:4096',
            'urutan' => 'nullable|integer|min:0',
        ]);

        $data = ['judul' => $request->judul, 'kategori' => $request->kategori, 'urutan' => $request->urutan ?? 0];
        if ($request->hasFile('gambar')) {
            Storage::disk('public')->delete($item->gambar);
            $data['gambar'] = $request->file('gambar')->store('gallery', 'public');
        }
        $item->update($data);
        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('admin.gallery.index')->with('success', 'Foto galeri berhasil diubah.');
    }

    public function destroy(string $id, Request $request)
    {
        $item = Gallery::findOrFail($id);
        if ($item->gambar) {
            Storage::disk('public')->delete($item->gambar);
        }
        $item->delete();
        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('admin.gallery.index')->with('success', 'Foto galeri berhasil dihapus.');
    }
}
