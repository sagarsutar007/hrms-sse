@extends('adminlte::page')

@section('title', 'Holiday Management')

@section('content_header')
    <h1>Holiday Management</h1>
@stop

@section('content')
<div class="row">
    <!-- Left Section - FullCalendar UI -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title">Holiday Calendar</h3>
            </div>
            <div class="card-body">
                <div id="holidayCalendar"></div>
            </div>
        </div>
    </div>

    <!-- Right Section - Buttons -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <!-- All Holidays Button (Triggers Modal) -->
                <button class="btn btn-outline-primary btn-block" data-toggle="modal" data-target="#holidaysModal">
                    All Holidays
                </button>

                <div class="mt-3 text-center">
                    <label for="fileUpload" class="btn btn-primary btn-block">
                        <i class="fas fa-file-upload"></i> Choose File
                    </label>
                    <input type="file" id="fileUpload" class="d-none">
                    <p id="fileName" class="mt-2 text-muted">No file chosen</p>

                    <button type="button" class="btn btn-success btn-block mt-2">
                        <i class="fas fa-upload"></i> Bulk Upload
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Holidays Modal -->
<div class="modal fade" id="holidaysModal" tabindex="-1" aria-labelledby="holidaysModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="holidaysModalLabel">Holiday List</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Holiday Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td>2025-02-02</td><td>Holiday A</td></tr>
                        <tr><td>2025-02-09</td><td>Holiday B</td></tr>
                        <tr><td>2025-02-16</td><td>Holiday C</td></tr>
                        <tr><td>2025-02-23</td><td>Holiday D</td></tr>
                        <tr><td>2025-02-24</td><td>Special Holiday</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.5/main.min.css">
    <style>
        /* Fixed Height for Calendar */
        #holidayCalendar {
            max-height: 1200px; /* Adjust this value as needed */
            overflow-y: auto;
        }
    </style>
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.5/main.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('holidayCalendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                height: 600,  // Fixed height for calendar
                events: [
                    { title: 'Holiday A', start: '2025-02-02', color: 'red' },
                    { title: 'Holiday B', start: '2025-02-09', color: 'red' },
                    { title: 'Holiday C', start: '2025-02-16', color: 'red' },
                    { title: 'Holiday D', start: '2025-02-23', color: 'red' },
                    { title: 'Special Holiday', start: '2025-02-24', color: 'blue' }
                ]
            });
            calendar.render();
        });
        document.getElementById('fileUpload').addEventListener('change', function(event) {
            var fileName = event.target.files[0] ? event.target.files[0].name : 'No file chosen';
            document.getElementById('fileName').textContent = fileName;
        });

    </script>
@stop
