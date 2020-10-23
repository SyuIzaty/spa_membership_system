@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content">
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-plus-circle'></i> Create Sponsor
        </h1>
    </div>
    <div class="row">

        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Create <span class="fw-300"><i>Sponsor</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if(session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                        @endif
                        <div class="card-body">
                            {!! Form::open(['action' => 'SponsorController@store', 'method' => 'POST']) !!}
                                <table class="table table-bordered">
                                    <tr>
                                        <td>Sponsor Code</td>
                                        <td colspan="3">{{Form::text('sponsor_code', '', ['class' => 'form-control', 'placeholder' => 'Sponsor Code', 'onkeyup' => 'this.value = this.value.toUpperCase()'])}}</td>
                                    </tr>
                                    <tr>
                                        <td>Sponsor Name</td>
                                        <td>{{Form::text('sponsor_name', '', ['class' => 'form-control', 'placeholder' => 'Sponsor Name', 'onkeyup' => 'this.value = this.value.toUpperCase()'])}}</td>
                                        <td>Sponsor Detail</td>
                                        <td>{{Form::text('sponsor_detail', '', ['class' => 'form-control', 'placeholder' => 'Sponsor Detail', 'onkeyup' => 'this.value = this.value.toUpperCase()' ])}}</td>
                                    </tr>
                                    <tr>
                                        <td>Department</td>
                                        <td>{{Form::text('sponsor_dept', '', ['class' => 'form-control', 'placeholder' => 'Department', 'onkeyup' => 'this.value = this.value.toUpperCase()'])}}</td>
                                        <td>Contact Person</td>
                                        <td>{{Form::text('sponsor_person', '', ['class' => 'form-control', 'placeholder' => 'Contact Person', 'onkeyup' => 'this.value = this.value.toUpperCase()'])}}</td>
                                    </tr>
                                    <tr>
                                        <td>Phone Number</td>
                                        <td>{{Form::number('sponsor_number', '', ['class' => 'form-control', 'placeholder' => 'Phone Number'])}}</td>
                                        <td>Email</td>
                                        <td>{{Form::email('sponsor_email', '', ['class' => 'form-control', 'placeholder' => 'Sponsor Email'])}}</td>
                                    </tr>
                                    <tr>
                                        <td>Address I</td>
                                        <td>{{Form::text('sponsor_address_1', '', ['class' => 'form-control', 'placeholder' => 'Sponsor Address 1', 'onkeyup' => 'this.value = this.value.toUpperCase()'])}}</td>
                                    </tr>
                                    <tr>
                                        <td>Address II</td>
                                        <td>{{Form::text('sponsor_address_2', '', ['class' => 'form-control', 'placeholder' => 'Sponsor Address II', 'onkeyup' => 'this.value = this.value.toUpperCase()'])}}</td>
                                        <td>Postcode</td>
                                        <td>{{Form::number('sponsor_poscode', '', ['class' => 'form-control', 'placeholder' => 'Sponsor Postcode', 'onkeyup' => 'this.value = this.value.toUpperCase()'])}}</td>
                                    </tr>
                                    <tr>
                                        <td>City</td>
                                        <td>{{Form::text('sponsor_city', '', ['class' => 'form-control', 'placeholder' => 'Sponsor City', 'onkeyup' => 'this.value = this.value.toUpperCase()'])}}</td>
                                        <td>State</td>
                                        <td>{{Form::text('sponsor_state', '', ['class' => 'form-control', 'placeholder' => 'Sponsor State', 'onkeyup' => 'this.value = this.value.toUpperCase()'])}}</td>
                                    </tr>
                                </table>
                                <button class="btn btn-primary float-right mb-3 btn-sm">Submit</button>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>
@endsection
