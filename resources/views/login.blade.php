@extends('layouts.auth')

@section('content')
    <div class="login-box">
        <div class="login-logo">
            <a href="../../index2.html"><b>Shri Sai Electricals</b></a>
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <form action="{{ route('login_req') }}" method="post">
                    @csrf

                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Email ID" name="email" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3 password-container">
                        <input type="password" id="password" class="form-control" placeholder="Password" name="Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="rememberMe" name="rememberMe">
                                <label for="rememberMe">Remember Me</label>
                            </div>
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Log In</button>
                        </div>
                    </div>
                </form>

                <p class="mb-1">
                    <a href="{{ url('Forgot-Password') }}">Forgot Password?</a>
                </p>
            </div>
        </div>
    </div>
@endsection
