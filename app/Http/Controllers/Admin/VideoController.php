<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VideoYoutube;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index()
    {
        $items = VideoYoutube::orderBy('urutan')->orderByDesc('created_at')->get();
        return view('admin.video.index', compact('items'));
    }

    public function create()
    {
        return view('admin.video.form', ['item' => null]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'       => 'required|string|max:255',
            'url_youtube' => 'required|string|max:500',
            'deskripsi'   => 'nullable|string',
            'urutan'      => 'nullable|integer|min:0',
            'aktif'       => 'nullable|boolean',
        ]);

        $youtubeId = VideoYoutube::extractYoutubeId($request->url_youtube);
        if (! $youtubeId) {
            return back()->withErrors(['url_youtube' => 'URL YouTube tidak valid. Pastikan URL benar.'])->withInput();
        }

        VideoYoutube::create([
            'judul'      => $request->judul,
            'youtube_id' => $youtubeId,
            'deskripsi'  => $request->deskripsi,
            'urutan'     => $request->urutan ?? 0,
            'aktif'      => $request->boolean('aktif', true),
        ]);

        if ($request->wantsJson() || $request->get('modal')) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('admin.video.index')->with('success', 'Video berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $item = VideoYoutube::findOrFail($id);
        return view('admin.video.form', ['item' => $item]);
    }

    public function update(Request $request, string $id)
    {
        $item = VideoYoutube::findOrFail($id);
        $request->validate([
            'judul'       => 'required|string|max:255',
            'url_youtube' => 'required|string|max:500',
            'deskripsi'   => 'nullable|string',
            'urutan'      => 'nullable|integer|min:0',
            'aktif'       => 'nullable|boolean',
        ]);

        $youtubeId = VideoYoutube::extractYoutubeId($request->url_youtube);
        if (! $youtubeId) {
            return back()->withErrors(['url_youtube' => 'URL YouTube tidak valid.'])->withInput();
        }

        $item->update([
            'judul'      => $request->judul,
            'youtube_id' => $youtubeId,
            'deskripsi'  => $request->deskripsi,
            'urutan'     => $request->urutan ?? 0,
            'aktif'      => $request->boolean('aktif'),
        ]);

        if ($request->wantsJson() || $request->get('modal')) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('admin.video.index')->with('success', 'Video berhasil diubah.');
    }

    public function destroy(string $id, Request $request)
    {
        VideoYoutube::findOrFail($id)->delete();

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('admin.video.index')->with('success', 'Video berhasil dihapus.');
    }
}
