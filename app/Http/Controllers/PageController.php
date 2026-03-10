<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\StaffSdm;
use App\Models\Gallery;
use App\Models\Slider;
use App\Models\VideoYoutube;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        $slides = Slider::where('aktif', true)->orderBy('urutan')->get();

        $slidesData = $slides->isEmpty()
            ? [
                ['title' => 'Selamat Datang di SD Al-Qur\'an Lantabur', 'desc' => 'Membangun generasi cerdas, berakhlak, dan siap menghadapi masa depan melalui pendidikan yang berkualitas dan inovatif.', 'image' => url('images/slide-1.jpeg')],
                ['title' => 'Pendidikan Berkualitas', 'desc' => 'Dengan kurikulum terkini dan metode pembelajaran inovatif, kami memastikan setiap siswa mendapatkan pendidikan terbaik.', 'image' => url('images/slide-2.jpeg')],
                ['title' => 'Lingkungan Mendukung', 'desc' => 'Fasilitas lengkap, guru profesional, dan suasana yang kondusif untuk mengembangkan potensi maksimal siswa.', 'image' => url('images/slide-3.jpeg')],
            ]
            : $slides->map(fn ($s) => [
                'title' => $s->judul,
                'desc' => $s->deskripsi ?? '',
                'image' => $s->gambar ? url('storage/' . ltrim(str_replace('\\', '/', $s->gambar), '/')) : url('images/slide-1.jpeg'),
            ])->values()->all();

        $latestNews = Berita::whereNotNull('published_at')->orderByDesc('published_at')->take(3)->get();

        return view('home', compact('slidesData', 'latestNews'));
    }

    public function staff()
    {
        $staff = StaffSdm::with('spesialisasi')->orderBy('nama')->get();
        return view('staff', compact('staff'));
    }

    public function news(Request $request)
    {
        $query = Berita::whereNotNull('published_at')->orderByDesc('published_at');
        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->q . '%')
                  ->orWhere('isi', 'like', '%' . $request->q . '%');
            });
        }
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }
        $berita = $query->paginate(9);
        return view('news', compact('berita'));
    }

    public function newsShow(string $id)
    {
        $item = Berita::whereNotNull('published_at')->findOrFail($id);
        $latestNews = Berita::whereNotNull('published_at')->where('id', '!=', $id)->orderByDesc('published_at')->take(5)->get();
        return view('news-show', compact('item', 'latestNews'));
    }

    public function gallery(Request $request)
    {
        $query = Gallery::orderBy('urutan')->orderByDesc('created_at');
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }
        $items = $query->get();
        $kategoris = Gallery::select('kategori')->distinct()->whereNotNull('kategori')->where('kategori', '!=', '')->pluck('kategori');
        $videos = VideoYoutube::where('aktif', true)->orderBy('urutan')->get();
        return view('gallery', compact('items', 'kategoris', 'videos'));
    }
}
