@extends('layouts.app')

@section('content')
@if($errors->any())
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    <strong>
        {!! implode('<br />', $errors->all('<span>:message</span>')) !!}
    </strong>
</div>
@endif


<section class="vh-100">
    <form method="post" action="{{ route('employees.store') }}" enctype='multipart/form-data'>
        @csrf
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-xl-9">

                    <h5 class="text-black mt-5 mb-4">{{__("messages.new_employee")}}</h5>

                    <div class="card" style="border-radius: 15px;">
                        <div class="card-body">

                            <div class="row align-items-center pt-4 pb-3">
                                <div class="col-md-3 ps-5">

                                    <h6 class="mb-0">First Name</h6>

                                </div>
                                <div class="col-md-9 pe-5">

                                    <input type="text" name="first_name" class="form-control form-control-lg"
                                        required />

                                </div>
                            </div>

                            <div class="row align-items-center pt-4 pb-3">
                                <div class="col-md-3 ps-5">

                                    <h6 class="mb-0">Last Name</h6>

                                </div>
                                <div class="col-md-9 pe-5">

                                    <input type="text" name="last_name" class="form-control form-control-lg" required />

                                </div>
                            </div>

                            <hr class="mx-n3">

                            <div class="row align-items-center py-3">
                                <div class="col-md-3 ps-5">

                                    <h6 class="mb-0">Email address</h6>

                                </div>
                                <div class="col-md-9 pe-5">

                                    <input type="email" name="email" class="form-control form-control-lg"
                                        placeholder="example@example.com" required />

                                </div>
                            </div>

                            <hr class="mx-n3">

                            <div class="row align-items-center py-3">
                                <div class="col-md-3 ps-5">

                                    <h6 class="mb-0">Phone</h6>

                                </div>
                                <div class="col-md-9 pe-5">

                                    <input type="phone" name="phone" class="form-control form-control-lg"
                                        placeholder="Phone" value="" />

                                </div>
                            </div>

                            <hr class="mx-n3">

                            <div class="row align-items-center py-3">
                                <div class="col-md-3 ps-5">

                                    <h6 class="mb-0">Company</h6>

                                </div>
                                <div class="col-md-9 pe-5">

                                    <select class="form-select" name="company_id">
                                        @foreach($companies as $company)
                                        <option value="{{$company->id}}">{{$company->name}}</option>
                                        @endforeach
                                    </select>


                                </div>
                            </div>

                            <hr class="mx-n3">

                            <div class="px-5 py-4">
                                <button type="submit" class="btn btn-primary btn-lg">Create</button>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </form>
</section>
@endsection