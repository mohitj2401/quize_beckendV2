@extends('home.layouts.master')
@section('title')
    Terms & Condition
@endsection
@section('body')
    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://picsum.photos/1024/400?random=1" class="d-block w-100" alt="..." style="height:400px ">
            </div>
            <div class="carousel-item">
                <img src="https://picsum.photos/1024/400?random=2" class="d-block w-100" alt="..."
                    style="height:400px ">
            </div>
            <div class="carousel-item">
                <img src="https://picsum.photos/1024/400?random=3" class="d-block w-100" alt="..."
                    style="height:400px ">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <div class="container py-3">
        <p class="fs-4 text-secondary">Contact Us</p>
        <div class="row">
            <div class="col-md-4">
                <p class="fs-2 fw-bold">Feel free to keep in touch with us!</p>
                <p class="my-4"><i class="fa-solid fa-envelope"></i><span
                        class="ms-2">admin@quizlearn.noonedev.com</span></p>
                <p class="my-4"><i class="fa-light fa-earth-asia"></i><span class="ms-2"><a href="https://noonedev.com/"
                            class="" target="_blank">noonedev.com</a></span></p>
            </div>
            <div class="col-md-8">
                <form action="">
                    <div class="row">
                        <div class="col-md-6">


                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com"
                                    required>
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
                                <input type="number" class="form-control" id="floatingInput" placeholder="Phone Number">
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
@endsection
