<!--Navbar-->
<nav class="navbar">
    <a href ="#" class ="navbar-logo">Koplak<span>Food</span></a>
    <div class="navbar-nav">
        <a href="{{ route('index') }}">Home</a>
        <?php
        session_start();
        ?>

        @auth

        @else
            <a href="{{ route('login') }}">Login</a>
            <a href="{{ route('regis') }}">Registrasi</a>
        @endauth
        {{-- @if(session()->has('username'))
            @else
            <a href="{{ route('login') }}">Login</a>
            <a href="{{ route('regis') }}">Registrasi</a>
        @endif --}}
        <a href="#products">Products</a>
        <a href="#forum">Forum</a>
        @auth
            <a href="{{ route('logout') }}">Logout</a>
        @else
        @endauth

        {{-- @if(session()->has('username'))
            <a href="{{ route('logout') }}">Logout</a>
            @else
        @endif --}}
    </div>

    <div class="navbar-extra">

        @auth
            <a href="{{ route('profile.show') }}" id="akun"><i data-feather="user" style="display:inline-block;"></i></a>
        @else
            <a href="profile.php" id="akun" style="display:none;"><i data-feather="user"></i></a>
        @endauth

        {{-- @if(session()->has('username'))
            <a href="{{ route('profile.show') }}" id="akun"><i data-feather="user" style="display:inline-block;"></i></a>
            @else
            <a href="profile.php" id="akun" style="display:none;"><i data-feather="user"></i></a>
        @endif --}}

        <a href="#" id="keranjang"><i data-feather="shopping-cart"></i></a>
        <a href="#" id="menu"><i data-feather="menu"></i></a>
    </div>
</nav>
