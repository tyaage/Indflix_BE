<style>
    .banner-container {
        width: 100%;
        height: 300px;
        /* Sesuaikan tinggi banner */
        overflow: hidden;
        position: relative;
    }

    .banner-slide {
        width: 100%;
        height: 100%;
        opacity: 0;
        transition: opacity 0.5s ease-in-out;
        position: absolute;
        top: 0;
        left: 0;
    }

    .banner-slide.active {
        opacity: 1;
    }

    .banner-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .banner-caption {
        position: absolute;
        bottom: 0;
        left: 0;
        padding: 10px;
        background-color: rgba(0, 0, 0, 0.5);
        color: #fff;
    }
</style>

<h1>Welcome to the Dashboard!</h1>

<!-- Tambahkan tombol untuk menuju halaman pengaturan -->
@guest
    <a href="/login">Login</a>
@else
    @if (!$user->isVip())
        <a href="/langganan-vip">Beli Langganan VIP</a>
    @else
        <p>Sisa Masa Aktif VIP: {{ $user->remainingVipDays() }} hari</p>
    @endif
    <a href="/akun">Akun {{ $user->name }}</a>
    <form method="POST" action="/logout">
        @csrf
        <button type="submit">
            Logout
        </button>
    </form>
@endguest

<!-- Tampilkan pesan jika ada -->
@if (session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
@endif

<div class="banner-container">
    @foreach ($bannerMovies as $index => $movie)
        <div class="banner-slide @if ($index === 0) active @endif">
            <img src="{{ $movie->image }}" alt="{{ $movie->name }}" class="banner-image">
            <div class="banner-caption">
                <h3>{{ $movie->name }}</h3>
                <p>{{ $movie->synopsis }}</p>
            </div>
        </div>
    @endforeach
</div>

<h2>Popular Movies</h2>

<ul>
    @foreach ($popularMovies as $movie)
        <a href="/{{ $movie->slug }}">
            <ul>
                {{ $movie->name }}
                <li>
                    @if ($movie->image)
                        <img src="{{ asset($movie->image) }}" alt="Movie Image"
                            style="max-width: 100px; max-height: 100px;">
                    @else
                        No Image
                    @endif
            </ul>
            </li>
        </a>
    @endforeach
</ul>

<h2>Newest Movies</h2>

<ul>
    @foreach ($newestMovies as $movie)
        <a href="/{{ $movie->slug }}">
            <ul>
                {{ $movie->name }}
                <li>
                    @if ($movie->image)
                        <img src="{{ asset($movie->image) }}" alt="Movie Image"
                            style="max-width: 100px; max-height: 100px;">
                    @else
                        No Image
                    @endif
                </li>
            </ul>
        </a>
    @endforeach
</ul>

<script>
    // Mengatur waktu slide dan interval
    var slideIndex = 0;
    var slideInterval = 5000; // Ubah waktu slide sesuai kebutuhan

    // Fungsi untuk menampilkan slide berikutnya
    function showNextSlide() {
        var slides = document.getElementsByClassName('banner-slide');

        // Menghilangkan kelas active pada slide saat ini
        slides[slideIndex].classList.remove('active');

        // Menentukan indeks slide berikutnya
        slideIndex = (slideIndex + 1) % slides.length;

        // Menambahkan kelas active pada slide berikutnya
        slides[slideIndex].classList.add('active');
    }

    // Menampilkan slide pertama secara otomatis
    showNextSlide();

    // Mengatur interval untuk menampilkan slide berikutnya
    setInterval(showNextSlide, slideInterval);
</script>
