@extends('layouts.public')

@section('content')
<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="background-image: url({{asset('img/coronavirus.png')}}); background-size: cover">
                    <div class="d-flex justify-content-center" style="color: black">
                        <div class="p-2">
                            <center><img src="{{ asset('img/intec_logo_new.png') }}" style="height: 120px; width: 320px;" class="responsive"/></center><br>
                            <h4 style="text-align: center">
                                <b>COVID19 RISK SCREENING DAILY DECLARATION FORM</b>
                            </h4>
                            <br>
                            <p style="padding-left: 40px; padding-right: 40px; font-size: 12px">
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
                                                <td width="20%"><label class="form-label" for="user_position"><span class="text-danger">*</span> Type</label></td>
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
                                                    <td width="20%"><label class="form-label" for="user_category"><span class="text-danger">*</span> Category </label></td>
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
                                                <tr class="stdVsr">
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
                                                <tr class="stdVsr">
                                                    <td width="20%"><label class="form-label" for="temperature"> Temperature (°C) </label></td>
                                                    <td colspan="6">
                                                        <input class="form-control temperature" type="number" step="any" id="temperature" name="temperature">
                                                        @error('temperature')
                                                            <p style="color: red"><strong> {{ $message }} </strong></p>
                                                        @enderror
                                                    </td>
                                                </tr>
                                                <tr class="select-depart">
                                                    <td width="20%"><label class="form-label" for="department_stf"><span class="text-danger">*</span> Department To Go </label></td>
                                                    <td colspan="6">
                                                        <select class="form-control department_stf" name="department_stf" id="department_stf">
                                                            <option value="">Select Department</option>
                                                            @foreach ($department as $depart) 
                                                                <option value="{{ $depart->id }}" @if (old('department_stf') == $depart->id) selected="selected" @endif>{{ $depart->department_name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('department_stf')
                                                            <p style="color: red"><strong> {{ $message }} </strong></p>
                                                        @enderror
                                                    </td>
                                                </tr>
                                                <tr class="select-depart">
                                                    <td width="20%"><label class="form-label" for="temperature_stf"> Temperature (°C) </label></td>
                                                    <td colspan="6">
                                                        <input class="form-control temperature_stf" type="number" step="any" id="temperature_stf" name="temperature_stf">
                                                        @error('temperature_stf')
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
                                                    {{-- <input class="form-control" name="declare_result2" id="declare_result2" value="{{ old('declare_result2') }}"> --}}
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
                                                    {{-- <input class="form-control" name="q4_result" id="q4_result" value="{{ old('q4_result') }}"> --}}
                                                    <select class="form-control q4res" id="q4_result" name="q4_result">
                                                        <option value="">Please Select</option>
                                                        <option value="P" {{ old('q4_result') == 'P' ? 'selected':''}} >Positive (+)</option>
                                                        <option value="N" {{ old('q4_result') == 'N' ? 'selected':''}} >Negative (-)</option>
                                                    </select>
                                                </td>
                                            </div>
                                        </tr>
                                        {{-- <tr class="q4" style="display: none">
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
                                        </tr> --}}
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
            $('.department_id, .user_position, .user_category, .department_stf, .deres2, .q4res').select2();

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

            $( "#user_category" ).change(function() {
                var val = $("#user_category").val();
                if(val=="WFO"){
                    document.getElementById("department_stf").required = true;
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
                    $("#department_stf").val(""); 
                    $("#temperature").val("");
                    $("#temperature_stf").val("");
            });

            $('.user_position').val('{{ old('user_position') }}'); 
            $(".user_position").change(); 
            $('.user_id').val('{{ old('user_id') }}');
            $(".user_id").change(); 
            $('.user_category').val('{{ old('user_category') }}'); 
            $(".user_category").change(); 
            $('.user_phone').val('{{ old('user_phone') }}');
            $('.department_id').val('{{ old('department_id') }}');
            $('.temperature').val('{{ old('temperature') }}');
            $('.department_stf').val('{{ old('department_stf') }}');
            $('.temperature_stf').val('{{ old('temperature_stf') }}');
            $('#vsr_name').val('{{ old('vsr_name') }}');
            $('#vsr_email').val('{{ old('vsr_email') }}');

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
