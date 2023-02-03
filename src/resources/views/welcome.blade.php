<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <style>
        .container {
            min-height: 100vh;
        }
        .container > .content:first-child {
                height: 100vh;
                position: relative;
                align-items: center;
            }
    </style>
    <title>WebForage - Sign in </title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

<body class="bg-gradient-primary">
    <style>
    .displayError{
        color : red;
        font-size: 20px;
    }
    </style>

    <div class="container">

        <!-- Outer Row -->
        <div class="row content justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                {{-- <div class="d-none d-lg-block position-absolute" style="left: 40%; z-index: 1;"><img src="images/icons/Logo.png" class="rounded-circle" alt="" style="width: 60%"></div>
                <div class="d-block d-lg-none position-absolute" style="left: 28%; z-index: 1;"><img src="images/icons/Logo.png" class="rounded-circle" alt="" style="width: 63%"></div> --}}
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image" style="z-index: 0"></div>
                            <div class="col-lg-6" style="z-index: 0">
                                <div class="position-absolute ml-5 w-100"><img src="images/icons/logo1.png" style="width:80%"></div>
                                <div class="p-5">
                                    <div class="text-center mt-5">
                                        <h1 class="h4 text-gray-900 mb-4">Sign In</h1>

                                        @if(Session::has('message'))
                                            <span class="displayError">{{ Session::get('message') }}</span>
                                        @endif

                                    </div>
                                    <form action="/login" method="post" class="user">
                                        @csrf

                                        <div class="form-group mt-3">
                                            <input type="number" name="phone" class="form-control form-control-user" placeholder="Phone number" value="{{ old('phone') }}" required/>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control form-control-user" placeholder="Password" value="{{ old('password') }}" required/>
                                        </div>

                                        <input type="submit" name="submit" value="Login" class="btn btn-primary btn-user btn-solid btn-block"/>

                                        <hr>

                                        <p style="font-size:18px;" class="text-center"><b>Welcome to K-FOURRAGE</b></p>

                                        <p class="text-center">We are at your service</p>
                                    </form>
                                    <hr>
                                    {{-- <div class="text-center">
                                        <a class="small" href="/forgot_password">Forgot Password?</a>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>


