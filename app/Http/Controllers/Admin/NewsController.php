<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $query = Berita::orderByDesc('published_at')->orderByDesc('created_at');
        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->q . '%')->orWhere('isi', 'like', '%' . $request->q . '%');
            });
        }
        $berita = $query->paginate(10);
        return view('admin.news.index', compact('berita'));
    }

    public function create()
    {
        return view('admin.news.form', ['item' => null]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'nullable|string|max:50',
            'isi' => 'nullable|string',
            'gambar' => 'nullable|image|max:2048',
            'publish' => 'nullable|boolean',
        ]);

        $data = $request->only(['judul', 'kategori', 'isi']);
        $data['published_at'] = $request->boolean('publish') ? now() : null;
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('berita', 'public');
        }
        Berita::create($data);
        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $item = Berita::findOrFail($id);
        return view('admin.news.form', ['item' => $item]);
    }

    public function update(Request $request, string $id)
    {
        $item = Berita::findOrFail($id);
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'nullable|string|max:50',
            'isi' => 'nullable|string',
            'gambar' => 'nullable|image|max:2048',
            'publish' => 'nullable|boolean',
        ]);

        $data = $request->only(['judul', 'kategori', 'isi']);
        $data['published_at'] = $request->boolean('publish') ? ($item->published_at ?? now()) : null;
        if ($request->hasFile('gambar')) {
            if ($item->gambar) {
                Storage::disk('public')->delete($item->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('berita', 'public');
        }
        $item->update($data);
        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil diubah.');
    }

    public function destroy(string $id)
    {
        $item = Berita::findOrFail($id);
        if ($item->gambar) {
            Storage::disk('public')->delete($item->gambar);
        }
        $item->delete();
        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil dihapus.');
    }
}
