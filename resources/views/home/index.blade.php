<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <style>
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
</head>

<body>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <a class="navbar-brand" href="#">Navbar</a>


            <div class="collapse navbar-collapse " id="navbarTogglerDemo03">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="">Privacy Policy</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="#">Terms & Condition</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="#">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="#">Register</a>
                    </li>
                </ul>

            </div>
        </div>
    </nav>

    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="..." class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="..." class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="..." class="d-block w-100" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <div class="container">
        <p class="fs-4 text-secondary">Contact Us</p>
        <div class="row">
            <div class="col-md-4">
                <p class="fs-2 fw-bold">Feel free to keep in touch with us!</p>
                <p class="my-4"><i class="fa-solid fa-envelope"></i><span
                        class="ms-2">admin@quizlearn.noonedev.com</span></p>
                <p class="my-4"><i class="fa-light fa-earth-asia"></i><span class="ms-2"><a
                            href="https://noonedev.com/" class="" target="_blank">noonedev.com</a></span></p>
            </div>
            <div class="col-md-8">
                <form action="">
                    <div class="row">
                        <div class="col-md-6">


                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="floatingInput"
                                    placeholder="name@example.com" required>
                                <label for="floatingInput">Email address *</label>
                            </div>

                        </div>
                        <div class="col-md-6">

                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="floatingInput" placeholder="Your Name"
                                    required>
                                <label for="floatingInput">Name *</label>
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="floatingInput" placeholder="Subject">
                                <label for="floatingInput">Subject </label>
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="form-floating mb-3">
                                <input type="number" class="form-control" id="floatingInput"
                                    placeholder="Phone Number">
                                <label for="floatingInput">Phone</label>
                            </div>
                        </div>
                        <div class="col-md-12">

                            <div class="form-floating mb-3">
                                <textarea class="form-control" id="floatingInput" placeholder="Message"style="height: 100px"></textarea>
                                <label for="floatingInput">Message </label>
                            </div>
                        </div>

                    </div>
                    <button class="contact-button" type="submit">Send Message Now <i
                            class="fa-solid fa-arrow-right ms-1"></i>
                    </button>
                </form>


            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>

</body>

</html>
