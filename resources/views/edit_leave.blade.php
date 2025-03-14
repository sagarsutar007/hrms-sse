@extends('adminlte::page')

@section('title', 'Update Leave')

@section('content_header')
    <h1>Update Leave</h1>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Update Leave</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" onclick="history.back()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                @isset($emp_type_Data)
                    @foreach ($emp_type_Data as $emp_data)
                    <form action="{{ route('update_leave') }}" method="post">
                        @csrf
                        <div class="card-body">
                            <input type="hidden" name="id" value="{{ $emp_data->id }}">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Leave_Type">Leave Type <span class="text-danger">*</span></label>
                                        <input type="text" name="Leave_Type" id="Leave_Type" class="form-control" value="{{ $emp_data->Leave_Type }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox mt-4">
                                            <input type="checkbox" class="custom-control-input" id="half_daY_check_box" name="half_day" value="1" {{ $emp_data->Half_Day == 1 ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="half_daY_check_box">Half Day</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Start_Date">Start Date <span class="text-danger">*</span></label>
                                        <div class="input-group date">
                                            <input type="date" name="Start_Date" id="Start_Date" class="form-control" value="{{ $emp_data->Start_Date }}" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="End_Date">End Date <span class="text-danger">*</span></label>
                                        <div class="input-group date">
                                            <input type="date" name="End_Date" id="End_Date" class="form-control" value="{{ $emp_data->End_Date }}" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Total_Days">Total Days <span class="text-danger">*</span></label>
                                        <input type="text" name="Total_Days" id="Total_Days" class="form-control" value="{{ $emp_data->Total_Days }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Description">Description <span class="text-danger">*</span></label>
                                        <input type="text" name="Description" id="Description" class="form-control" value="{{ $emp_data->Description }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Remarks_by_Approver">Remarks by Approver <span class="text-danger">*</span></label>
                                        <input type="text" name="Remarks_by_Approver" id="Remarks_by_Approver" class="form-control" value="{{ $emp_data->Remarks_by_Approve }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Status <span class="text-danger">*</span></label>
                                        <select name="status" id="status" class="form-control" required>
                                            <option value="0" {{ $emp_data->Status == '0' ? 'selected' : '' }}>Select status</option>
                                            <option value="pending" {{ strtolower($emp_data->Status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="approved" {{ strtolower($emp_data->Status) == 'approved' ? 'selected' : '' }}>Approved</option>
                                            <option value="Rejected" {{ strtolower($emp_data->Status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="button" class="btn btn-secondary" onclick="history.back()">Cancel</button>
                        </div>
                    </form>
                    @endforeach
                @endisset
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
@endsection

@section('js')
<script>
    $(document).ready(function() {
        // Function to calculate and set total days
        function calculateTotalDays() {
            const startDate = new Date($("#Start_Date").val());
            const endDate = new Date($("#End_Date").val());
            const isHalfDay = $("#half_daY_check_box").is(":checked");

            // Check if both dates are valid
            if (startDate && endDate && !isNaN(startDate) && !isNaN(endDate)) {
                if (isHalfDay) {
                    // If Half Day is checked
                    $("#Total_Days").val(0.5);

                    // Ensure start and end dates are the same
                    $("#End_Date").val($("#Start_Date").val());
                } else {
                    // If Half Day is not checked
                    const timeDifference = endDate - startDate;

                    if (timeDifference >= 0) {
                        const daysDifference = Math.ceil(timeDifference / (1000 * 60 * 60 * 24)) + 1;
                        $("#Total_Days").val(daysDifference);
                    } else {
                        // If end date is earlier than start date, reset Total Days
                        $("#Total_Days").val(0);
                    }
                }
            }
        }

        // Show alert if Half Day is checked and End Date is changed
        $("#End_Date").on("change", function() {
            const isHalfDay = $("#half_daY_check_box").is(":checked");
            if (isHalfDay) {
                Swal.fire({
                    title: 'Half Day Selected',
                    text: 'End Date should be the same as Start Date.',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
                // Force end date to be same as start date
                $("#End_Date").val($("#Start_Date").val());
            }
            calculateTotalDays();
        });

        // Bind change event on Start Date and Half Day checkbox
        $("#Start_Date").on("change", calculateTotalDays);
        $("#half_daY_check_box").on("change", function() {
            if ($(this).is(":checked")) {
                // If half day is checked, make end date same as start date
                $("#End_Date").val($("#Start_Date").val());
            }
            calculateTotalDays();
        });

        // Initialize calculation on page load
        calculateTotalDays();
    });
</script>
@endsection
