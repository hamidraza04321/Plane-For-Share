<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=navigation">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ url('assets/plugins/bootstrap/css/bootstrap.min.css') }}">
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
                            <a href="#">Home</a>
                        </li>
                        <li>
                            <a href="#" class="active">How it works</a>
                        </li>
                        <li>
                            <a href="">About</a>
                        </li>
                        <li>
                            <a href="#">Login / Register</a>
                        </li>
                    </ul>
                </nav>
                <label for="nav_check" class="hamburger">
                    <div></div>
                    <div></div>
                    <div></div>
                </label>
            </header>
            <section class="main-tabs">
                <div id="tabs" class="container"> 
                    <ul class="nav nav-tabs">
                        <li>
                            <a href="#1" data-toggle="tab" class="active"><i class="fa fa-file-lines"></i> Text</a>
                        </li>
                        <li>
                            <a href="#2" data-toggle="tab"><i class="fa fa-copy"></i> Files</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="1">
                            <textarea id="text" name="text" class="form-control text-input" placeholder="Type Something..."></textarea>
                            <div class="row btn-row">
                                <div class="col-12">
                                    <button class="btn-clear">Clear</button>
                                    <button class="btn-save-text">Save</button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="2">
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </section>

    <!-- jQuery -->
    <script src="{{ url('assets/plugins/jQuery/jQuery-3.7.1.min.js') }}"></script>
    <!-- <script src="{{ url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script> -->
    <script src="{{ url('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
</body>
</html>