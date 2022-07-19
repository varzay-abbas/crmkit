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
        <p>{{__("messages.cmp_pg_title")}}</p>
        <p><a class="btn btn-success" href="{{ route('companies.create') }}"> Create New Company</a></p>
    </div>

    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Logo</th>
                <th>Website</th>
                <th width="100px">CLogo</th>
                <th width="100px">Action</th>
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
        ajax: "{{ route('companies.index') }}",
        columns: [{
                data: 'id',
                name: 'id'
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'email',
                name: 'email'
            },
            {
                data: 'logo',
                name: 'logo'
            },
            {
                data: 'website',
                name: 'website'
            },
            {
                data: 'clogo',
                name: 'clogo',
                orderable: false,
                searchable: false
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