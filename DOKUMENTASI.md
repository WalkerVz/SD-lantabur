# Dokumentasi Website SD Al-Qur'an Lantabur

## 📋 Daftar Isi
1. [Overview](#overview)
2. [Teknologi](#teknologi)
3. [Struktur Project](#struktur-project)
4. [Halaman-Halaman](#halaman-halaman)
5. [Cara Menggunakan](#cara-menggunakan)
6. [Customization](#customization)
7. [Troubleshooting](#troubleshooting)

---

## Overview

Website resmi **SD Al-Qur'an Lantabur** adalah platform digital yang menampilkan informasi sekolah, profil tenaga pendidik, dan memfasilitasi komunikasi dengan calon siswa dan orangtua.

**Fitur Utama:**
- 🎨 Design modern & responsive (mobile, tablet, desktop)
- 🖼️ Hero slider dengan gambar background
- 📱 Mobile-friendly navigation
- 🎯 SEO optimized
- 💚 Brand color: Hijau tua (Green 700-900)
- 🔤 Font: Poppins (heading) + Inter (body)

---

## Teknologi

### Backend
- **Framework**: Laravel 11
- **Language**: PHP 8.2+
- **Database**: MySQL
- **Web Server**: Apache (via Laragon)

### Frontend
- **CSS Framework**: Tailwind CSS 4
- **JS Library**: Alpine.js 3 (untuk slider interaktif)
- **Font**: Google Fonts (Poppins, Inter)
- **Build Tool**: Vite

### Deployment
- **Local**: Laragon
- **Environment**: Development (.env)

---

## Struktur Project

```
SDLANTABUR/
├── app/
│   ├── Http/Controllers/
│   ├── Models/
│   └── Providers/
├── bootstrap/
├── config/
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
├── public/
│   ├── index.php
│   ├── images/
│   │   ├── logo.png
│   │   ├── slide-1.jpg (belum ada)
│   │   ├── slide-2.jpg (belum ada)
│   │   └── slide-3.jpg (belum ada)
│   └── build/
├── resources/
│   ├── css/
│   │   └── app.css (Tailwind config)
│   ├── image/
│   │   └── WhatsApp_Image_2026-01-24_...
│   ├── js/
│   │   ├── app.js
│   │   └── bootstrap.js
│   └── views/
│       ├── home.blade.php (Hero dengan slider)
│       ├── about.blade.php (Tentang sekolah)
│       ├── staff.blade.php (Tenaga pendidik)
│       ├── contact.blade.php (Formulir kontak)
│       ├── layouts/
│       │   └── app.blade.php (Master layout)
│       └── components/
│           └── Navbar/navbar.blade.php
├── routes/
│   └── web.php (Route definition)
├── storage/
├── tests/
├── vendor/
├── package.json
├── vite.config.js
├── artisan
└── composer.json
```

---

## Halaman-Halaman

### 1. **Home** (`/`)
**File**: `resources/views/home.blade.php`

**Komponen**:
- Hero Slider (3 slides dengan Alpine.js)
- Auto-play setiap 5 detik
- Navigation buttons (prev/next)
- Pagination dots
- Tentang Kami section
- Keunggulan (3 cards)
- CTA section

**Ukuran Hero**:
- Mobile: `h-96` (384px)
- Tablet: `h-[550px]` (550px)
- Desktop: `h-[660px]` (660px)

**Background Slider**:
- Path: `public/images/slide-1.jpg`, `slide-2.jpg`, `slide-3.jpg`
- Format: JPG/PNG
- Ukuran: min 1920x1080 (16:9)
- Belum ada gambar (kosong saat ini)

---

### 2. **About** (`/about`)
**File**: `resources/views/about.blade.php`

**Komponen**:
- Hero section dengan gradient
- Visi & Misi
- Profil sekolah (4 sections):
  - Pendidikan
  - Tenaga Pendidik
  - Fasilitas
  - Prestasi
- CTA section

---

### 3. **Staff** (`/staff`)
**File**: `resources/views/staff.blade.php`

**Komponen**:
- Hero section
- Struktur Organisasi (6 posisi):
  - Guru Kelas
  - Guru Mata Pelajaran
  - Guru Pendamping
  - Guru Agama
  - Guru Olahraga & Seni
  - Staff Administrasi
- Kualifikasi Tenaga Pendidik
- CTA section

---

### 4. **Contact** (`/contact`)
**File**: `resources/views/contact.blade.php`

**Komponen**:
- Hero section
- Contact Form (5 fields):
  - Nama Lengkap
  - Email
  - Nomor Telepon
  - Pesan
  - Submit button
- Informasi Kontak:
  - Alamat
  - Telepon
  - Email
  - Jam Operasional

---

### 5. **Layout Master** (`layouts/app.blade.php`)
**File**: `resources/views/layouts/app.blade.php`

**Komponen Utama**:
- Header + Navbar
- Content section (yield)
- Footer

**Navbar** (`components/Navbar/navbar.blade.php`):
- Logo + brand name
- Navigation links: Home, About, Staff, Contact
- Sticky (tetap di atas saat scroll)

**Footer**:
- 3 kolom: Branding, Menu, Kontak
- Dark background (green-900)
- Copyright

---

## Cara Menggunakan

### ✅ Instalasi & Setup

```bash
# 1. Clone/navigate ke project
cd D:\laragon\www\SDLANTABUR

# 2. Install dependencies PHP
composer install

# 3. Install dependencies Node
npm install

# 4. Copy environment file
cp .env.example .env

# 5. Generate key
php artisan key:generate

# 6. Database setup (jika diperlukan)
php artisan migrate

# 7. Build assets
npm run build
```

### 🚀 Development Mode

```bash
# Terminal 1: Tailwind watch
npm run dev

# Terminal 2: Laravel dev server (optional)
php artisan serve

# Akses: http://localhost:8000 atau http://localhost
```

### 🔨 Production Build

```bash
npm run build
```

---

## Customization

### 📝 Mengubah Konten

#### 1. Ubah Judul Halaman
File: `resources/views/layouts/app.blade.php` (line 6)
```html
<title>SD Al-Qur'an Lantabur - Sekolah Dasar Unggul</title>
```

#### 2. Ubah Warna Brand
File: `resources/css/app.css`
```css
/* Ganti green ke warna lain */
bg-green-800 → bg-blue-800
text-green-800 → text-blue-800
```

#### 3. Ubah Font
File: `resources/css/app.css` (line 8-11)
```css
--font-sans: 'Inter', ...;
--font-display: 'Poppins', ...;
```

#### 4. Ubah Konten Slider Home
File: `resources/views/home.blade.php` (line 5-8)
```javascript
slides: [
    { 
        title: 'Judul slide', 
        desc: 'Deskripsi slide',
        image: 'url({{ asset('images/slide-1.jpg') }})'
    },
    // ... lebih banyak slides
]
```

#### 5. Ubah Ukuran Hero Section
File: `resources/views/home.blade.php` (line 4 & 27)

Dari:
```html
<section class="h-96 md:h-[550px] lg:h-[660px]">
```

Contoh nilai:
- `h-64` = 256px
- `h-80` = 320px
- `h-96` = 384px
- `md:h-[400px]` = custom 400px
- `lg:h-[700px]` = custom 700px

---

### 🖼️ Menambah Gambar Slider

#### Langkah 1: Siapkan 3 Gambar
- Format: JPG atau PNG
- Ukuran: Min 1920x1080 (16:9 ratio)
- Nama: `slide-1.jpg`, `slide-2.jpg`, `slide-3.jpg`

#### Langkah 2: Upload ke Folder
Letakkan di: `public/images/`
- `D:\laragon\www\SDLANTABUR\public\images\slide-1.jpg`
- `D:\laragon\www\SDLANTABUR\public\images\slide-2.jpg`
- `D:\laragon\www\SDLANTABUR\public\images\slide-3.jpg`

#### Langkah 3: Rebuild & Refresh
```bash
npm run build
# Refresh browser (Ctrl+F5)
```

✅ Selesai! Slider akan otomatis menampilkan gambar baru.

---

### 🔗 Mengubah Link Kontak

File: `resources/views/contact.blade.php` (line 48-67)

```php
<!-- Ubah nomor telepon -->
<a href="tel:+6221123456">

<!-- Ubah email -->
<a href="mailto:info@sdlantabur.sch.id">

<!-- Ubah alamat, jam operasional, dll -->
```

File: `resources/views/layouts/app.blade.php` (line 45-49)

```php
<!-- Ubah di footer juga -->
```

---

### ➕ Menambah Halaman Baru

#### 1. Buat file view
File: `resources/views/namahalan.blade.php`
```php
@extends('layouts.app')
@section('content')
    <!-- Konten halaman -->
@endsection
```

#### 2. Tambah route
File: `routes/web.php`
```php
Route::view('/namahalan', 'namahalan');
```

#### 3. Tambah link di navbar
File: `resources/views/components/Navbar/navbar.blade.php`
```html
<a href="/namahalan" class="...">Nama Halaman</a>
```

#### 4. Rebuild
```bash
npm run build
```

---

### 🎨 Mengubah Styling

#### Tailwind Classes
Semua menggunakan Tailwind CSS. Contoh:
```html
<!-- Warna -->
<div class="bg-green-800 text-white">

<!-- Spacing -->
<div class="px-5 py-24 mb-8">

<!-- Responsif -->
<div class="text-4xl md:text-5xl lg:text-6xl">

<!-- Hover -->
<a class="hover:bg-green-50 hover:text-green-200">
```

Referensi: https://tailwindcss.com/docs

---

## Troubleshooting

### ❌ CSS tidak muncul
**Solusi**:
```bash
# Clear cache & rebuild
npm run build
# Refresh browser: Ctrl+F5
```

### ❌ Gambar slider tidak muncul
**Solusi**:
1. Pastikan file ada di: `public/images/slide-1.jpg`, dll
2. Nama file harus exact: `slide-1.jpg`, `slide-2.jpg`, `slide-3.jpg`
3. Format: JPG atau PNG
4. Run: `npm run build`
5. Refresh: `Ctrl+F5`

### ❌ Slider tidak auto-play
**Solusi**:
1. Pastikan Alpine.js loaded (cek di browser console)
2. Clear browser cache
3. Refresh page

### ❌ Layout berantakan di mobile
**Solusi**:
1. Pastikan ada `<meta name="viewport">` di head
2. Test di browser devtools (F12 → responsive mode)
3. Check padding/margin di mobile classes

### ❌ Warna berbeda dari desain
**Solusi**:
1. Clear cache: `npm run build`
2. Restart browser
3. Check Tailwind config di `resources/css/app.css`

---

## 📊 Statistics

- **Total Pages**: 5 (Home, About, Staff, Contact, + Layout)
- **Responsive Breakpoints**: Mobile, Tablet, Desktop (3)
- **Color Palette**: Green 50-900 + Neutral
- **Typography**: Poppins (Display) + Inter (Body)
- **JavaScript**: Alpine.js (slider)
- **Database**: MySQL (configured but not used yet)

---

## 🔐 Security Notes

- `.env` file contains sensitive data - jangan commit ke git
- Form contact tidak terhubung ke backend (belum ada handler)
- Semua input perlu validasi di backend sebelum digunakan

---

## 📞 Kontak & Support

**Sekolah**: SD Al-Qur'an Lantabur
**Alamat**: Jl. Pendidikan No. 123
**Telepon**: (021) 123-456
**Email**: info@sdlantabur.sch.id

---

## 📝 Changelog

### v1.0 (24 Januari 2026)
- ✅ Setup Laravel + Tailwind CSS
- ✅ Buat 5 halaman utama
- ✅ Implementasi hero slider
- ✅ Responsive design
- ✅ Footer & navbar
- ✅ Dokumentasi

---

**Last Updated**: 24 Januari 2026
**Developer**: AI Assistant
**Status**: Active Development
