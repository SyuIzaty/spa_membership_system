@extends('layouts.admin')

@section('content')

<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-plus-circle'></i> Borrower Registration
        </h1>
    </div>
    <div class="row">

        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Register <span class="fw-300"><i>New Borrower</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                      
                        <form action="{{ route('newBorrow') }}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 mb-4">

                                    <div class="card card-primary card-outline">
                                        <div class="card-header">
                                            <h5 class="card-title w-100"><i class="fal fa-info width-2 fs-xl"></i>BORROW DETAILS</h5>
                                        </div>
                                        
                                        <div class="card-body">
                                            
                                            <div class="table-responsive">
                                                <p><span class="text-danger">*</span> Required fields</p>
                                                <table id="new_assets" class="table table-bordered table-hover table-striped w-100">
                                                    <thead>
                                                        <tr class="bg-primary-50">
                                                            <td colspan="6"><label class="form-label"> BORROWER PROFILE</label></td>
                                                        </tr>

                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="10%"><label class="form-label" for="borrower_name"><span class="text-danger">*</span> Borrower Name :</label></td>
                                                                <td colspan="3">
                                                                    <select class="form-control borrower_name" name="borrower_name" id="borrower_name" >
                                                                        <option value=""> Select Borrower Name </option>
                                                                        @foreach ($user as $usr) 
                                                                            <option value="{{ $usr->id }}" {{ old('borrower_name') ==  $usr->id  ? 'selected' : '' }}>{{ $usr->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    @error('borrower_name')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                                </td>
                                                                <td width="10%"><label class="form-label" for="borrower_id"> Borrower ID :</label></td>
                                                                <td colspan="3">
                                                                    <input class="form-control borrower_id" id="borrower_id" name="borrower_id"  value="{{ old('borrower_id') }}" readonly>
                                                                </td>
                                                            </div>
                                                        </tr>

                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="10%"><label class="form-label" for="borrower_email"> Email :</label></td>
                                                                <td colspan="3">
                                                                    <input class="form-control borrower_email" id="borrower_email" name="borrower_email"  value="{{ old('borrower_email') }}" readonly>
                                                                </td>
                                                                <td width="10%"><label class="form-label" for="borrower_phone"> Phone Number :</label></td>
                                                                <td colspan="3">
                                                                    <input class="form-control borrower_phone" id="borrower_phone" name="borrower_phone"  value="{{ old('borrower_phone') }}" readonly>
                                                                </td>
                                                            </div>
                                                        </tr>

                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="10%"><label class="form-label" for="borrower_dept"> Department :</label></td>
                                                                <td colspan="3">
                                                                    <input class="form-control borrower_dept" id="borrower_dept" name="borrower_dept"  value="{{ old('borrower_dept') }}" readonly>
                                                                </td>
                                                                <td width="10%"><label class="form-label" for="borrower_post"> Position :</label></td>
                                                                <td colspan="3">
                                                                    <input class="form-control borrower_post" id="borrower_post" name="borrower_post"  value="{{ old('borrower_post') }}" readonly>
                                                                </td>
                                                            </div>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                            
                                            <div class="table-responsive">
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
                                                                        <option value="">Select Department</option>
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
                                                                <td width="10%"><label class="form-label" for="asset_code"><span class="text-danger">*</span> Asset Code :</label></td>
                                                                <td colspan="3">
                                                                    <select class="form-control asset_code" name="asset_code" id="asset_code">
                                                                    </select>
                                                                    @error('asset_code')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                                </td>
                                                                <td width="10%"><label class="form-label" for="asset_name"> Asset Name :</label></td>
                                                                <td colspan="3">
                                                                    <input value="{{ old('asset_name') }}" class="form-control" id="asset_name" name="asset_name"  readonly>
                                                                    @error('asset_name')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                                </td>
                                                            </div>
                                                        </tr>

                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="10%"><label class="form-label" for="model"> Model :</label></td>
                                                                <td colspan="3"><input value="{{ old('model') }}" class="form-control" id="model" name="model" readonly>
                                                                    @error('model')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                                </td>
                                                                <td width="10%"><label class="form-label" for="brand"> Brand :</label></td>
                                                                <td colspan="3"><input value="{{ old('brand') }}" class="form-control" id="brand" name="brand" readonly>
                                                                    @error('brand')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                                </td>
                                                            </div>
                                                        </tr>

                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="10%"><label class="form-label" for="serial_no"> Serial No. :</label></td>
                                                                <td colspan="3"><input value="{{ old('serial_no') }}" class="form-control" id="serial_no" name="serial_no" readonly>
                                                                    @error('serial_no')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                                </td>
                                                                <td width="10%"><label class="form-label" for="storage_location"> Location :</label></td>
                                                                <td colspan="3"><input value="{{ old('storage_location') }}" class="form-control" id="storage_location" name="storage_location" readonly>
                                                                    @error('storage_location')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                                </td>
                                                            </div>
                                                        </tr>

                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="10%"><label class="form-label" for="borrow_date"><span class="text-danger">*</span> Borrow Date :</label></td>
                                                                <td colspan="3"><input type="date" class="form-control" id="borrow_date" name="borrow_date" value="{{ old('borrow_date') }}">
                                                                    @error('borrow_date')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                                </td>
                                                                <td width="10%"><label class="form-label" for="return_date"><span class="text-danger">*</span> Return Date :</label></td>
                                                                <td colspan="3"><input type="date" class="form-control" id="return_date" name="return_date" value="{{ old('return_date') }}">
                                                                    @error('return_date')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                                </td>
                                                            </div>
                                                        </tr>
                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="10%"><label class="form-label" for="reason"><span class="text-danger">*</span> Reason :</label></td>
                                                                <td colspan="6">
                                                                    <textarea rows="5" class="form-control" id="reason" name="reason"></textarea>
                                                                    @error('reason')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                                </td>
                                                            </div>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                            <br>

                                            <button type="submit" class="btn btn-primary ml-auto float-right"><i class="fal fa-save"></i> Save</button>	
                                            <button style="margin-right:5px" type="reset" class="btn btn-danger ml-auto float-right"><i class="fal fa-redo"></i> Reset</button>
                                            <a style="margin-right:5px" href="/borrow-index" onclick="return confirm('Are you sure to discard data?')" class="btn btn-success ml-auto float-right"><i class="fal fa-trash-alt"></i> Discard</a><br><br>
                                            
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
        $('#department_id, #asset_type, #borrower_name, .asset_code').select2();

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
                            var selected = (data[i].id=="{{old('asset_type', $borrow->asset_type)}}") ? "selected='selected'" : '';
                            op+='<option value="'+data[i].id+'" '+selected+'>'+data[i].asset_type+'</option>';
                        }

                        $('.asset_type').html(op);
                    },
                    error:function(){
                        console.log('success');
                    },
                });
            }

        if($('.borrower_name').val()!=''){
                updateCr($('.borrower_name'));
            }

            $(document).on('change','.borrower_name',function(){
                updateCr($(this));
            });

            function updateCr(elem){
                var user_id=elem.val();   

                $.ajax({
                    type:'get',
                    url:'{!!URL::to('findUsers')!!}',
                    data:{'id':user_id},
                    success:function(data)
                    
                    {
                        console.log(data);
                        $('#borrower_id').val(data.id);
                        $('#name').val(data.name);
                        $('#borrower_email').val(data.staff.staff_email);
                        $('#borrower_dept').val(data.staff.staff_dept);
                        $('#borrower_post').val(data.staff.staff_position);
                        $('#borrower_phone').val(data.staff.staff_phone);
                    }
                });
        }

    });

    $(document).ready( function() {

        if($('.asset_type').val()!=''){
                updateType($('.asset_type'));
            }
            $(document).on('change','.asset_type',function(){
                updateType($(this));
            });

            function updateType(elem){
            var eduid=elem.val();
            var op=" "; 

                $.ajax({
                    type:'get',
                    url:'{!!URL::to('findAsset')!!}',
                    data:{'id':eduid},
                    success:function(data2)
                    {
                        console.log(data2)
                        op+='<option value=""> Select Asset </option>';
                        for (var i=0; i<data2.length; i++)
                        {
                            var selected = (data2[i].id=="{{old('asset_code', $borrow->asset_code)}}") ? "selected='selected'" : '';
                            op+='<option value="'+data2[i].id+'" '+selected+'>'+data2[i].asset_code+'</option>';
                        }

                        $('.asset_code').html(op);
                    },
                    error:function(){
                        console.log('success');
                    },
                });
            }
        
        if($('.asset_code').val()!=''){
                updateCr($('.asset_code'));
            }

            $(document).on('change','.asset_code',function(){
                updateCr($(this));
            });

            function updateCr(elem){
                var user_id=elem.val();   

                $.ajax({
                    type:'get',
                    url:'{!!URL::to('findAssets')!!}',
                    data:{'id':user_id},
                    success:function(data)
                    
                    {
                        console.log(data);
                        $('#asset_name').val(data.asset_name);
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
