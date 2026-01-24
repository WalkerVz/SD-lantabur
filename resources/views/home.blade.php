@extends('layouts.app')

<style>
.hero {
    height: 80vh;
    background: linear-gradient(135deg, #2563eb, #1e40af);
    color: white;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;

    text-align: center;
    padding: 0 20px;
}

.hero h1 {
    font-size: 42px;
    margin-bottom: 15px;
}

.hero p {
    max-width: 600px;
    margin-bottom: 25px;
    line-height: 1.6;
}

/* BUTTON */
.btn-primary,
.btn-secondary {
    padding: 12px 24px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 600;
}

.btn-primary {
    background: white;
    color: #1e40af;
}

.btn-secondary {
    background: #1e40af;
    color: white;
}

/* SECTION */
.section {
    padding: 60px 20px;
    text-align: center;
}

.section h2 {
    margin-bottom: 20px;
    font-size: 28px;
}
.feature-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
    max-width: 900px;
    margin: 0 auto;
}

.feature-card {
    background: #f9fafb;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
}
.cta {
    background: #f1f5f9;
    padding: 60px 20px;
    text-align: center;
}

</style>

@section('content')
    {{-- HERO --}}
    <section class="hero">
        <h1>Selamat Datang di SD Lantabur</h1>
        <p>
            Membangun generasi cerdas, berakhlak, dan siap menghadapi masa depan
            melalui pendidikan yang berkualitas.
        </p>
        <a href="/about" class="btn-primary">Pelajari Lebih Lanjut</a>
    </section>

    {{-- ABOUT --}}
    <section class="section about">
        <h2>Tentang Kami</h2>
        <p>
            SD Lantabur berkomitmen memberikan pendidikan terbaik dengan
            mengedepankan nilai akademik, karakter, dan teknologi.
        </p>
    </section>

    {{-- KEUNGGULAN --}}
    <secbtion class="section features">
        <h2>Keunggulan Kami</h2>
        <div class="feature-grid">
            <div class="feature-card">
                <h3>Guru Profesional</h3>
                <p>Tenaga pendidik berpengalaman dan berdedikasi.</p>
            </div>
            <div class="feature-card">
                <h3>Lingkungan Nyaman</h3>
                <p>Suasana belajar yang aman dan kondusif.</p>
            </div>
            <div class="feature-card">
                <h3>Pendidikan Karakter</h3>
                <p>Menanamkan nilai moral sejak dini.</p>
            </div>
        </div>
    </secbtion>

    {{-- CTA --}}
    <section class="cta">
        <h2>Bergabung Bersama Kami</h2>
        <p>Daftarkan putra-putri Anda dan wujudkan masa depan yang gemilang.</p>
        <a href="/contact" class="btn-secondary">Hubungi Kami</a>
    </section>
@endsection
