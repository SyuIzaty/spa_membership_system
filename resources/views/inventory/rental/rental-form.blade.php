@extends('layouts.admin')

@section('content')

<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-plus-circle'></i> RENTAL FORM MANAGEMENT
        </h1>
    </div>
    <div class="row">

        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Register New Rental
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        {!! Form::open(['id' => 'data', 'action' => ['Inventory\RentalManagementController@store_rental_detail'], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 mb-4">
                                    <div class="card card-primary card-outline">
                                        <div class="card-header">
                                            <h5 class="card-title w-100"><i class="fal fa-user width-2 fs-xl"></i>RENTER DETAIL</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <p><span class="text-danger">*</span> Required fields</p>
                                                <table class="table table-bordered table-hover table-striped w-100">
                                                    <thead>
                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="10%"><label class="form-label" for="staff_name"><span class="text-danger">*</span> Name :</label></td>
                                                                <td colspan="3">
                                                                    <select class="form-control staff_name" name="staff_name" id="staff_name" required>
                                                                        <option value="" disabled selected> Please select</option>
                                                                        @foreach ($user as $users)
                                                                            <option value="{{ $users->id }}" {{ old('staff_name') ==  $users->id  ? 'selected' : '' }}>{{ $users->id }} - {{ $users->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    @error('staff_name')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                                </td>
                                                                <td width="10%"><label class="form-label" for="staff_id"> Staff ID :</label></td>
                                                                <td colspan="3">
                                                                    <input class="form-control staff_id" id="staff_id" name="staff_id"  value="{{ old('staff_id') }}" readonly>
                                                                </td>
                                                            </div>
                                                        </tr>
                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="10%"><label class="form-label" for="staff_email"> Email :</label></td>
                                                                <td colspan="3">
                                                                    <input class="form-control staff_email" id="staff_email" name="staff_email"  value="{{ old('staff_email') }}" readonly>
                                                                </td>
                                                                <td width="10%"><label class="form-label" for="staff_phone"> Phone Number :</label></td>
                                                                <td colspan="3">
                                                                    <input class="form-control staff_phone" id="staff_phone" name="staff_phone"  value="{{ old('staff_phone') }}" readonly>
                                                                </td>
                                                            </div>
                                                        </tr>
                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="10%"><label class="form-label" for="staff_dept"> Department :</label></td>
                                                                <td colspan="3">
                                                                    <input class="form-control staff_dept" id="staff_dept" name="staff_dept"  value="{{ old('staff_dept') }}" readonly>
                                                                </td>
                                                                <td width="10%"><label class="form-label" for="staff_position"> Position :</label></td>
                                                                <td colspan="3">
                                                                    <input class="form-control staff_position" id="staff_position" name="staff_position"  value="{{ old('staff_position') }}" readonly>
                                                                </td>
                                                            </div>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card card-primary card-outline">
                                        <div class="card-header">
                                            <h5 class="card-title w-100"><i class="fal fa-info width-2 fs-xl"></i>RENTAL DETAIL</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover table-striped w-100">
                                                    <thead>
                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="10%"><label class="form-label" for="asset_type"><span class="text-danger">*</span> Asset Type :</label></td>
                                                                <td colspan="3">
                                                                    <select class="form-control asset_type" name="asset_type" id="asset_type" required>
                                                                        <option value="" disabled selected> Please select</option>
                                                                            @foreach ($assetType as $assetTypes)
                                                                                <option value="{{ $assetTypes->id }}" {{ old('asset_type') ==  $assetTypes->id  ? 'asset_type' : '' }}>{{ $assetTypes->asset_type }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    @error('asset_type')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                                </td>
                                                                <td width="10%"><label class="form-label" for="asset_name"><span class="text-danger">*</span> Asset Name :</label></td>
                                                                <td colspan="3">
                                                                    <select class="form-control asset_name" name="asset_name" id="asset_name" required>
                                                                    </select>
                                                                    <input type="hidden" id="id" name="id">
                                                                    @error('asset_name')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                                </td>
                                                            </div>
                                                        </tr>
                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="10%"><label class="form-label" for="asset_code"> Asset Code :</label></td>
                                                                <td colspan="3">
                                                                    <input value="{{ old('asset_code') }}" class="form-control asset_code" id="asset_code" name="asset_code" readonly>
                                                                </td>
                                                                <td width="10%"><label class="form-label" for="serial_no"> Serial No. :</label></td>
                                                                <td colspan="3">
                                                                    <input value="{{ old('serial_no') }}" class="form-control serial_no" id="serial_no" name="serial_no" readonly>
                                                                </td>
                                                            </div>
                                                        </tr>
                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="10%"><label class="form-label" for="model"> Model :</label></td>
                                                                <td colspan="3">
                                                                    <input value="{{ old('model') }}" class="form-control model" id="model" name="model" readonly>
                                                                </td>
                                                                <td width="10%"><label class="form-label" for="brand"> Brand :</label></td>
                                                                <td colspan="3">
                                                                    <input value="{{ old('brand') }}" class="form-control brand" id="brand" name="brand" readonly>
                                                                </td>
                                                            </div>
                                                        </tr>
                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="10%"><label class="form-label" for="checkout_date"><span class="text-danger">*</span> Checkout Date :</label></td>
                                                                <td colspan="3"><input type="datetime-local" class="form-control" id="checkout_date" name="checkout_date" value="{{ old('checkout_date') }}" required>
                                                                    @error('checkout_date')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                                </td>
                                                                <td width="10%"><label class="form-label" for="return_date"> Return Date :</label></td>
                                                                <td colspan="3"><input type="datetime-local" class="form-control" id="return_date" name="return_date" value="{{ old('return_date') }}">
                                                                    @error('return_date')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                                </td>
                                                            </div>
                                                        </tr>
                                                        <tr>
                                                            <div class="form-group">
                                                                <div class="form-group">
                                                                    <td width="10%"><label class="form-label" for="storage_location"><span class="text-danger">*</span> Location :</label></td>
                                                                    <td colspan="3">
                                                                        <input value="{{ old('storage_location') }}" class="form-control storage_location" id="storage_location" name="storage_location" required>
                                                                        @error('storage_location')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror
                                                                    </td>
                                                                </div>
                                                                <td width="10%"><label class="form-label" for="reason"><span class="text-danger">*</span> Reason :</label></td>
                                                                <td colspan="6">
                                                                    <textarea rows="3" class="form-control" id="reason" name="reason" required></textarea>
                                                                    @error('reason')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                                </td>
                                                            </div>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success ml-auto float-right mt-2"><i class="fal fa-save"></i> Save</button>
                                    <a href="/rental-list" class="btn btn-secondary ml-auto float-right mr-2 mt-2"><i class="fal fa-arrow-alt-left"></i> Back</a><br><br>
                                </div>
                            </div>
                        {!! Form::close() !!}
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
        $('#staff_name, #asset_type, #asset_name').select2();

        if($('.staff_name').val()!=''){
            updateFd($('.staff_name'));
        }

        $(document).on('change','.staff_name',function(){
            updateFd($(this));
        });

        function updateFd(elem){
            var id=elem.val();

            $.ajax({
                type:'get',
                url:'{!!URL::to('find-renter-info')!!}',
                data:{'id':id},
                success:function(data)

                {
                    $('#staff_id').val(data.staff_id);
                    $('#staff_email').val(data.staff_email);
                    $('#staff_phone').val(data.staff_phone);
                    $('#staff_dept').val(data.staff_dept);
                    $('#staff_position').val(data.staff_position);
                }
            });
        }
    });

    $(document).ready(function() {

        if($('.asset_type').val()!=''){
            updateFd($('.asset_type'));
        }

        $(document).on('change','.asset_type',function(){
            updateFd($(this));
        });

        function updateFd(elem){
        var id=elem.val();
        var op=" ";

            $.ajax({
                type:'get',
                url:'{!!URL::to('find-asset-type')!!}',
                data:{'id':id},
                success:function(data)
                {
                    op+='<option value="" disabled selected> Please select</option>';
                    for (var i=0; i<data.length; i++)
                    {
                        var selected = (data[i].id=="{{old('asset_name')}}") ? "selected='selected'" : '';
                        op+='<option value="'+data[i].id+'" '+selected+'>'+data[i].asset_name+'</option>';
                    }

                    $('.asset_name').html(op);
                },
                error:function(){
                    console.log('success');
                },
            });
        }
    });

    $(document).ready(function() {

        if($('.asset_name').val()!=''){
            updateFd($('.asset_name'));
        }

        $(document).on('change','.asset_name',function(){
            updateFd($(this));
        });

        function updateFd(elem){
            var id=elem.val();

            $.ajax({
                type:'get',
                url:'{!!URL::to('find-asset-info')!!}',
                data:{'id':id},
                success:function(data)

                {
                    $('#id').val(data.id);
                    $('#asset_code').val(data.asset_code);
                    $('#serial_no').val(data.serial_no);
                    $('#model').val(data.model);
                    $('#brand').val(data.brand);
                    $('#storage_location').val(data.storage_location);
                }
            });
        }

    });

</script>
@endsection
