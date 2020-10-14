@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-table'></i> Sponsor
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>Edit Sponsor</h2>
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
                                {!! Form::open(['action' => ['SponsorController@update', $sponsor['id']], 'method' => 'POST'])!!}
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            {{Form::label('title', 'Sponsor Code')}}
                                            {{Form::text('sponsor_code', $sponsor->sponsor_code, ['class' => 'form-control', 'placeholder' => 'Sponsor Code'])}}
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{Form::label('title', 'Sponsor Name')}}
                                            {{Form::text('sponsor_name', $sponsor->sponsor_name, ['class' => 'form-control', 'placeholder' => 'Sponsor Name'])}}
                                        </div>
                                        <div class="form-group col-md-12">
                                            {{Form::label('title', 'Sponsor Detail')}}
                                            {{Form::text('sponsor_detail', $sponsor->sponsor_detail, ['class' => 'form-control', 'placeholder' => 'Sponsor Detail'])}}
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{Form::label('title', 'Sponsor Number')}}
                                            {{Form::number('sponsor_number', $sponsor->sponsor_number, ['class' => 'form-control', 'placeholder' => 'Sponsor Number'])}}
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{Form::label('title', 'Sponsor Email')}}
                                            {{Form::email('sponsor_email', $sponsor->sponsor_email, ['class' => 'form-control', 'placeholder' => 'Sponsor Email'])}}
                                        </div>
                                        <div class="form-group col-md-12">
                                            {{Form::label('title', 'Sponsor Address I')}}
                                            {{Form::text('sponsor_address_1', $sponsor->sponsor_address_1, ['class' => 'form-control', 'placeholder' => 'Sponsor Address I'])}}
                                        </div>
                                        <div class="form-group col-md-12">
                                            {{Form::label('title', 'Sponsor Address II')}}
                                            {{Form::text('sponsor_address_2', $sponsor->sponsor_address_2, ['class' => 'form-control', 'placeholder' => 'Sponsor Address II'])}}
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{Form::label('title', 'Sponsor Contact Person')}}
                                            {{Form::text('sponsor_person', $sponsor->sponsor_person, ['class' => 'form-control', 'placeholder' => 'Sponsor Contact Person'])}}
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{Form::label('title', 'Sponsor Dept')}}
                                            {{Form::text('sponsor_dept', $sponsor->sponsor_dept, ['class' => 'form-control', 'placeholder' => 'Sponsor Email'])}}
                                        </div>
                                        <div class="form-group col-md-12">
                                            {{Form::label('title', 'Sponsor Addresee')}}
                                            {{Form::text('sponsor_addresee', $sponsor->sponsor_addresee, ['class' => 'form-control', 'placeholder' => 'Sponsor Number'])}}
                                        </div>
                                        <div class="form-group col-md-4">
                                            {{Form::label('title', 'Sponsor Postcode')}}
                                            {{Form::text('sponsor_poscode', $sponsor->sponsor_poscode, ['class' => 'form-control', 'placeholder' => 'Sponsor Postcode'])}}
                                        </div>
                                        <div class="form-group col-md-4">
                                            {{Form::label('title', 'Sponsor City')}}
                                            {{Form::text('sponsor_city', $sponsor->sponsor_city, ['class' => 'form-control', 'placeholder' => 'Sponsor City'])}}
                                        </div>
                                        <div class="form-group col-md-4">
                                            {{Form::label('title', 'Sponsor State')}}
                                            {{Form::text('sponsor_state', $sponsor->sponsor_state, ['class' => 'form-control', 'placeholder' => 'Sponsor State'])}}
                                        </div>
                                    </div>
                                    {{Form::hidden('_method', 'PUT')}}
                                    <button class="btn btn-primary">Submit</button>
                                {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
