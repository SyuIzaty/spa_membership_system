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

                        @error('hp_no')
                        <div class="alert alert-success" style="color: #000000; background-color: #ffdf89;"> <i class="icon fal fa-check-circle"></i> {{ $message }}</div>
                        @enderror

                        @error('office_no')
                        <div class="alert alert-success" style="color: #000000; background-color: #ffdf89;"> <i class="icon fal fa-check-circle"></i> {{ $message }}</div>
                        @enderror


                        <div class="panel-container show">
                            <div class="panel-content">
                                <div class="table-responsive">
                                    <table id="info" class="table table-bordered table-hover table-striped w-100">
                                        <thead>
                                            <tr>
                                                <td colspan="3" class="bg-warning text-center" align="center"><h5>Status:  <b>{{strtoupper($activeData->getStatus->first()->description)}}</b></h5></td>
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
                                                <td colspan="2" style="vertical-align: middle">{{strtoupper($user_details->staff_name)}}</td>
                                                <th width="20%" style="vertical-align: middle">Staff ID : </th>
                                                <td colspan="2" style="vertical-align: middle">{{$user_details->staff_id}}</td>
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
                                                <td colspan="2" style="vertical-align: middle">{{$activeData->office_no}}</td>
                                            </tr>
                                            <tr>
                                                <th width="20%" style="vertical-align: middle">Grant Period Eligibility : </th>
                                                <td colspan="2" style="vertical-align: middle; color: red; text-transform: uppercase;"><b>1825 Days (Maximum is 60 Months = 1825 days)</b></td>
                                                <th width="20%" style="vertical-align: middle">Grant Amount Eligibility : </th>
                                                <td colspan="2" style="vertical-align: middle; color: red;"><b>RM 1,500</b></td>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>

                                @role('Computer Grant (IT Admin)')
                                <a class="btn btn-warning ml-auto float-right" data-page="/applicationPDF/{{ $activeData->id }}" onclick="Print(this)" style="color: rgb(0, 0, 0); margin-top: 5px; margin-bottom: 15px;">
                                    <i class="fal fa-download"></i> Export Application
                                </a>
                                @endrole

                                @if ($activeData->status == 1)
                                @role('Computer Grant (IT Admin)')
                                {!! Form::open(['action' => 'ComputerGrantController@verifyApplication', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                <input type="hidden" id="id" name="id" value="{{ $activeData->id }}" required>

                                <div class="table-responsive">
                                    <table id="info" class="table table-bordered table-hover table-striped w-100">
                                        <thead>
                                            <tr>
                                                <td colspan="5" class="bg-primary-50"><label class="form-label"><i class="fal fa-user"></i> IT ADMIN & CE APPROVAL</label></td>
                                            </tr>
                                            <tr>
                                                <th width="20%" style="vertical-align: top"><span class="text-danger">*</span> Upload Application : </th>
                                                <td colspan="4"><input type="file" class="form-control" id="upload_image" name="upload_image" required>

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
                                        <button style="margin-top: 5px;" class="btn btn-danger float-right" id="submit" name="submit"><i class="fal fa-check"></i> Verify Application</button></td>
                                    </div>
                                </div>
                                {!! Form::close() !!}
                                @endrole
                                @endif

                                @if ($activeData->status != '1')
                                <div class="table-responsive">
                                    <table id="info" class="table table-bordered table-hover table-striped w-100">
                                        <thead>
                                            <tr>
                                                <td colspan="5" class="bg-primary-50"><label class="form-label"><i class="fal fa-user"></i> IT ADMIN & CE APPROVAL</label></td>
                                            </tr>
                                            <tr>
                                                <th width="20%" style="vertical-align: top"><span class="text-danger">*</span> Verified Application : </th>
                                                <td colspan="4"><a target="_blank" href="/get-file/{{$verified_doc->upload}}">{{$verified_doc->upload}}</a></td>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                @endif

                                @if ($activeData->status == '3' || $activeData->status == '4' || $activeData->status == '5' || $activeData->status == '6'  )

                                <div class="table-responsive">
                                    <table id="upload" class="table table-bordered table-hover table-striped w-100">
                                        <thead>
                                            <input type="hidden" id="id" name="id" value="{{ $activeData->id }}" required>
                                            <tr>
                                                <td colspan="5" class="bg-primary-50"><label class="form-label"><i class="fal fa-file"></i> DETAILS OF PURCHASE</label></td>
                                            </tr>
                                            <tr>
                                                <th width="20%" style="vertical-align: middle"><span class="text-danger">*</span> Type of Device : </th>
                                                <td colspan="2" style="vertical-align: middle">{{$activeData->getType->first()->description}}</td>
                                                <th width="20%" style="vertical-align: middle"><span class="text-danger">*</span> Serial No : </th>
                                                <td colspan="2" style="vertical-align: middle">{{$activeData->serial_no}}</td>
                                            </tr>
                                            <tr>
                                                <th width="20%" style="vertical-align: middle"><span class="text-danger">*</span> Brand : </th>
                                                <td colspan="2" style="vertical-align: middle">{{$activeData->brand}}</td>
                                                <th width="20%" style="vertical-align: middle"><span class="text-danger">*</span> Model : </th>
                                                <td colspan="2" style="vertical-align: middle">{{$activeData->model}}</td>
                                            </tr>
                                            <tr>
                                                <th width="20%" style="vertical-align: middle"><span class="text-danger">*</span> Purchase Receipt : </th>
                                                <td colspan="2">
                                                    @if ($proof->isNotEmpty())
                                                        <a target="_blank" href="/get-receipt/{{$proof->where('type',1)->first()->upload}}">{{$proof->where('type',1)->first()->upload}}</a>
                                                    @endif
                                                </td>
                                                <th width="20%" style="vertical-align: middle"><span class="text-danger">*</span> Device Image : </th>
                                                <td colspan="2">
                                                    @if ($proof->isNotEmpty())
                                                        <a target="_blank" href="/get-image/{{$proof->where('type',2)->first()->upload}}">{{$proof->where('type',2)->first()->upload}}</a>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th width="20%" style="vertical-align: top"><span class="text-danger">*</span> Price : RM</th>
                                                <td colspan="4" style="vertical-align: middle">{{$activeData->price}}</td>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                @endif

                                @if ($activeData->status == 3)
                                @role('Computer Grant (IT Admin)')
                                {!! Form::open(['action' => 'ComputerGrantController@verifyPurchase', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                <input type="hidden" id="id" name="id" value="{{ $activeData->id }}" required>

                                <div class="table-responsive">
                                    <div class="form-group">
                                        <button style="margin-top: 5px;" class="btn btn-danger float-right" id="submit" name="submit"><i class="fal fa-check"></i> Verify Purchase</button></td>
                                    </div>
                                </div>
                                @endrole
                                {!! Form::close() !!}

                                @elseif ($activeData->status == 4)
                                @role('Computer Grant (Finance Admin)')
                                {!! Form::open(['action' => 'ComputerGrantController@verifyReimbursement', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                <input type="hidden" id="id" name="id" value="{{ $activeData->id }}" required>

                                <div class="table-responsive">
                                    <div class="form-group">
                                        <button style="margin-top: 5px;" class="btn btn-danger float-right" id="submit" name="submit"><i class="fal fa-check"></i> Complete Reimbursement</button></td>
                                    </div>
                                </div>
                                @endrole
                                {!! Form::close() !!}
                                @endif

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

