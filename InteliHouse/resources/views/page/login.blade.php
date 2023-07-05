@extends('layout.login')

@section('titre')
    Connexion
@endsection

@section('main')
    <div class="container-fluid position-relative d-flex p-0">
        <!-- Spinner Start -->

        <div id="spinner"
            class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">


            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">

                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <!-- Spinner End -->


        <!-- Sign In Start -->
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="bg-secondary rounded p-4 p-sm-5 my-4 mx-3">
                            <div class="d-flex align-items-center justify-content-center">
                                <img class="" src="img/logo2.png " style="height: 80px;" alt="">
                            </div>

                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <a href="index.html" class="">
                                    <h3 class="text-primary">
                                        IntelliHouse</h3>
                                </a>
                                <h3>Connexion</h3>
                            </div>
                            @if (Session::has('error_msg'))
                                <div class="mb-2 alert alert-danger">
                                    <span class="text-primary">{{ Session::get('error_msg') }}</span>

                                </div>
                            @endif
                            <div class="form-floating mb-3">
                                <input type="text " class="form-control" name="contact" id="floatingInput"
                                    placeholder="70707070">
                                <label for="floatingInput">Contact</label>
                            </div>
                            <div class="form-floating mb-4">
                                <input type="password" class="form-control" name="password" id="floatingPassword"
                                    placeholder="Password">
                                <label for="floatingPassword">Password</label>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-4">
                            </div>
                            <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Connexion</button>
                            <p class="text-center mb-0">J'ai pas de compte? <a
                                    href="{{ route('inscription') }}">S'inscrire</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Sign In End -->
    </div>
@endsection

@section('script')
@endsection
