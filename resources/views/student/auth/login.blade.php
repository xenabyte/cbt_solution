
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>{{ env('APP_NAME') }} - Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="{{ env('APP_NAME') }}" name="description" />
    <meta content="Oladipo Damilare(KoderiaNG)" name="author" />
    <meta name="robots" content="noindex">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('assets/images/favicon.ico')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Layout config Js -->
    <script src="{{asset('assets/js/layout.js')}}"></script>
    <!-- Bootstrap Css -->
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{asset('assets/css/app.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{asset('assets/css/custom.min.css')}}" rel="stylesheet" type="text/css" />
</head>

<body>
    @include('sweetalert::alert')
    <script src="http://localhost:8000/vendor/sweetalert/sweetalert.all.js"></script>
    <div class="auth-page-wrapper pt-5">
        <!-- auth page bg -->
        <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
            <div class="bg-overlay"></div>

            <div class="shape">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
                    <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                </svg>
            </div>
        </div>

        <!-- auth page content -->
        <div class="auth-page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mt-sm-5 mb-4 text-white-50">
                            <div>
                                <a href="{{url('/')}}" class="d-inline-block auth-logo">
                                    <img src="{{asset('assets/images/logo-light.png')}}" alt="" height="90">
                                </a>
                            </div>
                            <p class="mt-3 fs-15 fw-medium">{{ env('APP_Name') }}</p>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card mt-4">

                            <div class="card-body p-4">
                                {{-- <div class="text-center mt-2">
                                    <h5 class="text-primary">Lock Screen</h5>
                                    <p class="text-muted">Enter your password to unlock the screen!</p>
                                </div> --}}
                               
                                <div class="p-2 mt-4">
                                    <form action="{{ url('/student/login') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label" for="identifier">Matric Number/Registration Number</label>
                                            <input type="text" class="form-control" id="identifier" name="identifier" placeholder="Matric Number/Registration Number" required>
                                        </div>
                                        @if($errors->has('identifier'))
                                            <div class="alert alert-danger">
                                                {{ $errors->first('identifier') }}
                                            </div>
                                        @endif
                                        <div class="mb-2 mt-4">
                                            <button class="btn btn-success w-100" type="submit">Continue</button>
                                        </div>
                                    </form><!-- end form -->

                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->

                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->

        <!-- footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="mb-0 text-muted">&copy;
                                <script>document.write(new Date().getFullYear())</script> {{ env('APP_NAME') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->
    </div>
    <!-- end auth-page-wrapper -->

    <!-- JAVASCRIPT -->
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    <script src="{{ asset('assets/js/plugins.js') }}"></script>

    <!-- particles js -->
    <script src="{{ asset('assets/libs/particles.js/particles.js') }}"></script>
    <!-- particles app js -->
    <script src="{{asset('assets/js/pages/particles.app.js')}}"></script>
</body>

</html>