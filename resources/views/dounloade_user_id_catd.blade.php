@extends('adminlte::page')

@section('title', 'Employee ID Cards')

@section('content_header')
    <h1>Employee ID Cards</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Selected Employee ID Cards</h5>
                <div>
                    <button id="download-all-cards" class="btn btn-success">
                        <i class="fas fa-download"></i> Download All Cards
                    </button>
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                @if(isset($user_data) && $user_data->count() > 0)
                    @foreach($user_data as $index => $user)
                        <div class="col-md-6 col-lg-4 my-4">
                            <div class="id-card-container">
                                <div class="punch-card" id="id_card{{ $index }}">
                                    <div class="card-header-section">
                                        <div class="card-tag-space"></div>
                                        <h2 class="card-title">Punch Card</h2>
                                        <div class="card-image-container">
                                            <img class="card-photo"
                                            src="{{ $user->photo_name ? asset('/storage/' . $user->photo_name) : 'https://placehold.co/80x80' }}"
                                            alt="Employee Photo">
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <h2 class="card-name">{{ strtoupper($user->f_name . ' ' . $user->l_name) }}</h2>
                                        <h3 class="card-role">{{ $user->roles }}</h3>
                                        <div class="card-qr-container">
                                            <div id="qrcode-{{ $index }}"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Download Button -->
                                <div class="download-button text-center mt-2">
                                    <button class="btn btn-primary btn-sm download-card"
                                            onclick="downloadIdAsJpg('id_card{{ $index }}', '{{ $user->f_name }}_{{ $user->l_name }}')">
                                        <i class="fas fa-download"></i> Download This Card
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12">
                        <div class="alert alert-info">
                            No ID cards selected or found.
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@stop

@section('css')
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
        height: 320px;
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

@section('js')
<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.0.0-rc.7/dist/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Initialize QR codes after DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
        @if(isset($user_data) && $user_data->count() > 0)
            @foreach($user_data as $index => $user)
                try {
                    new QRCode(document.getElementById("qrcode-{{ $index }}"), {
                        text: "{{ url('/login') }}/{{ $user->Employee_id ?? $user->id }}",
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


    function downloadIdAsJpg(id, employeeName) {
        const content = document.getElementById(id);

        // Display loading message
        Swal.fire({
            title: 'Generating card...',
            text: 'Please wait',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Make sure the element is visible and has layout
        const originalDisplay = content.style.display;
        content.style.display = 'block';

        // Force a repaint
        void content.offsetWidth;

        // Wait for any pending operations
        setTimeout(() => {
            // Set specific dimensions for better capture
            const cardWidth = content.offsetWidth;
            const cardHeight = content.offsetHeight;

            html2canvas(content, {
                scale: 3,
                backgroundColor: "#ffffff",
                useCORS: true,
                allowTaint: true,
                foreignObjectRendering: true, // Try enabling this option
                logging: true,
                // Use exact dimensions of the ID card
                width: cardWidth,
                height: cardHeight,
                // Ensure we're getting the full element
                scrollX: 0,
                scrollY: 0,
                windowWidth: document.documentElement.offsetWidth,
                windowHeight: document.documentElement.offsetHeight
            }).then(function(canvas) {
                // Convert the canvas to a data URL
                const imgData = canvas.toDataURL('image/jpeg', 1.0); // Use maximum quality

                // Create a temporary link to trigger the download
                const link = document.createElement('a');
                link.href = imgData;
                link.download = employeeName ? 'punch-card-' + employeeName + '.jpg' : 'punch-card.jpg';
                document.body.appendChild(link); // Needed for Firefox
                link.click();
                document.body.removeChild(link);

                // Restore original display
                content.style.display = originalDisplay;

                // Close loading message
                Swal.close();
            }).catch(error => {
                console.error("Error generating card:", error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to generate ID card: ' + error.message
                });
                content.style.display = originalDisplay;
            });
        }, 300); // Give time for layout to stabilize
    }

    // Download all ID cards
    document.getElementById('download-all-cards').addEventListener('click', function() {
        const idCards = document.querySelectorAll('[id^="id_card"]');

        if (idCards.length === 0) {
            Swal.fire({
                icon: 'info',
                title: 'No Cards',
                text: 'No ID cards available to download'
            });
            return;
        }

        // Show loading indicator
        Swal.fire({
            title: 'Preparing downloads...',
            html: `Preparing ${idCards.length} ID cards for download`,
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        let completedDownloads = 0;
        const totalCards = idCards.length;

        // Download each card with a delay between them
        idCards.forEach((card, index) => {
            setTimeout(() => {
                html2canvas(card, {
                    scale: 3, // Higher resolution
                    backgroundColor: "#ffffff",
                    useCORS: true
                }).then(function(canvas) {
                    const imgData = canvas.toDataURL('image/jpeg', 0.95);
                    const link = document.createElement('a');
                    link.href = imgData;
                    link.download = 'punch-card-' + (index + 1) + '.jpg';
                    link.click();

                    completedDownloads++;

                    // Update progress
                    Swal.update({
                        title: 'Downloading...',
                        html: `Downloaded ${completedDownloads} of ${totalCards} ID cards`
                    });

                    if (completedDownloads === totalCards) {
                        // All downloads completed
                        setTimeout(() => {
                            Swal.fire({
                                icon: 'success',
                                title: 'Download Complete',
                                html: `Successfully downloaded ${totalCards} ID card${totalCards > 1 ? 's' : ''}`,
                                timer: 3000
                            });
                        }, 500);
                    }
                }).catch(error => {
                    console.error("Error generating card:", error);
                });
            }, index * 800); // Increased delay to prevent browser issues
        });
    });
</script>
@stop
