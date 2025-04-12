@extends('adminlte::page')

@section('title', 'Holidays Calendar')

@section('content_header')
    <h1>Holidays Calendar</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-9">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Calendar</h3>
            </div>
            <div class="card-body">
                <div id="calendar">
                    <div id="header" class="d-flex justify-content-between align-items-center mb-3">
                        <button id="prev-month" class="btn btn-default"><i class="fas fa-angle-left"></i></button>
                        <div id="month-year">
                            <span id="current-month" class="clickable h4 mr-2"></span>
                            <span id="current-year" class="clickable h4"></span>
                        </div>
                        <button id="next-month" class="btn btn-default"><i class="fas fa-angle-right"></i></button>
                    </div>
                    <div id="days-of-week" class="d-flex justify-content-between mb-2"></div>
                    <div id="days" class="calendar-grid"></div>
                </div>
                <div id="selector-container" class="mt-3"></div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Holiday Options</h3>
            </div>
            <div class="card-body">
                <div class="list-group">
                    <a href="{{ url('/all-holidays') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-calendar-alt mr-2"></i> All Holidays
                    </a>
                    <a href="#" class="list-group-item list-group-item-action" id="add-holiday-btn">
                        <i class="fas fa-plus mr-2"></i> Add Holiday
                    </a>
                    {{-- <a href="#" class="list-group-item list-group-item-action">
                        <i class="fas fa-upload mr-2"></i> Bulk Upload
                    </a> --}}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Holiday Modal -->
<div class="modal fade" id="addHolidayModal" tabindex="-1" role="dialog" aria-labelledby="addHolidayModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addHolidayModalLabel">Add Holiday</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="holidayForm" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nmt">Holiday Name*</label>
                        <input type="text" class="form-control" id="nmt" name="Holiday_Name" placeholder="Enter holiday name" required>
                    </div>
                    <div class="form-group">
                        <label for="Holiday_Date">Holiday Date*</label>
                        <input type="date" class="form-control" id="Holiday_Date" name="Holiday_Date" required>
                    </div>
                    <div class="form-group d-none">
                        <label for="Swap_with_Datem">Swap with Date</label>
                        <input type="date" class="form-control" id="Swap_with_Datem" name="Swap_with_Date">
                    </div>
                    <div class="form-group">
                        <label for="Public_Holiday">Public Holiday*</label>
                        <select class="form-control" id="Public_Holiday" name="status" required>
                            <option value="">Select</option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="submit_btn">Save Holiday</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Error Toast -->
<div class="toast" id="errorToast" style="position: absolute; top: 20px; right: 20px;" role="alert" aria-live="assertive" aria-atomic="true" data-delay="3000">
    <div class="toast-header bg-danger text-white">
        <strong class="mr-auto">Error</strong>
        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="toast-body" id="error_message">
    </div>
</div>

<!-- Success Toast -->
<div class="toast" id="successToast" style="position: absolute; top: 20px; right: 20px;" role="alert" aria-live="assertive" aria-atomic="true" data-delay="3000">
    <div class="toast-header bg-success text-white">
        <strong class="mr-auto">Success</strong>
        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="toast-body" id="success_message">
    </div>
</div>
@stop

@section('css')
<style>
    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 5px;
    }

    .day {
        padding: 10px;
        height: 60px;
        border: 1px solid #ddd;
        cursor: pointer;
        border-radius: 4px;
        position: relative;
        transition: all 0.3s ease;
        background-color: #ffffff;
    }

    .day:hover {
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transform: translateY(-2px);
        background-color: #f8f9fa;
    }

    .inactive {
        color: #aaa;
        padding: 10px;
        height: 60px;
        border: 1px solid #eee;
        border-radius: 4px;
        background-color: #f9f9f9;
    }

    .active {
        background-color: #e9ecef;
        font-weight: bold;
        border: 2px solid #007bff;
    }

    .sunday {
        color: #dc3545;
    }

    .event {
        font-size: 10px;
        padding: 3px 5px;
        margin-top: 5px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        background-color: rgba(232, 62, 140, 0.2);
        border-radius: 3px;
        color: #e83e8c;
    }

    .clickable {
        cursor: pointer;
    }

    .selector {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 10px;
        margin-top: 10px;
    }

    .month-option, .year-option {
        padding: 10px;
        text-align: center;
        cursor: pointer;
        border: 1px solid #ddd;
        border-radius: 4px;
        transition: all 0.2s ease;
    }

    .month-option:hover, .year-option:hover {
        background-color: #007bff;
        color: white;
        transform: scale(1.05);
    }

    #header {
        background-color: #f8f9fa;
        padding: 10px;
        border-radius: 4px;
        margin-bottom: 15px;
    }

    #month-year {
        color: #3c8dbc;
    }

    .bg-pink {
        background-color: rgba(232, 62, 140, 0.1);
    }

    .card {
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
        border-radius: 8px;
        border: none;
    }

    .card-header {
        background-color: #3c8dbc;
        color: white;
        border-radius: 8px 8px 0 0 !important;
    }

    .list-group-item {
        transition: all 0.2s ease;
    }

    .list-group-item:hover {
        background-color: #f8f9fa;
        transform: translateX(5px);
    }

    #calendar {
        min-height: 500px;
    }

    .day-number {
        font-weight: 500;
        font-size: 14px;
    }

    /* Holiday types */
    .holiday-public {
        background-color: rgba(40, 167, 69, 0.2);
        border-left: 3px solid #28a745;
    }

    .holiday-non-public {
        background-color: rgba(255, 193, 7, 0.2);
        border-left: 3px solid #ffc107;
    }
</style>
@stop

@section('js')
<script>
$(document).ready(function () {
    // Show the modal when clicking "Add Holiday" button
    $("#add-holiday-btn").on("click", function() {
        $("#addHolidayModal").modal('show');
    });

    // Calendar initialization
    var calendar = {
        current: new Date(),
        activeDate: null,
        events: {}
    };

    const daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

    // Function to render the calendar
    function renderCalendar() {
        const month = calendar.current.getMonth();
        const year = calendar.current.getFullYear();
        const today = new Date();

        $('#current-month').text(calendar.current.toLocaleString('default', { month: 'long' }));
        $('#current-year').text(year);

        // Create day headers with improved styling
        const dayHeadersHtml = daysOfWeek.map(day => {
            const isSunday = day === 'Sun' ? 'text-danger' : '';
            return `<div class="text-center font-weight-bold ${isSunday}">${day}</div>`;
        }).join('');

        $('#days-of-week').html(dayHeadersHtml);

        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const prevMonthDays = new Date(year, month, 0).getDate();

        let daysHtml = '';

        // Previous month days
        for (let i = firstDay; i > 0; i--) {
            daysHtml += `<div class="inactive">${prevMonthDays - i + 1}</div>`;
        }

        // Current month days
        for (let i = 1; i <= daysInMonth; i++) {
            const date = new Date(year, month, i);
            const dateKey = `${year}-${String(month + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
            const isToday = today.toDateString() === date.toDateString() ? 'active' : '';
            const isSunday = date.getDay() === 0 ? 'sunday' : '';

            const event = calendar.events[dateKey] ? calendar.events[dateKey].name : '';
            const isPublic = calendar.events[dateKey] && calendar.events[dateKey].isPublic ? 'holiday-public' : calendar.events[dateKey] ? 'holiday-non-public' : '';
            const eventHtml = event ? `<div class="event">${event}</div>` : '';
            const hasEvent = event ? 'bg-pink' : '';

            daysHtml += `
                <div class="day ${isToday} ${isSunday} ${hasEvent} ${isPublic}" data-date="${dateKey}">
                    <span class="day-number">${i}</span>
                    ${eventHtml}
                </div>`;
        }

        // Next month days (to fill the remaining grid)
        const totalDays = firstDay + daysInMonth;
        const remainingDays = 42 - totalDays; // 6 weeks x 7 days = 42

        for (let i = 1; i <= remainingDays; i++) {
            daysHtml += `<div class="inactive">${i}</div>`;
        }

        $('#days').html(daysHtml);
    }

    function showMonthSelector() {
        const months = Array.from({ length: 12 }, (_, i) =>
            `<div class="month-option" data-month="${i}">
                ${new Date(0, i).toLocaleString('default', { month: 'long' })}
            </div>`).join('');

        $('#selector-container').html(`<div class="selector">${months}</div>`).fadeIn();
    }

    function showYearSelector() {
        const currentYear = calendar.current.getFullYear();
        const years = Array.from({ length: 21 }, (_, i) =>
            `<div class="year-option" data-year="${currentYear - 10 + i}">
                ${currentYear - 10 + i}
            </div>`).join('');

        $('#selector-container').html(`<div class="selector">${years}</div>`).fadeIn();
    }

    // Navigation events
    $(document).on('click', '#prev-month', function () {
        calendar.current.setMonth(calendar.current.getMonth() - 1);
        renderCalendar();
    });

    $(document).on('click', '#next-month', function () {
        calendar.current.setMonth(calendar.current.getMonth() + 1);
        renderCalendar();
    });

    $(document).on('click', '#current-month', showMonthSelector);
    $(document).on('click', '#current-year', showYearSelector);

    $(document).on('click', '.month-option', function () {
        calendar.current.setMonth($(this).data('month'));
        $('#selector-container').fadeOut();
        renderCalendar();
    });

    $(document).on('click', '.year-option', function () {
        calendar.current.setFullYear($(this).data('year'));
        $('#selector-container').fadeOut();
        renderCalendar();
    });

    // Day click event
    $(document).on('click', '.day', function () {
        const dateStr = $(this).data('date');
        $("#Holiday_Date").val(dateStr);
        $("#addHolidayModal").modal('show');
    });

    // Function to load holidays
    function loadHolidays() {
        $.ajax({
            url: "{{ url('/all-holiday-api') }}/" + 100000000,
            type: "GET",
            dataType: "json",
            headers: {
                "Content-Type": "application/json"
            },
            success: function(response) {
                // Clear existing events
                calendar.events = {};

                if (response && response.all_users && response.all_users.data) {
                    const eventData = response.all_users.data;

                    eventData.forEach(event => {
                        calendar.events[event.holiday_Date] = {
                            name: event.Holiday_name,
                            isPublic: event.Public_Holiday === "1"  // Changed from status to Public_Holiday
                        };
                    });

                    renderCalendar();
                } else {
                    console.error("Invalid response format:", response);
                    showError("Failed to load holidays: Invalid response format");
                }
            },
            error: function(xhr, status, error) {
                console.error("Error:", error);
                showError("Failed to load holidays: " + error);
            }
        });
    }

    // Show error messages using toast
    function showError(message) {
        $('#error_message').text(message);
        $('#errorToast').toast('show');
    }

    // Show success messages using toast
    function showSuccess(message) {
        $('#success_message').text(message);
        $('#successToast').toast('show');
    }

    // Form submission
    $("#holidayForm").on("submit", function(event) {
        event.preventDefault();

        $.ajax({
            url: "{{ route('add_holiday_api') }}",
            method: "POST",
            data: $(this).serialize(),
            success: function(response) {
                if (response.status) {
                    showSuccess(response.message);
                    $("#addHolidayModal").modal('hide');
                    $("#holidayForm")[0].reset();

                    // Reload holidays to refresh the calendar
                    loadHolidays();
                }
            },
            error: function(xhr) {
                showError("Error saving holiday: " + xhr.responseText);
                console.log(xhr.responseText);
            }
        });
    });

    // Initialize calendar and load holidays
    loadHolidays();
    renderCalendar();
});
</script>
@stop
