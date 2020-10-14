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
                        <table class="table table-bordered">
                            <div class="card-body">
                                {!! Form::open(['action' => 'SponsorController@store', 'method' => 'POST']) !!}
                                    <div class="row form-group">
                                        <div class="col-md-6">
                                            {{Form::label('title', 'Sponsor Code')}}
                                            {{Form::text('sponsor_code', '', ['class' => 'form-control', 'placeholder' => 'Sponsor Code'])}}
                                        </div>
                                        <div class="col-md-6">
                                            {{Form::label('title', 'Sponsor Name')}}
                                            {{Form::text('sponsor_name', '', ['class' => 'form-control', 'placeholder' => 'Sponsor Name'])}}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('title', 'Sponsor Detail')}}
                                        {{Form::text('sponsor_detail', '', ['class' => 'form-control', 'placeholder' => 'Sponsor Detail'])}}
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-6">
                                            {{Form::label('title', 'Sponsor Number')}}
                                            {{Form::number('sponsor_number', '', ['class' => 'form-control', 'placeholder' => 'Sponsor Number'])}}
                                        </div>
                                        <div class="col-md-6">
                                            {{Form::label('title', 'Sponsor Email')}}
                                            {{Form::email('sponsor_email', '', ['class' => 'form-control', 'placeholder' => 'Sponsor Email'])}}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('title', 'Sponsor Address I')}}
                                        {{Form::text('sponsor_address_1', '', ['class' => 'form-control', 'placeholder' => 'Sponsor Address 1'])}}
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('title', 'Sponsor Address II')}}
                                        {{Form::text('sponsor_address_2', '', ['class' => 'form-control', 'placeholder' => 'Sponsor Address II'])}}
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-6">
                                            {{Form::label('title', 'Sponsor Contact Person')}}
                                            {{Form::text('sponsor_person', '', ['class' => 'form-control', 'placeholder' => 'Sponsor Contact Person'])}}
                                        </div>
                                        <div class="col-md-6">
                                            {{Form::label('title', 'Sponsor Dept')}}
                                            {{Form::text('sponsor_dept', '', ['class' => 'form-control', 'placeholder' => 'Sponsor Email'])}}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('title', 'Sponsor Addresee')}}
                                        {{Form::text('sponsor_addresee', '', ['class' => 'form-control', 'placeholder' => 'Sponsor Number'])}}
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-4">
                                            {{Form::label('title', 'Sponsor Postcode')}}
                                            {{Form::number('sponsor_poscode', '', ['class' => 'form-control', 'placeholder' => 'Sponsor Postcode'])}}
                                        </div>
                                        <div class="col-md-4">
                                            {{Form::label('title', 'Sponsor City')}}
                                            {{Form::text('sponsor_city', '', ['class' => 'form-control', 'placeholder' => 'Sponsor City'])}}
                                        </div>
                                        <div class="col-md-4">
                                            {{Form::label('title', 'Sponsor State')}}
                                            {{Form::text('sponsor_state', '', ['class' => 'form-control', 'placeholder' => 'Sponsor State'])}}
                                        </div>
                                    </div>
                                    <button class="btn btn-primary">Submit</button>
                                {!! Form::close() !!}
                            </div>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>
@endsection
