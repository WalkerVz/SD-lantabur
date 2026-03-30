<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\StaffSdm;
use App\Models\MasterTahunAjaran;
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

        return view('home', compact('slidesData'));
    }

    public function staff()
    {
        $tahunAktif = MasterTahunAjaran::getAktif() ?? MasterTahunAjaran::getFallback();

        $staff = StaffSdm::with(['tahunKelas' => function ($q) use ($tahunAktif) {
            $q->where('tahun_ajaran', $tahunAktif)->orderBy('kelas');
        }])->get();

        $prioritas = [
            'Kepala Sekolah' => 0,
            'Wakil Kepala Sekolah' => 1,
            'Wali Kelas' => 2,
            'Guru Bidang Studi' => 3,
            'Staff Administrasi' => 4,
            'Satpam' => 999,
        ];

        $staff = $staff
            ->sortBy(function ($s) use ($prioritas) {
                $p = $prioritas[$s->jabatan ?? ''] ?? 900;
                $n = strtolower(trim((string) ($s->nama ?? '')));
                return str_pad((string) $p, 4, '0', STR_PAD_LEFT) . '|' . $n;
            })
            ->values();
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
        return view('news-show', compact('item'));
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
