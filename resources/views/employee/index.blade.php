@extends('layouts.app')

@section('content')

@if(Session::has('success'))
<div class="alert alert-success" id="alert">
    <strong>Success:</strong> {{Session::get('success')}}
</div>

@elseif(session('error'))
<div class="alert alert-danger" id="alert">
    <strong>Error:</strong>{{Session::get('error')}}
</div>
@endif

<div class="container">

    <div class=" pt-4  font-weight-bold d-flex justify-content-between w-100">
        <p>{{__("messages.emp_pg_title")}}</p>
        <p><a class="btn btn-success" href="{{ route('employees.create') }}"> Create New Employee</a></p>
    </div>

    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Company</th>
                <th width="150px">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>


<script type="text/javascript">
$(document).ready(function() {
    $.noConflict();
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('employees.index') }}",
        columns: [{
                data: 'id',
                name: 'id'
            },
            {
                data: 'first_name',
                name: 'first_name'
            },
            {
                data: 'last_name',
                name: 'last_name'
            },
            {
                data: 'email',
                name: 'email'
            },
            {
                data: 'phone',
                name: 'phone'
            },
            {
                data: 'company.name',
                name: 'company.name'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ]
    });
});
</script>
@endsection