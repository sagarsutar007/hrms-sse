@extends('adminlte::page')

@section('title', 'Employee Association Time List')

@section('content_header')
    <h1 class="m-0 text-dark">Association Time List</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">Association Time Details</h3>
        </div>

        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Filter by Date</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-calendar"></i>
                                </span>
                            </div>
                            <input type="date" id="date_input" class="form-control">
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table id="association-time-table" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Sr. No.</th>
                            <th>Employee Name</th>
                            <th>Date of Joining</th>
                            <th>Years Months Difference</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Leave Details Modal --}}
<div class="modal fade" id="leaveDetailsModal" tabindex="-1" role="dialog" aria-labelledby="leaveDetailsModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="leaveDetailsModalLabel">
                    <i class="fas fa-info-circle mr-2"></i>Leave Details
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="leaveDetailsContent">
                {{-- Dynamic content will be loaded here --}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<input type="hidden" value="{{session('role_number')}}" id="role_number">
@endsection

@section('js')
<script>
$(document).ready(function() {
    // DataTable initialization remains largely the same as in the original script
    var table = $('#association-time-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{url('/association_time_api')}}",
            type: 'GET',
            data: function(d) {
                d.date = $('#date_input').val();
            },
            dataSrc: function(json) {
                return json.data || [];
            }
        },
        columns: [
            {
                data: null,
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            { data: 'name', name: 'name' },
            { data: 'DOJ', name: 'DOJ' },
            { data: 'years_months_diff', name: 'years_months_diff' },
            {
                data: null,
                render: function(data, type, row) {
                    return `
                        <button class="btn btn-sm btn-info view-leave" data-id="${row.id}">
                            <i class="fas fa-eye mr-1"></i>View Leaves
                        </button>
                    `;
                }
            }
        ],
        responsive: true,
        pageLength: 10,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        order: [[0, 'asc']]
    });

    // Date filter
    $('#date_input').on('change', function() {
        table.draw();
    });

    // Leave view event delegation (remains the same as original)
    $(document).on('click', '.view-leave', function() {
        var employeeId = $(this).data('id');

        $.ajax({
            type: "GET",
            url: "{{url('/leave-view')}}/" + employeeId,
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    var r_data = response.data;
                    var leaveDetailsHtml = `
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card card-info">
                                    <div class="card-header">
                                        <h3 class="card-title">Personal Details</h3>
                                    </div>
                                    <div class="card-body">
                                        <p><strong>Name:</strong> ${r_data.Name || 'N/A'}</p>
                                        <p><strong>Employee ID:</strong> ${r_data.Employee_id || 'N/A'}</p>
                                        <p><strong>Description:</strong> ${r_data.Description || 'N/A'}</p>
                                        <p><strong>Remarks by Approve:</strong> ${r_data.Remarks_by_Approve || 'N/A'}</p>
                                        <p><strong>Total Days:</strong> ${r_data.Total_Days || 'N/A'}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Leave Details</h3>
                                    </div>
                                    <div class="card-body">
                                        <p><strong>Leave Type:</strong> ${r_data.Leave_Type_name || 'N/A'}</p>
                                        <p><strong>Start Date:</strong> ${r_data.Start_Date || 'N/A'}</p>
                                        <p><strong>End Date:</strong> ${r_data.End_Date || 'N/A'}</p>
                                        <p><strong>Status:</strong> ${r_data.Status || 'N/A'}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;

                    $('#leaveDetailsContent').html(leaveDetailsHtml);
                    $('#leaveDetailsModal').modal('show');
                } else {
                    $('#leaveDetailsContent').html('<div class="alert alert-warning">No leave details found.</div>');
                    $('#leaveDetailsModal').modal('show');
                }
            },
            error: function(xhr, status, error) {
                console.error("Error:", error);
                $('#leaveDetailsContent').html('<div class="alert alert-danger">Error loading leave details.</div>');
                $('#leaveDetailsModal').modal('show');
            }
        });
    });

    // Set current date
    function setCurrentDate() {
        const today = new Date();
        const formattedDate = today.toISOString().split('T')[0];
        $('#date_input').val(formattedDate);
    }
    setCurrentDate();
});
</script>
@endsection
