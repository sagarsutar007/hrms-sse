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
                    <button id="selectAllButton" class="btn btn-sm btn-secondary" onclick="selectAllCards(); return false;">Select All</button>
                    <button id="deselectAllButton" class="btn btn-sm btn-secondary" onclick="deselectAllCards(); return false;">Deselect All</button>
                    <button id="printButton" class="btn btn-sm btn-primary" onclick="printSelectedCards(); return false;">Print Selected Cards</button>
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
                color-adjust: exact !important;
            }

            .punch-card {
                box-shadow: none;
                border: 1px solid #ddd;
            }
        }
    </style>
@stop

@section('js')
    <!-- jQuery Check and Load if Needed -->
    <script>
        if (typeof jQuery === 'undefined') {
            document.write('<script src="https://code.jquery.com/jquery-3.6.0.min.js"><\/script>');
            console.error('jQuery was not loaded. Loading it now.');
        }
    </script>

    <!-- QR Code Library -->
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>

    <!-- Direct functions attached to window object -->
    <script>
        // Global functions accessible by inline onclick attributes
        function selectAllCards() {
            console.log('Select all function called');
            document.querySelectorAll('.card-checkbox').forEach(function(checkbox) {
                checkbox.checked = true;
            });
            return false;
        }

        function deselectAllCards() {
            console.log('Deselect all function called');
            document.querySelectorAll('.card-checkbox').forEach(function(checkbox) {
                checkbox.checked = false;
            });
            return false;
        }

        function printSelectedCards() {
            console.log('Print function called');
            const selectedCheckboxes = document.querySelectorAll('.card-checkbox:checked');

            if(selectedCheckboxes.length === 0) {
                alert('Please select at least one card to print.');
                return false;
            }

            // Create printable area
            const printableArea = document.createElement('div');
            printableArea.className = 'printable';

            const containerDiv = document.createElement('div');
            containerDiv.className = 'container-fluid';

            let rowDiv = document.createElement('div');
            rowDiv.className = 'row';

            // Add cards to print area
            selectedCheckboxes.forEach(function(checkbox, index) {
                const cardParent = checkbox.closest('.col-lg-2, .col-md-3, .col-sm-4');
                if(cardParent) {
                    const colDiv = document.createElement('div');
                    colDiv.className = 'col-2 mb-3';

                    // Clone the card but not the checkbox
                    const card = cardParent.querySelector('.punch-card').cloneNode(true);
                    const checkboxInCard = card.querySelector('.card-checkbox');
                    if(checkboxInCard) {
                        checkboxInCard.remove();
                    }

                    colDiv.appendChild(card);
                    rowDiv.appendChild(colDiv);

                    // Create a new row after every 6 cards
                    if((index + 1) % 6 === 0 && index < selectedCheckboxes.length - 1) {
                        containerDiv.appendChild(rowDiv);
                        rowDiv = document.createElement('div');
                        rowDiv.className = 'row';
                    }
                }
            });

            // Add remaining cards
            if(rowDiv.children.length > 0) {
                containerDiv.appendChild(rowDiv);
            }

            printableArea.appendChild(containerDiv);
            document.body.appendChild(printableArea);

            // Print
            window.print();

            // Remove print area after delay
            setTimeout(function() {
                if (document.body.contains(printableArea)) {
                    document.body.removeChild(printableArea);
                }
            }, 1000);

            return false;
        }
    </script>

    <!-- Main script for page functionality -->
    <script>
        // Wait for document to be fully loaded
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Document loaded, setting up QR codes and events');

            // Generate QR codes for each card
            @if(isset($user_data) && !empty($user_data))
                @foreach($user_data as $index => $user)
                    try {
                        new QRCode(document.getElementById("qrcode{{ $index }}"), {
                            text: "{{ url('/login') }}/{{ $user->Employee_id }}",
                            width: 80,
                            height: 80,
                        });
                        console.log('QR code generated for index {{ $index }}');
                    } catch(e) {
                        console.error('Error generating QR code for index {{ $index }}:', e);
                    }
                @endforeach
            @endif

            // Add event listeners to buttons
            const selectAllButton = document.getElementById('selectAllButton');
            const deselectAllButton = document.getElementById('deselectAllButton');
            const printButton = document.getElementById('printButton');

            if(selectAllButton) {
                selectAllButton.addEventListener('click', selectAllCards);
                console.log('Select all button event listener added');
            } else {
                console.warn('Select all button not found in DOM');
            }

            if(deselectAllButton) {
                deselectAllButton.addEventListener('click', deselectAllCards);
                console.log('Deselect all button event listener added');
            } else {
                console.warn('Deselect all button not found in DOM');
            }

            if(printButton) {
                printButton.addEventListener('click', printSelectedCards);
                console.log('Print button event listener added');
            } else {
                console.warn('Print button not found in DOM');
            }
        });

        // Also use jQuery event binding as backup
        $(function() {
            console.log('jQuery ready function running');

            $('#selectAllButton').on('click', selectAllCards);
            $('#deselectAllButton').on('click', deselectAllCards);
            $('#printButton').on('click', printSelectedCards);
        });
    </script>
@stop
