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
                            <b>INTEC EDUCATION COLLEGE COVID19 RISK SCREENING DAILY DECLARATION FORM</b>
                        </h4>
                        <div>
                            <p style="padding-left: 40px; padding-right: 40px">
                                *<i><b>IMPORTANT!</b></i> : All staff / students / contractors / visitors are required to make a daily declaration of COVID-19 risk screening on every working day 
                                (whether working in the office or from home) as stated in item 5.1 (ii) regarding COVID-19 UiTM prevention measures. 
                                However, you are encouraged to make a declaration on a daily basis including public holidays and other holidays.
                            </p>
                        </div>

                        <div class="panel-container show">
                            <div class="panel-content">
                                {!! Form::open(['action' => 'CovidController@newStore', 'method' => 'POST']) !!}
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    @if (Session::has('message'))
                                        <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('message') }}</div>
                                    @endif
                                    <div>
                                        <table class="table table-bordered table-hover table-striped w-100">
                                            <thead>
                                                <tr>
                                                    <div class="form-group">
                                                        <th style="text-align: center; border-left-style: hidden; border-right-style: hidden"><label>Full Name : </label></th>
                                                        <td style=" border-right-style: hidden; width: 400px;">
                                                            {{-- <input class="form-control" id="user_name" name="user_name"  value="{{ old('user_name') }}"> --}}
                                                            <select class="form-control user_name" name="user_name" id="user_name" >
                                                                <option value=""> Select User Name </option>
                                                                @foreach ($user as $usr) 
                                                                <option value="{{ $usr->id }}" {{ old('user_name') ==  $usr->id  ? 'selected' : '' }}>
                                                                    {{ $usr->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <th style="text-align: center; border-right-style: hidden"><label>Staff ID / Student ID: </label></th>
                                                        <td style=" border-right-style: hidden">
                                                            <input class="form-control user_id" id="user_id" name="user_id"  value="{{ old('user_id') }}" readonly>
                                                        </td>
                                                        <th style="text-align: center; border-right-style: hidden"><label>Email : </label></th>
                                                        <td style=" border-right-style: hidden">
                                                            <input class="form-control user_email" id="user_email" name="user_email"  value="{{ old('user_email') }}" readonly>
                                                        </td>
                                                        <th style="text-align: center; border-right-style: hidden"><label>Phone No. : </label></th>
                                                        <td style=" border-right-style: hidden">
                                                            <input class="form-control" id="user_phone" name="user_phone"  value="{{ old('user_phone') }}">
                                                        </td>
                                                    </div>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>

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
                                                    <td width="80%;"><label for="q1">Have you been confirmed positive with COVID-19 within 14 days? <b style="color: red">@error('q1')* required @enderror</b></label></td>
                                                    <td style="text-align: center"><input type="radio" name="q1" id="q1" value="Y" {{ old('q1') == "Y" ? 'checked' : '' }}></td>
                                                    <td style="text-align: center"><input type="radio" name="q1" id="q1" value="N" {{ old('q1') == "N" ? 'checked' : '' }}></td>
                                                </div>
                                            </tr>
                                            <tr class="declare_date1" style="display: none">
                                                <div class="form-group">
                                                    <td style="text-align: center" width="4%"><label for="declare_date"></label></td>
                                                    <td width="80%" style="vertical-align: middle;"><label for="declare_date1">Date Confirmed Positive : </label></td>
                                                    <td colspan="2" style="text-align: center">
                                                        <input class="form-control" type="datetime-local" name="declare_date1" id="declare_date1" value="{{ old('declare_date1') }}">
                                                    </td>
                                                </div>
                                            </tr>
                                            <tr class="q2" style="display: none">
                                                <div class="form-group">
                                                    <td style="text-align: center" width="4%"><label for="q2">2.</label></td>
                                                    <td><label for="q2">Have you had close contact with anyone who confirmed positive case of COVID-19 within 10 days? <b style="color: red">@error('q2')* required @enderror</b></label></td>
                                                    <td style="text-align: center"><input type="radio" name="q2" id="q2" value="Y" {{ old('q2') == "Y" ? 'checked' : '' }}></td>
                                                    <td style="text-align: center"><input type="radio" name="q2" id="q2" value="N" {{ old('q2') == "N" ? 'checked' : '' }}></td>
                                                </div>
                                            </tr>
                                            <tr class="declare_date2" style="display: none">
                                                <div class="form-group">
                                                    <td style="text-align: center" width="4%"><label for="declare_date"></label></td>
                                                    <td width="80%" style="vertical-align: middle;"><label for="declare_date2">Date Confirmed Contact : </label></td>
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
                                                        Are you from an area of Enhanced Movement Control Order (EMCO) in period of 10 days ? <b style="color: red">@error('q3')* required @enderror</b></label></td>
                                                    <td style="text-align: center; vertical-align: middle"><input type="radio" name="q3" id="q3" value="Y" {{ old('q3') == "Y" ? 'checked' : '' }}></td>
                                                    <td style="text-align: center; vertical-align: middle"><input type="radio" name="q3" id="q3" value="N" {{ old('q3') == "N" ? 'checked' : '' }}></td>
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
                                                    <td width="3%"><label for="q4a"><li>Fever <b style="color: red">@error('q4a')* required @enderror</b></li></label></td>
                                                    <td style="text-align: center"><input type="radio" name="q4a" id="q4a" value="Y" {{ old('q4a') == "Y" ? 'checked' : '' }}></td>
                                                    <td style="text-align: center"><input type="radio" name="q4a" id="q4a" value="N" {{ old('q4a') == "N" ? 'checked' : '' }}></td>
                                                </div>
                                            </tr>
                                            <tr class="q4" style="display: none">
                                                <div class="form-group">
                                                    <td width="3%"><label for="q4b"><li>Cough <b style="color: red">@error('q4b')* required @enderror</b></li></label></td>
                                                    <td style="text-align: center"><input type="radio" name="q4b" id="q4b" value="Y" {{ old('q4b') == "Y" ? 'checked' : '' }}></td>
                                                    <td style="text-align: center"><input type="radio" name="q4b" id="q4b" value="N" {{ old('q4b') == "N" ? 'checked' : '' }}></td>
                                                </div>
                                            </tr>
                                            <tr class="q4" style="display: none">
                                                <div class="form-group">
                                                    <td width="3%"><label for="q4c"><li>Flu <b style="color: red">@error('q4c')* required @enderror</b></li></label></td>
                                                    <td style="text-align: center"><input type="radio" name="q4c" id="q4c" value="Y" {{ old('q4c') == "Y" ? 'checked' : '' }}></td>
                                                    <td style="text-align: center"><input type="radio" name="q4c" id="q4c" value="N" {{ old('q4c') == "N" ? 'checked' : '' }}></td>
                                                </div>
                                            </tr>
                                            <tr class="q4" style="display: none">
                                                <div class="form-group">
                                                    <td width="3%"><label for="q4d"><li>Difficulty in Breathing <b style="color: red">@error('q4d')* required @enderror</b></li></label></td>
                                                    <td style="text-align: center"><input type="radio" name="q4d" id="q4d" value="Y" {{ old('q4d') == "Y" ? 'checked' : '' }}></td>
                                                    <td style="text-align: center"><input type="radio" name="q4d" id="q4d" value="N" {{ old('q4d') == "N" ? 'checked' : '' }}></td>
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
        $('.user_name').select2();

        if($('.user_name').val()!=''){
            updateCr($('.user_name'));
        }
        $(document).on('change','.user_name',function(){
            updateCr($(this));
        });

        function updateCr(elem){
            var user_id=elem.val();   

            $.ajax({
                type:'get',
                url:'{!!URL::to('findUser')!!}',
                data:{'id':user_id},
                success:function(data)
                {
                    $('#user_id').val(data.id);
                    $('#user_email').val(data.email);
                }
            });
        }
    });

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

    })

</script>
@endsection

