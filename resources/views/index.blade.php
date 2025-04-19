<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koplak Food</title>
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <!--font google-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lily+Script+One&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- Feather icon -->
    <script src="https://unpkg.com/feather-icons"></script>
    <!--Css-->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login_regis.css') }}">
</head>
<body>
    {{-- navbar --}}
    @include('layout.navbar')

    <!-- Hero sec -->
    <section class="hero" id="home">
        <main class="content">
            <h1 id="kolak">Kopi Salak</h1>
            <h1 id="kofood">KoplakFood</h1>
            <img src="{{ asset('assets/img/imgKOPI2.png') }}">
            <p>Kopi Salak <span>adalah minuman serbuk yang terbuat dari biji salak yang digiling halus. Biji salak yang digunakan merupakan limbah atau sisa dari konsumsi buah salak</span></p>
            <a href="login.php" class="cta"><button id="klik">Click here<i data-feather="arrow-right"></i></button></a>
        </main>
    </section>

    <!-- Product section -->
    <!-- abaout section -->
    <!-- Footer -->
    <footer class="py-4" style="background-color: #FFA75B;">
        <div class="container">
            <div class="row">
                <div class="col-md-4 text-center">
                    <img src="{{ asset('assets/img/logoKF.png') }}" alt="Si Umang Logo" class="img-fluid" id="img-footer" style="max-width: 200px;">
                </div>
                <div class="col-md-4">
                    <h5 style="font-weight: 550; font-family: 'Lily Script One';font-size: 2rem;">Alamat</h5>
                    <p class="mb-0" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif ; font-weight: 550;font-size: 1.5rem;">PT KoplakFood</p>
                    <p class="mb-0" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;font-weight: 550;font-size: 1.2rem;">dusun Gumuksegawe, Gumuk Segawe, Pancakarya, Kec. Ajung, Kabupaten Jember, Jawa Timur 68175</p>
                </div>
                <div class="col-md-4 text-center" style="margin-top: 3rem;">
                    <h5 style="font-weight: 550; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;font-size: 1.5rem;">Media sosial kami</h5>
                    <div class="mt-2">
                        <a href="#"><img src="assets\img\icons8-youtube-48.png" style="max-width: 2.7rem; margin: 0 0.8rem;"></a>
                        <a href="#"><img src="assets\img\icons8-ig-48.png" style="max-width: 2.7rem;margin: 0 0.8rem;"></a>
                        <a href="#"><img src="assets\img\icons8-whatsapp-48.png" style="max-width: 2.7rem;margin: 0 0.8rem;"></a>
                    </div>
                </div>
            </div>
            <hr class="my-3" style="border-top: 1px solid rgba(0, 0, 0, 0.1);">
            <div class="text-center text-muted">
                <p class="mb-0" style="color: #ffffff;">&copy; 2025 KoplakFood. All Rights Reserved.</p>
            </div>
        </div>
    </footer>
    <!-- feather icon -->
    <script>
        feather.replace();
    </script>

    <!-- my js -->
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
