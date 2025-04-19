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
    <!-- remixicon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css">
    <!--Css-->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login_regis.css') }}">
</head>
<body>

    <!--Navbar-->
    @include('layout.navbar')

    <!-- login form -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <h1 class="text-center">Welcome back to <span>KoplakFood</span></h1>
            <p class="text-center">Selamat datang kembali di KoplakFood</p>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Login</div>

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="card-body">
                        <form action="{{ route('login.submit') }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="username">Username:</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="password">Password:</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-warning w-100">Login</button>
                        </form>
                    </div>
                </div>
                <div class="mt-3 text-center">
                    <a href="{{ route('regis') }}">Belum punya akun?</a>
                </div>
                <div class="mt-3 text-center">
                    <button type="button" class="btn">
                        <a href="index.php">Home</a>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="invalidDataModal" tabindex="-1" role="dialog" aria-labelledby="invalidDataModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="invalidDataModalLabel">Data Tidak Valid</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Data yang Anda masukkan tidak valid, harap isi kembali.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- footer -->
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
    <script>
        feather.replace();
    </script>
    <!-- bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- my js -->
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/login_regis.js') }}"></script>
</body>
</html>
