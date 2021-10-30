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
                            <b>INTEC EDUCATION COLLEGE COVID19 RISK SCREENING DAILY DECLARATION FORM</b>
                        </h4>
                        <div>
                            <p style="padding-left: 40px; padding-right: 40px">
                                *<i><b>IMPORTANT!</b></i> : All staff & students  are required to make a daily declaration of COVID-19 risk screening on every working day (whether working in the office or from home) as prevention measures. 
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
                                    @if($bakihari<15)
                                        @php $display = false; @endphp
                                        <table id="info" class="table table-bordered table-hover table-striped w-100">
                                            <thead>
                                                <tr align="center" class="data-row">
                                                    <td valign="top" colspan="4" class="dataTables_empty">
                                                        <p style="font-family: 'Times New Roman', Times, serif; color: rgb(97 63 115)"><b> ' YOU MADE SELF DECLARATION ON {{ date(' d/m/Y ', strtotime($declare->declare_date) )}} ' </b></p>
                                                        <p style="font-size: 20px; color: black">Please Quarantine Yourself For 14 Days</p>
                                                        <p style="font-size: 20px; color: black">Countdown : {{ $bakihari }}/14 Days</p>
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
                                    @endif
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
                                            <div>
                                                <div class="table-responsive">
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
                                                </div>
                                                    <table class="table table-bordered table-hover table-striped w-100">
                                                        <thead>
                                                            <tr>
                                                                <td width="20%"><label class="form-label" for="user_category"> Category : @error('user_category')<b style="color: red"><strong> required </strong></b>@enderror</label></td>
                                                                <td colspan="6">
                                                                    <select class="form-control user_category" name="user_category" id="user_category">
                                                                        <option value="">Select Category</option>
                                                                        @foreach ($category as $cate) 
                                                                            <option value="{{ $cate->category_code }}" @if (old('user_category') == $cate->category_code) selected="selected" @endif>{{ $cate->category_name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr class="select-depart">
                                                                <td width="20%"><label class="form-label" for="department_id"> Department To Go : </label></td>
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
                                                                <td width="80%"><label for="q1">Have you been confirmed positive with COVID-19 within 14 days?</label>@error('q1')<b style="color: red"><strong> required </strong></b>@enderror</td>
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
                                                                <td><label for="q2">Have you had close contact with anyone who confirmed positive case of COVID-19 within 10 days?</label>@error('q2')<b style="color: red"><strong> required </strong></b>@enderror</td>
                                                                <td style="text-align: center"><input type="radio" name="q2" id="q2" value="Y" {{ (old('q2') && old('q2') == 'Y') ? 'checked' : '' }}></td>
                                                                <td style="text-align: center"><input type="radio" name="q2" id="q2" value="N" {{ (old('q2') && old('q2') == 'N') ? 'checked' : '' }}></td>
                                                            </div>
                                                        </tr>
                                                        <tr class="declare_date2" style="display: none">
                                                            <div class="form-group">
                                                                <td style="text-align: center" width="4%"><label for="declare_date"></label></td>
                                                                <td width="80%" style="vertical-align: middle;"><label for="declare_date2"><span class="text-danger">*</span> Date Confirmed Contact : </label>@error('declare_date2')<b style="color: red"><strong> required </strong></b>@enderror</td>
                                                                <td colspan="2" style="text-align: center">
                                                                    <input class="form-control" type="datetime-local" name="declare_date2" id="declare_date2" value="{{ old('declare_date2') }}">
                                                                </td>
                                                            </div>
                                                        </tr>
                                                        <tr class="q3" style="display: none">
                                                            <div class="form-group">
                                                                <td style="text-align: center" width="4%"><label for="q3">3.</label></td>
                                                                <td><label for="q3">
                                                                    Have you had close contact with any individual on question 2 within 10 days <br><br> OR <br><br>
                                                                    Have you ever attended an event or visited any place involving suspected or positive COVID-19 case within 10 days <br><br> OR <br><br>
                                                                    Are you from an area of Enhanced Movement Control Order (EMCO) in period of 10 days ?  @error('q3')<b style="color: red"><strong> required </strong></b>@enderror</label></td>
                                                                <td style="text-align: center; vertical-align: middle"><input type="radio" name="q3" id="q3" value="Y" {{ (old('q3') && old('q3') == 'Y') ? 'checked' : '' }}></td>
                                                                <td style="text-align: center; vertical-align: middle"><input type="radio" name="q3" id="q3" value="N" {{ (old('q3') && old('q3') == 'N') ? 'checked' : '' }}></td>
                                                            </div>
                                                        </tr>
                                                    
                                                        <tr class="q4" style="display: none">
                                                            <div class="form-group">
                                                                <td style="text-align: center" width="3%" rowspan="5"><label for="q4">4.</label></td>
                                                                <td><label for="q4">Do you experience the following symptoms:</label></td>
                                                                <td colspan="2"></td>
                                                            </div>
                                                        </tr>
                                                        <tr class="q4" style="display: none">
                                                            <div class="form-group">
                                                                <td width="3%"><label for="q4a"><li>Fever</li></label>@error('q4a')<b style="color: red"><strong> required </strong></b>@enderror</td>
                                                                <td style="text-align: center"><input type="radio" name="q4a" id="q4a" value="Y" {{ (old('q4a') && old('q4a') == 'Y') ? 'checked' : '' }}></td>
                                                                <td style="text-align: center"><input type="radio" name="q4a" id="q4a" value="N" {{ (old('q4a') && old('q4a') == 'N') ? 'checked' : '' }}></td>
                                                            </div>
                                                        </tr>
                                                        <tr class="q4" style="display: none">
                                                            <div class="form-group">
                                                                <td width="3%"><label for="q4b"><li>Cough</li></label>@error('q4b')<b style="color: red"><strong> required </strong></b>@enderror</td>
                                                                <td style="text-align: center"><input type="radio" name="q4b" id="q4b" value="Y" {{ (old('q4b') && old('q4b') == 'Y') ? 'checked' : '' }}></td>
                                                                <td style="text-align: center"><input type="radio" name="q4b" id="q4b" value="N" {{ (old('q4b') && old('q4b') == 'N') ? 'checked' : '' }}></td>
                                                            </div>
                                                        </tr>
                                                        <tr class="q4" style="display: none">
                                                            <div class="form-group">
                                                                <td width="3%"><label for="q4c"><li>Flu</li></label>@error('q4c')<b style="color: red"><strong> required </strong></b>@enderror</td>
                                                                <td style="text-align: center"><input type="radio" name="q4c" id="q4c" value="Y" {{ (old('q4c') && old('q4c') == 'Y') ? 'checked' : '' }}></td>
                                                                <td style="text-align: center"><input type="radio" name="q4c" id="q4c" value="N" {{ (old('q4c') && old('q4c') == 'N') ? 'checked' : '' }}></td>
                                                            </div>
                                                        </tr>
                                                        <tr class="q4" style="display: none">
                                                            <div class="form-group">
                                                                <td width="3%"><label for="q4d"><li>Difficulty in Breathing</li></label>@error('q4d')<b style="color: red"><strong> required </strong></b>@enderror</td>
                                                                <td style="text-align: center"><input type="radio" name="q4d" id="q4d" value="Y" {{ (old('q4d') && old('q4d') == 'Y') ? 'checked' : '' }}></td>
                                                                <td style="text-align: center"><input type="radio" name="q4d" id="q4d" value="N" {{ (old('q4d') && old('q4d') == 'N') ? 'checked' : '' }}></td>
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
        $('.department_id, .user_category').select2();
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
        }
        else {
          $(".q3").show();
          $(".declare_date2").hide();
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

      $(".select-depart").hide();

      $( "#user_category" ).change(function() {
        var val = $("#user_category").val();
        if(val=="WFO"){
            $(".select-depart").show();
        } else {
            $(".select-depart").hide();
        }
      });

        $('.user_category').val('{{ old('user_category') }}'); 
        $(".user_category").change(); 
        $('.department_id').val('{{ old('department_id') }}');
        $('.temperature').val('{{ old('temperature') }}');
        $('.user_phone').val('{{ old('user_phone') }}');
        $('input[name="q1"]:checked').val('{{ old('q1') }}');
        $('input[name="q1"]:checked').change(); 
        $('#declare_date1').val('{{ old('declare_date1') }}');
        $('input[name="q2"]:checked').val('{{ old('q2') }}');
        $('input[name="q2"]:checked').change(); 
        $('#declare_date2').val('{{ old('declare_date2') }}');
        $('input[name="q3"]:checked').val('{{ old('q3') }}');
        $('input[name="q3"]:checked').change(); 
        $('input[name="q4a"]:checked').val('{{ old('q4a') }}');
        $('input[name="q4a"]:checked').change(); 
        $('input[name="q4b"]:checked').val('{{ old('q4b') }}');
        $('input[name="q4b"]:checked').change(); 
        $('input[name="q4c"]:checked').val('{{ old('q4c') }}');
        $('input[name="q4c"]:checked').change(); 
        $('input[name="q4d"]:checked').val('{{ old('q4d') }}');
        $('input[name="q4d"]:checked').change(); 

    })

</script>
@endsection

