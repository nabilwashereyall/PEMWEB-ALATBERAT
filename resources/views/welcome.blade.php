<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penyewaan Alat Berat - PT. Berat Jaya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        /* Navbar */
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: white !important;
        }

        .nav-link {
            color: rgba(255,255,255,0.9) !important;
            margin: 0 1rem;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: white !important;
            transform: translateY(-2px);
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 100px 0;
            min-height: 600px;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 40%;
            height: 100%;
            background: rgba(255,255,255,0.05);
            border-radius: 50% 0 0 50%;
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .hero p {
            font-size: 1.3rem;
            margin-bottom: 2rem;
            opacity: 0.95;
        }

        .btn-primary-hero {
            background: white;
            color: #667eea;
            padding: 12px 40px;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
            display: inline-block;
            text-decoration: none;
            margin-right: 1rem;
        }

        .btn-primary-hero:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }

        .btn-secondary-hero {
            background: transparent;
            color: white;
            border: 2px solid white;
            padding: 10px 38px;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
            display: inline-block;
            text-decoration: none;
        }

        .btn-secondary-hero:hover {
            background: white;
            color: #667eea;
            transform: translateY(-3px);
        }

        /* Features Section */
        .features {
            padding: 80px 0;
            background: #f8f9fa;
        }

        .feature-card {
            text-align: center;
            padding: 30px;
            border-radius: 10px;
            background: white;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .feature-icon {
            font-size: 3rem;
            color: #667eea;
            margin-bottom: 1rem;
        }

        .feature-card h5 {
            font-weight: 700;
            margin-bottom: 1rem;
        }

        /* Equipment Section */
        .equipment {
            padding: 80px 0;
            background: white;
        }

        .equipment-card {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .equipment-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        }

        .equipment-img {
            height: 250px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .equipment-img i {
            font-size: 4rem;
            color: white;
        }

        .equipment-info {
            padding: 20px;
        }

        .equipment-info h5 {
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .equipment-price {
            color: #667eea;
            font-weight: 700;
            font-size: 1.2rem;
        }

        /* Company Profile Section */
        .company-profile {
            padding: 80px 0;
            background: #f8f9fa;
        }

        .company-profile h2 {
            font-weight: 700;
            margin-bottom: 2rem;
            color: #333;
        }

        .company-profile p {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #555;
            margin-bottom: 1rem;
        }

        /* CTA Section */
        .cta {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 80px 0;
            text-align: center;
        }

        .cta h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 2rem;
        }

        /* Footer */
        .footer {
            background: #333;
            color: white;
            padding: 40px 0;
            text-align: center;
        }

        .footer-link {
            color: #ccc;
            text-decoration: none;
            margin: 0 1rem;
            transition: all 0.3s ease;
        }

        .footer-link:hover {
            color: white;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2rem;
            }

            .hero p {
                font-size: 1rem;
            }

            .hero {
                padding: 50px 0;
                min-height: auto;
            }
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container">
        <a class="navbar-brand" href="/">
            <i class="fas fa-hard-hat"></i> PT. Berat Jaya
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#home">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#equipment">Alat Berat</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#about">Tentang Kami</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/contact">Kontak</a>
                </li>
                <li class="nav-item ms-3">
                    <a class="btn btn-light btn-sm" href="/login">Login</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="hero" id="home">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 hero-content">
                <h1>Sewa Alat Berat Berkualitas</h1>
                <p>Solusi lengkap untuk kebutuhan alat berat Anda dengan harga terjangkau dan layanan terbaik</p>
                <div>
                    <a href="/login" class="btn-primary-hero">Mulai Pesan Sekarang</a>
                    <a href="#equipment" class="btn-secondary-hero">Lihat Koleksi</a>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <i class="fas fa-excavator" style="font-size: 8rem; color: white; opacity: 0.8;"></i>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features">
    <div class="container">
        <h2 class="text-center mb-5" style="font-weight: 700; font-size: 2.5rem;">Keunggulan Kami</h2>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h5>Alat Berkualitas</h5>
                    <p>Semua alat terawat dengan baik dan dilengkapi sertifikat layak pakai</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <h5>Harga Terjangkau</h5>
                    <p>Menawarkan harga kompetitif dengan sistem pembayaran yang fleksibel</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h5>Layanan 24/7</h5>
                    <p>Tim profesional siap membantu Anda kapan saja untuk kebutuhan apapun</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Equipment Section -->
<section class="equipment" id="equipment">
    <div class="container">
        <h2 class="text-center mb-5" style="font-weight: 700; font-size: 2.5rem;">Koleksi Alat Berat</h2>
        <div class="row">
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="equipment-card">
                    <div class="equipment-img">
                        <i class="fas fa-excavator"></i>
                    </div>
                    <div class="equipment-info">
                        <h5>Excavator PC 200</h5>
                        <p class="text-muted small">Mesin penggali tanah dan material lainnya</p>
                        <div class="equipment-price">Rp 500.000/hari</div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4 mb-4">
                <div class="equipment-card">
                    <div class="equipment-img">
                        <i class="fas fa-truck"></i>
                    </div>
                    <div class="equipment-info">
                        <h5>Dump Truck 10 Ton</h5>
                        <p class="text-muted small">Truk untuk mengangkut material berat</p>
                        <div class="equipment-price">Rp 300.000/hari</div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4 mb-4">
                <div class="equipment-card">
                    <div class="equipment-img">
                        <i class="fas fa-road"></i>
                    </div>
                    <div class="equipment-info">
                        <h5>Roller Compactor</h5>
                        <p class="text-muted small">Alat pemadatan tanah dan aspal</p>
                        <div class="equipment-price">Rp 250.000/hari</div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4 mb-4">
                <div class="equipment-card">
                    <div class="equipment-img">
                        <i class="fas fa-microchip"></i>
                    </div>
                    <div class="equipment-info">
                        <h5>Concrete Mixer</h5>
                        <p class="text-muted small">Mesin pengaduk beton profesional</p>
                        <div class="equipment-price">Rp 150.000/hari</div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4 mb-4">
                <div class="equipment-card">
                    <div class="equipment-img">
                        <i class="fas fa-fan"></i>
                    </div>
                    <div class="equipment-info">
                        <h5>Power Generator 50 kW</h5>
                        <p class="text-muted small">Generator listrik berkapasitas tinggi</p>
                        <div class="equipment-price">Rp 200.000/hari</div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4 mb-4">
                <div class="equipment-card">
                    <div class="equipment-img">
                        <i class="fas fa-tower-broadcast"></i>
                    </div>
                    <div class="equipment-info">
                        <h5>Mobile Crane 25 Ton</h5>
                        <p class="text-muted small">Crane untuk mengangkat beban berat</p>
                        <div class="equipment-price">Rp 1.000.000/hari</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-5">
            <p class="text-muted mb-3">Ingin melihat semua koleksi? Silakan login terlebih dahulu</p>
            <a href="/login" class="btn btn-primary" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; padding: 12px 40px; border-radius: 50px; font-weight: 600;">
                Login untuk Pesan
            </a>
        </div>
    </div>
</section>

<!-- Company Profile Section -->
<section class="company-profile" id="about">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div style="text-align: center;">
                    <i class="fas fa-building" style="font-size: 6rem; color: #667eea;"></i>
                </div>
            </div>
            <div class="col-lg-6">
                <h2>Tentang PT. Berat Jaya</h2>
                <p>
                    PT. Berat Jaya adalah perusahaan terkemuka dalam industri penyewaan alat berat di Indonesia. Dengan pengalaman lebih dari 15 tahun, kami telah melayani ribuan proyek dari skala kecil hingga skala besar.
                </p>
                <p>
                    Kami berkomitmen untuk memberikan layanan terbaik dengan menyediakan alat-alat berkualitas tinggi, operator profesional, dan dukungan teknis 24/7. Kepuasan pelanggan adalah prioritas utama kami.
                </p>
                <p>
                    Dengan armada lebih dari 150 unit alat berat, kami siap memenuhi kebutuhan Anda untuk berbagai jenis pekerjaan konstruksi, infrastruktur, dan proyek industri.
                </p>
                
                <div class="row mt-4">
                    <div class="col-sm-6 mb-3">
                        <h6 style="color: #667eea; font-weight: 700;">📍 Lokasi</h6>
                        <p>Jakarta, Surabaya, Bandung, Medan</p>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <h6 style="color: #667eea; font-weight: 700;">📞 Kontak</h6>
                        <p>(021) 1234-5678</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta">
    <div class="container">
        <h2>Siap Memulai Proyek Anda?</h2>
        <p style="font-size: 1.2rem; margin-bottom: 2rem;">Daftar sekarang dan dapatkan penawaran khusus untuk pelanggan baru</p>
        <a href="/register" class="btn btn-light" style="padding: 12px 40px; font-weight: 600; border-radius: 50px;">Daftar Sekarang</a>
    </div>
</section>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <p>&copy; 2025 PT. Berat Jaya. All rights reserved.</p>
        <div>
            <a href="#" class="footer-link"><i class="fab fa-facebook"></i></a>
            <a href="#" class="footer-link"><i class="fab fa-twitter"></i></a>
            <a href="#" class="footer-link"><i class="fab fa-instagram"></i></a>
            <a href="#" class="footer-link"><i class="fab fa-linkedin"></i></a>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
v