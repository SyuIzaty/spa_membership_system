@extends('layouts.admin')

@section('content')

@php $display = true; @endphp

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
                            <b>COVID19 RISK SCREENING DAILY DECLARATION FORM</b>
                        </h4>
                        <br>
                        <div>
                            <p style="padding-left: 40px; padding-right: 40px; font-size: 12px">
                                *<i><b>IMPORTANT!</b></i> : All staff, student and visitor are required to make a daily declaration of COVID-19 risk screening on every working day (whether working in the office or from home) as prevention measures. 
                                However, you are encouraged to make a declaration on a daily basis including public holidays and other holidays.
                            </p>
                        </div>
                        @if(isset($declare))
                                @php
                                    $datenow   = date('d-m-Y');
                                    $duedate   = $declare->declare_date->format('d-m-Y');
                                    $datetime1 = new DateTime($datenow);
                                    $datetime2 = new DateTime($duedate);
                                    $bakihari  = $datetime1->diff($datetime2)->format('%a')+1;
                                @endphp
            
                                @if($declare->category == 'A')
                                    @if($bakihari<11)
                                        @php $display = false; @endphp
                                        <table id="info" class="table table-bordered table-hover table-striped w-100">
                                            <thead>
                                                <tr align="center" class="data-row">
                                                    <td valign="top" colspan="4" class="dataTables_empty">
                                                        <p style="font-family: 'Times New Roman', Times, serif; color: rgb(97 63 115)"><b> ' YOU MADE SELF DECLARATION ON {{ date(' d/m/Y ', strtotime($declare->declare_date) )}} ' </b></p>
                                                        <p style="font-size: 20px; color: black">Please Quarantine Yourself For 10 Days</p>
                                                        <p style="font-size: 20px; color: black">Countdown : {{ $bakihari }}/10 Days</p>
                                                        <table>
                                                            <tr><td style="background-color:#ff664c; color: white;">
                                                            <p class="mb-0 mt-0" style="font-size: 40px">{{ date(' j ', strtotime($declare->declare_date) )}}
                                                            <sup style="top: -16px; font-size: 20px;">{{ date(' M Y ', strtotime($declare->declare_date) )}}</sup>
                                                            <p style="margin-top: -32px;margin-left: 58px;margin-bottom: -15px;font-size: 21px;">{{ date(' l ', strtotime($declare->declare_date) )}}</p></p>
                                                            <hr class="mb-0 mt-0">
                                                            <p align="center" class="mb-0 mt-0">{{$declare->category}}</p>
                                                        </td></tr>
                                                        </table>
                                                        <a style="margin-top: 20px;" class="btn btn-primary" href="/declare-info/{{$declare->id}}"><i class="fal fa-eye"></i> Declaration Result</a>
                                                    </td>
                                                </tr>
                                            </thead>
                                        </table>
                                    @endif
                                @elseif($declare->category == 'B')
                                    {{-- @if($bakihari<8) --}}
                                        @php $display = false; @endphp
                                        <table id="info" class="table table-bordered table-hover table-striped w-100">
                                            <thead>
                                                <tr align="center" class="data-row">
                                                    <td valign="top" colspan="4" class="dataTables_empty">
                                                        <p style="font-family: 'Times New Roman', Times, serif; color: rgb(97 63 115)"><b> ' YOU MADE SELF DECLARATION ON {{ date(' d/m/Y ', strtotime($declare->declare_date) )}} ' </b></p>
                                                        <p style="font-size: 20px; color: black">Please Contact HR For Confirmation of Quarantine Process.</p>
                                                        {{-- <p style="font-size: 20px; color: black">Countdown : {{ $bakihari }}/7 Days</p> --}}
                                                        <table>
                                                            <tr><td style="background-color:orange; color: white;">
                                                            <p class="mb-0 mt-0" style="font-size: 40px">{{ date(' j ', strtotime($declare->declare_date) )}}
                                                            <sup style="top: -16px; font-size: 20px;">{{ date(' M Y ', strtotime($declare->declare_date) )}}</sup>
                                                            <p style="margin-top: -32px;margin-left: 58px;margin-bottom: -15px;font-size: 21px;">{{ date(' l ', strtotime($declare->declare_date) )}}</p></p>
                                                            <hr class="mb-0 mt-0">
                                                            <p align="center" class="mb-0 mt-0">{{$declare->category}}</p>
                                                        </td></tr>
                                                        </table>
                                                        <a style="margin-top: 20px;" class="btn btn-primary" href="/declare-info/{{$declare->id}}"><i class="fal fa-eye"></i> Declaration Result</a>
                                                    </td>
                                                </tr>
                                            </thead>
                                        </table>
                                    {{-- @endif --}}
                                @else
                                    @if($exist)
                                        @php $display = false; @endphp
                                        <table id="info" class="table table-bordered table-hover table-striped w-100">
                                        <thead>
                                            <tr align="center" class="data-row">
                                                <td valign="top" colspan="4" class="dataTables_empty">
                                                    <b style="font-family: 'Times New Roman', Times, serif; color: rgb(97 63 115)"> ' YOU HAVE MADE SELF DECLARATION FOR TODAY ' </b><br><br>
                                                    <table>
                                                        <tr><td style="background-color:#17d173; color: white;">
                                                        <p class="mb-0 mt-0" style="font-size: 40px">{{ date(' j ', strtotime($declare->declare_date) )}}
                                                        <sup style="top: -16px; font-size: 20px;">{{ date(' M Y ', strtotime($declare->declare_date) )}}</sup>
                                                        <p style="margin-top: -32px;margin-left: 58px;margin-bottom: -15px;font-size: 21px;">{{ date(' l ', strtotime($declare->declare_date) )}}</p></p>
                                                        <hr class="mb-0 mt-0">
                                                        <p align="center" class="mb-0 mt-0">{{$declare->category}}</p>
                                                    </td></tr>
                                                    </table>
                                                    <a style="margin-top: 20px;" class="btn btn-primary" href="/declare-info/{{$declare->id}}"><i class="fal fa-eye"></i> Today's Declaration Result</a>
                                                </td>
                                            </tr>
                                        </thead>
                                    </table>
                                    @endif
                                @endif
                        @endif
                            <div class="panel-container show {{ $display ? '' : 'd-none' }}">
                                <div class="panel-content">
                                    {!! Form::open(['action' => 'CovidController@formStore', 'method' => 'POST']) !!}
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <div class="table-responsive">
                                            {{-- <div class="table-responsive">
                                                <table class="table table-bordered table-hover table-striped w-100">
                                                    <thead>
                                                        <tr>
                                                            <div class="form-group">
                                                                <th style="text-align: center; border-left-style: hidden; border-right-style: hidden"><label>Full Name : </label>
                                                                    <b style="font-size: 15px; letter-spacing: 1px; padding-left: 18px; color: rgb(27, 57, 3); font-weight: normal">{{ strtoupper($user->name)}}</b>
                                                                </th>
                                                                <th style="text-align: center; border-right-style: hidden"><label>Staff ID / Student ID : </label>
                                                                    <b style="font-size: 15px; letter-spacing: 1px; padding-left: 18px; color: rgb(27, 57, 3); font-weight: normal">{{ strtoupper($user->id)}}</b>
                                                                </th>
                                                                <th style="text-align: center; border-right-style: hidden"><label>Email : </label>
                                                                    <b style="font-size: 15px; letter-spacing: 1px; padding-left: 18px; color: rgb(27, 57, 3); font-weight: normal">{{ $user->email}}</b>
                                                                </th>
                                                                <th style="text-align: center; border-right-style: hidden"><label>Phone No. : </label></th>
                                                                <th style=" border-right-style: hidden">
                                                                    <input class="form-control" id="user_phone" name="user_phone"  value="{{ old('user_phone') }}" style="width: 170px">
                                                                </th>
                                                            </div>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div> --}}
                                            <table class="table table-bordered table-hover table-striped w-100">
                                                <thead>
                                                    <p><span class="text-danger">*</span> Required fields</p>
                                                    <tr>
                                                        <td width="20%"><label class="form-label" for="user_phone"><span class="text-danger">*</span>  Phone No. : </label></td>
                                                        <td colspan="6">
                                                            <input type="number" class="form-control" id="user_phone" name="user_phone"  value="{{ old('user_phone') }}" required>
                                                            @error('user_phone')
                                                            <p style="color: red"><strong> {{ $message }} </strong></p>
                                                        @enderror
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td width="20%"><label class="form-label" for="user_category"><span class="text-danger">*</span>  Category : </label></td>
                                                        <td colspan="6">
                                                            <select class="form-control user_category" name="user_category" id="user_category" required>
                                                                <option value="">Select Category</option>
                                                                @foreach ($category as $cate) 
                                                                    <option value="{{ $cate->category_code }}" @if (old('user_category') == $cate->category_code) selected="selected" @endif>{{ $cate->category_name }}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('user_category')
                                                                <p style="color: red"><strong> {{ $message }} </strong></p>
                                                            @enderror
                                                        </td>
                                                    </tr>
                                                    <tr class="select-depart">
                                                        <td width="20%"><label class="form-label" for="department_id"><span class="text-danger">*</span>  Department To Go :  </label></td>
                                                        <td colspan="6">
                                                            <select class="form-control department_id" name="department_id" id="department_id">
                                                                <option value="">Select Department</option>
                                                                @foreach ($department as $depart) 
                                                                    <option value="{{ $depart->id }}" @if (old('department_id') == $depart->id) selected="selected" @endif>{{ $depart->department_name }}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('department_id')
                                                                <p style="color: red"><strong> {{ $message }} </strong></p>
                                                            @enderror
                                                        </td>
                                                    </tr>
                                                    <tr class="select-depart">
                                                        <td width="20%"><label class="form-label" for="temperature"> Temperature (°C) : </label></td>
                                                        <td colspan="6">
                                                            <input class="form-control temperature" type="number" step="any" id="temperature" name="temperature">
                                                            @error('temperature')
                                                                <p style="color: red"><strong> {{ $message }} </strong></p>
                                                            @enderror
                                                        </td>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>

                                        <div class="table-responsive">
                                            <table id="info" class="table table-bordered table-hover table-striped w-100">
                                                <thead>
                                                    <tr>
                                                        <div class="form-group">
                                                            <th style="text-align: center" width="4%"><label class="form-label" for="qHeader">NO.</label></th>
                                                            <th style="text-align: center"><label class="form-label" for="qHeader">DECLARATION CHECKLIST</label></th>
                                                            <th style="text-align: center"><label class="form-label" for="qHeader">YES</label></th>
                                                            <th style="text-align: center"><label class="form-label" for="qHeader">NO</label></th>
                                                        </div>
                                                    </tr>
                                                    <tr class="q1">
                                                        <div class="form-group">
                                                            <td style="text-align: center" width="4%"><label for="q1">1.</label></td>
                                                            <td width="80%;"><label for="q1">Have you been confirmed positive with COVID-19 within 14 days? </label>@error('q1')<b style="color: red"><strong> required </strong></b>@enderror</td>
                                                            <td style="text-align: center"><input type="radio" name="q1" id="q1" value="Y" {{ (old('q1') && old('q1') == 'Y') ? 'checked' : '' }}></td>
                                                            <td style="text-align: center"><input type="radio" name="q1" id="q1" value="N" {{ (old('q1') && old('q1') == 'N') ? 'checked' : '' }}></td>
                                                        </div>
                                                    </tr>
                                                    <tr class="declare_date1" style="display: none">
                                                        <div class="form-group">
                                                            <td style="text-align: center" width="4%"><label for="declare_date"></label></td>
                                                            <td width="80%" style="vertical-align: middle;"><label for="declare_date1"><span class="text-danger">*</span> Date Confirmed Positive : </label>@error('declare_date1')<b style="color: red"><strong> required </strong></b>@enderror</td>
                                                            <td colspan="2" style="text-align: center">
                                                                <input class="form-control" type="datetime-local" name="declare_date1" id="declare_date1" value="{{ old('declare_date1') }}">
                                                            </td>
                                                        </div>
                                                    </tr>
                                                    <tr class="q2" style="display: none">
                                                        <div class="form-group">
                                                            <td style="text-align: center" width="4%"><label for="q2">2.</label></td>
                                                            <td><label for="q2">Have you had close contact with anyone who confirmed positive case of COVID-19 within 10 days? </label>@error('q2')<b style="color: red"><strong> required </strong></b>@enderror</td>
                                                            <td style="text-align: center"><input type="radio" name="q2" id="q2" value="Y" {{ (old('q2') && old('q2') == 'Y') ? 'checked' : '' }}></td>
                                                            <td style="text-align: center"><input type="radio" name="q2" id="q2" value="N" {{ (old('q2') && old('q2') == 'N') ? 'checked' : '' }}></td>
                                                        </div>
                                                    </tr>
                                                    <tr class="declare_date2" style="display: none">
                                                        <div class="form-group">
                                                            <td style="text-align: center" width="4%"><label for="declare_date2"></label></td>
                                                            <td width="80%" style="vertical-align: middle;"><label for="declare_date2"><span class="text-danger">*</span> Date Confirmed Contact : </label>@error('declare_date2')<b style="color: red"><strong> required </strong></b>@enderror</td>
                                                            <td colspan="2" style="text-align: center">
                                                                <input class="form-control" type="datetime-local" name="declare_date2" id="declare_date2" value="{{ old('declare_date2') }}">
                                                            </td>
                                                        </div>
                                                    </tr>
                                                    <tr class="declare_date2" style="display: none">
                                                        <div class="form-group">
                                                            <td style="text-align: center" width="4%"><label for="declare_contact2"></label></td>
                                                            <td width="80%" style="vertical-align: middle;"><label for="declare_contact2"><span class="text-danger">*</span> Who's The Close Contact (eg: parents/siblings/friend) ? : </label>@error('declare_contact2')<b style="color: red"><strong> required </strong></b>@enderror</td>
                                                            <td colspan="2" style="text-align: center">
                                                                <input class="form-control" name="declare_contact2" id="declare_contact2" value="{{ old('declare_contact2') }}">
                                                            </td>
                                                        </div>
                                                    </tr>
                                                    <tr class="declare_date2" style="display: none">
                                                        <div class="form-group">
                                                            <td style="text-align: center" width="4%"><label for="declare_kit2"></label></td>
                                                            <td width="80%" style="vertical-align: middle;"><label for="declare_kit2"><span class="text-danger">*</span> Done Your Own COVID-19 Care Medical Kit ? : </label>@error('declare_kit2')<b style="color: red"><strong> required </strong></b>@enderror</td>
                                                            <td style="text-align: center"><input type="radio" name="declare_kit2" id="declare_kit2" value="Y" {{ (old('declare_kit2') && old('declare_kit2') == 'Y') ? 'checked' : '' }}></td>
                                                            <td style="text-align: center"><input type="radio" name="declare_kit2" id="declare_kit2" value="N" {{ (old('declare_kit2') && old('declare_kit2') == 'N') ? 'checked' : '' }}></td>
                                                        </div>
                                                    </tr>
                                                    <tr class="declare_result2" style="display: none">
                                                        <div class="form-group">
                                                            <td style="text-align: center" width="4%"><label for="declare_result2"></label></td>
                                                            <td width="80%" style="vertical-align: middle;"><label for="declare_result2"><span class="text-danger">*</span> Result : </label>@error('declare_result2')<b style="color: red"><strong> required </strong></b>@enderror</td>
                                                            <td colspan="2" style="text-align: center">
                                                                <select class="form-control deres2" id="declare_result2" name="declare_result2">
                                                                    <option value="">Please Select</option>
                                                                    <option value="P" {{ old('declare_result2') == 'P' ? 'selected':''}} >Positive (+)</option>
                                                                    <option value="N" {{ old('declare_result2') == 'N' ? 'selected':''}} >Negative (-)</option>
                                                                </select>
                                                            </td>
                                                        </div>
                                                    </tr>
                                                    <tr class="q3" style="display: none">
                                                        <div class="form-group">
                                                            <td style="text-align: center" width="4%"><label for="q3">3.</label></td>
                                                            <td><label for="q3">
                                                                Are you categorized as Casual Contact in MySejahtera ? <br><br> OR <br><br>
                                                                Have you ever attended an event or visited any place involving suspected or positive COVID-19 case ? <br><br> OR <br><br>
                                                                Are you from an area of Enhanced Movement Control Order (EMCO) in period of 10 days ? @error('q3')<b style="color: red"><strong> required </strong></b>@enderror</label></td>
                                                            <td style="text-align: center; vertical-align: middle"><input type="radio" name="q3" id="q3" value="Y" {{ (old('q3') && old('q3') == 'Y') ? 'checked' : '' }}></td>
                                                            <td style="text-align: center; vertical-align: middle"><input type="radio" name="q3" id="q3" value="N" {{ (old('q3') && old('q3') == 'N') ? 'checked' : '' }}></td>
                                                        </div>
                                                    </tr>
                                                    
                                                    <tr class="q4" style="display: none">
                                                        <div class="form-group">
                                                            <td style="text-align: center" width="4%"><label for="q3">4.</label></td>
                                                            <td><label for="q4">Do you have any symptom of Covid-19 (Fever/Cough/Flu/Sore Throat) ?</label></td>
                                                            <td style="text-align: center; vertical-align: middle"><input type="radio" name="q4" id="q4" value="Y" {{ (old('q4') && old('q4') == 'Y') ? 'checked' : '' }}></td>
                                                            <td style="text-align: center; vertical-align: middle"><input type="radio" name="q4" id="q4" value="N" {{ (old('q4') && old('q4') == 'N') ? 'checked' : '' }}></td>
                                                        </div>
                                                    </tr>
                                                    <tr class="q4_kit" style="display: none">
                                                        <div class="form-group">
                                                            <td style="text-align: center" width="4%"><label for="q4_kit"></label></td>
                                                            <td width="80%" style="vertical-align: middle;"><label for="q4_kit"><span class="text-danger">*</span> Done Your Own COVID-19 Care Medical Kit ? : </label>@error('declare_kit2')<b style="color: red"><strong> required </strong></b>@enderror</td>
                                                            <td style="text-align: center"><input type="radio" name="q4_kit" id="q4_kit" value="Y" {{ (old('q4_kit') && old('q4_kit') == 'Y') ? 'checked' : '' }}></td>
                                                            <td style="text-align: center"><input type="radio" name="q4_kit" id="q4_kit" value="N" {{ (old('q4_kit') && old('q4_kit') == 'N') ? 'checked' : '' }}></td>
                                                        </div>
                                                    </tr>
                                                    <tr class="q4_result" style="display: none">
                                                        <div class="form-group">
                                                            <td style="text-align: center" width="4%"><label for="q4_result"></label></td>
                                                            <td width="80%" style="vertical-align: middle;"><label for="q4_result"><span class="text-danger">*</span> Result : </label>@error('q4_result')<b style="color: red"><strong> required </strong></b>@enderror</td>
                                                            <td colspan="2" style="text-align: center">
                                                                <select class="form-control q4res" id="q4_result" name="q4_result">
                                                                    <option value="">Please Select</option>
                                                                    <option value="P" {{ old('q4_result') == 'P' ? 'selected':''}} >Positive (+)</option>
                                                                    <option value="N" {{ old('q4_result') == 'N' ? 'selected':''}} >Negative (-)</option>
                                                                </select>
                                                            </td>
                                                        </div>
                                                    </tr>
                                                    <tr>
                                                        <div class="form-group">
                                                            <td colspan="4"><label class="form-label" for="confirmation">
                                                            <input style="margin-top: 15px; margin-right: 30px; margin-left: 15px; margin-bottom: 15px;" type="checkbox" name="chk" id="chk" onclick="btn()"/>
                                                            <b> I CERTIFY THAT ALL INFORMATION PROVIDED IS CORRECT AND ACCURATE. ACTION MAY BE TAKEN IF THE INFORMATION PROVIDED IS FALSE.</b></label> 
                                                            <button style="margin-top: 5px;" class="btn btn-primary float-right" id="submit" name="submit" disabled><i class="fal fa-check"></i> Submit Declaration</button></td>
                                                        </div>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
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
        $('.department_id, .user_category, .deres2, .q4res').select2();
    })

    function btn()
    {
        var chk = document.getElementById("chk")
        var submit = document.getElementById("submit");
        submit.disabled = chk.checked ? false : true;
        if(!submit.disabled){
            submit.focus();
        }
    }

    $(function () {          
        $("input[name=q1]").change(function () {        
            if ($(this).val() == "Y") {
            $(".q2").hide();
            $(".q3").hide();
            $(".q4").hide();
            $(".declare_date2").hide();
            $(".declare_date1").show();
            }
            else {
            $(".q2").show();
            $(".declare_date1").hide();
            }
        });

        $("input[name=q2]").change(function () {        
            if ($(this).val() == "Y") {
                $(".q3").hide();
                $(".q4").hide();
                $(".declare_date1").hide();
                $(".declare_date2").show();
                $(".declare_contact2").show();
                $(".declare_kit2").show();
            }
            else {
                $(".q3").show();
                $(".declare_date2").hide();
                $(".declare_result2").hide();
            }
        });

        $("input[name=declare_kit2]").change(function () {        
            if ($(this).val() == "Y") {
                $(".q3").hide();
                $(".q4").hide();
                $(".declare_date1").hide();
                $(".declare_date2").show();
                $(".declare_result2").show();
            }
            else {
                $(".declare_result2").hide();
            }
        });

        $("input[name=q3]").change(function () {        
            if ($(this).val() == "Y") {
            $(".q4").hide();
            }
            else {
            $(".q4").show();
            }
        });

        $("input[name=q4]").change(function () {        
            if ($(this).val() == "Y") {
            $(".q4_kit").show();
            $(".q4_result").hide();
            }
            else {
            $(".q4_kit").hide();
            $(".q4_result").hide();
            }
        });

        $("input[name=q4_kit]").change(function () {        
            if ($(this).val() == "Y") {
            $(".q4_result").show();
            }
            else {
            $(".q4_result").hide();
            }
        });

        $(".select-depart").hide();

        $( "#user_category" ).change(function() {
            var val = $("#user_category").val();
            if(val=="WFO"){
                $(".select-depart").show();
            } else {
                $(".select-depart").hide();
            }
        });

        $( "#user_category" ).change(function() {
            var val = $("#user_category").val();
            if(val=="WFO"){
                document.getElementById("department_id").required = true;
            } 
        });

        $('.user_category').val('{{ old('user_category') }}'); 
        $(".user_category").change(); 
        $('.user_phone').val('{{ old('user_phone') }}');
        $('.department_id').val('{{ old('department_id') }}');
        $('.temperature').val('{{ old('temperature') }}');

        $('input[name="q1"]:checked').val('{{ old('q1') }}');
        $('input[name="q1"]:checked').change(); 
        $('#declare_date1').val('{{ old('declare_date1') }}');
        $('input[name="q2"]:checked').val('{{ old('q2') }}');
        $('input[name="q2"]:checked').change(); 
        $('#declare_date2').val('{{ old('declare_date2') }}');
        $('#declare_contact2').val('{{ old('declare_contact2') }}');
        $('input[name="declare_kit2"]:checked').val('{{ old('declare_kit2') }}');
        $('input[name="declare_kit2"]:checked').change(); 
        $('#declare_result2').val('{{ old('declare_result2') }}');
        $('input[name="q3"]:checked').val('{{ old('q3') }}');
        $('input[name="q3"]:checked').change(); 
        $('input[name="q4"]:checked').val('{{ old('q4') }}');
        $('input[name="q4"]:checked').change(); 
        $('input[name="q4_kit"]:checked').val('{{ old('q4_kit') }}');
        $('input[name="q4_kit"]:checked').change(); 
        $('#q4_result').val('{{ old('q4_result') }}');

    })

</script>
@endsection

