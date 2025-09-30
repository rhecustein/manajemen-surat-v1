<!DOCTYPE html>
<html lang="en" dir="ltr" data-startbar="dark" data-bs-theme="light">

    <head>
        <meta charset="utf-8" />
                <title>Login | Manajemen Surat</title>
                <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                <meta content=" Manajemen Surat" name="description" />
                <meta content="" name="@bintangwijaye" />
                <meta http-equiv="X-UA-Compatible" content="IE=edge" />

                <!-- App favicon -->
                <link rel="shortcut icon" href="assets/images/favicon.ico">

         <!-- App css -->
         <link href="{{ asset('dist/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
         <link href="{{ asset('dist/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
         <link href="{{ asset('dist/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />

    </head>
    <!-- Top Bar Start -->
    <body>
    <div class="container-xxl">
    <div class="row vh-100 justify-content-center align-items-center">
        <div class="col-12">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4 mx-auto">
                        <div class="card">
                            <div class="card-body p-0 bg-black auth-header-box rounded-top">
                                <div class="text-center p-3">
                                    <h4 class="mt-3 mb-1 fw-semibold text-white fs-18">Manajemen Surat V1</h4>   
                                    <p class="text-muted fw-medium mb-0">Masuk untuk melanjutkan ke Manajemen Surat.</p>  
                                </div>
                            </div>

                            <div class="card-body pt-0">
                                <form class="my-4" method="POST" action="{{ route('login') }}">
                                    @csrf

                                    <div class="form-group mb-3">
                                        <label class="form-label" for="username">Username / Email</label>
                                        <input type="text" class="form-control @error('email') is-invalid @enderror"
                                            id="username" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="Enter username">
                                        @error('email')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label" for="userpassword">Password</label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                                            id="userpassword" name="password" required autocomplete="current-password" placeholder="Enter password">
                                        @error('password')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group row align-items-center mb-3">
                                        <div class="col-sm-6">
                                            <div class="form-check form-switch form-switch-success">
                                                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                                <label class="form-check-label" for="remember">Remember me</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 text-end">
                                            @if (Route::has('password.request'))
                                                <a href="{{ route('password.request') }}" class="text-muted font-13">
                                                    <i class="dripicons-lock"></i> Forgot password?
                                                </a>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group mb-0">
                                        <div class="d-grid">
                                            <button class="btn btn-primary" type="submit">
                                                Log In <i class="fas fa-sign-in-alt ms-1"></i>
                                            </button>
                                        </div>
                                    </div>

                                </form><!-- end form -->
                            </div><!-- end card-body -->
                        </div><!-- end card -->
                    </div><!-- end col -->
                </div><!-- end row -->
            </div><!-- end card-body -->
        </div><!-- end col -->
    </div><!-- end row -->                                        
</div><!-- end container -->

    </body>
    <!--end body-->
</html>