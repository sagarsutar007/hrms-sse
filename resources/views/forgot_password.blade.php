<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <!-- AdminLTE and dependencies -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{url('css/app.css') }}">
    <link rel="stylesheet" href="{{url('css/common_class.css') }}">
</head>
<body class="hold-transition login-page" onload="loade_animation()">
    <!-- Loader -->
    <div id="loader_div">
        <img src="{{url('images/logo.png')}}" alt="" id="loder_logo">
    </div>

    <!-- Login Box -->
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <h1 class="h1">Forgot Password</h1>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Enter your email to reset your password</p>

                <form action="{{route('forgot_password')}}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Email" name="email" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <button type="submit" name="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-paper-plane mr-2"></i> Send Password Reset Link
                            </button>
                        </div>
                    </div>
                </form>

                <div class="mt-3 text-center">
                    <p>
                        <a href="{{url('login')}}">Back to Login</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>
    <script src="{{ url('js/app.js')}}"></script>

    <script>
        // Retain the background image functionality from the original
        document.body.style.backgroundImage = "url('{{ url('images/team.jpg') }}')";
        document.body.style.backgroundSize = "cover";
        document.body.style.backgroundPosition = "center";
    </script>
</body>
</html>
