@extends('layout.register')

@section('titre')
    Inscription
@endsection

@section('main')
    
<div class="container-fluid position-relative d-flex p-0">
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->


    <!-- Sign Up Start -->
    <div class="container-fluid">
        <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
            <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                <form action="{{ route('register_submit') }}" method="POST">
                    @csrf

                    <div class="bg-secondary rounded p-4 p-sm-5 my-4 mx-3">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <a href="index.html" class="">
                                <h3 class="text-primary"><i class="fa fa-user-edit me-2"></i>IntelliHouse</h3>
                            </a>
                            <h3>Inscription</h3>
                        </div>
                        <div class="row">
                            <div class="form-floating mb-3 col-md-6">
                                <input type="text" class="form-control bg-white text-black" id="contact" name="nom" placeholder="" required>
                                <label for="floatingText">Nom</label>
                            </div> 
                            <div class="form-floating mb-3 col-md-6">
                                <input type="text" class="form-control bg-white text-black" id="contact" name="prenom" placeholder="" required>
                                <label for="floatingText">Prenom</label>
                            </div>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control bg-white text-black " id="contact" name="contact" placeholder="70707070" required>
                            <label for="floatingText">Contact</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control bg-white text-black" id="email" name="email" placeholder="nom@example.com" required>
                            <label for="floatingInput">Email</label>
                        </div>
                        <div class="form-floating mb-4">
                            <input type="password" class="form-control bg-white text-black" id="password" name="password" placeholder="Password" required>
                            <label for="floatingPassword">Password</label>
                        </div>
                        
                        <button type="submit" class="btn btn-primary py-3 w-100 mb-4">inscription</button>
                        <p class="text-center mb-0">J'ai déja un compte? <a href="{{ route('connexion') }}">Connexion</a></p>
                    </div>

                </form>
                
            </div>
        </div>
    </div>
    <!-- Sign Up End -->
</div>
@endsection

@section('script')
@endsection
