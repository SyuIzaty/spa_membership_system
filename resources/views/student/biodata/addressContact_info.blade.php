@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content">

    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2 style="font-size: 25px;">
                        Address Info <small>| student's address information</small> <span class="fw-300"><i> </i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>

                </div>

                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="card card-primary card-outline">
                            
                            <div class="alert alert-warning alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h5><i class="icon fal fa-info"></i> Message</h5>
                                Please check your address information. Contact Academic Management Office (Undergraduates) or Centre For Graduate Studies (Postgraduates) if have an errors.
                            </div>

                            <div class="card-header bg-highlight">
                                <h5 class="card-title w-100">PERMANENT ADDRESS</small></h5>
                            </div>
                                <div class="card-body">
                                    <table id="permanent_address" class="table table-bordered table-hover table-striped w-100">
                                        <thead>
                                            <tr>
                                                <td width="21%"><b>Address :</b></td>
                                            <td colspan="10"> {{ $student->studentContactInfo->students_address_1 }}, {{ $student->studentContactInfo->students_address_2 }}, {{ $student->studentContactInfo->students_poscode }}, {{ $student->studentContactInfo->students_city }}, {{ $student->studentContactInfo->state->state_name }}</td>
                                            </tr>

                                            <tr>
                                                <td width="21%"><b>Phone No. :</b></td>
                                                <td colspan="10"> {{ $student->students_phone }} </td>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                        </div>
           
                        <div class="card card-primary card-outline">
                            <div class="card-header bg-highlight">
                                <h5 class="card-title w-100">CURRENT ADDRESS</h5>
                            </div>
                                <div class="card-body">
                                    {!! Form::open(['action' => ['StudentController@updateStudent'], 'method' => 'POST'])!!}
                                    {{Form::hidden('id', $student->id)}}
                                    <table id="current_address" class="table table-bordered table-hover table-striped w-100">
                                        <thead>
                                            @if(isset($student->studentContactInfo))
                                            <tr>
                                                <td width="21%"><b>Address :</b></td>
                                                <td colspan="10">
                                                    {{ Form::text('students_address_1', $student->studentContactInfo->students_address_1, ['class' => 'form-control', 'placeholder' => 'Address 1']) }}<br>
                                                    {{ Form::text('students_address_2', $student->studentContactInfo->students_address_2, ['class' => 'form-control', 'placeholder' => 'Address 2']) }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <td width="21%"><b>Postcode :</b></td>
                                                <td colspan="5">
                                                    {{ Form::text('students_poscode', $student->studentContactInfo->students_poscode, ['class' => 'form-control', 'placeholder' => 'Postcode']) }}
                                                </td>
                                                <td width="21%"><b>City :</b></td>
                                                <td colspan="5">
                                                    {{ Form::text('students_city', $student->studentContactInfo->students_city, ['class' => 'form-control', 'placeholder' => 'City']) }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <td width="21%"><b>State :</b></td>
                                                <td colspan="5">
                                                    <select class="form-control" name="students_state" id="students_state" >
                                                        @foreach($state as $states)
                                                            <option value="{{$states->state_code}}"  {{ $student->studentContactInfo->students_state == $states->state_code ? 'selected="selected"' : '' }}>{{$states->state_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td width="21%"><b>Country :</b></td>
                                                <td colspan="5">
                                                    <select class="form-control" name="students_country" id="students_country" >
                                                        @foreach($country as $countries)
                                                            <option value="{{$countries->country_code}}"  {{ $student->studentContactInfo->students_country == $countries->country_code ? 'selected="selected"' : '' }}>{{$countries->country_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            @endif

                                            <tr>
                                                <td width="21%"><b>Phone No. :</b></td>
                                                <td colspan="5">
                                                {{ Form::text('students_phone', $student->students_phone, ['class' => 'form-control' , 'placeholder' => 'Student Phone']) }}
                                                <br>Example: <span style="color:red">+60</span><span style="color:blue">12</span><span style="color:green">3456789</span> (International Telephone Number)</td>
                                                <td width="21%"><b>Email :</b></td>
                                                <td colspan="5">
                                                {{ Form::email('students_email', $student->students_email, ['class' => 'form-control', 'placeholder' => 'Student Email']) }}
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <td width="21%"><b>INTEC Email :</b></td>
                                                <td colspan="10"> </td>
                                            </tr>
                                            
                                        </thead>
                                    </table>
                                    {{-- @role('executive') --}}
                                    <button type="submit" class="btn btn-primary ml-auto float-right"><i class="fal fa-save"></i> Update</button> 
                                    {!! Form::close() !!}
                                    {{-- @endrole --}}
                                </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</main>
@endsection

