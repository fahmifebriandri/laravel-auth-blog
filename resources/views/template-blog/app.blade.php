<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('template-blog') }}/assets/img/favicon.ico" />
    <link rel="icon" type="image/png" href="{{ asset('template-blog') }}/assets/img/favicon.ico" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>My Blog</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no"
        name="viewport" />
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,700|Source+Sans+Pro:400,600,700"
        rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
        integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous" />
    <!-- Main CSS -->
    <link href="{{ asset('template-blog') }}/assets/css/main.css" rel="stylesheet" />
    @yield('style')
</head>

<body>
    @if (Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif
    @if (Session::has('error'))
        <div class="alert alert-danger" role="alert">
            {{ Session::get('error') }}
        </div>
    @endif
    <nav class="topnav navbar navbar-expand-lg navbar-light bg-white fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('welcome') }}"><strong>My Blog</strong></a>
            <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarColor02"
                aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse collapse" id="navbarColor02" style="">
                <ul class="navbar-nav mr-auto d-flex align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('welcome') }}">Home</a>
                    </li>
                    @if (session('member'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('member-logout') }}">Log Out</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="">Welcome : {{session('member.full_name')}} </a>
                    </li>
                    @endif
                </ul>

            </div>
        </div>
    </nav>
    @yield('body')
    <div class="container mt-5">
        <footer class="bg-white border-top p-3 text-muted small">
            <div class="row align-items-center justify-content-between">
                <div>
                    <span class="navbar-brand mr-2"><strong>My Blog</strong></span>
                    Copyright &copy;
                    <script>
                        document.write(new Date().getFullYear());
                    </script>
                    . All rights reserved.
                </div>
            </div>
        </footer>
    </div>
    <script src="{{ asset('template-blog') }}/assets/js/vendor/jquery.min.js" type="text/javascript"></script>
    <script src="{{ asset('template-blog') }}/assets/js/vendor/popper.min.js" type="text/javascript"></script>
    <script src="{{ asset('template-blog') }}/assets/js/vendor/bootstrap.min.js" type="text/javascript"></script>
    <script src="{{ asset('template-blog') }}/assets/js/functions.js" type="text/javascript"></script>
    @yield('script')
</body>

</html>
