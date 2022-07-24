<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <style>
        html,
        body {
            font-family: 'Raleway', sans-serif;
        }

        .contact-button {
            border: none;
            outline: none;
            font-size: 13px;
            border-radius: 25px;
            padding: 13px 25px;
            background-color: #5fb759;
            text-transform: uppercase;
            color: #fff;
            font-weight: 600;
            letter-spacing: 1px;
            -webkit-transition: all 0.3s ease 0s;
            -moz-transition: all 0.3s ease 0s;
            -o-transition: all 0.3s ease 0s;
            transition: all 0.3s ease 0s;
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            margin: 0;
        }

        a {
            color: black;
            text-decoration: none;
        }

        a:hover {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
    @yield('style')
</head>

<body>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark shadow-sm">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <a class="navbar-brand" href="/">QuizLearn</a>


            <div class="collapse navbar-collapse " id="navbarTogglerDemo03">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">

                    <li class="nav-item">
                        <a class="nav-link " href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="{{ route('register') }}">Register</a>
                    </li>
                </ul>

            </div>
        </div>
    </nav>
    @yield('body')
    <footer class="py-4 bg-dark mt-auto">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between small">
                <div class="text-muted">Copyright &copy; Quiz Learn | <a href="https://Noonedev.com" target="_blank"
                        class="text-white">Noone</a></div>
                <div>
                    <a href="{{ route('privacy') }}" class="text-white">Privacy Policy</a>
                    &middot;
                    <a href="{{ route('terms') }}" class="text-white">Terms &amp; Conditions</a>
                </div>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>

</body>

</html>
