@extends('layouts.admin')

@section('content')
<style>
    .select2-selection--single {
        height: 100% !important;
    }
    .select2-selection__rendered{
        word-wrap: break-word ;
        text-overflow: inherit;
        white-space: normal !important;
    }

    /* Customize the label (the container) */
    .container {
    position: relative;
    padding-left: 50px;
    margin-bottom: 12px;
    cursor: pointer;
    font-size: 15px;
    }

    /* Hide the browser's default checkbox */
    .container input[type="checkbox"] {
    display: none
    }

    /* Create a custom checkbox - using ::before */
    .checkmark::before {
    content: "";
    height: 25px;
    width: 25px;
    background-color: #fff;
    border: solid 2px;
    position: absolute;
    left:0;
    top:0;
    /* margin-right: 10px; */
    margin-top: 5px;
    }

    /* Show the checkmark when checked */
    .container input:checked~.checkmark:after {
    display: block;
    left: 9px;
    top: 8px;
    width: 8px;
    height: 14px;
    border: solid #194263;
    border-width: 0 3px 3px 0;
    transform: rotate(45deg);
    content: "";
    position: absolute;
    margin-right: 10px;
    }
    /* strike through the text */
    .container input:checked ~ input {
      text-decoration: line-through
    }
</style>
<main id="js-page-content" role="main" class="page-content">
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-users'></i> ENGAGEMENT MANAGEMENT
        </h1>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>Create New Profile</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>

                    <div class="panel-container show">
                        <div class="panel-content">
                                <div class="row">
                                    <div class="col-sm-12">
                                        {!! Form::open(['action' => ['EngagementManagementController@store'], 'method' => 'POST', 'enctype' => 'multipart/form-data'])!!}
                                        <div class="card card-primary card-outline">
                                            <div class="card-header bg-primary text-white">
                                                <h5 class="card-title w-100 text-center">PROFILE</h5>
                                            </div>
                                            <div class="card-body">
                                                @if (Session::has('message'))
                                                    <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('message') }}</div>
                                                @endif
                                                <div class="table-responsive">
                                                <table class="table table-bordered table-hover table-striped w-100">
                                                    <thead>
                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="25%"><label class="form-label" for="title"><span class="text-danger">*</span> Title:</label></td>
                                                                <td colspan="4">
                                                                    <input type="text" id="title" name="title" class="form-control max" required>
                                                                    <span style="font-size: 10px; color: red;"><i>*Limit to 150 characters only</i></span>
                                                                        @error('title')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror
                                                                </td>
                                                            </div>
                                                        </tr>
                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="25%"><label class="form-label" for="engage_part_1"><span class="text-danger">*</span> Engage Party 1:</label></td>
                                                                <td colspan="4">
                                                                    <input type="text" id="engage_part_1" name="engage_part_1" class="form-control max" required>
                                                                    <span style="font-size: 10px; color: red;"><i>*Limit to 150 characters only</i></span>
                                                                        @error('engage_part_1')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror
                                                                </td>
                                                            </div>
                                                        </tr>
                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="25%"><label class="form-label" for="engage_part_2"> Engage Party 2:</label></td>
                                                                <td colspan="4">
                                                                    <input type="text" id="engage_part_2" name="engage_part_2" class="form-control max">
                                                                    <span style="font-size: 10px; color: red;"><i>*Limit to 150 characters only</i></span>
                                                                        @error('engage_part_2')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror
                                                                </td>
                                                            </div>
                                                        </tr>
                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="25%"><label class="form-label" for="member"><span class="text-danger">*</span> Team Member:</label></td>
                                                                <td colspan="4">
                                                                <select class="form-control member" name="member_id[]" multiple required>
                                                                    @foreach ($user as $u)
                                                                        <option value="{{ $u->id }}">{{ $u->name }}</option>
                                                                    @endforeach
                                                                </select>                                                                    
                                                                    @error('member')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                                </td>
                                                            </div>
                                                        </tr>
                                                    </thead>
                                                </table>
                                                </div>
                                                    <button type="submit" class="btn btn-primary ml-auto float-right"><i class="fal fa-save"></i> Save</button>
                                            </div>
                                        </div>    
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                                <br>
                        </div>
                    </div>                       
            </div>
        </div>
    </div>
</main>
@endsection

@section('script')

<script>
       $(document).ready(function() {
            $('.member').select2();
        });

        $(function () {
    $('input:checkbox').on('change', function () {
        var input = $(this).next('span');
        if (this.checked) {
            $(input).css('textDecoration', 'line-through');
        } else {
            $(input).css('textDecoration', 'none');
        }
    })
})

var timeoutId;
$('form input, form textarea').on('input propertychange change', function() {
    console.log('Textarea Change');
    
    clearTimeout(timeoutId);
    timeoutId = setTimeout(function() {
        // Runs 1 second (1000 ms) after the last change    
        saveToDB();
    }, 1000);
});

function saveToDB()
{
    console.log('Saving to the db');
    form = $('.savetodolist');
	$.ajax({
		url: "/todolist-create",
		type: "POST",
		data: form.serialize(), // serializes the form's elements.
		beforeSend: function(xhr) {
            // Let them know we are saving
			$('.form-status-holder').html('Saving...');
		},
		success: function(data) {
			var jqObj = jQuery(data); // You can get data returned from your ajax call here. ex. jqObj.find('.returned-data').html()
            // Now show them we saved and when we did
            var d = new Date();
            $('.form-status-holder').html('Saved! Last: ' + d.toLocaleTimeString());
		},
	});
}

// This is just so we don't go anywhere  
// and still save if you submit the form
$('.savetodolist').submit(function(e) {
	saveToDB();
	e.preventDefault();
});
</script>

@endsection
