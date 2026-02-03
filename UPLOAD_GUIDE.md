# 📸 Panduan Upload File & Media di SD Al-Qur'an Lantabur

## 🔧 Struktur Storage

### Symbolic Link
Semua file media disimpan di `storage/app/public/` dan di-link ke `public/storage/` melalui **symbolic link**.

```
storage/app/public/
├── sliders/          → Gambar Hero Slider
├── staff_sdm/        → Foto Guru & Staff
├── berita/           → Gambar Berita
└── gallery/          → Foto Galeri
```

### URL Akses
- Slider: `http://localhost/storage/sliders/nama-file.jpg`
- Staff: `http://localhost/storage/staff_sdm/nama-file.jpg`
- Berita: `http://localhost/storage/berita/nama-file.jpg`
- Gallery: `http://localhost/storage/gallery/nama-file.jpg`

---

## 📤 Cara Upload File

### 1. **Slider (Hero Images)**
- **Lokasi Upload**: `/admin/slider`
- **Folder Tujuan**: `storage/app/public/sliders/`
- **Ukuran Max**: 4MB
- **Format**: JPG, PNG, WebP
- **Resolusi Rekomendasi**: 1920x600px atau lebih besar
- **Aspect Ratio**: 16:9 atau 3:1

```php
// Automatic Upload (admin form)
Route::post('slider', [SliderController::class, 'store']);
```

### 2. **Staff/SDM Photos**
- **Lokasi Upload**: `/admin/sdm`
- **Folder Tujuan**: `storage/app/public/staff_sdm/`
- **Ukuran Max**: 2MB
- **Format**: JPG, PNG
- **Resolusi Rekomendasi**: 400x500px (untuk tampilan card)

### 3. **Berita/News Images**
- **Lokasi Upload**: `/admin/news`
- **Folder Tujuan**: `storage/app/public/berita/`
- **Ukuran Max**: 2MB
- **Format**: JPG, PNG
- **Resolusi Rekomendasi**: 800x400px

### 4. **Gallery Images**
- **Lokasi Upload**: `/admin/gallery`
- **Folder Tujuan**: `storage/app/public/gallery/`
- **Format**: JPG, PNG
- **Ukuran Max**: 2MB (default)
- **Resolusi Rekomendasi**: 600x400px

---

## 🛠️ Setup Awal (Jika Belum)

### Buat Symbolic Link
```bash
php artisan storage:link
```

Perintah ini membuat link dari:
- `storage/app/public/` → `public/storage/`

### Verify Link Sudah Ada
Cek apakah folder `public/storage` sudah ada:
```bash
dir public/storage
```

---

## 🔍 Testing Upload

### Seeder Default
Database seeder sudah menyediakan 3 slider default:
```bash
php artisan db:seed
```

File slider default:
- `storage/app/public/sliders/default-slide-1.jpg`
- `storage/app/public/sliders/default-slide-2.jpg`
- `storage/app/public/sliders/default-slide-3.jpg`

### Akses Web
Home page akan menampilkan slider dari database:
- **URL**: `http://localhost/`
- **Slider Auto-rotate**: Setiap 5 detik
- **Manual Control**: Tombol prev/next & pagination dots

---

## 📝 Troubleshooting

### ❌ Gambar Tidak Muncul

#### Solusi 1: Cek Symbolic Link
```bash
# Hapus link lama (jika ada)
rmdir public/storage

# Buat link baru
php artisan storage:link
```

#### Solusi 2: Cek Path di Database
```php
// Buka admin panel → Slider → Edit
// Pastikan path gambar benar, contoh:
// sliders/nama-file.jpg
// (BUKAN storage/sliders/... atau /storage/...)
```

#### Solusi 3: Cek Permission Folder
```bash
# Pastikan folder storage/app/public writable
chmod -R 755 storage/app/public
```

#### Solusi 4: Cek File Exists
```bash
# Pastikan file benar-benar ada
dir storage/app/public/sliders
dir public/storage/sliders
```

### ❌ Upload Gagal

- **Max File Size**: Cek ukuran file, maksimal 4MB untuk slider
- **Format File**: Hanya JPG, PNG, WebP yang diterima
- **Permission**: Pastikan folder `storage/app/public` bisa ditulis

---

## 📊 Database Schema

### Table: `sliders`
```sql
id (PRIMARY KEY)
judul (string 255)
deskripsi (text, nullable)
gambar (string 255)          -- Path file (sliders/nama-file.jpg)
urutan (integer, default 0)
aktif (boolean, default true)
timestamps
```

### Contoh Record:
```
id: 1
judul: "Selamat Datang di SD Al-Qur'an Lantabur"
deskripsi: "Membangun generasi cerdas..."
gambar: "sliders/default-slide-1.jpg"
urutan: 1
aktif: 1
```

---

## 🎯 Best Practices

1. **Naming Convention**:
   - Gunakan nama file yang deskriptif: `slider-visi.jpg` (bukan `IMG_001.jpg`)
   - Lowercase + dash separator: `hero-image-1.jpg`

2. **File Size**:
   - Kompres gambar sebelum upload untuk kecepatan loading
   - Gunakan tool: TinyPNG, ImageMagick, atau online compressor

3. **Resolution**:
   - Slider: 1920x600 atau 1920x1080
   - Staff: 400x500
   - News: 800x400
   - Gallery: 600x400

4. **Backup**:
   - Backup folder `storage/app/public` secara berkala
   - Simpan original file di tempat aman

5. **Cleanup**:
   - Hapus file lama melalui admin panel
   - Jangan hapus manual di folder

---

## 🔗 File Configuration

### `config/filesystems.php`
```php
'disks' => [
    'public' => [
        'driver' => 'local',
        'root' => storage_path('app/public'),
        'url' => rtrim(env('APP_URL', 'http://localhost'), '/').'/storage',
        'visibility' => 'public',
    ],
]
```

### `routes/web.php`
```php
Route::get('/', [PageController::class, 'home']);
Route::get('/slider', [PageController::class, 'home']); // Akses slider
```

---

## 📞 Informasi Penting

- **Admin Login**: `/admin/login`
- **Upload Slider**: `/admin/slider/create`
- **Upload Staff**: `/admin/sdm/create`
- **Upload News**: `/admin/news/create`
- **Upload Gallery**: `/admin/gallery/create`

---

**Last Updated**: 28 Jan 2026
**Version**: 1.0
