<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function index()
    {
        $items = Slider::orderBy('urutan')->get();
        return view('admin.slider.index', compact('items'));
    }

    public function create()
    {
        return view('admin.slider.form', ['item' => null]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'gambar' => 'required|image|max:4096',
            'urutan' => 'nullable|integer|min:0',
        ]);

        $path = $request->file('gambar')->store('sliders', 'public');
        Slider::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'gambar' => $path,
            'urutan' => $request->urutan ?? 0,
            'aktif' => $request->boolean('aktif'),
        ]);
        return redirect()->route('admin.slider.index')->with('success', 'Slider berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $item = Slider::findOrFail($id);
        return view('admin.slider.form', ['item' => $item]);
    }

    public function update(Request $request, string $id)
    {
        $item = Slider::findOrFail($id);
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|max:4096',
            'urutan' => 'nullable|integer|min:0',
        ]);

        $data = [
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'urutan' => $request->urutan ?? 0,
            'aktif' => $request->boolean('aktif'),
        ];
        if ($request->hasFile('gambar')) {
            Storage::disk('public')->delete($item->gambar);
            $data['gambar'] = $request->file('gambar')->store('sliders', 'public');
        }
        $item->update($data);
        return redirect()->route('admin.slider.index')->with('success', 'Slider berhasil diubah.');
    }

    public function destroy(string $id)
    {
        $item = Slider::findOrFail($id);
        Storage::disk('public')->delete($item->gambar);
        $item->delete();
        return redirect()->route('admin.slider.index')->with('success', 'Slider berhasil dihapus.');
    }
}
