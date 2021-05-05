@extends('layouts.covid')

@section('content')
<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="background-image: url({{asset('img/coronavirus.png')}}); background-size: cover">
                    <div class="d-flex justify-content-center" style="color: black">
                        <div class="p-2">
                            <center><img src="{{ asset('img/intec_logo.png') }}" style="max-width: 100%" class="responsive"/></center><br>
                            <h4 style="text-align: center">
                                <b>INTEC EDUCATION COLLEGE COVID19 RISK SCREENING DAILY DECLARATION FORM</b>
                            </h4>
                            <p style="padding-left: 40px; padding-right: 40px">
                                *<i><b>IMPORTANT!</b></i> : All staff, student and visitor are required to make a daily declaration of COVID-19 risk screening on every working day (whether working in the office or from home) as prevention measures. 
                                However, you are encouraged to make a declaration on a daily basis including public holidays and other holidays.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="panel-container show">
                        <div class="panel-content">
                            {!! Form::open(['action' => 'CovidController@storeOpenForm', 'method' => 'POST']) !!}
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" class="form-control name" id="name" name="name">
                            <input type="hidden" class="form-control email" id="email" name="email">
                                @if (Session::has('message'))
                                    <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('message') }}</div>
                                @endif
                                @if (Session::has('notification'))
                                    <div class="alert alert-success" style="color: #5b0303; background-color: #ff6c6cc9;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('notification') }}</div>
                                @endif
                                <div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-striped w-100">
                                            <thead>
                                                <p><span class="text-danger">*</span> Required fields</p>
                                                <td width="20%"><label class="form-label" for="user_position"><span class="text-danger">*</span> Category</label></td>
                                                <td colspan="6">
                                                    <select class="form-control user_position" name="user_position" id="user_position">
                                                        <option value="">Please select</option>
                                                        @foreach ($type as $user) 
                                                            <option value="{{ $user->user_code }}" @if (old('user_position') == $user->user_code) selected="selected" @endif>{{ $user->user_type }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('user_position')
                                                        <p style="color: red"><strong> * Selection required </strong></p>
                                                    @enderror
                                                </td>
                                            </thead>
                                        </table>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-striped w-100">
                                            <thead>
                                                <tr class="all">
                                                    <td width="20%">
                                                        <label class="form-label intecStf" for="user_id"><span class="text-danger">*</span> Staff ID </label>
                                                        <label class="form-label intecStd" for="user_id"><span class="text-danger">*</span> Student ID </label>
                                                        <label class="form-label intecVsr" for="user_id"><span class="text-danger">*</span> IC/Passport No. </label>
                                                    </td>
                                                    <td colspan="6"><input class="form-control user_id" id="user_id" name="user_id" >
                                                        @error('user_id')
                                                            <p style="color: red"><strong> {{ $message }} </strong></p>
                                                        @enderror
                                                    </td>
                                                </tr>
                                                <tr class="all">
                                                    <td width="20%"><label class="form-label" for="user_name"><span class="text-danger">*</span> Full Name </label></td>
                                                    <td colspan="6">
                                                        <input class="form-control intec" id="user_name" name="user_name" readonly>
                                                        <input class="form-control visitor" id="vsr_name" name="vsr_name" >
                                                        @error('user_name')
                                                            <p style="color: red"><strong> {{ $message }} </strong></p>
                                                        @enderror
                                                        @error('vsr_name')
                                                            <p style="color: red"><strong> {{ $message }} </strong></p>
                                                        @enderror
                                                    </td>
                                                </tr>
                                                <tr class="all">
                                                    <td width="20%"><label class="form-label" for="user_email"> Email </label></td>
                                                    <td colspan="6">
                                                        <input class="form-control intec" id="user_email" name="user_email" readonly>
                                                        <input class="form-control visitor" id="vsr_email" name="vsr_email" >
                                                        @error('user_email')
                                                            <p style="color: red"><strong> {{ $message }} </strong></p>
                                                        @enderror
                                                        @error('vsr_email')
                                                            <p style="color: red"><strong> {{ $message }} </strong></p>
                                                        @enderror
                                                    </td>
                                                </tr>
                                                <tr class="all">
                                                    <td width="20%"><label class="form-label" for="user_phone"><span class="text-danger">*</span>  Phone No. </label></td>
                                                    <td colspan="6">
                                                        <input class="form-control user_phone" id="user_phone" name="user_phone" >
                                                        @error('user_phone')
                                                            <p style="color: red"><strong> {{ $message }} </strong></p>
                                                        @enderror
                                                    </td>
                                                </tr>
                                                <tr class="intecStf">
                                                    <td width="20%"><label class="form-label" for="user_category"><span class="text-danger">*</span> User Category </label></td>
                                                    <td colspan="6">
                                                        <select class="form-control user_category" name="user_category" id="user_category">
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
                                                <tr class="stdVsr select-depart">
                                                    <td width="20%"><label class="form-label" for="department_id"><span class="text-danger">*</span> Department To Go </label></td>
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
                                            </thead>
                                        </table>
                                    </div>
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
                                                    Are you from an area of Enhanced Movement Control Order (EMCO) in period of 10 days ? @error('q3')<b style="color: red"><strong> required </strong></b>@enderror</label></td>
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
</main>
@endsection
@section('script')
    <script>
    $(document).ready( function() {
        $('.department_id, .user_position, .user_category').select2();

        if($('.user_id').val()!=''){
            updateCr($('.user_id'));
        }
        $(document).on('change','.user_id',function(){
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
                    $('#user_id').html(data.id);
                    $('#user_name').val(data.name);
                    $('#name').val(data.name);
                    $('#user_email').val(data.email);
                    $('#email').val(data.email);
                }
            });
        }

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
      

      $(".intec").hide();

      $( "#user_position" ).change(function() {
        var val = $("#user_position").val();
        if(val=="STF" || val=="STD"){
            $(".intec").show();
        } else {
            $(".intec").hide();
        }
      });

      $(".visitor").hide();

      $( "#user_position" ).change(function() {
        var val = $("#user_position").val();
        if(val=="VSR"){
            $(".visitor").show();
        } else {
            $(".visitor").hide();
        }
      });

      $(".intecStf").hide();

      $( "#user_position" ).change(function() {
        var val = $("#user_position").val();
        if(val=="STF"){
            $(".intecStf").show();
        } else {
            $(".intecStf").hide();
        }
      });

      $(".intecStd").hide();

      $( "#user_position" ).change(function() {
        var val = $("#user_position").val();
        if(val=="STD"){
            $(".intecStd").show();
        } else {
            $(".intecStd").hide();
        }
      });

      $(".intecVsr").hide();

      $( "#user_position" ).change(function() {
        var val = $("#user_position").val();
        if(val=="VSR"){
            $(".intecVsr").show();
        } else {
            $(".intecVsr").hide();
        }
      });

      $(".stdVsr").hide();

      $( "#user_position" ).change(function() {
        var val = $("#user_position").val();
        if(val=="STD" || val=="VSR"){
            $(".stdVsr").show();
        } else {
            $(".stdVsr").hide();
        }
      });


      $(".all").hide();

      $( "#user_position" ).change(function() {
        var val = $("#user_position").val();
        if(val=="STD" || val=="STF" || val=="VSR"){
            $(".all").show();
        } else {
            $(".all").hide();
        }
      });

      $("#user_position").change(function() {
            $("#user_name").val("");
            $("#user_email").val("");
            $("#vsr_name").val("");
            $("#vsr_email").val("");
            $("#user_id").val("");
            $("#user_phone").val("");
            $("#department_id").val("");
      });

        $('.user_position').val('{{ old('user_position') }}'); 
        $(".user_position").change(); 
        $('.user_id').val('{{ old('user_id') }}');
        $(".user_id").change(); 
        $('.user_category').val('{{ old('user_category') }}'); 
        $(".user_category").change(); 
        $('.user_phone').val('{{ old('user_phone') }}');
        $('.department_id').val('{{ old('department_id') }}');
        $('#vsr_name').val('{{ old('vsr_name') }}');
        $('#vsr_email').val('{{ old('vsr_email') }}');

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

    </script>
@endsection
