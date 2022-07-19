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
    <form method="post" action="/companies/{{$company->id}}" enctype='multipart/form-data'>
        @method("put");
        @csrf
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-xl-9">

                    <h5 class="text-black mb-4">Company Update</h5>

                    <div class="card" style="border-radius: 15px;">
                        <div class="card-body">

                            <div class="row align-items-center pt-4 pb-3">
                                <div class="col-md-3 ps-5">

                                    <h6 class="mb-0">Company Name</h6>

                                </div>
                                <div class="col-md-9 pe-5">

                                    <input type="text" name="name" value="{{$company->name}}"
                                        class="form-control form-control-lg" />

                                </div>
                            </div>

                            <hr class="mx-n3">

                            <div class="row align-items-center py-3">
                                <div class="col-md-3 ps-5">

                                    <h6 class="mb-0">Email address</h6>

                                </div>
                                <div class="col-md-9 pe-5">

                                    <input type="email" name="email" value="{{$company->email}}"
                                        class="form-control form-control-lg" placeholder="example@example.com" />

                                </div>
                            </div>

                            <hr class="mx-n3">

                            <div class="row align-items-center py-3">
                                <div class="col-md-3 ps-5">

                                    <h6 class="mb-0">Website</h6>

                                </div>
                                <div class="col-md-9 pe-5">

                                    <input type="text" name="website" value="{{$company->website}}"
                                        class="form-control form-control-lg" placeholder="Website" />

                                </div>
                            </div>

                            <hr class="mx-n3">

                            <div class="row align-items-center py-3">
                                <div class="col-md-3 ps-5">

                                    <h6 class="mb-0">Upload Logo</h6>

                                </div>
                                <div class="col-md-9 pe-5">

                                    <input class="form-control form-control-lg" id="logo" name="logo" type="file" />
                                    <div class="small text-muted mt-2">Upload company logo minsize(100X100)</div>

                                </div>
                            </div>

                            <hr class="mx-n3">

                            <div class="px-5 py-4">
                                <button type="submit" class="btn btn-primary btn-lg">Update</button>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </form>
</section>
@endsection