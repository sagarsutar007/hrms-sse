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
            --id_card_border_color: #ddd;
        }

        .punch-card-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
            gap: 15px;
            justify-content: center;
            padding: 10px 0;
        }

        .punch-card {
            width: 200px;
            height: 290px;
            background: #fff;
            border: 1px solid var(--id_card_border_color);
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            position: relative;
            box-sizing: border-box;
            margin: 0 auto;
            overflow: hidden;
        }

        .card-header-section {
            height: 110px;
            width: 100%;
            background-color: var(--id_card_top_color);
            border-radius: 8px 8px 0 0;
            padding: 10px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .card-tag-space {
            height: 5px;
            width: 50px;
            background: #fff;
            border-radius: 10px;
            margin: 5px auto;
        }

        .card-title {
            color: white;
            margin: 5px 0;
            font-size: 1.1rem;
            text-align: center;
            font-weight: 600;
        }

        .card-image-container {
            width: 70px;
            height: 70px;
            margin: 0 auto;
            position: relative;
            top: 10px;
            border: 2px solid #fff;
            background-color: #fff;
            z-index: 2;
        }

        .card-photo {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .card-name {
            margin-top: 35px;
            font-size: 0.9rem;
            text-align: center;
            font-weight: bold;
            padding: 0 5px;
            text-transform: uppercase;
        }

        .card-role {
            background-color: var(--id_card_top_color);
            color: white;
            width: 100%;
            text-align: center;
            margin: 5px 0;
            padding: 3px 0;
            font-size: 0.85rem;
            font-weight: 500;
            text-transform: capitalize;
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
            right: 10px;
            transform: scale(1.2);
            z-index: 10;
        }

        .card-body {
            padding: 0 !important;
        }

        .search-form {
            max-width: 300px;
            margin-top: 15px;
            margin-right: 15px;
            margin-bottom: 20px;
            margin-left: auto; /* This ensures it stays to the right */
        }

        /* Print Styles */
        @media print {
            @page {
                size: A4;
                margin: 5mm;
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
                background-color: var(--id_card_top_color) !important;
            }

            .card-role {
                background-color: var(--id_card_top_color) !important;
            }

            .card-checkbox {
                display: none !important;
            }

            .page {
                page-break-after: always;
                width: 210mm;
                padding: 20mm;
            }

            .punch-card {
                box-shadow: none;
                break-inside: avoid;
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
                    <button id="selectAllButton" class="btn btn-outline-secondary btn-sm mr-2">
                        <i class="fas fa-check-square"></i> Select All
                    </button>
                    <button id="deselectAllButton" class="btn btn-outline-secondary btn-sm mr-2">
                        <i class="fas fa-square"></i> Deselect All
                    </button>
                    <button id="printButton" class="btn btn-primary btn-sm">
                        <i class="fas fa-print"></i> Print Cards
                    </button>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="d-flex justify-content-end mb-3">
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
                                    src="{{ $inner_array->photo_name ? asset('/storage/' . $inner_array->photo_name) : 'https://placehold.co/80x80' }}"
                                    alt="Employee Photo">
                                </div>
                            </div>

                            <div class="card-body">
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
            const cardsPerRow = 3;

            // Group cards into pages
            for (let i = 0; i < selectedCards.length; i += cardsPerPage) {
                const pageDiv = document.createElement('div');
                pageDiv.className = 'page';

                // Create a proper grid layout for cards - 3x3
                const gridContainer = document.createElement('div');
                gridContainer.style.display = 'grid';
                gridContainer.style.gridTemplateColumns = 'repeat(3, 1fr)';
                gridContainer.style.gridTemplateRows = 'repeat(3, 1fr)';
                gridContainer.style.gap = '15mm 10mm';
                gridContainer.style.padding = '10mm';
                gridContainer.style.width = '100%';
                gridContainer.style.height = '100%';

                // Add up to 9 cards to this page
                const pageCards = selectedCards.slice(i, i + cardsPerPage);
                pageCards.forEach(card => {
                    const clonedCard = card.cloneNode(true);
                    // Remove checkboxes for printing
                    const checkbox = clonedCard.querySelector('.card-checkbox');
                    if (checkbox) checkbox.remove();

                    // Adjust card styles for printing
                    clonedCard.style.margin = '0 auto';
                    clonedCard.style.width = '60mm';
                    clonedCard.style.height = '85mm';

                    // Create a cell for this card
                    const cell = document.createElement('div');
                    cell.style.display = 'flex';
                    cell.style.justifyContent = 'center';
                    cell.style.alignItems = 'center';
                    cell.appendChild(clonedCard);

                    gridContainer.appendChild(cell);
                });

                // Fill any empty cells to maintain grid structure
                const emptyCellsNeeded = cardsPerPage - pageCards.length;
                for (let j = 0; j < emptyCellsNeeded; j++) {
                    const emptyCell = document.createElement('div');
                    gridContainer.appendChild(emptyCell);
                }

                pageDiv.appendChild(gridContainer);
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
