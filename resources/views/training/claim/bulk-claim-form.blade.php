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
                            <b>INTEC EDUCATION COLLEGE TRAINING HOURS CLAIM FORM</b>
                        </h4>
                        <div>
                            <p style="padding-left: 40px; padding-right: 40px">
                                *<i><b>IMPORTANT!</b></i> : This form is used by admin to submit training hour on behalf of staff. Admin have to make sure all detail of training and participant provided are correct. 
                                This claim will be shown on Claim Record of each staff after submitted.
                            </p>
                        </div>

                        <div class="panel-container show">
                            <div class="panel-content">
                                {!! Form::open(['action' => 'TrainingController@bulkClaimStore', 'method' => 'POST', 'id' => 'data', 'enctype' => 'multipart/form-data']) !!}
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    @if(Session::has('message'))
                                        <script type="text/javascript">

                                        function massage() {
                                        Swal.fire(
                                                    'Successful!',
                                                    'Your Claim Form Has Been Submitted and Recorded!',
                                                    'success'
                                                );
                                        }

                                        window.onload = massage;
                                        </script>
                                    @endif
                                    @if(Session::has('notification'))
                                        <script type="text/javascript">

                                        function massage() {
                                        Swal.fire(
                                                    'Not Successful!',
                                                    'Your Claim For This Training Already Exist. Please Check Claim List!',
                                                    'warning'
                                                );
                                        }

                                        window.onload = massage;
                                        </script>
                                    @endif
                                    <div>
                                        <div class="table-responsive">
                                            <p style="font-style: italic"><span class="text-danger">*</span> Required Fields</p>
                                            <table class="table table-bordered table-hover table-striped w-100">
                                                <ol class="breadcrumb breadcrumb-md breadcrumb-arrow">
                                                    <li>
                                                        <a href="#" disabled style="pointer-events: none" class="bg-primary">
                                                            <i class="fal fa-info-circle"></i>
                                                            <span class="hidden-md-down">Training Info</span>
                                                        </a>
                                                    </li>
                                                    <p></p>
                                                </ol>
                                                <thead>
                                                    <tr>
                                                        <div class="form-group">
                                                            <td width="20%" style="vertical-align: middle"><label class="form-label"><span class="text-danger">*</span> Training Title :</label></td>
                                                            <td colspan="6">
                                                                <select name="training_id" id="training_id" class="training_id form-control" required>
                                                                    <option value="" selected disabled>Select Training</option>
                                                                    @foreach ($training_list as $lists) 
                                                                        <option value="{{ $lists->id }}" {{ old('training_id') ? 'selected' : '' }}>{{ strtoupper($lists->title) }}</option>
                                                                    @endforeach
                                                                    <option value="0" {{ old('training_id') == '0' ? 'selected':''}} >OTHERS</option>
                                                                </select>
                                                                @error('training_id')
                                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                @enderror
                                                                <input class="form-control mt-4 othr_title" id="title" name="title" value="{{ old('title') }}" placeholder="Training Title Here ...">
                                                                @error('title')
                                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                @enderror
                                                            </td>
                                                        </div>
                                                    </tr>
                                                    <tr>
                                                        <div class="form-group">
                                                            <td width="20%" style="vertical-align: middle"><label class="form-label"><span class="text-danger">*</span> Type of Training :</label></td>
                                                            <td colspan="3">
                                                                <select name="type" id="type" class="type form-control" required>
                                                                    <option value="" selected disabled>Select Type</option>
                                                                    @foreach ($training_type as $training_types) 
                                                                        <option value="{{ $training_types->id }}" {{ old('type') ? 'selected' : '' }}>{{ strtoupper($training_types->type_name) }}</option>
                                                                    @endforeach
                                                                </select>
                                                                @error('type')
                                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                @enderror
                                                            </td>
                                                            <td width="20%" style="vertical-align: middle"><label class="form-label"><span class="text-danger">*</span> Category of Training :</label></td>
                                                            <td colspan="3">
                                                                <select name="category" id="category" class="category form-control" required>
                                                                    <option value="" selected disabled>Select Category</option>
                                                                    @foreach ($training_cat as $training_cats) 
                                                                        <option value="{{ $training_cats->id }}" {{ old('category') ? 'selected' : '' }}>{{ strtoupper($training_cats->category_name) }}</option>
                                                                    @endforeach
                                                                </select>
                                                                @error('category')
                                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                @enderror
                                                            </td>
                                                        </div>
                                                    </tr>
                                                    <tr>
                                                        <div class="form-group">
                                                            <td width="20%" style="vertical-align: middle"><label class="form-label"><span class="text-danger">*</span> Start Date :</label></td>
                                                            <td colspan="3">
                                                                <input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date') }}" required>
                                                                    @error('start_date')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                            </td>
                                                            <td width="20%" style="vertical-align: middle"><label class="form-label"><span class="text-danger">*</span> End Date :</label></td>
                                                            <td colspan="3">
                                                                <input type="date" class="form-control" id="end_date" name="end_date" value="{{ old('end_date') }}" required>
                                                                @error('end_date')
                                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                @enderror
                                                            </td>
                                                        </div>
                                                    </tr>
                                                    <tr>
                                                        <div class="form-group">
                                                            <td width="20%" style="vertical-align: middle"><label class="form-label"><span class="text-danger">*</span> Start Time :</label></td>
                                                            <td colspan="3">
                                                                <input type="time" class="form-control" id="start_time" name="start_time" value="{{ old('start_time') }}" required>
                                                                    @error('start_date')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                            </td>
                                                            <td width="20%" style="vertical-align: middle"><label class="form-label"><span class="text-danger">*</span> End Time :</label></td>
                                                            <td colspan="3">
                                                                <input type="time" class="form-control" id="end_time" name="end_time" value="{{ old('end_time') }}" required>
                                                                    @error('end_time')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                            </td>
                                                        </div>
                                                    </tr>
                                                    <tr>
                                                        <div class="form-group">
                                                            <td width="20%" style="vertical-align: middle"><label class="form-label"><span class="text-danger">*</span> Claim Hours :</label></td>
                                                            <td colspan="3">
                                                                <input type="number" step="any" class="form-control" id="claim_hour" name="claim_hour" value="{{ old('claim_hour') }}" required>
                                                                @error('claim_hour')
                                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                @enderror
                                                            </td>
                                                            <td width="20%" style="vertical-align: middle"><label class="form-label"><span class="text-danger">*</span> Venue :</label></td>
                                                            <td colspan="3">
                                                                <input class="form-control" id="venue" name="venue" value="{{ old('venue') }}" required>
                                                                @error('venue')
                                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                @enderror
                                                            </td>
                                                        </div>
                                                    </tr>
                                                </thead>
                                            </table>
                                            <br>
                                            <table class="table table-bordered table-hover table-striped w-100">
                                                <ol class="breadcrumb breadcrumb-md breadcrumb-arrow mb-4">
                                                    <li>
                                                        <a href="#" disabled style="pointer-events: none" class="bg-primary">
                                                            <i class="fal fa-list"></i>
                                                            <span class="hidden-md-down">Participant List</span>
                                                        </a>
                                                    </li>
                                                    <li style="margin-top: 10px; margin-left: 10px">
                                                        <input type="radio" name="rad_view" id="rad_view" value="0" {{ old('rad_view') == "0" ? 'checked' : '' }}> Form
                                                        <input class="ml-5" type="radio" name="rad_view" id="rad_view" value="1" {{ old('rad_view') == "1" ? 'checked' : '' }}> Upload
                                                    </li>
                                                </ol>
                                                    {{-- start form view --}}
                                                        <table class="table table-bordered text-center form_view" id="head_field">
                                                            <tr>
                                                                <td><label class="form-label" for="staff_id"><span class="text-danger">*</span> Staff Detail</label></td>
                                                                <td>Action</td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <select name="staff_id[]" id="staff_id" class="staff_id form-control">
                                                                        <option value="">Please select</option>
                                                                        @foreach ($staff as $staffID) 
                                                                            <option value="{{ $staffID->staff_id }}" {{ old('staff_id') ? 'selected' : '' }}>{{ $staffID->staff_id }} - {{ $staffID->staff_name }} [ {{ $staffID->staff_dept }} ]</option>
                                                                        @endforeach
                                                                    </select>
                                                                    @error('staff_id')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                                </td>
                                                                <td style="vertical-align: middle"><button type="button" name="addhead" id="addhead" class="btn btn-success btn-sm"><i class="fal fa-plus"></i></button></td>
                                                            </tr>
                                                        </table>
                                                    {{-- end form view --}}
                                                    {{-- start upload view --}}
                                                        <table class="table table-bordered upload_view">
                                                            <tr> 
                                                                <td width="20%"><label class="form-label" for="import_file"><span class="text-danger">*</span> File :</label></td>
                                                                <td colspan="5"><input type="file" name="import_file" class="form-control mb-3"></td>
                                                            </tr>
                                                        </table>
                                                    {{-- end upload view --}}
                                            </table>
                                        </div>
                                    </div>
                                    <div class="footer">
                                        <button type="submit" id="submithead" class="btn btn-primary ml-auto float-right"><i class="fal fa-location-arrow"></i> Submit Claim</button>
                                        <a href="/bulkClaimTemplate" class="btn btn-info float-right mr-2 upload_view"><i class="fal fa-download"></i> Download Template</a><br><br>
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
        $('#type, #category, #training_id, #staff_id').select2();

        $( "#training_id" ).change(function() {
            var val = $("#training_id").val();
            if(val=="0"){
                $('#start_date, #end_date, #start_time, #end_time, #type, #category, #venue, #claim_hour').prop('disabled', false);
            } else {
                $('#start_date, #end_date, #start_time, #end_time, #type, #category, #venue, #claim_hour').prop('disabled', true);

                $('#data').on('submit', function() {
                    $('#start_date, #end_date, #start_time, #end_time, #type, #category, #venue, #claim_hour').prop('disabled', false);
                });
            }
        });

        $(".form_view").hide();
        $(".upload_view").hide();

        $("input[name=rad_view]").change(function () {        
            if ($(this).val() == "0") {
                $(".form_view").show();
                $(".upload_view").hide();
            }
            else if ($(this).val() == "1") {
                $(".upload_view").show();
                $(".form_view").hide();
            }
            else {
                $(".form_view").hide();
                $(".upload_view").hide();
            }
        });
    
        $('input[name="rad_view"]:checked').val('{{ old('rad_view') }}');
        $('input[name="rad_view"]:checked').change(); 

        if($('.training_id').val()!=''){
            updateCr($('.training_id'));
        }

        $(document).on('change','.training_id',function(){
            updateCr($(this));
        });

        function updateCr(elem){
            var training_id=elem.val();   
            $.ajax({
                type:'get',
                url:'{!!URL::to('findTraining')!!}',
                data:{'id':training_id},
                success:function(data)
                {
                    // $('#training_id').val(data.id);
                    $('#type').val(data.type).change();
                    $('#category').val(data.category).change();
                    $('#start_date').val(data.start_date);
                    $('#end_date').val(data.end_date);
                    $('#start_time').val(data.start_time);
                    $('#end_time').val(data.end_time);
                    $('#venue').val(data.venue);
                    $('#claim_hour').val(data.claim_hour);
                }
            });
        }

        $(".othr_title").hide();

        $( "#training_id" ).change(function() {
            var val = $("#training_id").val();
            if(val=="0"){
                $(".othr_title").show();
            } else {
                $(".othr_title").hide();
            }
        });

        $('#training_id').val('{{ old('training_id') }}'); 
        $("#training_id").change(); 
        $('#title').val('{{ old('title') }}');

        // Add Custodian
        $('#addhead').click(function(){
            i++;
            $('#head_field').append(`
            <tr id="row${i}" class="head-added">
            <td>
                <select name="staff_id[]" class="staffs_id form-control">
                    <option value="">Please select</option>
                    @foreach ($staff as $staffID) 
                        <option value="{{ $staffID->id }}" {{ old('staff_id') ? 'selected' : '' }}>{{ $staffID->staff_id }} - {{ $staffID->staff_name }} [ {{ $staffID->staff_dept }} ]</option>
                    @endforeach
                </select>
            </td>
            <td><button type="button" name="remove" id="${i}" class="btn btn-sm btn-danger btn_remove"><i class="fal fa-trash"></i></button></td>
            </tr>
            `); 
            $('.staffs_id').select2();
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

    })

</script>
@endsection

