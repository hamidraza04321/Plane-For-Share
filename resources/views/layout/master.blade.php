<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=navigation">
    <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ url('assets/plugins/bootstrap/css/bootstrap.min.css') }}">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="{{ url('assets/plugins/toastr/css/toastr.min.css') }}">
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ url('assets/dist/css/style.css') }}">
    <title>Plane for share</title>
</head>
<body>
    <section class="page-wrap">
        <div style="height: 5rem;"></div>
        <div class="animate-spin animate-spin-8s"></div>
        <div class="animate-spin animate-spin-6s"></div>
        <div class="animate-spin animate-spin-4s"></div>
        <div class="animate-spin animate-spin-2s"></div>
        <div class="main-content">
            <header>
                <div class="logo">
                    <img src="{{ url('assets/dist/img/logo.png') }}" width="150">
                </div>
                <input type="checkbox" id="nav_check" hidden>
                <nav>
                    <ul>
                        <li>
                            <a href="{{ route('index') }}" @class([ 'active' => Route::currentRouteName() == 'index'])>Home</a>
                        </li>
                        <li>
                            <a href="{{ route('how.it.works') }}" @class([ 'active' => Route::currentRouteName() == 'how.it.works'])>How it works</a>
                        </li>
                        <li>
                            @auth
                                <a href="#">{{ auth()->user()->name }}</a>
                            @else
                                <a href="{{ route('login') }}" @class([ 'active' => in_array(Route::currentRouteName(), [ 'login', 'register' ])])>Login / Register</a>
                            @endauth
                        </li>
                    </ul>
                </nav>
                <label for="nav_check" class="hamburger">
                    <div></div>
                    <div></div>
                    <div></div>
                </label>
            </header>
            @yield('main-content')
            <div id="footer">
                <div class="ft-border"></div>
                <p>Copyrights &copy; all rights reserved Developed By <a href="#">Hamid Raza</a></p>
            </div>
        </div>
    </section>

    <!-- Application base URL -->
    <input type="hidden" id="base-url" value="{{ url('/') }}">

    <!-- jQuery -->
    <script src="{{ url('assets/plugins/jQuery/jQuery-3.7.1.min.js') }}"></script>
    <script src="{{ url('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ url('assets/plugins/toastr/js/toastr.min.js') }}"></script>
    <script src="{{ url('assets/dist/js/main.js') }}"></script>
    @yield('scripts')
</body>
</html>