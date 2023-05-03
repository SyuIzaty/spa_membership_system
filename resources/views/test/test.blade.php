@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content"
        style="background-image: url({{ asset('img/bg-form.jpg') }}); background-size: cover">

        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr" style="background-color:rgb(97 63 115)">
                        <h2>
                        </h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip"
                                data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip"
                                data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10"
                                data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                            <center><img src="{{ asset('img/intec_logo_new.png') }}" style="height: 100px; width: 300px;">
                            </center><br>
                            <h4 style="text-align: center">
                                <b>ICT EQUIPMENT RENTAL FORM</b>
                            </h4>
                        </div>
                        <div class="panel-container show">
                            <div class="panel-content">
                                @if (session()->has('message'))
                                    <div class="alert alert-success">
                                        {{ session()->get('message') }}
                                    </div>
                                @endif
                                @error('hpno')
                                    <div class="alert alert-success" style="color: #000000; background-color: #ffdf89;"> <i
                                            class="icon fal fa-check-circle"></i> {{ $message }}</div>
                                @enderror
                                @error('room_no')
                                    <div class="alert alert-success" style="color: #000000; background-color: #ffdf89;"> <i
                                            class="icon fal fa-check-circle"></i> {{ $message }}</div>
                                @enderror
                                @error('retdate')
                                    <div class="alert alert-success" style="color: #000000; background-color: #ffdf89;"> <i
                                            class="icon fal fa-check-circle"></i> {{ $message }}</div>
                                @enderror
                                @error('rentdate')
                                    <div class="alert alert-success" style="color: #000000; background-color: #ffdf89;"> <i
                                            class="icon fal fa-check-circle"></i> {{ $message }}</div>
                                @enderror
                                @error('purpose')
                                    <div class="alert alert-success" style="color: #000000; background-color: #ffdf89;"> <i
                                            class="icon fal fa-check-circle"></i> {{ $message }}</div>
                                @enderror

                                {!! Form::open([
                                    'action' => 'TestController@store',
                                    'method' => 'POST',
                                    'id' => 'rental-form',
                                    'enctype' => 'multipart/form-data',
                                ]) !!}
                                {{-- <form id="formId" action="/store" method="POST">
                                    @csrf --}}
                                <div class="table-responsive">
                                    <b><span class="text-danger">*</span> Please enter the following details. <span
                                            class="text-danger">*</span> Denotes mandatory information</b>
                                    <table id="rent" class="table table-bordered table-hover table-striped w-100">
                                        <tr>
                                            <th>Name : </th>
                                            <td>
                                                <input class="form-control" type="text" name="name" size="30"
                                                    required="required" placeholder="Name" value="{{ $staff->staff_name }}"
                                                    disabled>
                                            </td>
                                            <th>Designation : </th>
                                            <td>
                                                <input class="form-control" type="text" name="des" size="30"
                                                    placeholder="Designation" value="{{ $staff->staff_position }}" disabled>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Staff ID No : </th>
                                            <td>
                                                <input class="form-control" type="text" name="id" size="30"
                                                    placeholder="Staff ID No" value="{{ $staff->staff_id }}" disabled>
                                            </td>
                                            <th><span class="text-danger">*</span> HP/ Extension No. : </th>
                                            <td>
                                                <input class="form-control" type="text" name="hpno" size="30"
                                                    placeholder="Number phone">
                                                {{-- @error('hpno')
                                                    <p style="color: red"><strong> {{ $message }} </strong></p>
                                                @enderror --}}

                                            </td>
                                        </tr> <br><br>
                                        <tr>
                                            <th>Department : </th>
                                            <td>
                                                <input class="form-control" type="text" name="department" size="30"
                                                    placeholder="department" value="{{ $staff->staff_dept }}" disabled>
                                            </td>
                                            <th><span class="text-danger">*</span> Room No : </th>
                                            <td>
                                                <input class="form-control" type="text" name="room_no" size="30"
                                                    placeholder="Room No">
                                                {{-- @error('room_no')
                                                    <p style="color: red"><strong> {{ $message }} </strong></p>
                                                @enderror --}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th><span class="text-danger">*</span> Rental Date Commences :</th>
                                            <td>
                                                <input class="form-control" type="date" name="rentdate" size="30"
                                                    min="{{ date('Y-m-d') }}">
                                                {{-- @error('rentdate')
                                                    <p style="color: red"><strong> {{ $message }} </strong></p>
                                                @enderror --}}

                                            </td>
                                            </td>
                                            <th><span class="text-danger">*</span> Returned Date : </th>
                                            <td>
                                                <input class="form-control" type="date" name="retdate" size="30"
                                                    min="{{ date('Y-m-d') }}">
                                                {{-- @error('retdate')
                                                    <p style="color: red"><strong> {{ $message }} </strong></p>
                                                @enderror --}}

                                            </td>
                                        </tr>
                                        <tr>
                                            <th><span class="text-danger">*</span> Purpose : </th>
                                            <td>
                                                <input class="form-control" type="text" name="purpose" size="30"
                                                    placeholder="purpose">
                                                {{-- @error('purpose')
                                                    <p style="color: red"><strong> {{ $message }} </strong></p>
                                                @enderror --}}

                                            </td>
                                        </tr>
                                    </table><br><br>
                                </div>
                                <div class="subheader">
                                    <ol class="breadcrumb breadcrumb-md breadcrumb-arrow">
                                        <li>
                                            <a href="#" disabled style="pointer-events: none">
                                                <span class=""> Equipment Rented</span>
                                            </a>
                                        </li>
                                        <p>
                                    </ol>
                                </div>
                                <table class="table table-bordered table-hover table-striped w-80" align="center"
                                    required>
                                    <tr align="center">
                                        <th></th>
                                        <th style="width:400px">Item</th>
                                        <th style="width:400px">Serial Number</th>
                                        <th style="width:400px">Description</th>
                                    </tr>
                                    {{-- take from database --}}
                                    {{-- equipment from controller-fx index --}}

                                    @foreach ($equipment as $equipment)
                                        <tr>
                                            <td>
                                                <input name="equipment_id[]" id="equipment{{ $equipment->id }}"
                                                    type="checkbox" value="{{ $equipment->id }}"
                                                    onclick="toggleFields({{ $equipment->id }})">
                                            </td>
                                            <td>{{ $equipment->equipment_name }}</td>
                                            <td>
                                                <input class="form-control" type="text"
                                                    name="sn[{{ $equipment->id }}]" id="sn{{ $equipment->id }}"
                                                    width="300" disabled>
                                            </td>
                                            <td>
                                                <input class="form-control" type="text"
                                                    name="des[{{ $equipment->id }}]" id="des{{ $equipment->id }}"
                                                    size="30" disabled>
                                            </td>
                                        </tr>
                                    @endforeach                               
                                </table><br/>
                                <div class="subheader">
                                    <ol class="breadcrumb breadcrumb-md breadcrumb-arrow">
                                        <li>
                                            <a href="#" disabled style="pointer-events: none">
                                                <span class=""> Document</span>
                                            </a>
                                        </li>
                                        <p>
                                    </ol>
                                </div>
                                <table id="" class="table table-bordered table-hover table-striped w-100">
                                    <thead>
                                        <tr>
                                            <th width="20%" style="vertical-align: middle"><span class="text-danger">*</span>  Picture : </th>
                                            <td colspan="2">
                                                <input type="file" class="form-control" id="upload_img" name="upload_img[]" accept="image/png,image/jpg,image/jpeg" multiple required>
                                                @error('upload_img')
                                                    <p style="color: red">{{ $message }}</p>
                                                @enderror
                                            </td>
                                            <th width="20%" style="vertical-align: middle"> Document : </th>
                                            <td colspan="2">
                                                <input type="file" class="form-control" id="doc" name="doc[]" accept="application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" multiple>
                                                @error('doc')
                                                    <p style="color: red">{{ $message }}</p>
                                                @enderror
                                            </td>
                                        </tr>
                                    </thead>
                                </table>
                                <div align="center">
                                    <div class="text-right">
                                        <div class="btn-group">

                                            <button style="margin-top: 5px;"
                                                class="btn btn-warning mr-2 mt-2 mb-4 waves-effect waves-themed operationverify"
                                                id="submit" name="submit"><i class="fal fa-location-arrow"></i> Submit</button>&nbsp;
                                    
                                            <button style="margin-top: 5px;"
                                                class="btn btn-warning mr-2 mt-2 mb-4 waves-effect waves-themed operationverify"
                                                type="reset"><i class="fal fa-redo"></i> Reset</button>
                                        </div>
                                    </div>
    
                                    {{-- <button type="submit" id="submit"
                                        class="btn btn-primary ml-auto float-right waves-effect waves-themed"><i
                                            class="fal fa-location-arrow"></i> Submit Form</button>
                                    <button style="margin-right:5px" type="reset"
                                        class="btn btn-danger ml-auto float-right waves-effect waves-themed"><i
                                            class="fal fa-redo"></i> Reset</button> --}}
                                    {!! Form::close() !!}
                                    {{-- </form> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
{{-- @section('script')
    <script>
        $(document).ready(function() {
            $('#btnSubmit').on('click', function(e) {
                e.preventDefault();

                // Get the form element and serialize the form data
                var form = $('#rental-form');
                var formData = form.serialize();

                // Send an AJAX request to submit the form data
                $.ajax({
                    url: '/store',
                    type: 'POST',
                    data: formData,
                    dataType: 'text',
                    success: function(data) {
                        // Display a success message
                        Swal.fire({
                            title: 'Success',
                            text: 'Form submitted successfully!',
                            icon: 'success'
                        });
                    },
                    error: function(xhr, status, error) {
                        if (xhr.status === 422) {
                            // Display validation errors
                            var errors = xhr.responseJSON.errors;
                            var errorMessage = '';
                            $.each(errors, function(field, message) {
                                errorMessage += message[0] + '<br>';
                            });
                            Swal.fire({
                                title: 'Error',
                                html: errorMessage,
                                icon: 'error'
                            });
                        } else {
                            // Display a generic error message for other types of errors
                            Swal.fire({
                                title: 'Error',
                                text: 'There was an error submitting the form. Please try again.',
                                icon: 'error'
                            });
                        }
                    }
                });
            });
        });
    </script>
@endsection --}}
{{-- @section('script')
<script>
    $("#submit").on('click', function(e) {
        e.preventDefault();

        var datas = $('#formId').serialize();

        $.ajax({
            type: "POST",
            url: "{{ url('store') }}",
            data: datas,
            dataType: "json",
            success: function(response) {
                console.log(response);
                if (response && response.success) {
                    Swal.fire(response.success);
                    location.reload();
                } else if (response && response.error) { // add this block
                    Swal.fire(response.error);
                }
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                console.log(status);
                console.log(error);
                Swal.fire("An error occurred. Please try again."); // add this line
            }
        });
    });
</script>
@endsection --}}
<script>
    function toggleFields(id) {
        var checkbox = document.getElementById('equipment' + id);
        var snField = document.getElementById('sn' + id);
        var desField = document.getElementById('des' + id);
        if (checkbox.checked) {
            snField.disabled = false;
            desField.disabled = false;
        } else {
            snField.disabled = true;
            desField.disabled = true;
        }
    }
</script>
