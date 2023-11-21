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
                            <b>I-STATIONERY APPLICATION FORM {{ date('Y',strtotime(Carbon\Carbon::now())) }}</b>
                        </h4>
                        <div class="panel-container show">
                            <div class="panel-content">
                                {!! Form::open(['action' => 'Stationery\StationeryManagementController@application_store', 'method' => 'POST', 'id' => 'data', 'enctype' => 'multipart/form-data']) !!}
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="applicant_id" value="{{ Auth::user()->id }}">
                                    <p><span class="text-danger">*</span> Required Field</p>
                                    <div class="table-responsive">
                                        <ol class="breadcrumb breadcrumb-md breadcrumb-arrow">
                                            <li>
                                                <a href="#" disabled style="pointer-events: none">
                                                    <i class="fal fa-user"></i>
                                                    <span class=""> APPLICANT INFORMATION</span>
                                                </a>
                                            </li>
                                            <p></p>
                                        </ol>
                                        <table id="info" class="table table-bordered table-hover table-striped w-100">
                                            <thead>
                                                <tr>
                                                    <th width="20%" style="vertical-align: middle">Name : </th>
                                                    <td colspan="2" style="vertical-align: middle; text-transform: uppercase">{{ $staff->staff_name }} ({{ $staff->staff_id }})</td>
                                                    <th width="20%" style="vertical-align: middle">Email : </th>
                                                    <td colspan="2" style="vertical-align: middle">{{ $staff->staff_email }}</td>
                                                </tr>
                                                <tr>
                                                    <th width="20%" style="vertical-align: middle">Department : </th>
                                                    <td colspan="2" style="vertical-align: middle; text-transform: uppercase">{{ $staff->departments->department_name }}</td>
                                                    <th width="20%" style="vertical-align: middle"><span class="text-danger">*</span> Phone Number : </th>
                                                    <td colspan="2"><input type="tel" class="form-control" id="applicant_phone" name="applicant_phone" value="{{ $staff->staff_phone ?? old('applicant_phone') }}" required></td>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>

                                    <div class="table-responsive">
                                        <ol class="breadcrumb breadcrumb-md breadcrumb-arrow">
                                            <li>
                                                <a href="#" disabled style="pointer-events: none">
                                                    <i class="fal fa-info"></i>
                                                    <span class=""> STATIONERY INFORMATION</span>
                                                </a>
                                            </li>
                                            <p></p>
                                        </ol>
                                        <ul style="margin-left: -20px">
                                            <li style="color: red;">To view the list of provided stationery, please click here: <a id="stationery-list-link" href="#"><u>Stationery List</u> 🔍</a></li>
                                            <li style="color: red;">Please complete the current row before adding a new one to ensure accurate item selection. Please do this step for all rows.</li>
                                        </ul>
                                        <div class="form-group stationery" id="stationery">
                                            <table class="table table-bordered table-hover table-striped w-100" id="head_field">
                                                <tr class="bg-primary-50 text-center">
                                                    <td><span class="text-danger">*</span> Item/Description</td>
                                                    <td><span class="text-danger">*</span> Quantity</td>
                                                    <td>Remark</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <select class="form-control stock_id" name="stock_id[]" required>
                                                            <option value="" disabled selected>Please select</option>
                                                            @foreach ($stock as $stocks)
                                                                <option value="{{ $stocks->id }}" {{ old('stock_id') ? 'selected' : '' }}>
                                                                    {{ $stocks->stock_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control" id="request_quantity" name="request_quantity[]" value="{{ old('request_quantity') }}" required>
                                                    </td>
                                                    <td>
                                                        <input class="form-control" id="request_remark" name="request_remark[]" value="{{ old('request_remark') }}">
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" name="addhead" id="addhead" class="btn btn-success btn-sm"><i class="fal fa-plus"></i></button>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <ol class="breadcrumb breadcrumb-md breadcrumb-arrow">
                                            <li>
                                                <a href="#" disabled style="pointer-events: none">
                                                    <i class="fal fa-check-square"></i>
                                                    <span class=""> CONSENT VERIFICATION</span>
                                                </a>
                                            </li>
                                            <p></p>
                                        </ol>
                                        <table id="verification" class="table table-bordered table-hover table-striped w-100">
                                            <thead>
                                                <tr>
                                                    <div class="form-group">
                                                        <td colspan="4"><p class="form-label" for="applicant_verification">
                                                        <input style="margin-top: 15px; margin-right: 30px; margin-left: 15px" type="checkbox" name="applicant_verification" required id="chk" onclick="btn()"/>
                                                        ALL INFORMATION PROVIDED ARE ACCURATE. I CONSENT TO BE CONTACTED FOR ANY FURTHER INQUIRIES RELATED TO THE SUBMITTED APPLICATION.
                                                    </div>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <button class="btn btn-danger float-right mb-4" type="button" id="submitBtn" disabled>
                                        <i class="fal fa-check-circle"></i> Submit Application
                                    </button>
                                {!! Form::close() !!}
                                <a href="/application-list" class="btn btn-success ml-auto float-right mr-2" ><i class="fal fa-arrow-alt-left"></i> Back</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="crud-modal" aria-hidden="true" data-keyboard="false" data-backdrop="static">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="card-header bg-primary text-white">
                                <h5 class="card-title w-100"><i class="ml-2 mr-4 fa-1x fal fa-search"></i></i>STATIONERY LIST</h5>
                            </div>
                            <div class="modal-body">
                                <div class="table-responsive">
                                    <table id="list" class="table table-bordered table-hover table-striped w-100">
                                        <thead>
                                            <tr class="text-center" style="white-space: nowrap">
                                                <th>NO</th>
                                                <th>ITEM/DESCRIPTION</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($stock as $stock_list)
                                                <tr>
                                                    <td class="text-center">{{$loop->iteration}}</td>
                                                    <td style="text-transform: uppercase">{{$stock_list->stock_name }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="footer">
                                    <button type="button" class="btn btn-sm btn-success ml-auto mt-4 float-right" data-dismiss="modal"><i class="fal fa-window-close"></i> Close</button>
                                </div>
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

    $(document).ready(function() {

        $('a#stationery-list-link').click(function(e) {
            e.preventDefault();
            $('#crud-modal').modal('show');
        });

        $("#data").submit(function () {
            $("#submit").attr("disabled", true);
            return true;
        });

        $('#list thead tr .hasinput').each(function(i)
        {
            $('input', this).on('keyup change', function()
            {
                if (table.column(i).search() !== this.value)
                {
                    table
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });

            $('select', this).on('keyup change', function()
            {
                if (table.column(i).search() !== this.value)
                {
                    table
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        });

        var table = $('#list').DataTable({
            columnDefs: [],
                orderCellsTop: true,
                "order": [[ 0, "asc" ]],
                "initComplete": function(settings, json) {
                }
        });

        $('.stock_id').select2();

        var selectedOptions = [];

        // Function to update options based on selected options
        function updateDropdownOptions() {
            $('.stock_id').each(function () {
                var $select = $(this);
                var $options = $select.find('option');

                // Reset the options to the original state
                $options.show();

                // Hide options that have been selected
                selectedOptions.forEach(function (selectedValue) {
                    $options.filter('[value="' + selectedValue + '"]').hide();
                });
            });
        }

        // When a dropdown value changes, update selectedOptions and update dropdown options
        $(document).on('change', '.stock_id', function () {
            var selectedValue = $(this).val();
            var $parentRow = $(this).closest('tr');

            // Remove the previously selected value from selectedOptions
            var previousSelectedValue = $parentRow.data('selected-value');
            if (previousSelectedValue) {
                var index = selectedOptions.indexOf(previousSelectedValue);
                if (index !== -1) {
                    selectedOptions.splice(index, 1);
                }
            }

            // Add the newly selected value to selectedOptions
            if (selectedValue) {
                selectedOptions.push(selectedValue);
                $parentRow.data('selected-value', selectedValue);
            }

            // Update dropdown options
            updateDropdownOptions();
        });

        // When a row is removed, update selectedOptions and dropdown options
        $(document).on('click', '.btn_remove', function () {
            var button_id = $(this).attr("id");
            var $row = $('#row' + button_id);
            var removedOptionValue = $row.find('select.stock_id').val();
            var previousSelectedValue = $row.data('selected-value');

            if (removedOptionValue) {
                var index = selectedOptions.indexOf(removedOptionValue);
                if (index !== -1) {
                    selectedOptions.splice(index, 1);
                }
            }

            $row.remove();
            updateDropdownOptions();
        });

        $('#addhead').click(function () {
            i++;
            var newRow = `
                <tr id="row${i}" class="head-added">
                    <td>
                        <select class="form-control stock_id" name="stock_id[]" required>
                            <option value="" disabled selected>Please select</option>`;

            // Loop through the stock options and add only those that haven't been selected
            @foreach ($stock as $stocks)
                var stockId = "{{ $stocks->id }}";
                var stockName = "{{ $stocks->stock_name }}";
                if (selectedOptions.indexOf(stockId) === -1) {
                    newRow += `<option value="${stockId}" {{ old('stock_id') ? 'selected' : '' }}>${stockName}</option>`;
                }
            @endforeach

            newRow += `
                        </select>
                    </td>
                    <td>
                        <input type="number" class="form-control" id="request_quantity" name="request_quantity[]" value="{{ old('request_quantity') }}" required>
                    </td>
                    <td>
                        <input class="form-control" id="request_remark" name="request_remark[]" value="{{ old('request_remark') }}">
                    </td>
                    <td class="text-center">
                        <button type="button" name="remove" id="${i}" class="btn btn-sm btn-danger btn_remove"><i class="fal fa-trash"></i></button>
                    </td>
                </tr>
            `;

            $('#head_field').append(newRow);
            $('.stock_id').select2();
            updateDropdownOptions(); // Update dropdown options
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

    });

    function btn()
    {
        var chk = document.getElementById("chk")
        var submit = document.getElementById("submitBtn");
        submit.disabled = chk.checked ? false : true;
        if(!submit.disabled){
            submit.focus();
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const submitBtn = document.getElementById('submitBtn');
        const form = document.getElementById('data');
        const checkBox = document.getElementById('chk');

        submitBtn.addEventListener('click', function () {
            event.preventDefault();

             if (form.checkValidity()) {
                Swal.fire({
                    title: 'Confirmation',
                    text: 'Are you sure you want to submit the application?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.value) {
                         form.submit();
                    } else {
                        checkBox.checked = false;
                    }
                });
            } else {
                 Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please fill in all required fields!',
                });
            }
        });
    });

</script>
@endsection

