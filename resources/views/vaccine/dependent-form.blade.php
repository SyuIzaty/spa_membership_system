@extends('layouts.admin')

@section('content')

<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">

    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr" style="background-color:rgb(97 63 115)">
                    <h2>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>

                </div>

                <div class="panel-container show">
                    <div class="panel-content">
                        <center><img src="{{ asset('img/intec_logo.png') }}" style="height: 120px; width: 270px;"></center><br>
                        <h4 style="text-align: center">
                            <b>DEPENDENT VACCINATION FORM</b>
                        </h4>
                        <div>
                            <p style="padding-left: 40px; padding-right: 40px" align="center">
                                *<i><b>IMPORTANT!</b></i> : All staff are required to fill in the dependent vaccination survey for the purpose of data collection. This survey can be updated anytime if there are any information changed.
                            </p>
                        </div>
                        @if($vaccine->q5 != '')
                        {{-- Start Update Form --}}
                        <div class="panel-container show">
                            <div class="panel-content">
                                {!! Form::open(['action' => 'VaccineController@dependentUpdate', 'method' => 'POST']) !!}
                                {{Form::hidden('id', $vaccine->id)}}
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    @if (Session::has('message'))
                                        <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('message') }}</div>
                                    @endif
                                    @if (Session::has('messages'))
                                        <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('messages') }}</div>
                                    @endif
                                    <div class="table-responsive">
                                        <table id="info" class="table table-bordered table-hover table-striped w-100">
                                            <thead>
                                                <tr>
                                                    <div class="form-group">
                                                        <th style="text-align: center" width="4%"><label class="form-label">NO.</label></th>
                                                        <th style="text-align: center"><label class="form-label">DEPENDENT VACCINATION CHECKLIST</label></th>
                                                        <th style="text-align: center" colspan="2"><label class="form-label">ANSWER</label></th>
                                                    </div>
                                                </tr>
                                                <div class="form-group">
                                                    <td style="text-align: center" width="4%"><label for="q5s">1.</label></td>
                                                    <td width="50%;"><label for="q5"><span class="text-danger">*</span> Do you have a spouse ?</label>@error('q5s')<b style="color: red"><strong> required </strong></b>@enderror</td>
                                                    <td style="text-align: center"><input type="radio" name="q5s" id="q5s" value="Y" {{ (old('q5s', ($vaccine->q5)) == 'Y') ? 'checked' : '' }}> Yes</td>
                                                    <td style="text-align: center"><input type="radio" name="q5s" id="q5s" value="N" {{ (old('q5s', ($vaccine->q5)) == 'N') ? 'checked' : '' }}> No</td>
                                                </div>
                                                <tr class="q5_appts" style="display: none">
                                                    <div class="form-group">
                                                        <td style="text-align: center" width="4%"><label for="q5_appts">2.</label></td>
                                                        <td width="50%;"><label for="q5_appts"><span class="text-danger">*</span> Has your spouse received a vaccination appointment ?</label>@error('q5_appts')<b style="color: red"><strong> required </strong></b>@enderror</td>
                                                        <td style="text-align: center"><input type="radio" name="q5_appts" id="q5_appts" value="Y" {{ (old('q5_appts', ($vaccine->q5_appt)) == 'Y') ? 'checked' : '' }}> Yes</td>
                                                        <td style="text-align: center"><input type="radio" name="q5_appts" id="q5_appts" value="N" {{ (old('q5_appts', ($vaccine->q5_appt)) == 'N') ? 'checked' : '' }}> No</td>
                                                    </div>
                                                </tr>
                                                <tr class="q5_names" style="display: none">
                                                    <div class="form-group">
                                                        <td style="text-align: center" width="4%"><label for="q5_names"></label></td>
                                                        <td width="50%" style="vertical-align: middle;"><label for="q5_names"><span class="text-danger">*</span> Spouse Name : </label>@error('q5_names')<b style="color: red"><strong> required </strong></b>@enderror</td>
                                                        <td colspan="2" style="text-align: center"><input class="form-control" name="q5_names" id="q5_names" value="{{ isset($vaccine->q5_name) ? $vaccine->q5_name : old('q5_names') }}"></td>
                                                    </div>
                                                </tr>
                                                <tr class="q5_first_doses" style="display: none">
                                                    <div class="form-group">
                                                        <td style="text-align: center" width="4%"><label for="q5_first_doses"></label></td>
                                                        <td width="50%" style="vertical-align: middle;"><label for="q5_first_doses"> First Dose Appointment Date : </label>@error('q5_first_doses')<b style="color: red"><strong> required </strong></b>@enderror</td>
                                                        <td colspan="2" style="text-align: center"><input type="datetime-local" class="form-control" id="q5_first_doses" name="q5_first_doses" value="{{ isset($vaccine->q5_first_dose) ? date('Y-m-d\TH:i', strtotime($vaccine->q5_first_dose)) : old('q5_first_doses') }}" /></td>
                                                    </div>
                                                </tr>
                                                <tr class="q5_second_doses" style="display: none">
                                                    <div class="form-group">
                                                        <td style="text-align: center" width="4%"><label for="q5_second_doses"></label></td>
                                                        <td width="50%" style="vertical-align: middle;"><label for="q5_second_doses"> Second Dose Appointment Date : </label>@error('q5_second_doses')<b style="color: red"><strong> required </strong></b>@enderror</td>
                                                        <td colspan="2" style="text-align: center"><input type="datetime-local" class="form-control" id="q5_second_doses" name="q5_second_doses" value="{{ isset($vaccine->q5_second_dose) ? date('Y-m-d\TH:i', strtotime($vaccine->q5_second_dose)) : old('q5_second_doses') }}" /></td>
                                                    </div>
                                                </tr>
                                                <tr class="q6s" style="display: none">
                                                    <div class="form-group">
                                                        <td style="text-align: center" width="4%"><label for="q6s">3.</label></td>
                                                        <td width="50%;"><label for="q6"><span class="text-danger">*</span> Do you have children 18 years and above ?</label>@error('q6s')<b style="color: red"><strong> required </strong></b>@enderror</td>
                                                        <td style="text-align: center"><input type="radio" name="q6s" id="q6s" value="Y" {{ (old('q6s', ($vaccine->q6)) == 'Y') ? 'checked' : '' }}> Yes</td>
                                                        <td style="text-align: center"><input type="radio" name="q6s" id="q6s" value="N" {{ (old('q6s', ($vaccine->q6)) == 'N') ? 'checked' : '' }}> No</td>
                                                    </div>
                                                </tr>
                                                <tr class="q6_childs" style="display: none">
                                                    <div class="form-group">
                                                        <td colspan="4" >
                                                            <div class="card-body test" id="tests">
                                                                <table class="table table-bordered text-center" id="head_fields">
                                                                    <thead>
                                                                        <tr class="bg-primary-50">
                                                                            <td>Child Name</td>
                                                                            <td>Has your children received a vaccination appointment ?</td>
                                                                            <td>First Dose Appointment Date</td>
                                                                            <td>Second Dose Appointment Date</td>
                                                                            <td>Action</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><input name="child_namess[]" id="child_namess" class="form-control child_namess"/></td>
                                                                            <td>
                                                                                <select name="child_apptss[]" id="child_apptss" class="child_apptss form-control">
                                                                                    <option value="">Please Select</option>
                                                                                    <option value="Y" {{ old('child_apptss') == 'Y' ? 'selected':''}} >Yes</option>
                                                                                    <option value="N" {{ old('child_apptss') == 'N' ? 'selected':''}} >No</option>
                                                                                </select>
                                                                            </td>
                                                                            <td><input class="form-control first_dose_datess" type="datetime-local" name="first_dose_datess[]" id="first_dose_dates"/></td>
                                                                            <td><input class="form-control second_dose_datess" type="datetime-local" name="second_dose_datess[]" id="second_dose_dates"/></td>
                                                                            <td style="vertical-align: middle"><button type="button" name="addheads" id="addheads" class="btn btn-success btn-sm"><i class="fal fa-plus"></i></button></td>
                                                                        </tr>
                                                                    </thead>
                                                                </table>
                                                                <br><br>
                                                                <table class="table table-bordered text-center">
                                                                    <thead>
                                                                        <tr class="bg-primary-50">
                                                                            <td>No.</td>
                                                                            <td>Child Name</td>
                                                                            <td>Has your children received a vaccination appointment ?</td>
                                                                            <td>First Dose Appointment Date</td>
                                                                            <td>Second Dose Appointment Date</td>
                                                                            <td>Action</td>
                                                                        </tr>
                                                                        <tr>
                                                                            @foreach ($dependent as $childs)
                                                                            <input type="hidden" name="ids[]" value="{{ $childs->id }}">
                                                                            <tr class="data-row">
                                                                                <td style="text-align: center; vertical-align : middle">{{ isset($childs->sequence) ? $childs->sequence : $loop->iteration }}</td>
                                                                                <td style="text-align: center"><input class="form-control" name="child_namesss[]" id="child_namesss" value="{{ isset($childs->child_name) ? $childs->child_name : old('child_namesss') }}"></td>
                                                                                <td style="text-align: center">
                                                                                    <select class="form-control child_apptsss" name="child_apptsss[]" id="child_apptsss">
                                                                                        <option value="Y" {{ $childs->child_appt == 'Y' ? 'selected="selected"' : ''}} >Yes</option>
                                                                                        <option value="N" {{ $childs->child_appt == 'N' ? 'selected="selected"' : ''}} >No</option>
                                                                                    </select>
                                                                                </td>
                                                                                <td style="text-align: center"><input type="datetime-local" class="form-control" id="first_dose_datesss" name="first_dose_datesss[]" value="{{ isset($childs->first_dose_date) ? date('Y-m-d\TH:i', strtotime($childs->first_dose_date)) : old('first_dose_datesss') }}" /></td>
                                                                                <td style="text-align: center"><input type="datetime-local" class="form-control" id="second_dose_datesss" name="second_dose_datesss[]" value="{{ isset($childs->second_dose_date) ? date('Y-m-d\TH:i', strtotime($childs->second_dose_date)) : old('second_dose_datesss') }}" /></td>
                                                                                <td align="center" style="vertical-align: middle">
                                                                                    <form action="{{route('deleteChild', $childs->id)}}" method="POST" class="delete_form"> 
                                                                                        {{-- @method('DELETE')   --}}
                                                                                        @csrf
                                                                                        <button type="submit" class="btn btn-danger btn-sm delete-alert"><i class="fal fa-trash"></i></button>               
                                                                                    </form>
                                                                                </td>
                                                                            </tr>
                                                                            @endforeach
                                                                        
                                                                        </tr>
                                                                    </thead>
                                                                </table>
                                                            </div>
                                                        </td>
                                                    </div>
                                                </tr>
                                                <tr>
                                                    <div class="form-group">
                                                        <td colspan="4">
                                                        <button style="margin-top: 5px;" class="btn btn-primary float-right" id="submit" name="submit"><i class="fal fa-check-circle"></i> Update Dependent Details</button></td>
                                                    </div>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                       
                                {!! Form::close() !!}
                            </div>
                        </div>
                        {{-- End Update Form --}}
                        @else
                        {{-- Start New Form --}}
                        <div class="panel-container show">
                            <div class="panel-content">
                                {!! Form::open(['action' => 'VaccineController@dependentStore', 'method' => 'POST']) !!}
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="table-responsive">
                                        <table id="info" class="table table-bordered table-hover table-striped w-100">
                                            <thead>
                                                <tr>
                                                    <div class="form-group">
                                                        <th style="text-align: center" width="4%"><label class="form-label">NO.</label></th>
                                                        <th style="text-align: center"><label class="form-label">DEPENDENT VACCINATION CHECKLIST</label></th>
                                                        <th style="text-align: center" colspan="2"><label class="form-label">ANSWER</label></th>
                                                    </div>
                                                </tr>
                                                <tr>
                                                    <div class="form-group">
                                                        <td style="text-align: center" width="4%"><label for="q5">1.</label></td>
                                                        <td width="50%;"><label for="q5"><span class="text-danger">*</span> Do you have a spouse ?</label>@error('q5')<b style="color: red"><strong> required </strong></b>@enderror</td>
                                                        <td style="text-align: center"><input type="radio" name="q5" id="q5" value="Y" {{ (old('q5') && old('q5') == 'Y') ? 'checked' : '' }}> Yes</td>
                                                        <td style="text-align: center"><input type="radio" name="q5" id="q5" value="N" {{ (old('q5') && old('q5') == 'N') ? 'checked' : '' }}> No</td>
                                                    </div>
                                                </tr>
                                                <tr class="q5_appt" style="display: none">
                                                    <div class="form-group">
                                                        <td style="text-align: center" width="4%"><label for="q5_appt">2.</label></td>
                                                        <td width="50%;"><label for="q5_appt"><span class="text-danger">*</span> Has your spouse received a vaccination appointment ?</label>@error('q5_appt')<b style="color: red"><strong> required </strong></b>@enderror</td>
                                                        <td style="text-align: center"><input type="radio" name="q5_appt" id="q5_appt" value="Y" {{ (old('q5_appt') && old('q5_appt') == 'Y') ? 'checked' : '' }}> Yes</td>
                                                        <td style="text-align: center"><input type="radio" name="q5_appt" id="q5_appt" value="N" {{ (old('q5_appt') && old('q5_appt') == 'N') ? 'checked' : '' }}> No</td>
                                                    </div>
                                                </tr>
                                                <tr class="q5_name" style="display: none">
                                                    <div class="form-group">
                                                        <td style="text-align: center" width="4%"><label for="q5_name"></label></td>
                                                        <td width="50%" style="vertical-align: middle;"><label for="q5_name"><span class="text-danger">*</span> Spouse Name : </label>@error('q5_name')<b style="color: red"><strong> required </strong></b>@enderror</td>
                                                        <td colspan="2" style="text-align: center"><input class="form-control" name="q5_name" id="q5_name" value="{{ old('q5_name') }}"></td>
                                                    </div>
                                                </tr>
                                                <tr class="q5_first_dose" style="display: none">
                                                    <div class="form-group">
                                                        <td style="text-align: center" width="4%"><label for="q5_first_dose"></label></td>
                                                        <td width="50%" style="vertical-align: middle;"><label for="q5_first_dose"> First Dose Appointment Date : </label>@error('q5_first_dose')<b style="color: red"><strong> required </strong></b>@enderror</td>
                                                        <td colspan="2" style="text-align: center"><input class="form-control" type="datetime-local" name="q5_first_dose" id="q5_first_dose" value="{{ old('q5_first_dose') }}"></td>
                                                    </div>
                                                </tr>
                                                <tr class="q5_second_dose" style="display: none">
                                                    <div class="form-group">
                                                        <td style="text-align: center" width="4%"><label for="q5_second_dose"></label></td>
                                                        <td width="50%" style="vertical-align: middle;"><label for="q5_second_dose"> Second Dose Appointment Date : </label>@error('q5_second_dose')<b style="color: red"><strong> required </strong></b>@enderror</td>
                                                        <td colspan="2" style="text-align: center"><input class="form-control" type="datetime-local" name="q5_second_dose" id="q5_second_dose" value="{{ old('q5_second_dose') }}"></td>
                                                    </div>
                                                </tr>
                                                <tr class="q6" style="display: none">
                                                    <div class="form-group">
                                                        <td style="text-align: center" width="4%"><label for="q6">3.</label></td>
                                                        <td width="50%;"><label for="q6"><span class="text-danger">*</span> Do you have children 18 years and above ?</label>@error('q6')<b style="color: red"><strong> required </strong></b>@enderror</td>
                                                        <td style="text-align: center"><input type="radio" name="q6" id="q6" value="Y" {{ (old('q6') && old('q6') == 'Y') ? 'checked' : '' }}> Yes</td>
                                                        <td style="text-align: center"><input type="radio" name="q6" id="q6" value="N" {{ (old('q6') && old('q6') == 'N') ? 'checked' : '' }}> No</td>
                                                    </div>
                                                </tr>
                                                <tr class="q6_child" style="display: none">
                                                    <div class="form-group">
                                                        <td colspan="4" >
                                                            <div class="card-body test" id="test">
                                                                <table class="table table-bordered text-center" id="head_field">
                                                                    <thead>
                                                                        <tr class="bg-primary-50">
                                                                            <td>Child Name</td>
                                                                            <td>Has your children received a vaccination appointment ?</td>
                                                                            <td>First Dose Appointment Date</td>
                                                                            <td>Second Dose Appointment Date</td>
                                                                            <td>Action</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><input name="child_name[]" class="form-control child_name"/></td>
                                                                            <td>
                                                                                <select name="child_appt[]" id="child_appt" class="child_appt form-control">
                                                                                    <option value="">Please Select</option>
                                                                                    <option value="Y" {{ old('child_appt') == 'Y' ? 'selected':''}} >Yes</option>
                                                                                    <option value="N" {{ old('child_appt') == 'N' ? 'selected':''}} >No</option>
                                                                                </select>
                                                                            </td>
                                                                            <td><input class="form-control first_dose_date" type="datetime-local" name="first_dose_date[]" id="first_dose_date"/></td>
                                                                            <td><input class="form-control second_dose_date" type="datetime-local" name="second_dose_date[]" id="second_dose_date"/></td>
                                                                            <td style="vertical-align: middle"><button type="button" name="addhead" id="addhead" class="btn btn-success btn-sm"><i class="fal fa-plus"></i></button></td>
                                                                        </tr>
                                                                    </thead>
                                                                </table>
                                                            </div>
                                                        </td>
                                                    </div>
                                                </tr>
                                                <tr>
                                                    <div class="form-group">
                                                        <td colspan="4">
                                                        <button style="margin-top: 5px;" class="btn btn-primary float-right" id="submit" name="submit"><i class="fal fa-check-circle"></i> Submit Dependent Details</button></td>
                                                    </div>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                        {{-- End New Form --}}
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

</main>

@endsection

@section('script')
<script>

    $(document).ready( function() {
        $('.child_appt, .child_apptss, .child_apptsss').select2();

        // Start AddMore
            $('#addhead').click(function(){
                i++;
                $('#head_field').append(`
                <tr id="row${i}" class="head-added">
                <td><input name="child_name[]" class="form-control child_name"/></td>
                <td>
                    <select name="child_appt[]" class="child_appts form-control">
                        <option value="">Please Select</option>
                        <option value="Y" {{ old('child_appt') == 'Y' ? 'selected':''}} >Yes</option>
                        <option value="N" {{ old('child_appt') == 'N' ? 'selected':''}} >No</option>
                    </select>
                </td>
                <td><input class="form-control first_dose_date" type="datetime-local" name="first_dose_date[]" id="first_dose_date"/></td>
                <td><input class="form-control second_dose_date" type="datetime-local" name="second_dose_date[]" id="second_dose_date"/></td>
                <td><button type="button" name="remove" id="${i}" class="btn btn-sm btn-danger btn_remove"><i class="fal fa-trash"></i></button></td>
                </tr>
                `); 
                $('.child_appts').select2();
            });

            var postURL = "<?php echo url('addmore'); ?>";
            var i=1;

            $.ajaxSetup({
                headers:{
                'X-CSRF-Token' : $("input[name=_token]").val()
                }
            });

            $(document).on('click', '.btn_remove', function(){
                var button_id = $(this).attr("id");
                $('#row'+button_id+'').remove();
            });

            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#submit').click(function(){
                $.ajax({
                    url:postURL,
                    method:"POST",
                    data:$('#add_name').serialize(),
                    type:'json',
                    success:function(data)
                    {
                        if(data.error){
                            printErrorMsg(data.error);
                        }else{
                            i=1;
                            $('.dynamic-added').remove();
                        }
                    }
                });
            });

            $('#submithead').click(function(){
                $.ajax({
                    url:postURL,
                    method:"POST",
                    data:$('#add_name').serialize(),
                    type:'json',
                    success:function(data)
                    {
                        if(data.error){
                            printErrorMsg(data.error);
                        }else{
                            i=1;
                            $('.head-added').remove();
                        }
                    }
                });
            });
        // End AddMore

        // Start AddMore
        $('#addheads').click(function(){
                i++;
                $('#head_fields').append(`
                <tr id="row${i}" class="head-addeds">
                <td><input name="child_namess[]" class="form-control child_namess"/></td>
                <td>
                    <select name="child_apptss[]" class="child_appointment form-control">
                        <option value="">Please Select</option>
                        <option value="Y" {{ old('child_apptss') == 'Y' ? 'selected':''}} >Yes</option>
                        <option value="N" {{ old('child_apptss') == 'N' ? 'selected':''}} >No</option>
                    </select>
                </td>
                <td><input class="form-control first_dose_datess" type="datetime-local" name="first_dose_datess[]" id="first_dose_datess"/></td>
                <td><input class="form-control second_dose_datess" type="datetime-local" name="second_dose_datess[]" id="second_dose_datess"/></td>
                <td><button type="button" name="remove" id="${i}" class="btn btn-sm btn-danger btn_remove"><i class="fal fa-trash"></i></button></td>
                </tr>
                `); 
                $('.child_appointment').select2();
            });

            var postURL = "<?php echo url('addmore'); ?>";
            var i=1;

            $.ajaxSetup({
                headers:{
                'X-CSRF-Token' : $("input[name=_token]").val()
                }
            });

            $(document).on('click', '.btn_remove', function(){
                var button_id = $(this).attr("id");
                $('#row'+button_id+'').remove();
            });

            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#submit').click(function(){
                $.ajax({
                    url:postURL,
                    method:"POST",
                    data:$('#add_name').serialize(),
                    type:'json',
                    success:function(data)
                    {
                        if(data.error){
                            printErrorMsg(data.error);
                        }else{
                            i=1;
                            $('.dynamic-added').remove();
                        }
                    }
                });
            });

            $('#submithead').click(function(){
                $.ajax({
                    url:postURL,
                    method:"POST",
                    data:$('#add_name').serialize(),
                    type:'json',
                    success:function(data)
                    {
                        if(data.error){
                            printErrorMsg(data.error);
                        }else{
                            i=1;
                            $('.head-addeds').remove();
                        }
                    }
                });
            });
        // End AddMore

    });

    // Start New Form
        $(function () {          
            $("input[name=q5]").change(function () {        
                if ($(this).val() == "Y") {
                    $(".q5_appt").show();
                    $(".q5_name").show();
                    $(".q6").show();
                
                } else {
                    $(".q5_appt").hide();
                    $(".q5_name").hide();
                    $(".q5_first_dose").hide();
                    $(".q5_second_dose").hide();
                    $(".q6").hide();
                    $(".q6_child").hide();
                }
            });

            $("input[name=q5_appt]").change(function () {        
                if ($(this).val() == "Y") {
                    $(".q5_appt").show();
                    $(".q5_name").show();
                    $(".q5_first_dose").show();
                    $(".q5_second_dose").show();
                    $(".q6").show();
                    $(".q6_child").hide();
                
                } else {
                    $(".q5_first_dose").hide();
                    $(".q5_second_dose").hide();
                    $(".q6_child").hide();
                }
            });

            $("input[name=q6]").change(function () {        
                if ($(this).val() == "Y") {
                    $(".q6_child").show();

                } else {
                    $(".q6_child").hide();
                }
            });

            $('input[name="q5"]:checked').val('{{ old('q5') }}');
            $('input[name="q5"]:checked').change(); 
            $('input[name="q5_appt"]:checked').val('{{ old('q5_appt') }}');
            $('input[name="q5_appt"]:checked').change(); 
            $('input[name="q6"]:checked').val('{{ old('q6') }}');
            $('input[name="q6"]:checked').change();

            $('.child_appt').val('{{ old('child_appt') }}'); 
            $(".child_appt").change(); 
            $('.child_appts').val('{{ old('child_appts') }}'); 
            $(".child_appts").change(); 

            $('#q5_name').val('{{ old('q5_name') }}');
            $('#q5_first_dose').val('{{ old('q5_first_dose') }}');
            $('#q5_second_dose').val('{{ old('q5_second_dose') }}');

            $('.child_name').val('{{ old('child_name') }}');
            $('.first_dose_date').val('{{ old('first_dose_date') }}');
            $('.second_dose_date').val('{{ old('second_dose_date') }}');
        })
    // End New Form

    // Start Update Form
    $(function () {          
            $("input[name=q5s]").change(function () {        
                if ($(this).val() == "Y") {
                    $(".q5_appts").show();
                    $(".q5_names").show();
                    $(".q6s").show();
                
                } else {
                    $(".q5_appts").hide();
                    $(".q5_names").hide();
                    $(".q5_first_doses").hide();
                    $(".q5_second_doses").hide();
                    $(".q6s").hide();
                    $(".q6_childs").hide();
                }
            });

            $("input[name=q5_appts]").change(function () {        
                if ($(this).val() == "Y") {
                    $(".q5_appts").show();
                    $(".q5_names").show();
                    $(".q5_first_doses").show();
                    $(".q5_second_doses").show();
                    $(".q6s").show();
                    $(".q6_childs").hide();
                
                } else {
                    $(".q5_first_doses").hide();
                    $(".q5_second_doses").hide();
                    $(".q6_childs").hide();
                }
            });

            $("input[name=q6s]").change(function () {        
                if ($(this).val() == "Y") {
                    $(".q6_childs").show();

                } else {
                    $(".q6_childs").hide();
                }
            });

            $('input[name="q5s"]:checked').val();
            $('input[name="q5s"]:checked').change(); 
            $('input[name="q5_appts"]:checked').val();
            $('input[name="q5_appts"]:checked').change(); 
            $('input[name="q6s"]:checked').val();
            $('input[name="q6s"]:checked').change();
            $('.child_appts').val(); 
            $(".child_appts").change(); 
            $('.child_apptss').val(); 
            $(".child_apptss").change(); 
            $('#q5_names').val();
            $('#q5_first_doses').val();
            $('#q5_second_doses').val();

            $('.child_names').val();
            $('.first_dose_dates').val();
            $('.second_dose_dates').val();
        })
    // End Update Form

    $("form.delete_form").submit(function(e){
        e.preventDefault();
        var form = $(this);
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        })
        .then((willDelete) => {
            if (willDelete) {
                    form[0].submit();
                    Swal.fire({ text: "Successfully delete the data.", icon: 'success'
                });
            } 
        });
    });

</script>
@endsection

