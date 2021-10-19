@extends('layouts.admin')

@section('content')

<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">

    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr bg-primary">
                    <h2 style="color: white;">
                        GRANT APPLICATION</b>
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

                        @if(session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                        @endif

                        @error('price')
                        <div class="alert alert-success" style="color: #000000; background-color: #ffdf89;"> <i class="icon fal fa-check-circle"></i> {{ $message }}</div>
                        @enderror

                        <div class="panel-container show">
                            <div class="panel-content">
                                <div class="table-responsive">
                                    <table id="info" class="table table-bordered table-hover table-striped w-100">
                                        <thead>
                                            <tr>
                                                <td colspan="3" class="bg-warning text-center" align="center"><h5>Status:  <b>{{ strtoupper($activeData->getStatus->first()->description) }}</b></h5></td>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>

                                <div class="table-responsive">
                                    <table id="info" class="table table-bordered table-hover table-striped w-100">
                                        <thead>
                                            <tr>
                                                <td colspan="5" class="bg-primary-50"><label class="form-label"><i class="fal fa-user"></i> APPLICANT INFORMATION</label></td>
                                            </tr>
                                            <tr>
                                                <th width="20%" style="vertical-align: middle">Ticket No : </th>
                                                <td colspan="2" style="vertical-align: middle">{{isset($activeData->ticket_no) ? $activeData->ticket_no : '-'}}</td>
                                                <th width="20%" style="vertical-align: middle">Staff Email : </th>
                                                <td colspan="2" style="vertical-align: middle">{{isset($user_details->staff_email) ? $user_details->staff_email : '-'}}</td>
                                            </tr>

                                            <tr>
                                                <th width="20%" style="vertical-align: middle">Staff Name : </th>
                                                <td colspan="2" style="vertical-align: middle">{{strtoupper($user->name)}}</td>
                                                <th width="20%" style="vertical-align: middle">Staff ID : </th>
                                                <td colspan="2" style="vertical-align: middle">{{$user->username}}</td>
                                            </tr>
                                            <tr>
                                                <th width="20%" style="vertical-align: middle">Staff Department : </th>
                                                <td colspan="2" style="vertical-align: middle">{{isset($user_details->staff_dept) ? $user_details->staff_dept : '-' }}</td>
                                                <th width="20%" style="vertical-align: middle">Staff Designation : </th>
                                                <td colspan="2" style="vertical-align: middle">{{isset($user_details->staff_position) ? $user_details->staff_position : '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th width="20%" style="vertical-align: middle"></span> Staff H/P No. : </th>
                                                <td colspan="2" style="vertical-align: middle">{{$activeData->hp_no}}</td>
                                                <th width="20%" style="vertical-align: middle"></span> Staff Office No. : </th>
                                                <td colspan="2" style="vertical-align: middle">{{isset($activeData->office_no) ? $activeData->office_no : '-'}}</td>
                                            </tr>
                                            <tr>
                                                <th width="20%" style="vertical-align: middle">Grant Period Eligibility : </th>
                                                <td colspan="2" style="vertical-align: middle; color: red;"><b>5 Years (60 Months)</b></td>
                                                <th width="20%" style="vertical-align: middle">Grant Amount Eligibility : </th>
                                                <td colspan="2" style="vertical-align: middle; color: red;"><b>RM 1,500</b></td>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                
                                @if (($activeData->status == 1) || ($activeData->status == 2) || ($activeData->status == 3))
                                <form id="form-id">
                                    @csrf
                                    <input type="hidden" id="id" name="id" value="{{ $activeData->id }}" required>
                                    <button type="submit" class="btn btn-danger ml-auto float-right mr-2 waves-effect waves-themed" id="cancel" style="margin-bottom:10px;"><i class="fal fa-times-circle"></i> Request for Cancellation</button>
                                </form>  
                                @endif

                                @if (($activeData->status == 2) || ($activeData->status == 3) || ($activeData->status == 4) || ($activeData->status == 5) || ($activeData->status == 6))
                                <div class="table-responsive">
                                    <table id="info" class="table table-bordered table-hover table-striped w-100">
                                        <thead>
                                            <tr>
                                                <td colspan="5" class="bg-primary-50"><label class="form-label"><i class="fal fa-user"></i> IT ADMIN & CE APPROVAL</label></td>
                                            </tr>
                                            <tr>
                                                <th width="20%" style="vertical-align: top">Verified Application : </th>
                                                <td colspan="4">
                                                    <ul>
                                                        @foreach ( $verified_doc as $v )
                                                        <li>  <a target="_blank" href="/get-file/{{$v->upload}}">{{$v->upload}}</a> </li>
                                                        @endforeach
                                                    </ul> 
                                                </td>                                           
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                @endif

                                @if ($activeData->status == 2)
                                <div class="table-responsive">
                                    <table id="upload" class="table table-bordered table-hover table-striped w-100">
                                        <thead>
                                            {!! Form::open(['action' => 'ComputerGrantController@update', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                            <input type="hidden" id="id" name="id" value="{{ $activeData->id }}" required>
                                            <tr>
                                                <td colspan="5" class="bg-primary-50"><label class="form-label"><i class="fal fa-file"></i> DETAILS OF PURCHASE</label></td>
                                            </tr>
                                            <tr>
                                                <th width="20%" style="vertical-align: middle"><span class="text-danger">*</span> Type of Device : </th>
                                                <td colspan="2">
                                                    <select class="form-control kategori" name="type" id="type" required >
                                                        <option disabled>Choose Type of Device</option>
                                                        @foreach ($deviceType as $d)
                                                            <option value="{{ $d->id }}" {{ old('type') == $d->id  ? 'selected' : '' }}>{{ $d->description }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <th width="20%" style="vertical-align: middle"><span class="text-danger">*</span> Serial No : </th>
                                                <td colspan="2"><input class="form-control" id="serial_no" name="serial_no" value="{{ old('serial_no') }}" required></td>
                                            </tr>
                                            <tr>
                                                <th width="20%" style="vertical-align: middle"><span class="text-danger">*</span> Brand : </th>
                                                <td colspan="2"><input class="form-control" id="brand" name="brand" value="{{ old('brand') }}" required></td>
                                                <th width="20%" style="vertical-align: middle"><span class="text-danger">*</span> Model : </th>
                                                <td colspan="2"><input class="form-control" id="model" name="model" value="{{ old('model') }}" required></td>
                                            </tr>
                                            <tr>
                                                <th width="20%" style="vertical-align: middle"><span class="text-danger">*</span> Purchase Receipt : </th>
                                                <td colspan="2">

                                                    <input type="file" class="form-control" id="receipt" name="receipt" required>

                                                    @error('receipt')
                                                        <p style="color: red">{{ $message }}</p>
                                                    @enderror
                                                </td>
                                                <th width="20%" style="vertical-align: middle"><span class="text-danger">*</span> Device Image : </th>
                                                <td colspan="2">

                                                    <input type="file" class="form-control" id="upload_image" name="upload_image" required>

                                                    @error('upload_image')
                                                        <p style="color: red">{{ $message }}</p>
                                                    @enderror
                                                </td>
                                            </tr>
                                            <tr>
                                                <th width="20%" style="vertical-align: top"><span class="text-danger">*</span> Price : RM</th>
                                                <td colspan="4"><input class="form-control" id="price" name="price" value="{{ old('price') }}" required></td>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>

                                <div class="table-responsive">
                                    <div class="form-group">
                                        <button style="margin-top: 5px;" class="btn btn-danger float-right" id="submit" name="submit"><i class="fal fa-check"></i> Save</button></td>
                                    </div>
                                </div>
                                {!! Form::close() !!}

                                @elseif (($activeData->status == '3') || ($activeData->status == '4') || ($activeData->status == '5'))

                                <div class="table-responsive">
                                    <table id="upload" class="table table-bordered table-hover table-striped w-100">
                                        <thead>
                                            <input type="hidden" id="id" name="id" value="{{ $activeData->id }}" required>
                                            <tr>
                                                <td colspan="5" class="bg-primary-50"><label class="form-label"><i class="fal fa-file"></i> DETAILS OF PURCHASE</label></td>
                                            </tr>
                                            <tr>
                                                <th width="20%" style="vertical-align: middle">Type of Device : </th>
                                                <td colspan="2" style="vertical-align: middle">{{$activeData->getType->first()->description}}</td>
                                                <th width="20%" style="vertical-align: middle">Serial No : </th>
                                                <td colspan="2" style="vertical-align: middle">{{$activeData->serial_no}}</td>
                                            </tr>
                                            <tr>
                                                <th width="20%" style="vertical-align: middle">Brand : </th>
                                                <td colspan="2" style="vertical-align: middle">{{$activeData->brand}}</td>
                                                <th width="20%" style="vertical-align: middle">Model : </th>
                                                <td colspan="2" style="vertical-align: middle">{{$activeData->model}}</td>
                                            </tr>
                                            <tr>
                                                <th width="20%" style="vertical-align: middle">Purchase Receipt : </th>
                                                <td colspan="2">
                                                    @if ($proof->isNotEmpty())
                                                        <a target="_blank" href="/get-receipt/{{$proof->where('type',1)->first()->upload}}">{{$proof->where('type',1)->first()->upload}}</a>
                                                    @endif
                                                </td>
                                                <th width="20%" style="vertical-align: middle">Device Image : </th>
                                                <td colspan="2">
                                                    @if ($proof->isNotEmpty())
                                                        <a target="_blank" href="/get-image/{{$proof->where('type',2)->first()->upload}}">{{$proof->where('type',2)->first()->upload}}</a>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th width="20%" style="vertical-align: top">Price : RM</th>
                                                <td colspan="4" style="vertical-align: middle">{{$activeData->price}}</td>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>

                                <!-- <a class="btn btn-info ml-auto float-right" data-page="/agreementPDF/{{ $activeData->id }}" onclick="Print(this)" style="color: rgb(0, 0, 0); margin-top: 5px; margin-bottom: 15px;">
                                    <i class="fal fa-download"></i> Export Application
                                </a> -->
                                @endif

                                @if ($activeData->status == '4')
                                    @if ($agreement_doc->isEmpty())
                                        {!! Form::open(['action' => 'ComputerGrantController@uploadAgreement', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                        <input type="hidden" id="id" name="id" value="{{ $activeData->id }}" required>

                                        <div class="table-responsive">
                                            <table id="info" class="table table-bordered table-hover table-striped w-100">
                                                <thead>
                                                    <tr>
                                                        <td colspan="5" class="bg-primary-50"><label class="form-label"><i class="fal fa-user"></i> GRANT ACCEPTANCE</label></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="5">Kindly download verified files above, then upload the signed files.</td>
                                                    </tr>
                                                    <tr>
                                                        <th width="20%" style="vertical-align: top"><span class="text-danger">*</span> Upload Signed Declaration files: </th>
                                                        <td colspan="4"><input type="file" class="form-control" id="upload_image" name="upload_image[]" multiple required>

                                                            @error('upload_image')
                                                                <p style="color: red">{{ $message }}</p>
                                                            @enderror
                                                        </td>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>

                                        <div class="table-responsive">
                                            <div class="form-group">
                                                <button style="margin-top: 5px;" class="btn btn-danger float-right" id="submit" name="submit"><i class="fal fa-check"></i> Submit Declaration</button></td>
                                            </div>
                                        </div>
                                        {!! Form::close() !!}

                                        @else
                                        <div class="table-responsive">
                                            <table id="info" class="table table-bordered table-hover table-striped w-100">
                                                <thead>
                                                    <tr>
                                                        <td colspan="5" class="bg-primary-50"><label class="form-label"><i class="fal fa-user"></i> GRANT ACCEPTANCE</label></td>
                                                    </tr>
                                                    <tr>
                                                        <th width="20%" style="vertical-align: top">Signed Declaration : </th>
                                                        <td colspan="4">
                                                            <ul>
                                                                @foreach ( $agreement_doc as $a )
                                                                <li>  <a target="_blank" href="/get-file/{{$a->upload}}">{{$a->upload}}</a> </li>
                                                                @endforeach
                                                            </ul> 
                                                        </td>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    @endif
                                @endif
                                    @if (($activeData->status == '5') || ($activeData->status == '6'))
                                        <div class="table-responsive">
                                            <table id="info" class="table table-bordered table-hover table-striped w-100">
                                                <thead>
                                                    <tr>
                                                        <td colspan="5" class="bg-primary-50"><label class="form-label"><i class="fal fa-user"></i> GRANT ACCEPTANCE</label></td>
                                                    </tr>
                                                    <tr>
                                                        <th width="20%" style="vertical-align: top">Signed Declaration : </th>
                                                        <td colspan="4">
                                                            <ul>
                                                                @foreach ( $agreement_doc as $a )
                                                                <li>  <a target="_blank" href="/get-file/{{$a->upload}}">{{$a->upload}}</a> </li>
                                                                @endforeach
                                                            </ul> 
                                                        </td>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr bg-primary">
                    <h2 style="color: white;">
                        GRANT INFORMATION HISTORY</b>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>

                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="table-responsive">
                            <table id="application" class="table table-bordered table-hover table-striped w-100">
                                <thead>
                                    <tr class="bg-primary-50 text-center">
                                        <th class="text-center">Ticket No.</th>
                                        <th class="text-center">Staff Department/Position</th>
                                        <th class="text-center">Grant Status</th>
                                        <th class="text-center">Total Price</th>
                                        <th class="text-center">Grant Amount/Period</th>
                                        <th class="text-center">Type</th>
                                        <th class="text-center">Brand/Model/Serial No.</th>
                                        <th class="text-center">Expiry Date</th>
                                        <th class="text-center">Remaining Grant Period</th>
                                        <th class="text-center">Balance Penalty</th>
                                        <th class="text-center">View</th>
                                        <th class="text-center">Activity Log</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="hasinput"></td>
                                        <td class="hasinput"></td>
                                        <td class="hasinput"></td>
                                        <td class="hasinput"></td>
                                        <td class="hasinput"></td>
                                        <td class="hasinput"></td>
                                        <td class="hasinput"></td>
                                        <td class="hasinput"></td>
                                        <td class="hasinput"></td>
                                        <td class="hasinput"></td>
                                        <td class="hasinput"></td>
                                        <td class="hasinput"></td>
                                    </tr>
                                </tbody>
                            </table>
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
    
    function Print(button)
        {
            var url = $(button).data('page');
            var printWindow = window.open( '{{url("/")}}'+url+'', 'Print', 'left=200, top=200, width=950, height=500, toolbar=0, resizable=0');
            printWindow.addEventListener('load', function(){
            printWindow.print();
            }, true);
        }

    $(document).ready(function()
    {
        var table = $('#application').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/datalist",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { className: 'text-center', data: 'ticket_no', name: 'ticket_no' },
                    { className: 'text-center', data: 'details', name: 'details' },
                    { className: 'text-center', data: 'status', name: 'status' },
                    { className: 'text-center', data: 'price', name: 'price' },
                    { className: 'text-center', data: 'amount', name: 'amount' },
                    { className: 'text-center', data: 'type', name: 'type' },
                    { className: 'text-center', data: 'purchase', name: 'purchase' },
                    { className: 'text-center', data: 'expiryDate', name: 'expiryDate' },
                    { className: 'text-center', data: 'remainingPeriod', name: 'remainingPeriod' },
                    { className: 'text-center', data: 'penalty', name: 'penalty' },
                    { className: 'text-center', data: 'action', name: 'action', orderable: false, searchable: false},
                    { className: 'text-center', data: 'log', name: 'log', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 1, "asc" ]],
                "initComplete": function(settings, json) {

                }
        });
    });

    $("#cancel").on('click', function(e) {
            e.preventDefault();

            var datas = $('#form-id').serialize();

            Swal.fire({
                title: 'Are you sure you want to cancel this application?',
                text: "Data cannot be restored!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Cancel!',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.value) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        type: "POST",
                        url: "{{ url('requestCancellation')}}",
                        data: datas,
                        dataType: "json",
                        success: function (response) {
                        console.log(response);
                        if(response){
                        Swal.fire(response.success);
                        location.reload();
                    }
                        }
                    });
                }
            })
        });

</script>
@endsection

