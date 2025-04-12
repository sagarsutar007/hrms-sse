@extends('adminlte::page')

@section('title', 'Punch Card')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
        @foreach($user_data as $index => $user)
        <div class="col-sm-12 col-md-6 col-lg-4 d-flex justify-content-center mb-4">
            <div class="card id-card">
                <div class="card-header text-center">
                    <h5 class="mb-0">Punch Card</h5>
                </div>
                <div class="card-body text-center">
                    <img class="profile-pic" src="{{ asset('/storage/' . $user->photo_name) }}" alt="Profile Picture">
                    <h4 class="mt-2">{{ $user->f_name }} {{ $user->m_name }} {{ $user->l_name }}</h4>
                    <span class="role-badge">{{ $user->roles }}</span>
                    <div id="qrcode{{ $index }}"></div>
                </div>
                <div class="card-footer text-center">
                    <h6 style="color: {{ $color_name }};">{{ $response_message }}</h6>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@stop

@section('css')
<style>
    .id-card {
        width: 250px;
        height: 370px;
        background-color: white;
        border-radius: 10px;
        box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
        text-align: center;
        padding: 10px;
    }

    .profile-pic {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #ccc;
    }

    .role-badge {
        display: inline-block;
        background: #343a40;
        color: white;
        padding: 5px 10px;
        margin-top: 5px;
        border-radius: 20px;
        font-size: 0.85rem;
    }

    @media (max-width: 576px) {
        .id-card {
            margin: 0 auto;
        }
    }
</style>
@stop

@section('js')
<script>
    const myTimeout = setTimeout(myGreeting, 5000);

    function myGreeting() {
        window.close();
    }
</script>
@stop
