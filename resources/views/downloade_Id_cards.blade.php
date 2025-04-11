@extends('adminlte::page')

@section('title', 'Punch Cards')

@section('content_header')
    <h1>Punch Cards</h1>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>

    <style>
        :root{
            --id_card_top_color: #707070;
            --id_card_h3_color: #707070;
            --id_card_border_color: #707070;
        }

        .punch-card-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 10px;
            justify-content: center;
            padding: 10px 0;
        }

        .punch-card {
            width: 2in;
            height: 3.4in;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            position: relative;
            box-sizing: border-box;
            margin: 0 auto;
        }

        .card-header-section {
            height: 150px;
            width: 100%;
            background-color: #707070;
            border-radius: 8px 8px 0 0;
            padding: 15px;
            text-align: center;
        }

        .card-tag-space {
            padding: 5px 20px;
            background: rgb(255, 255, 255);
            width: 60px;
            border-radius: 20px;
            margin: 0 auto 8px;
        }

        .card-title {
            color: white;
            margin: 10px 0;
            font-size: 1.2rem;
            text-align: center;
            float: none
        }

        .card-image-container {
            width: 80px;
            height: 80px;
            margin: 0 auto;
        }

        .card-photo {
            width: 80px;
            height: 80px;
            box-shadow: 0 0 0 2px hsl(0, 0%, 50%), 0 0 0 4px #707070;
            background-color: #fff;
            object-fit: cover;
        }

        .card-name {
            margin-top: 20px;
            font-size: 0.9rem;
            text-align: center;
            font-weight: bold;
        }

        .card-role {
            background-color: #707070;
            color: white;
            width: 100%;
            text-align: center;
            margin: 5px 0;
            padding: 5px 0;
            font-size: 0.9rem;
        }

        .card-qr-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 10px 0;
            min-height: 80px;
        }

        .card-checkbox {
            position: absolute;
            top: 10px;
            left: 10px;
            transform: scale(1.2);
            z-index: 10;
        }

        .card-actions {
            display: flex;
            justify-content: space-around;
            padding: 10px 15px;
        }

        .search-form {
            max-width: 300px;
            margin-bottom: 20px;
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

            .printable {
                visibility: visible;
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
            }

            .printable * {
                visibility: visible;
            }

            * {
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
                print-color-adjust: exact;
            }

            .card-header-section {
                background-color: #707070 !important;
                print-color-adjust: exact;
            }

            .card-role {
                background-color: #707070 !important;
                print-color-adjust: exact;
            }

            .card-checkbox {
                display: none !important;
            }

            .page {
                page-break-after: always;
            }
        }
    </style>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <h5 class="m-0">Punch Card Management</h5>
                <div class="button-group">
                    <button id="selectAllButton" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-check-square"></i> Select All
                    </button>
                    <button id="deselectAllButton" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-square"></i> Deselect All
                    </button>
                    <button id="printButton" class="btn btn-primary btn-sm">
                        <i class="fas fa-print"></i> Print Cards
                    </button>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <form action="{{route('limit_for_daownload_id')}}" method="post" class="search-form">
                        @csrf
                        <div class="input-group">
                            <input type="search" name="search_input" class="form-control" placeholder="Search by name and mobile number" required>
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="punch-card-container">
                @if(isset($user_data))
                    @foreach($user_data as $i => $inner_array)
                        <div class="punch-card">
                            <input type="checkbox" class="card-checkbox">
                            <div class="card-header-section">
                                <div class="card-tag-space"></div>
                                <h2 class="card-title">Punch Card</h2>
                                <div class="card-image-container">
                                    <img class="card-photo"
                                        src="{{asset('/storage')}}/{{ $inner_array->photo_name }}"
                                        alt="Employee Photo">
                                </div>
                            </div>

                            <div class="card-body p-0">
                                <h2 class="card-name">{{ $inner_array->f_name . " " . $inner_array->m_name . " " . $inner_array->l_name }}</h2>
                                <h3 class="card-role">{{ $inner_array->roles }}</h3>
                                <div class="card-qr-container">
                                    <div id="qrcode-{{ $i }}"></div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        // Make sure QR Code library is loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Generate QR codes for each card
            @if(isset($user_data))
                @foreach($user_data as $i => $inner_array)
                    new QRCode(document.getElementById("qrcode-{{ $i }}"), {
                        text: "{{url('/login')}}/{{ $inner_array->Employee_id }}",
                        width: 70,
                        height: 70,
                        colorDark: "#000000",
                        colorLight: "#ffffff",
                        correctLevel: QRCode.CorrectLevel.H
                    });
                @endforeach
            @endif
        });

        // Select All and Deselect All functionality
        const selectAllButton = document.getElementById('selectAllButton');
        const deselectAllButton = document.getElementById('deselectAllButton');

        selectAllButton.addEventListener('click', function() {
            document.querySelectorAll('.card-checkbox').forEach(checkbox => checkbox.checked = true);
        });

        deselectAllButton.addEventListener('click', function() {
            document.querySelectorAll('.card-checkbox').forEach(checkbox => checkbox.checked = false);
        });

        // Print button functionality
        document.getElementById('printButton').addEventListener('click', function() {
            const selectedCards = Array.from(document.querySelectorAll('.card-checkbox:checked'))
                .map(checkbox => checkbox.closest('.punch-card'));

            if (selectedCards.length === 0) {
                alert('Please select at least one card to print.');
                return;
            }

            // Create a temporary container for printable content
            const printableArea = document.createElement('div');
            printableArea.className = 'printable';

            // Calculate how many cards per page (9 cards in a 3x3 grid)
            const cardsPerPage = 9;

            // Group cards into pages
            for (let i = 0; i < selectedCards.length; i += cardsPerPage) {
                const pageDiv = document.createElement('div');
                pageDiv.className = 'page';
                pageDiv.style.display = 'grid';
                pageDiv.style.gridTemplateColumns = 'repeat(3, 1fr)';
                pageDiv.style.gap = '20px';
                pageDiv.style.margin = '0 auto';
                pageDiv.style.maxWidth = '800px';

                // Add up to 9 cards to this page
                const pageCards = selectedCards.slice(i, i + cardsPerPage);
                pageCards.forEach(card => {
                    const clonedCard = card.cloneNode(true);
                    // Remove checkboxes for printing
                    const checkbox = clonedCard.querySelector('.card-checkbox');
                    if (checkbox) checkbox.remove();
                    pageDiv.appendChild(clonedCard);
                });

                printableArea.appendChild(pageDiv);
            }

            document.body.appendChild(printableArea);

            // Trigger print
            window.print();

            // Remove temporary printable area after printing
            setTimeout(() => {
                document.body.removeChild(printableArea);
            }, 100);
        });
    </script>
@stop
