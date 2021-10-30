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
                        <center><img src="{{ asset('img/intec_logo_new.png') }}" style="height: 120px; width: 320px;"></center><br>
                        <h4 style="text-align: center">
                            <b>VACCINATION FORM</b>
                        </h4>
                        <div>
                            <p style="padding-left: 40px; padding-right: 40px" align="center">
                                *<i><b>IMPORTANT!</b></i> : All staff are required to fill in the vaccination survey for the purpose of data collection. This survey can be updated anytime if there are any information changed.
                            </p>
                        </div>
                        @if(isset($vaccine))
                        {{-- Start Update Form --}}
                        <div class="panel-container show">
                            <div class="panel-content">
                                {!! Form::open(['action' => 'VaccineController@vaccineUpdate', 'method' => 'POST']) !!}
                                {{Form::hidden('id', $vaccine->id)}}
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    @if (Session::has('message'))
                                        <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('message') }}</div>
                                    @endif
                                    <div class="table-responsive">
                                        <table id="info" class="table table-bordered table-hover table-striped w-100">
                                            <thead>
                                                <tr>
                                                    <div class="form-group">
                                                        <th style="text-align: center" width="4%"><label class="form-label">NO.</label></th>
                                                        <th style="text-align: center"><label class="form-label">VACCINATION CHECKLIST</label></th>
                                                        <th style="text-align: center" colspan="2"><label class="form-label">ANSWER</label></th>
                                                    </div>
                                                </tr>
                                                <tr class="q1s">
                                                    <div class="form-group">
                                                        <td style="text-align: center" width="4%"><label for="q1s">1.</label></td>
                                                        <td width="50%;"><label for="q1s"><span class="text-danger">*</span> Have already registered to receive the COVID-19 vaccine ?</label>@error('q1s')<b style="color: red"><strong> required </strong></b>@enderror</td>
                                                        <td style="text-align: center"><input type="radio" name="q1s" id="q1s" value="Y" {{ (old('q1s', ($vaccine->q1)) == 'Y') ? 'checked' : '' }}> Yes</td>
                                                        <td style="text-align: center"><input type="radio" name="q1s" id="q1s" value="N" {{ (old('q1s', ($vaccine->q1)) == 'N') ? 'checked' : '' }}> No</td>
                                                    </div>
                                                </tr>
                                                <tr class="q1_reasons" style="display: none ">
                                                    <div class="form-group">
                                                        <td style="text-align: center" width="4%"><label for="q1_reasons"></label></td>
                                                        <td width="50%" style="vertical-align: middle;"><label for="q1_reasons"><span class="text-danger">*</span> Reason : </label>@error('q1_reasons')<b style="color: red"><strong> required </strong></b>@enderror</td>
                                                        <td colspan="2">
                                                            <select class="form-control reasonss" name="q1_reasons" id="q1_reasons" >
                                                                <option value=""> Select Reason </option>
                                                                @foreach ($reason as $reasons) 
                                                                <option value="{{ $reasons->id }}" {{ old('q1_reasons', ($vaccine->reasons ? $vaccine->reasons->id : '')) ==  $reasons->id  ? 'selected' : '' }}>
                                                                    {{ $reasons->reason_name }}</option>
                                                                @endforeach
                                                            </select>
                                                            <br><br>
                                                            <input placeholder="Please state your reason..." class="form-control" name="q1_other_reasons" id="q1_other_reasons" value="{{ old('q1_other_reasons') ?? $vaccine->q1_other_reason }}">
                                                        </td>
                                                    </div>
                                                </tr>
                                                <tr class="q2s" style="display: none  ">
                                                    <div class="form-group">
                                                        <td style="text-align: center" width="4%"><label for="q2s">2.</label></td>
                                                        <td><label for="q2s"><span class="text-danger">*</span> Have you received an appointment date for the vaccine injection ?</label>@error('q2s')<b style="color: red"><strong> required </strong></b>@enderror</td>
                                                        <td style="text-align: center"><input type="radio" name="q2s" id="q2s" value="Y" {{ (old('q2s', ($vaccine->q2)) == 'Y') ? 'checked' : '' }}> Yes</td>
                                                        <td style="text-align: center"><input type="radio" name="q2s" id="q2s" value="N" {{ (old('q2s', ($vaccine->q2)) == 'N') ? 'checked' : '' }}> No</td>
                                                    </div>
                                                </tr>
                                                <tr class="q3s" style="display:  none ">
                                                    <div class="form-group">
                                                        <td style="text-align: center" width="4%"><label for="q3s">3.</label></td>
                                                        <td><label for="q3s"><span class="text-danger">*</span> Have you finished receiving your first dose vaccine ? @error('q3s')<b style="color: red"><strong> required </strong></b>@enderror</label></td>
                                                        <td style="text-align: center; vertical-align: middle"><input type="radio" name="q3s" id="q3s" value="Y" {{ (old('q3s', ($vaccine->q3)) == 'Y') ? 'checked' : '' }}> Yes</td>
                                                        <td style="text-align: center; vertical-align: middle"><input type="radio" name="q3s" id="q3s" value="N" {{ (old('q3s', ($vaccine->q3)) == 'N') ? 'checked' : '' }}> No</td>
                                                    </div>
                                                </tr>
                                                <tr class="q3_dates" style="display: none  ">
                                                    <div class="form-group">
                                                        <td style="text-align: center" width="4%"><label for="q3_dates"></label></td>
                                                        <td width="50%" style="vertical-align: middle;"><label for="q3_dates"><span class="text-danger">*</span> First Dose Appointment Date : </label>@error('q3_dates')<b style="color: red"><strong> required </strong></b>@enderror</td>
                                                        <td colspan="2" style="text-align: center"><input type="datetime-local" class="form-control" id="q3_dates" name="q3_dates" value="{{ isset($vaccine->q3_date) ? date('Y-m-d\TH:i', strtotime($vaccine->q3_date)) : old('q3_dates') }}" /></td>
                                                    </div>
                                                </tr>
                                                <tr class="q3_effects" style="display: none ">
                                                    <div class="form-group">
                                                        <td style="text-align: center" width="4%"><label for="q3_effects">4.</label></td>
                                                        <td><label for="q3_effects"><span class="text-danger">*</span> Do you receive side effects from first dose vaccine injection ? @error('q3_effects')<b style="color: red"><strong> required </strong></b>@enderror</label></td>
                                                        <td style="text-align: center; vertical-align: middle"><input type="radio" name="q3_effects" id="q3_effects" value="Y" {{ (old('q3_effects', ($vaccine->q3_effect)) == 'Y') ? 'checked' : '' }}> Yes</td>
                                                        <td style="text-align: center; vertical-align: middle"><input type="radio" name="q3_effects" id="q3_effects" value="N" {{ (old('q3_effects', ($vaccine->q3_effect)) == 'N') ? 'checked' : '' }}> No</td>
                                                    </div>
                                                </tr>
                                                <tr class="q3_effect_remarks" style="display: none  ">
                                                    <div class="form-group">
                                                        <td style="text-align: center" width="4%"><label for="q3_effect_remarks"></label></td>
                                                        <td width="50%" style="vertical-align: middle;"><label for="q3_effect_remarks"><span class="text-danger">*</span> Side Effects : </label>@error('q3_effect_remarks')<b style="color: red"><strong> required </strong></b>@enderror</td>
                                                        <td colspan="2" style="text-align: center"><input placeholder="Please state the side effect..." class="form-control" name="q3_effect_remarks" id="q3_effect_remarks" value="{{ old('q3_effect_remarks') ?? $vaccine->q3_effect_remark}}"></td>
                                                    </div>
                                                </tr>
                                                <tr class="q4s" style="display: none  ">
                                                    <div class="form-group">
                                                        <td style="text-align: center" width="4%"><label for="q4s">5.</label></td>
                                                        <td><label for="q4s"><span class="text-danger">*</span> Have you finished receiving your second dose vaccine ? @error('q4s')<b style="color: red"><strong> required </strong></b>@enderror</label></td>
                                                        <td style="text-align: center; vertical-align: middle"><input type="radio" name="q4s" id="q4s" value="Y" {{ (old('q4s', ($vaccine->q4)) == 'Y') ? 'checked' : '' }}> Yes</td>
                                                        <td style="text-align: center; vertical-align: middle"><input type="radio" name="q4s" id="q4s" value="N" {{ (old('q4s', ($vaccine->q4)) == 'N') ? 'checked' : '' }}> No</td>
                                                    </div>
                                                </tr>
                                                <tr class="q4_dates" style="display: none  ">
                                                    <div class="form-group">
                                                        <td style="text-align: center" width="4%"><label for="q4_dates"></label></td>
                                                        <td width="50%" style="vertical-align: middle;"><label for="q4_dates"><span class="text-danger">*</span> Second Dose Appointment Date : </label>@error('q4_dates')<b style="color: red"><strong> required </strong></b>@enderror</td>
                                                        <td colspan="2" style="text-align: center"><input type="datetime-local" class="form-control" id="q4_dates" name="q4_dates" value="{{ isset($vaccine->q4_date) ? date('Y-m-d\TH:i', strtotime($vaccine->q4_date)) : old('q4_dates') }}" /></td>
                                                    </div>
                                                </tr>
                                                <tr class="q4_effects" style="display: none  ">
                                                    <div class="form-group">
                                                        <td style="text-align: center" width="4%"><label for="q4_effects">6.</label></td>
                                                        <td><label for="q4_effect"><span class="text-danger">*</span> Do you receive side effects from second dose vaccine injection ? @error('q4_effects')<b style="color: red"><strong> required </strong></b>@enderror</label></td>
                                                        <td style="text-align: center; vertical-align: middle"><input type="radio" name="q4_effects" id="q4_effects" value="Y" {{ (old('q4_effects', ($vaccine->q4_effect)) == 'Y') ? 'checked' : '' }}> Yes</td>
                                                        <td style="text-align: center; vertical-align: middle"><input type="radio" name="q4_effects" id="q4_effects" value="N" {{ (old('q4_effects', ($vaccine->q4_effect)) == 'N') ? 'checked' : '' }}> No</td>
                                                    </div>
                                                </tr>
                                                <tr class="q4_effect_remarks" style="display: none  ">
                                                    <div class="form-group">
                                                        <td style="text-align: center" width="4%"><label for="q4_effect_remarks"></label></td>
                                                        <td width="50%" style="vertical-align: middle;"><label for="q4_effect_remarks"><span class="text-danger">*</span> Side Effects : </label>@error('q4_effect_remarks')<b style="color: red"><strong> required </strong></b>@enderror</td>
                                                        <td colspan="2" style="text-align: center"><input placeholder="Please state the side effect..." class="form-control" name="q4_effect_remarks" id="q4_effect_remarks" value="{{ old('q4_effect_remarks') ?? $vaccine->q4_effect_remark }}"></td>
                                                    </div>
                                                </tr>
                                                <tr>
                                                    <div class="form-group">
                                                        <td colspan="4">
                                                        <button style="margin-top: 5px;" class="btn btn-primary float-right" id="submit" name="submit"><i class="fal fa-check-circle"></i> Update Details</button></td>
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
                                {!! Form::open(['action' => 'VaccineController@vaccineStore', 'method' => 'POST']) !!}
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="table-responsive">
                                        <table id="info" class="table table-bordered table-hover table-striped w-100">
                                            <thead>
                                                <tr>
                                                    <div class="form-group">
                                                        <th style="text-align: center" width="4%"><label class="form-label">NO.</label></th>
                                                        <th style="text-align: center"><label class="form-label">VACCINATION CHECKLIST</label></th>
                                                        <th style="text-align: center" colspan="2"><label class="form-label">ANSWER</label></th>
                                                    </div>
                                                </tr>
                                                <tr class="q1">
                                                    <div class="form-group">
                                                        <td style="text-align: center" width="4%"><label for="q1">1.</label></td>
                                                        <td width="50%;"><label for="q1"><span class="text-danger">*</span> Have already registered to receive the COVID-19 vaccine ?</label>@error('q1')<b style="color: red"><strong> required </strong></b>@enderror</td>
                                                        <td style="text-align: center"><input type="radio" name="q1" id="q1" value="Y" {{ (old('q1') && old('q1') == 'Y') ? 'checked' : '' }}> Yes</td>
                                                        <td style="text-align: center"><input type="radio" name="q1" id="q1" value="N" {{ (old('q1') && old('q1') == 'N') ? 'checked' : '' }}> No</td>
                                                    </div>
                                                </tr>
                                                <tr class="q1_reason" style="display: none">
                                                    <div class="form-group">
                                                        <td style="text-align: center" width="4%"><label for="q1_reason"></label></td>
                                                        <td width="50%" style="vertical-align: middle;"><label for="q1_reason"><span class="text-danger">*</span> Reason : </label>@error('q1_reason')<b style="color: red"><strong> required </strong></b>@enderror</td>
                                                        <td colspan="2">
                                                            <select class="form-control reasons" name="q1_reason" id="q1_reason" >
                                                                <option value=""> Select Reason </option>
                                                                @foreach ($reason as $reasons) 
                                                                <option value="{{ $reasons->id }}" {{ old('q1_reason') ==  $reasons->id  ? 'selected' : '' }}>
                                                                    {{ $reasons->reason_name }}</option>
                                                                @endforeach
                                                            </select>
                                                            <br><br>
                                                            <input placeholder="Please state your reason..." class="form-control q1_other_reason" name="q1_other_reason" id="q1_other_reason" value="{{ old('q1_other_reason') }}">
                                                            @error('q1_other_reason')<b style="color: red"><strong> * required </strong></b>@enderror
                                                        </td>
                                                    </div>
                                                </tr>
                                                <tr class="q2" style="display: none">
                                                    <div class="form-group">
                                                        <td style="text-align: center" width="4%"><label for="q2">2.</label></td>
                                                        <td><label for="q2"><span class="text-danger">*</span> Have you received an appointment date for the vaccine injection ?</label>@error('q2')<b style="color: red"><strong> required </strong></b>@enderror</td>
                                                        <td style="text-align: center"><input type="radio" name="q2" id="q2" value="Y" {{ (old('q2') && old('q2') == 'Y') ? 'checked' : '' }}> Yes</td>
                                                        <td style="text-align: center"><input type="radio" name="q2" id="q2" value="N" {{ (old('q2') && old('q2') == 'N') ? 'checked' : '' }}> No</td>
                                                    </div>
                                                </tr>
                                                <tr class="q3" style="display: none">
                                                    <div class="form-group">
                                                        <td style="text-align: center" width="4%"><label for="q3">3.</label></td>
                                                        <td><label for="q3"><span class="text-danger">*</span> Have you finished receiving your first dose vaccine ? @error('q3')<b style="color: red"><strong> required </strong></b>@enderror</label></td>
                                                        <td style="text-align: center; vertical-align: middle"><input type="radio" name="q3" id="q3" value="Y" {{ (old('q3') && old('q3') == 'Y') ? 'checked' : '' }}> Yes</td>
                                                        <td style="text-align: center; vertical-align: middle"><input type="radio" name="q3" id="q3" value="N" {{ (old('q3') && old('q3') == 'N') ? 'checked' : '' }}> No</td>
                                                    </div>
                                                </tr>
                                                <tr class="q3_date" style="display: none">
                                                    <div class="form-group">
                                                        <td style="text-align: center" width="4%"><label for="q3_date"></label></td>
                                                        <td width="50%" style="vertical-align: middle;"><label for="q3_date"><span class="text-danger">*</span> First Dose Appointment Date : </label>@error('q3_date')<b style="color: red"><strong> required </strong></b>@enderror</td>
                                                        <td colspan="2" style="text-align: center"><input class="form-control" type="datetime-local" name="q3_date" id="q3_date" value="{{ old('q3_date') }}"></td>
                                                    </div>
                                                </tr>
                                                <tr class="q3_effect" style="display: none">
                                                    <div class="form-group">
                                                        <td style="text-align: center" width="4%"><label for="q3_effect">4.</label></td>
                                                        <td><label for="q3_effect"><span class="text-danger">*</span> Do you receive side effects from first dose vaccine injection ? @error('q5')<b style="color: red"><strong> required </strong></b>@enderror</label></td>
                                                        <td style="text-align: center; vertical-align: middle"><input type="radio" name="q3_effect" id="q3_effect" value="Y" {{ (old('q3_effect') && old('q3_effect') == 'Y') ? 'checked' : '' }}> Yes</td>
                                                        <td style="text-align: center; vertical-align: middle"><input type="radio" name="q3_effect" id="q3_effect" value="N" {{ (old('q3_effect') && old('q3_effect') == 'N') ? 'checked' : '' }}> No</td>
                                                    </div>
                                                </tr>
                                                <tr class="q3_effect_remark" style="display: none">
                                                    <div class="form-group">
                                                        <td style="text-align: center" width="4%"><label for="q3_effect_remark"></label></td>
                                                        <td width="50%" style="vertical-align: middle;"><label for="q3_effect_remark"><span class="text-danger">*</span> Side Effects : </label>@error('q3_effect_remark')<b style="color: red"><strong> required </strong></b>@enderror</td>
                                                        <td colspan="2" style="text-align: center"><input placeholder="Please state the side effect..." class="form-control" name="q3_effect_remark" id="q3_effect_remark" value="{{ old('q3_effect_remark') }}"></td>
                                                    </div>
                                                </tr>
                                                <tr class="q4" style="display: none">
                                                    <div class="form-group">
                                                        <td style="text-align: center" width="4%"><label for="q4">5.</label></td>
                                                        <td><label for="q4"><span class="text-danger">*</span> Have you finished receiving your second dose vaccine ? @error('q4')<b style="color: red"><strong> required </strong></b>@enderror</label></td>
                                                        <td style="text-align: center; vertical-align: middle"><input type="radio" name="q4" id="q4" value="Y" {{ (old('q4') && old('q4') == 'Y') ? 'checked' : '' }}> Yes</td>
                                                        <td style="text-align: center; vertical-align: middle"><input type="radio" name="q4" id="q4" value="N" {{ (old('q4') && old('q4') == 'N') ? 'checked' : '' }}> No</td>
                                                    </div>
                                                </tr>
                                                <tr class="q4_date" style="display: none">
                                                    <div class="form-group">
                                                        <td style="text-align: center" width="4%"><label for="q4_date"></label></td>
                                                        <td width="50%" style="vertical-align: middle;"><label for="q4_date"><span class="text-danger">*</span> Second Dose Appointment Date : </label>@error('q4_date')<b style="color: red"><strong> required </strong></b>@enderror</td>
                                                        <td colspan="2" style="text-align: center"><input class="form-control" type="datetime-local" name="q4_date" id="q4_date" value="{{ old('q4_date') }}"></td>
                                                    </div>
                                                </tr>
                                                <tr class="q4_effect" style="display: none">
                                                    <div class="form-group">
                                                        <td style="text-align: center" width="4%"><label for="q4_effect">6.</label></td>
                                                        <td><label for="q4_effect"><span class="text-danger">*</span> Do you receive side effects from second dose vaccine injection ? @error('q5')<b style="color: red"><strong> required </strong></b>@enderror</label></td>
                                                        <td style="text-align: center; vertical-align: middle"><input type="radio" name="q4_effect" id="q4_effect" value="Y" {{ (old('q4_effect') && old('q4_effect') == 'Y') ? 'checked' : '' }}> Yes</td>
                                                        <td style="text-align: center; vertical-align: middle"><input type="radio" name="q4_effect" id="q4_effect" value="N" {{ (old('q4_effect') && old('q4_effect') == 'N') ? 'checked' : '' }}> No</td>
                                                    </div>
                                                </tr>
                                                <tr class="q4_effect_remark" style="display: none">
                                                    <div class="form-group">
                                                        <td style="text-align: center" width="4%"><label for="q4_effect_remark"></label></td>
                                                        <td width="50%" style="vertical-align: middle;"><label for="q4_effect_remark"><span class="text-danger">*</span> Side Effects : </label>@error('q4_effect_remark')<b style="color: red"><strong> required </strong></b>@enderror</td>
                                                        <td colspan="2" style="text-align: center"><input placeholder="Please state the side effect..." class="form-control" name="q4_effect_remark" id="q4_effect_remark" value="{{ old('q4_effect_remark') }}"></td>
                                                    </div>
                                                </tr>
                                                <tr>
                                                    <div class="form-group">
                                                        <td colspan="4">
                                                        <button style="margin-top: 5px;" class="btn btn-primary float-right" id="submit" name="submit"><i class="fal fa-check-circle"></i> Submit Details</button></td>
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
        $('.reasons, .reasonss').select2();
    });

    // Start New Form
    $(function () {          
        $("input[name=q1]").change(function () {        
            if ($(this).val() == "Y") {
            $(".q2").show();
            $(".q1_reason").hide();
            $(".q1_other_reason").hide();
            $(".q3").hide();
            $(".q3_date").hide();
            $(".q3_effect").hide();
            $(".q3_effect_remark").hide();
            $(".q4").hide();
            $(".q4_date").hide();
            $(".q4_effect").hide();
            $(".q4_effect_remark").hide();
            
            }
            else {
            $(".q1_reason").show();
            $(".q1_other_reason").hide();
            $(".q2").hide();
            $(".q3").hide();
            $(".q3_date").hide();
            $(".q3_effect").hide();
            $(".q3_effect_remark").hide();
            $(".q4").hide();
            $(".q4_date").hide();
            $(".q4_effect").hide();
            $(".q4_effect_remark").hide();
            }
        });

        $(".q1_other_reason").hide();

        $( "#q1_reason" ).change(function() {
            var val = $("#q1_reason").val();
            if(val=="4"){
                $(".q1_other_reason").show();
            } else {
                $(".q1_other_reason").hide();
            }
        });

        $("input[name=q2]").change(function () {        
            if ($(this).val() == "Y") {
            $(".q3_date").show();
            $(".q3").show();
            $(".q3_effect").hide();
            $(".q3_effect_remark").hide();
            $(".q4_date").hide();
            $(".q4").hide();
            $(".q4_effect").hide();
            $(".q4_effect_remark").hide();
            }
            else {
            $(".q3_date").hide();
            $(".q3").hide();
            $(".q3_effect").hide();
            $(".q3_effect_remark").hide();
            $(".q4_date").hide();
            $(".q4").hide();
            $(".q4_effect").hide();
            $(".q4_effect_remark").hide();
            }
        });

        $("input[name=q3]").change(function () {        
            if ($(this).val() == "Y") {
            $(".q4_date").show();
            $(".q4").show();
            $(".q3_effect").show();
            $(".q3_effect_remark").hide();
            $(".q4_effect").hide();
            $(".q4_effect_remark").hide();
            }
            else {
            $(".q3_effect").hide();
            $(".q3_effect_remark").hide();
            $(".q4_date").hide();
            $(".q4").hide();
            $(".q4_effect").hide();
            $(".q4_effect_remark").hide();
            }
        });

        $("input[name=q3_effect]").change(function () {        
            if ($(this).val() == "Y") {
            $(".q3_effect_remark").show();
            }
            else {
            $(".q3_effect_remark").hide();
            }
        });

        $("input[name=q4_effect]").change(function () {        
            if ($(this).val() == "Y") {
            $(".q4_effect_remark").show();
            }
            else {
            $(".q4_effect_remark").hide();
            }
        });

        $("input[name=q4]").change(function () {        
            if ($(this).val() == "Y") {
            $(".q4_effect").show();
            $(".q4_effect_remark").hide();
            }
            else {
            $(".q4_effect").hide();
            $(".q4_effect_remark").hide();
            }
        });
 

        $('input[name="q1"]:checked').val('{{ old('q1') }}');
        $('input[name="q1"]:checked').change(); 
        $('input[name="q2"]:checked').val('{{ old('q2') }}');
        $('input[name="q2"]:checked').change(); 
        $('input[name="q3"]:checked').val('{{ old('q3') }}');
        $('input[name="q3"]:checked').change();
        $('input[name="q4"]:checked').val('{{ old('q4') }}');
        $('input[name="q4"]:checked').change();
        $('input[name="q3_effect"]:checked').val('{{ old('q3_effect') }}');
        $('input[name="q3_effect"]:checked').change();
        $('input[name="q4_effect"]:checked').val('{{ old('q4_effect') }}');
        $('input[name="q4_effect"]:checked').change();

        $('#q1_reason').val('{{ old('q1_reason') }}'); 
        $("#q1_reason").change(); 
        $('#q1_other_reason').val('{{ old('q1_other_reason') }}'); 
        $('#q3_date').val('{{ old('q3_date') }}');
        $('#q3_effect_remark').val('{{ old('q3_effect_remark') }}');
        $('#q4_date').val('{{ old('q4_date') }}');
        $('#q4_effect_remark').val('{{ old('q4_effect_remark') }}');
    })

    // Start Update Form
    $(function () {          
        $("input[name=q1s]").change(function () {        
            if ($(this).val() == "Y") {
            $(".q2s").show();
            $(".q1_reasons").hide();
            $("#q1_other_reasons").hide();
            $(".q3s").hide();
            $(".q3_dates").hide();
            $(".q3_effects").hide();
            $(".q3_effect_remarks").hide();
            $(".q4s").hide();
            $(".q4_dates").hide();
            $(".q4_effects").hide();
            $(".q4_effect_remarks").hide();
            
            }
            else {
            $(".q1_reasons").show();
            $("#q1_other_reasons").hide();
            $(".q2s").hide();
            $(".q3s").hide();
            $(".q3_dates").hide();
            $(".q3_effects").hide();
            $(".q3_effect_remarks").hide();
            $(".q4s").hide();
            $(".q4_dates").hide();
            $(".q4_effects").hide();
            $(".q4_effect_remarks").hide();
            }
        });

        $("#q1_other_reasons").hide();

        $( "#q1_reasons" ).change(function() {
            var val = $("#q1_reasons").val();
            if(val=="4"){
                $("#q1_other_reasons").show();
            } else {
                $("#q1_other_reasons").hide();
            }
        });

        $("input[name=q2s]").change(function () {        
            if ($(this).val() == "Y") {
            $(".q3_dates").show();
            $(".q3s").show();
            $(".q3_effects").hide();
            $(".q3_effect_remarks").hide();
            $(".q4_dates").hide();
            $(".q4s").hide();
            $(".q4_effects").hide();
            $(".q4_effect_remarks").hide();
            }
            else {
            $(".q3_dates").hide();
            $(".q3s").hide();
            $(".q3_effects").hide();
            $(".q3_effect_remarks").hide();
            $(".q4_dates").hide();
            $(".q4s").hide();
            $(".q4_effects").hide();
            $(".q4_effect_remarks").hide();
            }
        });

        $("input[name=q3s]").change(function () {        
            if ($(this).val() == "Y") {
            $(".q4_dates").show();
            $(".q4s").show();
            $(".q3_effects").show();
            $(".q3_effect_remarks").hide();
            $(".q4_effects").hide();
            $(".q4_effect_remarks").hide();
            }
            else {
            $(".q3_effects").hide();
            $(".q3_effect_remarks").hide();
            $(".q4_dates").hide();
            $(".q4s").hide();
            $(".q4_effects").hide();
            $(".q4_effect_remarks").hide();
            }
        });

        $("input[name=q3_effects]").change(function () {        
            if ($(this).val() == "Y") {
            $(".q3_effect_remarks").show();
            }
            else {
            $(".q3_effect_remarks").hide();
            }
        });

        $("input[name=q4_effects]").change(function () {        
            if ($(this).val() == "Y") {
            $(".q4_effect_remarks").show();
            }
            else {
            $(".q4_effect_remarks").hide();
            }
        });

        $("input[name=q4s]").change(function () {        
            if ($(this).val() == "Y") {
            $(".q4_effects").show();
            $(".q4_effect_remarks").hide();
            }
            else {
            $(".q4_effects").hide();
            $(".q4_effect_remarks").hide();
            }
        });

        $('input[name="q1s"]:checked').val();
        $('input[name="q1s"]:checked').change(); 
        $('input[name="q2s"]:checked').val();
        $('input[name="q2s"]:checked').change(); 
        $('input[name="q3s"]:checked').val();
        $('input[name="q3s"]:checked').change();
        $('input[name="q4s"]:checked').val();
        $('input[name="q4s"]:checked').change();
        $('input[name="q3_effects"]:checked').val();
        $('input[name="q3_effects"]:checked').change();
        $('input[name="q4_effects"]:checked').val();
        $('input[name="q4_effects"]:checked').change();
        $('#q1_reasons').val(); 
        $("#q1_reasons").change(); 
        $('#q1_other_reasons').val(); 
        $('#q3_dates').val();
        $('#q3_effect_remarks').val();
        $('#q4_dates').val();
        $('#q4_effect_remarks').val();
    })
</script>
@endsection

