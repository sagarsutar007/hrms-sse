@extends('adminlte::page')

@section('title', 'Punch Cards')

@section('content_header')
    <h1>Punch Cards</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="card-title">Manage Punch Cards</h3>
                <div>
                    <button id="selectAllButton" class="btn btn-sm btn-secondary">Select All</button>
                    <button id="deselectAllButton" class="btn btn-sm btn-secondary">Deselect All</button>
                    <button id="printButton" class="btn btn-sm btn-primary">Print Selected Cards</button>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <form action="{{route('limit_for_daownload_id')}}" method="post" class="form-inline">
                        @csrf
                        <div class="input-group">
                            <input type="search" name="search_input" class="form-control" placeholder="Search by name or mobile number" required>
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i> Search
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="container-fluid" id="cardContainer">
                <div class="row">
                    @if(isset($user_data) && !empty($user_data))
                        @foreach($user_data as $index => $user)
                            <div class="col-lg-2 col-md-3 col-sm-4 mb-3">
                                <div class="punch-card">
                                    <input type="checkbox" class="card-checkbox position-absolute">
                                    <div class="punch-card-header">
                                        <div class="header-line"></div>
                                        <div class="text-center text-white">
                                            <h6 class="mb-1">Punch Card</h6>
                                            <img src="{{asset('/storage')}}/{{ $user->photo_name }}" class="profile-img" alt="Profile">
                                        </div>
                                    </div>

                                    <div class="punch-card-body">
                                        <div class="text-center">
                                            <div class="employee-name">{{ $user->f_name }} {{ $user->m_name }} {{ $user->l_name }}</div>
                                            <div class="employee-role">Employee</div>
                                            <div class="qr-code-container" id="qrcode{{ $index }}"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-12 text-center">
                            <p>No records found</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        /* Punch Card Styles */
        .punch-card {
            width: 100%;
            max-width: 180px;
            height: 260px;
            border: 1px solid #ccc;
            border-radius: 5px;
            overflow: hidden;
            background-color: white;
            position: relative;
            margin: 0 auto;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .card-checkbox {
            top: 10px;
            left: 10px;
            z-index: 10;
            transform: scale(1.2);
        }

        .punch-card-header {
            background-color: #808080;
            height: 90px;
            position: relative;
            padding: 10px;
        }

        .header-line {
            width: 50px;
            height: 5px;
            background-color: white;
            border-radius: 5px;
            margin: 5px auto;
        }

        .profile-img {
            width: 25px;
            height: 25px;
            margin: 5px auto;
            display: block;
        }

        .punch-card-body {
            padding: 10px;
        }

        .employee-name {
            font-weight: bold;
            font-size: 14px;
            margin-top: 10px;
            margin-bottom: 5px;
        }

        .employee-role {
            background-color: #808080;
            color: white;
            padding: 3px 0;
            margin-bottom: 10px;
            font-size: 12px;
        }

        .qr-code-container {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .qr-code-container img {
            max-width: 100%;
            height: auto;
        }

        /* Print Styles */
        @media print {
            @page {
                size: A4;
                margin: 10mm;
            }

            body * {
                visibility: hidden;
            }

            .printable, .printable * {
                visibility: visible;
            }

            .printable {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            .printable .punch-card {
                page-break-inside: avoid;
                break-inside: avoid;
            }

            /* Force background colors to print */
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .punch-card {
                box-shadow: none;
                border: 1px solid #ddd;
            }
        }
    </style>
@stop

@section('js')
    <!-- QR Code Library -->
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
    <script>
        $(function () {
            // Generate QR codes for each card
            @if(isset($user_data) && !empty($user_data))
                @foreach($user_data as $index => $user)
                    new QRCode(document.getElementById("qrcode{{ $index }}"), {
                        text: "{{ url('/login') }}/{{ $user->Employee_id }}",
                        width: 80,
                        height: 80,
                    });
                @endforeach
            @endif

            // Select/Deselect all cards
            $('#selectAllButton').click(function() {
                $('.card-checkbox').prop('checked', true);
            });

            $('#deselectAllButton').click(function() {
                $('.card-checkbox').prop('checked', false);
            });

            // Print selected cards
            $('#printButton').click(function() {
                const selectedCards = Array.from(document.querySelectorAll('.card-checkbox:checked'))
                    .map(checkbox => checkbox.closest('.punch-card'));

                if (selectedCards.length === 0) {
                    alert('Please select at least one card to print.');
                    return;
                }

                // Create a temporary container for printable content
                const printableArea = document.createElement('div');
                printableArea.className = 'printable';

                const pageDiv = document.createElement('div');
                pageDiv.className = 'container-fluid';

                const rowDiv = document.createElement('div');
                rowDiv.className = 'row';

                // Add cards to grid
                selectedCards.forEach(card => {
                    const colDiv = document.createElement('div');
                    colDiv.className = 'col-2 mb-3';

                    const cardClone = card.cloneNode(true);
                    cardClone.querySelector('.card-checkbox').remove();

                    colDiv.appendChild(cardClone);
                    rowDiv.appendChild(colDiv);
                });

                pageDiv.appendChild(rowDiv);
                printableArea.appendChild(pageDiv);
                document.body.appendChild(printableArea);

                // Trigger print
                window.print();

                // Clean up
                document.body.removeChild(printableArea);
            });
        });
    </script>
@stop
