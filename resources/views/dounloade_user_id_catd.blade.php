@extends('adminlte::page')

@section('title', 'Punch Card')

@section('content_header')
    <h1>Punch Card</h1>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/id_card.css') }}">
    <style>
        #all_ids_div {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
            background: rgb(247, 247, 247);
            padding: 15px;
        }

        .id_inner_Div {
            width: 250px;
            height: 370px;
            background-color: white;
            border-radius: 10px;
            margin: 20px 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .download_btn {
            display: flex;
            justify-content: center;
            margin-bottom: 10px;
            margin-top: 5px;
        }

        #id_card_div_1 {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .image_mane_div {
            display: flex;
            justify-content: center;
            margin: 5px 0;
        }

        .qr-container {
            display: flex;
            justify-content: center;
            margin: 5px 0 15px;
            padding: 0 20px;
        }

        #company_name_h2 {
            font-size: 20px;
            font-weight: bold;
            margin: 10px 0;
        }

        #id_image_div {
            width: 120px;
            height: 120px;
            overflow: hidden;
            border-radius: 5px;
        }

        #id_card_image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        #name_h2 {
            font-size: 18px;
            margin: 10px 0 5px;
            text-align: center;
        }

        #emp_type_h3 {
            font-size: 14px;
            color: #ffffff;
            margin: 5px 0;
            padding: 10px 0;
        }

        #tag_space {
            height: 20px;
        }

        /* Print styles */
        @media print {
            @page {
                size: A4;
                margin: 0;
            }

            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
            }

            .print-section {
                width: 100%;
                max-width: 21cm;
                height: 29.7cm;
                padding: 20mm;
                box-sizing: border-box;
                margin: auto;
                border: 1px solid #000;
            }

            .no-print {
                display: none;
            }
        }
    </style>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h3 class="card-title">Employee Punch Cards</h3>
                </div>
                <div class="col-md-6">
                    <form action="{{ route('limit_for_daownload_id') }}" method="post" class="float-right">
                        @csrf
                        <div class="input-group">
                            <input type="search" name="search_input" class="form-control" placeholder="Search by name or mobile number" required>
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Search
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div id="all_ids_div">
                @if(isset($user_data) && $user_data)
                    @foreach($user_data as $index => $user)
                        <div>
                            <div id="id_dard{{ $index }}" class="id_inner_Div">
                                <div id="id_card_div_1">
                                    <div class="image_mane_div">
                                        <div id="tag_space"></div>
                                    </div>
                                    <div class="image_mane_div">
                                        <h2 id="company_name_h2">Punch Card</h2>
                                    </div>
                                    <div class="image_mane_div">
                                        <div id="id_image_div">
                                            <img id="id_card_image" class="img-thumbnail"
                                                src="{{ asset('/storage') }}/{{ $user->photo_name }}"
                                                alt="Employee Photo">
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="image_mane_div">
                                        <h2 id="name_h2">{{ $user->f_name }} {{ $user->m_name }} {{ $user->l_name }}</h2>
                                    </div>
                                    <div class="image_mane_div">
                                        <h3 id="emp_type_h3">{{ $user->roles }}</h3>
                                    </div>
                                    <div class="qr-container">
                                        <div id="qrcode{{ $index }}" style="width: 100px; height: 100px;"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="download_btn">
                                <button class="btn btn-sm btn-primary" onclick="downloadIdAsJpg('id_dard{{ $index }}')">
                                    <i class="fas fa-download"></i> Download
                                </button>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="alert alert-info">
                        No punch cards found. Please search for employees.
                    </div>
                @endif
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.0.0-rc.7/dist/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        // Initialize QR codes after DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            @if(isset($user_data) && $user_data)
                @foreach($user_data as $index => $user)
                    try {
                        new QRCode(document.getElementById("qrcode{{ $index }}"), {
                            text: "{{ url('/login') }}/{{ isset($user->Employee_id) ? $user->Employee_id : $user->id }}",
                            width: 100,
                            height: 100,
                            colorDark: "#000000",
                            colorLight: "#ffffff",
                            correctLevel: QRCode.CorrectLevel.H
                        });
                    } catch (error) {
                        console.error("QR Code Error:", error);
                    }
                @endforeach
            @endif
        });

        function downloadIdAsJpg(id) {
            var content = document.getElementById(id);
            // Use html2canvas to capture the div as a canvas
            html2canvas(content).then(function(canvas) {
                // Convert the canvas to a data URL
                var imgData = canvas.toDataURL('image/jpeg');

                // Create a temporary link to trigger the download
                var link = document.createElement('a');
                link.href = imgData;
                link.download = 'punch-card.jpg';
                link.click();
            });
        }
    </script>
@stop
