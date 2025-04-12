@extends('adminlte::page')

@section('title', 'All Payslip')

@section('content_header')
    <h1>All Payslip</h1>
@stop

@section('content')
@isset($emp_type_Data)

<div class="card">
    <div class="card-header">
        <form action="{{ route('all_payslip_search') }}" method="POST" class="form-inline">
            @csrf
            <div class="input-group mr-2">
                <input type="text" name="search_input" class="form-control" placeholder="Search by name & Email">
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search mr-1"></i> Search
            </button>
        </form>
    </div>

    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead class="thead-light">
                <tr>
                    <th>Sr.N.</th>
                    <th>Name</th>
                    <th>Employee ID</th>
                    <th>Net Salary</th>
                    <th>Salary Month</th>
                    <th>Payroll Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @php $count = 1; @endphp
                @foreach($emp_type_Data as $emp_Data)
                    <tr>
                        <td>{{ $count++ }}</td>
                        <td>{{ $emp_Data->f_name }} {{ $emp_Data->m_name }} {{ $emp_Data->l_name }}</td>
                        <td>{{ $emp_Data->Employee_id }}</td>
                        <td>{{ $emp_Data->Net_Salarye }}</td>
                        <td>{{ $emp_Data->Salary_Month }}</td>
                        <td>{{ $emp_Data->Payroll_Date }}</td>
                        <td>{{ $emp_Data->Status }}</td>
                        <td>
                            <a href="{{ url('edit-payslip/'.$emp_Data->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="{{ url('delete/'.$emp_Data->id.'/payslip') }}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                <i class="fas fa-trash"></i> Delete
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endisset
@stop
