<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Traits\ImageOptimization;

class NewsController extends Controller
{
    use ImageOptimization;
    public function index(Request $request)
    {
        $sort = $request->get('sort', 'desc'); // default to descending (newest first)
        $query = Berita::query();
        
        // Apply sorting
        if ($sort === 'asc') {
            $query->orderBy('published_at', 'asc')->orderBy('created_at', 'asc');
        } else {
            $query->orderByDesc('published_at')->orderByDesc('created_at');
        }
        
        // Search filter
        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->q . '%')->orWhere('isi', 'like', '%' . $request->q . '%');
            });
        }
        
        // Category filter
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }
        
        // Status filter (published/draft)
        if ($request->filled('status')) {
            if ($request->status === 'published') {
                $query->whereNotNull('published_at');
            } elseif ($request->status === 'draft') {
                $query->whereNull('published_at');
            }
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
            'ringkasan' => 'nullable|string',
            'gambar' => 'nullable|image|max:2048',
            'gambar_dua' => 'nullable|image|max:2048',
            'publish' => 'nullable|boolean',
        ]);

        $data = $request->only(['judul', 'kategori', 'isi', 'ringkasan']);
        $data['published_at'] = $request->boolean('publish') ? now() : null;
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $this->optimizeAndStore($request->file('gambar'), 'berita');
        }
        if ($request->hasFile('gambar_dua')) {
            $data['gambar_dua'] = $this->optimizeAndStore($request->file('gambar_dua'), 'berita');
        }
        Berita::create($data);
        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }
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
            'ringkasan' => 'nullable|string',
            'gambar' => 'nullable|image|max:2048',
            'gambar_dua' => 'nullable|image|max:2048',
            'publish' => 'nullable|boolean',
        ]);

        $data = $request->only(['judul', 'kategori', 'isi', 'ringkasan']);
        $data['published_at'] = $request->boolean('publish') ? ($item->published_at ?? now()) : null;
        if ($request->hasFile('gambar')) {
            if ($item->gambar) {
                Storage::disk('public')->delete($item->gambar);
            }
            $data['gambar'] = $this->optimizeAndStore($request->file('gambar'), 'berita');
        }
        if ($request->hasFile('gambar_dua')) {
            if ($item->gambar_dua) {
                Storage::disk('public')->delete($item->gambar_dua);
            }
            $data['gambar_dua'] = $this->optimizeAndStore($request->file('gambar_dua'), 'berita');
        }
        $item->update($data);
        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil diubah.');
    }

    public function destroy(string $id, Request $request)
    {
        $item = Berita::findOrFail($id);
        if ($item->gambar) {
            Storage::disk('public')->delete($item->gambar);
        }
        if ($item->gambar_dua) {
            Storage::disk('public')->delete($item->gambar_dua);
        }
        $item->delete();
        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil dihapus.');
    }
}
