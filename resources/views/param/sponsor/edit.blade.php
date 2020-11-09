@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-table'></i> Update Sponsor
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>Update Sponsor</h2>
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
                                <div class="text-danger mb-3">* Required Field</div>
                                {!! Form::open(['action' => ['SponsorController@update', $sponsor['id']], 'method' => 'POST'])!!}
                                    <table class="table table-bordered">
                                        <tr>
                                            <td>Sponsor Code *</td>
                                            <td colspan="3">{{Form::text('sponsor_code', $sponsor->sponsor_code, ['class' => 'form-control', 'placeholder' => 'Sponsor Code', 'onkeyup' => 'this.value = this.value.toUpperCase()'])}}</td>
                                        </tr>
                                        <tr>
                                            <td>Sponsor Name *</td>
                                            <td>{{Form::text('sponsor_name', $sponsor->sponsor_name, ['class' => 'form-control', 'placeholder' => 'Sponsor Name', 'onkeyup' => 'this.value = this.value.toUpperCase()'])}}</td>
                                            <td>Department</td>
                                            <td>{{Form::text('sponsor_dept', $sponsor->sponsor_dept, ['class' => 'form-control', 'placeholder' => 'Sponsor Department', 'onkeyup' => 'this.value = this.value.toUpperCase()'])}}</td>
                                            {{-- <td>Contact Person *</td>
                                            <td>{{Form::text('sponsor_person', $sponsor->sponsor_person, ['class' => 'form-control', 'placeholder' => 'Sponsor Contact Person', 'onkeyup' => 'this.value = this.value.toUpperCase()'])}}</td> --}}
                                        </tr>
                                        <tr>
                                            <td>Sponsor Phone Number *</td>
                                            <td>{{Form::number('sponsor_number', $sponsor->sponsor_number, ['class' => 'form-control', 'placeholder' => 'Sponsor Number'])}}</td>
                                            <td>Sponsor Email *</td>
                                            <td>{{Form::email('sponsor_email', $sponsor->sponsor_email, ['class' => 'form-control', 'placeholder' => 'Sponsor Email'])}}</td>
                                        </tr>
                                        <tr>
                                            <td>Address I</td>
                                            <td colspan="3">{{Form::text('sponsor_address_1', $sponsor->sponsor_address_1, ['class' => 'form-control', 'placeholder' => 'Sponsor Address I', 'onkeyup' => 'this.value = this.value.toUpperCase()'])}}</td>
                                        </tr>
                                        <tr>
                                            <td>Address II</td>
                                            <td colspan="3">{{Form::text('sponsor_address_2', $sponsor->sponsor_address_2, ['class' => 'form-control', 'placeholder' => 'Sponsor Address II', 'onkeyup' => 'this.value = this.value.toUpperCase()'])}}</td>
                                        </tr>
                                        <tr>
                                            <td>Postcode</td>
                                            <td>{{Form::text('sponsor_poscode', $sponsor->sponsor_poscode, ['class' => 'form-control', 'placeholder' => 'Sponsor Postcode', 'onkeyup' => 'this.value = this.value.toUpperCase()'])}}</td>
                                            <td>City</td>
                                            <td>{{Form::text('sponsor_city', $sponsor->sponsor_city, ['class' => 'form-control', 'placeholder' => 'Sponsor City', 'onkeyup' => 'this.value = this.value.toUpperCase()'])}}</td>
                                        </tr>
                                        <tr>
                                            <td>State</td>
                                            <td colspan="3">{{Form::text('sponsor_state', $sponsor->sponsor_state, ['class' => 'form-control', 'placeholder' => 'Sponsor State', 'onkeyup' => 'this.value = this.value.toUpperCase()'])}}</td>
                                        </tr>
                                    </table>
                                    <table class="table table-bordered">
                                        <tr>
                                            <td>Contact Person</td>
                                            <td>Phone Number</td>
                                            <td>Email</td>
                                        </tr>
                                        <tr>
                                            <td>{{Form::text('sponsor_person', $sponsor->sponsor_person, ['class' => 'form-control', 'placeholder' => 'Contact Person', 'onkeyup' => 'this.value = this.value.toUpperCase()'])}}</td>
                                            <td>{{Form::text('person_phone_1', $sponsor->person_phone_1, ['class' => 'form-control', 'placeholder' => 'Phone Number'])}}</td>
                                            <td>{{Form::email('person_email_1', $sponsor->person_email_1, ['class' => 'form-control', 'placeholder' => 'Email'])}}</td>
                                        </tr>
                                        <tr>
                                            <td>{{Form::text('sponsor_person_2', $sponsor->sponsor_person_2, ['class' => 'form-control', 'placeholder' => 'Contact Person', 'onkeyup' => 'this.value = this.value.toUpperCase()'])}}</td>
                                            <td>{{Form::text('person_phone_2', $sponsor->person_phone_2, ['class' => 'form-control', 'placeholder' => 'Phone Number'])}}</td>
                                            <td>{{Form::email('person_email_2', $sponsor->person_email_2, ['class' => 'form-control', 'placeholder' => 'Email'])}}</td>
                                        </tr>
                                    </table>
                                    {{Form::hidden('_method', 'PUT')}}
                                    <button class="btn btn-primary btn-sm float-right mb-3">Submit</button>
                                {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
