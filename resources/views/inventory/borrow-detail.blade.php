@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-cogs'></i> BORROWER DETAILS
        </h1>
    </div>

        <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2 style="font-size: 20px;">
                            BORROW ID : #{{ $borrow->id}}
                        </h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>

                    <div class="panel-container show">
                        <div class="panel-content">
                               
                            <div class="row">

                                <div class="col-sm-12 mb-4">
                                    {!! Form::open(['action' => ['BorrowController@borrowUpdate'], 'method' => 'POST', 'enctype' => 'multipart/form-data'])!!}
                                    {{Form::hidden('id', $borrow->id)}}
                                        <div class="card card-primary card-outline">
                                            <div class="card-header">
                                                <h5 class="card-title w-100"><i class="fal fa-cube width-2 fs-xl"></i>BORROW DETAILS</h5>
                                            </div>
                                            <div class="card-body">
                                                @if (Session::has('notification'))
                                                    <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('notification') }}</div>
                                                @endif
                                                <div class="table-responsive">
                                                    <table id="asset" class="table table-bordered table-hover table-striped w-100 mb-1">
                                                        <thead>
                                                            <div style="float: right"><i><b>Updated Date : </b>{{ date(' j F Y | h:i:s A', strtotime($borrow->updated_at) )}}</i></div><br>
                                                            <p style="margin-bottom: -15px"><span class="text-danger">*</span> Required fields</p>
                                                            <tr class="bg-primary-50">
                                                                <div class="form-group">
                                                                    <td colspan="6"><label class="form-label"> BORROWER PROFILE</label></td>
                                                                </div>
                                                            </tr>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td width="15%"><label class="form-label" for="department_id"> Staff ID : </label></td>
                                                                    <td colspan="3">
                                                                        <input class="form-control" id="department_id" style="cursor:context-menu" name="department_id" value="{{ $borrow->borrower_id }}" readonly>
                                                                    </td>
                                                                    <td width="15%"><label class="form-label" for="staff_name"> Name : </label></td>
                                                                    <td colspan="3">
                                                                        <input class="form-control" id="staff_name" style="cursor:context-menu" name="staff_name" value="{{ $borrow->borrower->staff_name }}" readonly>
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td width="15%"><label class="form-label" for="staff_email"> Email : </label></td>
                                                                    <td colspan="3">
                                                                        <input class="form-control" id="staff_email" style="cursor:context-menu" name="staff_email" value="{{ $borrow->borrower->staff_email }}" readonly>
                                                                    </td>
                                                                    <td width="15%"><label class="form-label" for="staff_phone"> Phone No. :</label></td>
                                                                    <td colspan="3">
                                                                        <input class="form-control" id="staff_phone" style="cursor:context-menu" name="staff_phone" value="{{ $borrow->borrower->staff_phone }}" readonly>
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td width="15%"><label class="form-label" for="staff_dept"> Department : </label></td>
                                                                    <td colspan="3">
                                                                        <input class="form-control" id="staff_dept" style="cursor:context-menu" name="staff_dept" value="{{ $borrow->borrower->staff_dept }}" readonly>
                                                                    </td>
                                                                    <td width="15%"><label class="form-label" for="staff_position"> Position:</label></td>
                                                                    <td colspan="3">
                                                                        <input class="form-control" id="staff_position" style="cursor:context-menu" name="staff_position" value="{{ $borrow->borrower->staff_position }}" readonly>
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                        </thead>
                                                    </table>

                                                    <table id="asset" class="table table-bordered table-hover table-striped w-100 mb-1">
                                                        <thead>
                                                            <tr class="bg-primary-50">
                                                                <div class="form-group">
                                                                    <td colspan="6"><label class="form-label"> ASSET INFO</label></td>
                                                                </div>
                                                            </tr>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td width="15%"><label class="form-label" for="department_id"> Asset Code : </label></td>
                                                                    <td colspan="3">
                                                                        <input class="form-control" id="department_id" style="cursor:context-menu" name="department_id" value="{{ $borrow->asset->asset_code }}" readonly>
                                                                    </td>
                                                                    <td width="15%"><label class="form-label" for="staff_name"> Asset Name : </label></td>
                                                                    <td colspan="3">
                                                                        <input class="form-control" id="staff_name" style="cursor:context-menu" name="staff_name" value="{{ $borrow->asset->asset_name }}" readonly>
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td width="15%"><label class="form-label" for="staff_email"> Asset Type : </label></td>
                                                                    <td colspan="3">
                                                                        <input class="form-control" id="staff_email" style="cursor:context-menu" name="staff_email" value="{{ $borrow->asset->type->asset_type }}" readonly>
                                                                    </td>
                                                                    <td width="15%"><label class="form-label" for="staff_phone"> Serial No. :</label></td>
                                                                    <td colspan="3">
                                                                        <input class="form-control" id="staff_phone" style="cursor:context-menu" name="staff_phone" value="{{ $borrow->asset->serial_no }}" readonly>
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td width="15%"><label class="form-label" for="staff_dept"> Model : </label></td>
                                                                    <td colspan="3">
                                                                        <input class="form-control" id="staff_dept" style="cursor:context-menu" name="staff_dept" value="{{ $borrow->asset->model }}" readonly>
                                                                    </td>
                                                                    <td width="15%"><label class="form-label" for="staff_position"> Brand:</label></td>
                                                                    <td colspan="3">
                                                                        <input class="form-control" id="staff_position" style="cursor:context-menu" name="staff_position" value="{{ $borrow->asset->brand }}" readonly>
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td width="15%"><label class="form-label" for="staff_dept"> Location : </label></td>
                                                                    <td colspan="3">
                                                                        <input class="form-control" id="staff_dept" style="cursor:context-menu" name="staff_dept" value="{{ $borrow->asset->storage_location }}" readonly>
                                                                    </td>
                                                                    <td width="15%"><label class="form-label" for="created_by"> Created By : </label></td>
                                                                    <td colspan="3">
                                                                        <input class="form-control" style="cursor:context-menu" id="created_by" name="created_by" value="{{ $borrow->borrower->staff_name }}" readonly>
                                                                        @error('created_by')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td width="15%"><label class="form-label" for="borrow_date"><span class="text-danger">*</span> Borrow Date : </label></td>
                                                                    <td colspan="3">
                                                                        <input type="date" class="form-control" id="borrow_date" name="borrow_date" value="{{ isset($borrow->borrow_date) ? date('Y-m-d', strtotime($borrow->borrow_date)) : old('borrow_date') }}" />
                                                                        @error('borrow_date')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror
                                                                    </td>
                                                                    <td width="15%"><label class="form-label" for="return_date"><span class="text-danger">*</span> Return Date:</label></td>
                                                                    <td colspan="3">
                                                                        <input type="date" class="form-control" id="return_date" name="return_date" value="{{ isset($borrow->return_date) ? date('Y-m-d', strtotime($borrow->return_date)) : old('return_date')  }}" />
                                                                        @error('return_date')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td width="15%"><label class="form-label" for="reason"><span class="text-danger">*</span> Reason : </label></td>
                                                                    <td colspan="3">
                                                                        <textarea rows="5" class="form-control" id="reason" name="reason">{{ $borrow->reason }}</textarea>
                                                                        @error('reason')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror
                                                                    </td>
                                                                    <td width="15%"><label class="form-label" for="status">Current Status:</label></td>
                                                                    <td colspan="3">
                                                                        @if($borrow->status=='1')
                                                                            <div class="ml-2" style="text-transform: uppercase; color:#CC0000"><b>{{ isset($borrow->borrow_status->status_name) ? $borrow->borrow_status->status_name : '--' }}</b></div>
                                                                        @else 
                                                                            <div class="ml-2" style="text-transform: uppercase; color:#3CBC3C"><b>{{ isset($borrow->borrow_status->status_name) ? $borrow->borrow_status->status_name : '--' }}</b></div>
                                                                        @endif
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                            
                                                        </thead>
                                                    </table>

                                                    <table id="asset" class="table table-bordered table-hover table-striped w-100 mb-1">
                                                        <thead>
                                                            <tr class="bg-primary-50">
                                                                <div class="form-group">
                                                                    <td colspan="6"><label class="form-label"> RETURN INFO</label></td>
                                                                </div>
                                                            </tr>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td width="15%"><label class="form-label" for="created_by"><span class="text-danger">*</span> Verifier : </label></td>
                                                                    <td colspan="3">
                                                                        <select class="form-control verified_by" name="verified_by" id="verified_by" >
                                                                            <option value=""> Select Verifier </option>
                                                                            @foreach ($user as $usr) 
                                                                                <option value="{{ $usr->id }}" {{ old('verified_by', ($borrow->users ? $borrow->users->id : '')) ==  $usr->id  ? 'selected' : '' }}>{{ $usr->name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        @error('verified_by')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror
                                                                    </td>
                                                                    <td width="15%"><label class="form-label" for="actual_return_date"><span class="text-danger">*</span> Actual Return Date:</label></td>
                                                                    <td colspan="3">
                                                                        <input type="date" class="form-control" id="actual_return_date" name="actual_return_date" value="{{ old('actual_return_date') ?? $borrow->actual_return_date }}">
                                                                        @error('actual_return_date')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td width="15%"><label class="form-label" for="remark"> Remark : </label></td>
                                                                    <td colspan="6">
                                                                        <textarea rows="5" class="form-control" id="remark" name="remark">{{ old('remark') ?? $borrow->remark }}</textarea>
                                                                        @error('remark')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror
                                                                    </td>
                                                                    {{-- <td width="15%"><label class="form-label" for="status"><span class="text-danger">*</span> Change Status:</label></td>
                                                                    <td colspan="3">
                                                                        <select class="form-control status" name="status" id="status">
                                                                            <option value="">Select Status</option>
                                                                            @foreach ($status as $stat) 
                                                                                <option value="{{ $stat->id }}" {{ $borrow->status == $stat->id ? 'selected="selected"' : '' }}>{{ $stat->status_name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        @error('status')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror
                                                                    </td> --}}
                                                                </div>
                                                            </tr>
                                                            
                                                        </thead>
                                                    </table>

                                                    <br>
                                                    <button type="submit" class="btn btn-primary ml-auto float-right"><i class="fal fa-save"></i> Update</button>
                                                    <a style="margin-right:5px" href="{{ url()->previous() }}" class="btn btn-success ml-auto float-right"><i class="fal fa-arrow-alt-left"></i> Back</a><br><br>
                                                </div>
                                            </div>
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

    $(document).ready(function()
    {
        $('#status, .verified_by').select2();

        $('.department, .custodian_id').select2({ 
            dropdownParent: $("#crud-modal") 
        });

        $('#new').click(function () {
            $('#crud-modal').modal('show');
        });

        $('#crud-modal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) 
            var depart = button.data('depart') 

            document.getElementById("depart").value = depart;
        });

        $('#news').click(function () {
            $('#crud-modals').modal('show');
        });

        $('#crud-modals').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) 
            var id = button.data('id') 
            var custodian = button.data('custodian')
            var reason = button.data('reason')

            $('.modal-body #ids').val(id); 
            $('.modal-body #custodian').val(custodian); 
            $('.modal-body #reason').val(reason); 
        });

    });

    function Print(button)
    {
        var url = $(button).data('page');
        var printWindow = window.open( '{{url("/")}}'+url+'', 'Print', 'left=200, top=200, width=950, height=500, toolbar=0, resizable=0');
        printWindow.addEventListener('load', function(){
            printWindow.print();
        }, true);
    }

</script>

@endsection
