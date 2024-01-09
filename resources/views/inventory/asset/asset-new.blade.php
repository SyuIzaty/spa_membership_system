@extends('layouts.admin')

@section('content')

<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-plus-circle'></i> ASSET REGISTRATION MANAGEMENT
        </h1>
    </div>
    <div class="row">

        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Register New Asset
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">

                        {!! Form::open(['id' => 'data', 'action' => ['Inventory\AssetManagementController@store_asset_detail'], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 mb-4">
                                    @if (Session::has('message'))
                                        <div class="alert alert-success" style="color: #3b6324"> <i class="icon fal fa-check-circle"></i> {{ Session::get('message') }}</div>
                                    @endif
                                    <div class="card card-primary card-outline">
                                        <div class="card-header">
                                            <h5 class="card-title w-100"><i class="fal fa-info width-2 fs-xl"></i> ASSET DETAILS</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <p><span class="text-danger">*</span> Required fields</p>
                                                <table id="new_asset" class="table table-bordered table-hover table-striped w-100">
                                                    <thead>
                                                        <tr class="bg-primary-50">
                                                            <td colspan="6"><label class="form-label"> ASSET INFO</label></td>
                                                        </tr>

                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="10%"><label class="form-label" for="department_id"><span class="text-danger">*</span> Department :</label></td>
                                                                <td colspan="3">
                                                                    <select name="department_id" id="department_id" class="department form-control" required>
                                                                        <option value="" selected disabled>Please Select</option>
                                                                        @foreach ($department as $depart)
                                                                            <option value="{{ $depart->id }}" {{ old('department_id') ? 'selected' : '' }}>{{ $depart->department_name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    @error('department_id')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                                </td>

                                                                <td width="10%"><label class="form-label" for="asset_type"><span class="text-danger">*</span> Asset Type :</label></td>
                                                                <td colspan="3">
                                                                    <select class="form-control asset_type" name="asset_type" id="asset_type" required>
                                                                    </select>
                                                                    @error('asset_type')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                                </td>
                                                            </div>
                                                        </tr>

                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="10%"><label class="form-label" for="finance_code"> Finance Code :</label></td>
                                                                <td colspan="3"><input value="{{ old('finance_code') }}" class="form-control" id="finance_code" name="finance_code">
                                                                    @error('finance_code')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                                </td>
                                                                <td width="10%"><label class="form-label" for="asset_code_type"><span class="text-danger">*</span> Code Type :</label></td>
                                                                <td colspan="3">
                                                                    <select class="form-control asset_code_type" name="asset_code_type" id="asset_code_type" required>
                                                                        <option value="" selected disabled>Please Select</option>
                                                                        @foreach ($codeType as $codeTypes)
                                                                            <option value="{{ $codeTypes->id }}" {{ old('asset_code_type') ==  $codeTypes->id  ? 'selected' : '' }}>{{ $codeTypes->id }} - {{ $codeTypes->code_name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    @error('asset_code_type')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                                </td>
                                                            </div>
                                                        </tr>

                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="10%"><label class="form-label" for="asset_name"><span class="text-danger">*</span> Asset Name :</label></td>
                                                                <td colspan="3"><input value="{{ old('asset_name') }}" class="form-control" id="asset_name" name="asset_name" required>
                                                                    @error('asset_name')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                                </td>
                                                                <td width="10%"><label class="form-label" for="serial_no"><span class="text-danger">*</span> Serial No. :</label></td>
                                                                <td colspan="3"><input value="{{ old('serial_no') }}" class="form-control" id="serial_no" name="serial_no" required>
                                                                    @error('serial_no')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                                </td>
                                                            </div>
                                                        </tr>

                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="10%"><label class="form-label" for="model"> Model :</label></td>
                                                                <td colspan="3"><input value="{{ old('model') }}" class="form-control" id="model" name="model">
                                                                    @error('model')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                                </td>
                                                                <td width="10%"><label class="form-label" for="brand"> Brand :</label></td>
                                                                <td colspan="3"><input value="{{ old('brand') }}" class="form-control" id="brand" name="brand">
                                                                    @error('brand')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                                </td>
                                                            </div>
                                                        </tr>

                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="10%"><label class="form-label" for="status"><span class="text-danger">*</span> Status :</label></td>
                                                                <td colspan="3">
                                                                    <select class="form-control status" id="status" name="status" required>
                                                                        <option value="" selected disabled>Please Select</option>
                                                                        <option value="1" {{ old('status') == '1' ? 'selected':''}} >Active</option>
                                                                        <option value="0" {{ old('status') == '0' ? 'selected':''}} >Inactive</option>
                                                                    </select>
                                                                    @error('status')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                                    <br><br>
                                                                    <input type="date" class="form-control inactive" id="inactive_date" name="inactive_date" value="{{ old('inactive_date') }}">
                                                                    @error('inactive_date')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                                </td>
                                                                <td width="10%"><label class="form-label" for="availability"> Availability :</label></td>
                                                                <td colspan="3">
                                                                    <select class="form-control availability" name="availability" id="availability" >
                                                                        <option value="" selected disabled>Please Select</option>
                                                                        @foreach ($availability as $available)
                                                                            <option value="{{ $available->id }}" {{ old('availability') ==  $available->id  ? 'selected' : '' }}>{{ $available->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    @error('availability')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                                </td>
                                                            </div>
                                                        </tr>
                                                        <tr class="inactive">
                                                            <div class="form-group">
                                                                <td width="10%"><label class="form-label" for="model"><span class="text-danger">*</span> Reason :</label></td>
                                                                <td colspan="3">
                                                                    <select class="form-control inactive_reason" name="inactive_reason" id="inactive_reason">
                                                                        <option value="" selected disabled>Please Select</option>
                                                                        @foreach ($status as $statuss)
                                                                            <option value="{{ $statuss->id }}" {{ old('inactive_reason') ==  $statuss->id  ? 'selected' : '' }}>{{ $statuss->status_name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    @error('inactive_reason')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                                </td>
                                                                <td width="10%"><label class="form-label" for="inactive_remark"> Remark :</label></td>
                                                                <td colspan="3">
                                                                    <textarea rows="5" class="form-control" id="inactive_remark" name="inactive_remark"></textarea>
                                                                    @error('inactive_remark')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                                </td>
                                                            </div>
                                                        </tr>
                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="10%"><label class="form-label" for="asset_class"><span class="text-danger">*</span>  Asset Class </label></td>
                                                                <td colspan="3">
                                                                    <select class="form-control asset_class" name="asset_class" id="asset_class" required>
                                                                        <option value="" selected disabled>Please Select</option>
                                                                        @foreach ($class as $classses)
                                                                            <option value="{{ $classses->class_code }}" {{ old('asset_class') ==  $classses->class_code  ? 'selected' : '' }}>{{ $classses->class_name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    @error('asset_class')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                                </td>
                                                                <td width="10%"><label class="form-label" for="upload_image"> Image :</label></td>
                                                                <td colspan="3">
                                                                    <input type="file" class="form-control" id="upload_image" name="upload_image[]" multiple>
                                                                    @error('upload_image')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                                </td>
                                                            </div>
                                                        </tr>
                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="10%"><label class="form-label" for="set_package"><span class="text-danger">*</span>  Set Package ?</label></td>
                                                                <td colspan="6">
                                                                        <input type="radio" name="set_package" id="set_package" value="Y" {{ old('set_package') == "Y" ? 'checked' : '' }}> Yes
                                                                        <input class="ml-5" type="radio" name="set_package" id="set_package" value="N" {{ old('set_package') == "N" ? 'checked' : '' }}> No
                                                                        @error('set_package')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror
                                                                    </label>
                                                                </td>
                                                            </div>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>

                                            <div class="table-responsive">
                                                <table id="new_assets" class="table table-bordered table-hover table-striped w-100">
                                                    <thead>
                                                        <tr class="bg-primary-50">
                                                            <td colspan="6"><label class="form-label"> PURCHASE INFO</label></td>
                                                        </tr>

                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="10%"><label class="form-label" for="purchase_date"> Purchase Date :</label></td>
                                                                <td colspan="3">
                                                                    <input type="date" class="form-control" id="purchase_date" name="purchase_date" value="{{ old('purchase_date') }}">
                                                                    @error('purchase_date')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                                </td>
                                                                <td width="10%"><label class="form-label" for="vendor_name"> Vendor :</label></td>
                                                                <td colspan="3"><input value="{{ old('vendor_name') }}" class="form-control" id="vendor_name" name="vendor_name">
                                                                    @error('vendor_name')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                                </td>
                                                            </div>
                                                        </tr>

                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="10%"><label class="form-label" for="lo_no"> L.O. Number :</label></td>
                                                                <td colspan="3"><input value="{{ old('lo_no') }}" class="form-control" id="lo_no" name="lo_no">
                                                                    @error('lo_no')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                                </td>
                                                                <td width="10%"><label class="form-label" for="do_no"> D.O. Number :</label></td>
                                                                <td colspan="3"><input value="{{ old('do_no') }}" class="form-control" id="do_no" name="do_no">
                                                                    @error('do_no')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                                </td>
                                                            </div>
                                                        </tr>

                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="10%"><label class="form-label" for="io_no"> Invoice Number :</label></td>
                                                                <td colspan="3"><input value="{{ old('io_no') }}" class="form-control" id="io_no" name="io_no">
                                                                    @error('io_no')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                                </td>
                                                                <td width="10%"><label class="form-label" for="total_price"> Price (RM) :</label></td>
                                                                <td colspan="3"><input type="number" step="any" class="form-control" id="total_price" name="total_price"  value="{{ old('total_price') }}">
                                                                    @error('total_price')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                                </td>
                                                            </div>
                                                        </tr>

                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="10%"><label class="form-label" for="acquisition_type"> Acquisition Type :</label></td>
                                                                <td colspan="3">
                                                                    <select class="form-control" name="acquisition_type" id="acquisition_type" >
                                                                        <option value="" selected disabled>Please Select</option>
                                                                        @foreach ($acquisition as $acq)
                                                                            <option value="{{ $acq->id }}" {{ old('acquisition_type') ==  $acq->id  ? 'selected' : '' }}>{{ $acq->acquisition_type }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    @error('acquisition_type')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                                </td>
                                                                <td width="10%"><label class="form-label" for="remark"> Remark :</label></td>
                                                                <td colspan="3">
                                                                    <textarea rows="5" class="form-control" id="remark" name="remark">{{ old('remark') }}</textarea>
                                                                    @error('remark')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                                </td>
                                                            </div>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>

                                            <div class="table-responsive">
                                                <table id="new_assets" class="table table-bordered table-hover table-striped w-100">
                                                    <thead>
                                                        <tr class="bg-primary-50">
                                                            <td colspan="6"><label class="form-label"> CUSTODIAN INFO</label></td>
                                                        </tr>

                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="10%"><label class="form-label" for="custodian_id"><span class="text-danger">*</span> Custodian :</label></td>
                                                                <td colspan="3">
                                                                    <select class="form-control custodian_id" name="custodian_id" id="custodian_id" required>
                                                                     </select>
                                                                    @error('custodian_id')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                                </td>
                                                                <td width="10%"><label class="form-label" for="storage_location"> Location :</label></td>
                                                                <td colspan="3"><input value="{{ old('storage_location') }}" class="form-control" id="storage_location" name="storage_location">
                                                                    @error('storage_location')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                                </td>
                                                            </div>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div><br>

                                            <button type="submit" class="btn btn-primary ml-auto float-right"><i class="fal fa-save"></i> Save</button>
                                            <a style="margin-right:5px" href="/asset-list" class="btn btn-success ml-auto float-right"><i class="fal fa-trash-alt"></i> Back</a><br><br>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        <{!! Form::close() !!}

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

        $('#department_id, #asset_type, #custodian_id, #status, #availability, #asset_code_type, #acquisition_type, #inactive_reason, #asset_class').select2();

        // Dependent Dropdown Function

        if($('.department').val()!=''){
                updateType($('.department'));
            }
            $(document).on('change','.department',function(){
                updateType($(this));
            });

            function updateType(elem){
            var eduid=elem.val();
            var op=" ";

            $.ajax({
                type:'get',
                url:'{!!URL::to('find-asset-type')!!}',
                data:{'id':eduid},
                success:function(data)
                {
                    console.log(data)
                    op+='<option value="" selected disabled> Please select </option>';
                    for (var i=0; i<data.length; i++)
                    {
                        var selected = (data[i].id=="{{old('asset_type')}}") ? "selected='selected'" : '';
                        op+='<option value="'+data[i].id+'" '+selected+'>'+data[i].asset_type+'</option>';
                    }

                    $('.asset_type').html(op);
                },
                error:function(){
                    console.log('success');
                },
            });
        }

        if($('.department').val()!=''){
                updateCustodian($('.department'));
            }
            $(document).on('change','.department',function(){
                updateCustodian($(this));
            });

            function updateCustodian(elem){
            var eduid=elem.val();
            var op=" ";

            $.ajax({
                type:'get',
                url:'{!!URL::to('find-custodian')!!}',
                data:{'id':eduid},
                success:function(data)
                {
                    console.log(data)
                    op+='<option value="" selected disabled> Please select </option>';
                    for (var i=0; i<data.length; i++)
                    {
                        var selected = (data[i].custodian_id=="{{old('custodian_id')}}") ? "selected='selected'" : '';
                        op+='<option value="'+data[i].custodian_id+'" '+selected+'>'+data[i].custodian.name+'</option>';
                    }

                    $('.custodian_id').html(op);
                },
                error:function(){
                    console.log('success');
                },
            });
        }

    });

     $(function () {

        // Package Function

        $('input[name="set_package"]:checked').val('{{ old('set_package') }}');
        $('input[name="set_package"]:checked').change();

        // Inactive Function

        $(".inactive").hide();

        $( "#status" ).change(function() {
            var val = $("#status").val();
            if(val=="0"){
                $(".inactive").show();
            } else {
                $(".inactive").hide();
            }
        });

        $('#status').val('{{ old('status') }}');
        $("#status").change();
        $('#inactive_date').val('{{ old('inactive_date') }}');
        $('#inactive_reason').val('{{ old('inactive_reason') }}');
        $("#inactive_reason").change();
        $('#inactive_remark').val('{{ old('inactive_remark') }}');

        $('#department_id').val('{{ old('department_id') }}');
        $("#department_id").change();
        $('#asset_type').val('{{ old('asset_type') }}');
        $("#asset_type").change();
        $('#custodian_id').val('{{ old('custodian_id') }}');
        $("#custodian_id").change();
    })

</script>
@endsection
