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
                            <b>INTEC EDUCATION COLLEGE TRAINING HOURS CLAIM FORM</b>
                        </h4>
                        <div>
                            <p style="padding-left: 40px; padding-right: 40px">
                                *<i><b>IMPORTANT!</b></i> : All staff are required to fill in the fields below for training hour claim request and make sure all detail are correct provided with attachment. 
                                Your claim request will be shown on Claim Record after being approved by Human Resource.
                            </p>
                        </div>

                        <div class="panel-container show">
                            <div class="panel-content">
                                {!! Form::open(['action' => 'TrainingController@claimStore', 'method' => 'POST', 'id' => 'data', 'enctype' => 'multipart/form-data']) !!}
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
                                                <thead>
                                                    <tr>
                                                        <div class="form-group">
                                                            <td width="20%" style="vertical-align: middle"><label class="form-label"> Full Name :</label></td>
                                                            <td colspan="3">
                                                                {{ $staff->staff_name ?? '--'}}
                                                            </td>
                                                            <td width="20%" style="vertical-align: middle"><label class="form-label"> Staff ID :</label></td>
                                                            <td colspan="3">
                                                                {{ $staff->staff_id ?? '--'}}
                                                            </td>
                                                        </div>
                                                    </tr>
                                                    <tr>
                                                        <div class="form-group">
                                                            <td width="20%" style="vertical-align: middle"><label class="form-label"> Position :</label></td>
                                                            <td colspan="3">
                                                                {{ $staff->staff_position ?? '--'}}
                                                            </td>
                                                            <td width="20%" style="vertical-align: middle"><label class="form-label"> Department :</label></td>
                                                            <td colspan="3">
                                                                {{ $staff->staff_dept ?? '--'}}
                                                            </td>
                                                        </div>
                                                    </tr>
                                                    <tr>
                                                        <div class="form-group">
                                                            <td width="20%" style="vertical-align: middle"><label class="form-label"><span class="text-danger">*</span> Training Title :</label></td>
                                                            <td colspan="6">
                                                                <select name="training_id" id="training_id" class="training_id form-control" required>
                                                                    <option value="" selected disabled>Select Training</option>
                                                                    @foreach ($training_list as $lists) 
                                                                        <option value="{{ $lists->id }}" {{ old('training_id') ? 'selected' : '' }}>{{ strtoupper($lists->title) }}  [ {{ date(' d/m/Y ', strtotime($lists->start_date) ) ?? '--'}} -  {{ date(' d/m/Y ', strtotime($lists->end_date) ) ?? '--'}}]</option>
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
                                                    <tr>
                                                        <div class="form-group">
                                                            <td width="20%" style="vertical-align: middle"><label class="form-label"> Link :</label></td>
                                                            <td colspan="3">
                                                                <input class="form-control" id="link" name="link" value="{{ old('link') }}">
                                                                @error('link')
                                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                @enderror
                                                            </td>
                                                            <td width="20%" style="vertical-align: middle"><label class="form-label"><span class="text-danger">*</span> Attachment : <i class="fal fa-info-circle fs-xs mr-1" data-toggle="tooltip" data-placement="right" title="" data-original-title="Attachment is accepted in the form of .pdf, .doc, .docx (max 1(one) file) or .png, .jpg, .jpeg (max 5(five) image)"></i></label></td>
                                                            <td colspan="3">
                                                                <input type="file" class="form-control" id="file_name" name="file_name[]" required multiple>
                                                                @error('file_name')
                                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                @enderror
                                                            </td>
                                                        </div>
                                                    </tr>
                                                </thead>
                                            </table>
                                            
                                        </div>
                                    </div>
                                    <div class="footer">
                                        <button type="submit" id="btnSubmit" class="btn btn-primary ml-auto float-right"><i class="fal fa-location-arrow"></i> Submit Claim</button>	
                                        <button style="margin-right:5px" type="reset" class="btn btn-danger ml-auto float-right"><i class="fal fa-redo"></i> Reset</button><br><br>
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
        $('#type, #category, #training_id').select2();

        $( "#training_id" ).change(function() {
            var val = $("#training_id").val();
            if(val=="0"){
                $('#start_date, #end_date, #start_time, #end_time, #type, #category, #venue, #claim_hour, #link').prop('disabled', false);
            } else {
                $('#start_date, #end_date, #start_time, #end_time, #type, #category, #venue, #claim_hour, #link').prop('disabled', true);

                $('#data').on('submit', function() {
                    $('#start_date, #end_date, #start_time, #end_time, #type, #category, #venue, #claim_hour, #link').prop('disabled', false);
                });
            }
        });

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
                    $('#link').val(data.link);
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

    })

    $(document).ready(function () {
        $("#data").submit(function () {
            $("#btnSubmit").attr("disabled", true);
            return true;
        });
    });

</script>
@endsection

