@extends('layouts.admin')

@section('content')

<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-plus-circle'></i> Asset Registration
        </h1>
    </div>
    <div class="row">

        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Register <span class="fw-300"><i>New Asset</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                      
                        <form action="{{ route('newAsset') }}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="row">
                                <div class="col-sm-12 col-md-12 mb-4">

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
                                                                    <select name="department_id" id="department_id" class="department form-control">
                                                                        <option value="">-- Select Department --</option>
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
                                                                    <select class="form-control asset_type" name="asset_type" id="asset_type" >
                                                                    </select>
                                                                    @error('asset_type')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                                </td>
                                                            </div>
                                                        </tr>

                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="10%"><label class="form-label" for="asset_name"><span class="text-danger">*</span> Asset Name :</label></td>
                                                                <td colspan="3"><input value="{{ old('asset_name') }}" class="form-control" id="asset_name" name="asset_name">
                                                                    @error('asset_name')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                                </td>
                                                                <td width="10%"><label class="form-label" for="serial_no"><span class="text-danger">*</span> Serial No. :</label></td>
                                                                <td colspan="3"><input value="{{ old('serial_no') }}" class="form-control" id="serial_no" name="serial_no">
                                                                    @error('serial_no')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                                </td>
                                                            </div>
                                                        </tr>

                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="10%"><label class="form-label" for="model"><span class="text-danger">*</span> Model :</label></td>
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
                                                                <td width="10%"><label class="form-label" for="upload_image"> Image :</label></td>
                                                                <td colspan="3">
                                                                    <input type="file" class="form-control" id="upload_image" name="upload_image">
                                                                    @error('upload_image')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                                </td>
                                                                <td width="10%"><label class="form-label" for="status"> Availability :</label></td>
                                                                <td colspan="3">
                                                                    <select class="form-control status" name="status" id="status" >
                                                                        <option value="">Select Status</option>
                                                                        @foreach ($status as $stat) 
                                                                            <option value="{{ $stat->id }}" {{ old('status') ==  $stat->id  ? 'selected' : '' }}>{{ $stat->status_name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    @error('status')
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
                                                            <td colspan="6"><label class="form-label"> PURCHASE INFO</label></td>
                                                        </tr>

                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="10%"><label class="form-label" for="purchase_date"><span class="text-danger">*</span> Purchase Date :</label></td>
                                                                <td colspan="3">
                                                                    <input type="date" class="form-control" id="purchase_date" name="purchase_date" value="{{ old('purchase_date') }}">
                                                                    @error('purchase_date')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                                </td>
                                                                <td width="10%"><label class="form-label" for="vendor_name"><span class="text-danger">*</span> Vendor :</label></td>
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
                                                                <td width="10%"><label class="form-label" for="remark"> Remark :</label></td>
                                                                <td colspan="6">
                                                                    <textarea rows="5" class="form-control" id="remark" name="remark"></textarea>
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
                                                                    <select class="form-control custodian_id" name="custodian_id" id="custodian_id" >
                                                                    </select>
                                                                    @error('custodian_id')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                                </td>
                                                                <td width="10%"><label class="form-label" for="storage_location"> Asset Storage :</label></td>
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
                                            <button style="margin-right:5px" type="reset" class="btn btn-danger ml-auto float-right"><i class="fal fa-redo"></i> Reset</button>
                                            <a style="margin-right:5px" href="/asset-index" onclick="return confirm('Are you sure to discard data?')" class="btn btn-success ml-auto float-right"><i class="fal fa-trash-alt"></i> Discard</a><br><br>
                                            
                                        </div>
                                    </div>

                                </div>
                            </div>
                                
                        </form>
                        
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
        $('#department_id, #asset_type, #custodian_id, #status').select2();

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
                    url:'{!!URL::to('findAssetType')!!}',
                    data:{'id':eduid},
                    success:function(data)
                    {
                        console.log(data)
                        op+='<option value=""> Select Asset Type </option>';
                        for (var i=0; i<data.length; i++)
                        {
                            var selected = (data[i].id=="{{old('asset_type', $asset->asset_type)}}") ? "selected='selected'" : '';
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
                    updateCust($('.department'));
                }
                $(document).on('change','.department',function(){
                    updateCust($(this));
                });

                function updateCust(elem){
                var eduid=elem.val();
                var op=" "; 

                $.ajax({
                    type:'get',
                    url:'{!!URL::to('findCustodian')!!}',
                    data:{'id':eduid},
                    success:function(data)
                    {
                        console.log(data)
                        op+='<option value=""> Select Custodian </option>';
                        for (var i=0; i<data.length; i++)
                        {
                            var selected = (data[i].id=="{{old('custodian_id', $asset->custodian_id)}}") ? "selected='selected'" : '';
                            op+='<option value="'+data[i].id+'" '+selected+'>'+data[i].custodian.name+'</option>';
                        }

                        $('.custodian_id').html(op);
                    },
                    error:function(){
                        console.log('success');
                    },
                });
            }

    });

</script>
@endsection
