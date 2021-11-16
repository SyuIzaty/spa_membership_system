@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-cogs'></i> STAFF RECORD DETAIL {{ $selectedYear }}
        </h1>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        StaffID : #{{ $staff->staff_id }}
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
                            <div class="col-auto">
                                <form action="{{ url('record-info/'. $id) }}" method="GET" id="form_find">
                                    <div class="form-group">
                                        <label> Year Selection : </label>
                                        <select class="selectfilter form-control" name="year" id="year">
                                            @foreach ($year as $years)
                                                <option value="{{ $years->year }}" {{ $selectedYear == $years->year ? 'selected' : '' }}>{{ $years->year }}</option>
                                            @endforeach
                                        </select> 
                                    </div>
                                </form>
                                <br>
                                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                    <a class="nav-link mb-2 active" id="current-tab" data-toggle="pill" href="#current" role="tab" aria-controls="current" aria-selected="false" style="border: 1px solid;">
                                        <i class="fal fa-info-circle"></i>
                                        <span class="hidden-sm-down ml-1"> TRAINING RECORD <b style="font-weight: 900">{{ $selectedYear }}</b></span>
                                    </a>
                                    <a class="nav-link mb-2" id="history-tab" data-toggle="pill" href="#history" role="tab" aria-controls="history" aria-selected="false" style="border: 1px solid;">
                                        <i class="fal fa-road"></i>
                                        <span class="hidden-sm-down ml-1"> CLAIM HISTORY <b style="font-weight: 900">{{ $selectedYear }}</b></span>
                                    </a>
                                </div>
                            </div>
                            
                            <div class="col">
                                <div class="tab-content" id="v-pills-tabContent">
                                    <div class="tab-pane mt-1 active" id="current" role="tabpanel"><br>
                                        <div class="col-sm-12 mb-4">
                                            <div class="card card-primary card-outline mb-4">
                                                <div class="card-header">
                                                    <h5 class="card-title w-100"><i class="fal fa-cube width-2 fs-xl"></i> STAFF PROFILE 
                                                        @if($data_status->status == '4') 
                                                           [ <span class="badge badge-success" style="padding: 0.4em 0.8em;font-size: 12px"><b>{{ $data_status->record_status->status_name}} </b></span> ]
                                                        @else
                                                           [ <span class="badge badge-duplicate" style="padding: 0.4em 0.8em;font-size: 12px"><b>{{ $data_status->record_status->status_name}} </b></span> ]
                                                        @endif
                                                        @if($data_training->first() != null)
                                                            <a data-page="/claim-slip/{{ $staff->staff_id }}/{{ $selectedYear }}/" class="float-right" style="cursor: pointer; margin-right: 25px" onclick="Print(this)"><i class="fal fa-file-pdf" style="color: red; font-size: 25px"></i></a>
                                                        @endif
                                                    </h5>
                                                </div>
                                                <div class="card-body m-3">
                                                    <center><img src="{{ asset('img/intec_logo_new.png') }}" style="height: 120px; width: 320px;"></center><br>
                                                    <h4 style="text-align: center">
                                                        <b>INTEC EDUCATION COLLEGE TRAINING HOUR RECORDS</b>
                                                    </h4>
                                                    <br>
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-hover table-striped w-100">
                                                            <thead>
                                                                <tr>
                                                                    <th width="15%">Name : </th>
                                                                    <td colspan="4">{{ $staff->staff_name ?? '--' }}</td>
                                                                    <th width="15%">ID/IC Number : </th>
                                                                    <td colspan="4">{{ $staff->staff_id ?? '--' }} ( {{ $staff->staff_ic ?? '--' }} )</td>
                                                                </tr>
                                                                <tr>
                                                                    <th width="15%">Email : </th>
                                                                    <td colspan="4">{{ $staff->staff_email ?? '--' }}</td>
                                                                    <th width="15%">Phone No : </th>
                                                                    <td colspan="4">{{ $staff->staff_phone ?? '--' }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th width="15%">Position : </th>
                                                                    <td colspan="4">{{ $staff->staff_position ?? '--' }}</td>
                                                                    <th width="15%">Department : </th>
                                                                    <td colspan="4">{{ $staff->staff_dept ?? '--' }}</td>
                                                                </tr>
                                                                
                                                            </thead>
                                                        </table>
                                                    </div>
                                                    <div class="table-responsive">
                                                        <table class="table mt-5 table-striped">
                                                            <thead>
                                                                <tr style="white-space: nowrap">
                                                                    <th class="text-center border-top-0 table-scale-border-bottom fw-700"></th>
                                                                    <th class="border-top-0 table-scale-border-bottom fw-700">Title</th>
                                                                    <th class="border-top-0 table-scale-border-bottom fw-700">Start Date</th>
                                                                    <th class="border-top-0 table-scale-border-bottom fw-700">End Date</th>
                                                                    <th class="border-top-0 table-scale-border-bottom fw-700">Venue</th>
                                                                    <th class="border-top-0 table-scale-border-bottom fw-700">Type</th>
                                                                    <th class="border-top-0 table-scale-border-bottom fw-700">Category</th>
                                                                    <th class="text-right border-top-0 table-scale-border-bottom fw-700">Approve Hours</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            @if($data_training->first() != null)
                                                                @foreach ($data_training as $key => $details)
                                                                    <tr style="text-transform: uppercase">
                                                                        <td class="text-center fw-700">{{ $no++ }}</td>
                                                                        <td class="text-left strong">{{ $details->title}}</td>
                                                                        <td class="text-left">{{ $details->start_date}}</td>
                                                                        <td class="text-left">{{ $details->end_date}}</td>
                                                                        <td class="text-left">{{ $details->venue}}</td>
                                                                        <td class="text-left">{{ $details->types->type_name}}</td>
                                                                        <td class="text-left">{{ $details->categories->category_name}}</td>
                                                                        <td class="text-right">{{ $details->approved_hour}}</td>
                                                                    </tr>
                                                                @endforeach
                                                            @else 
                                                                <td colspan="8" class="text-center">-- No Data Available --</td>
                                                            @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-4 ml-sm-auto">
                                                            <div class="table-responsive">
                                                                <table class="table table-clean">
                                                                    <tbody>
                                                                        <tr class="table-scale-border-top border-left-0 border-right-0 border-bottom-0">
                                                                            <td class="text-left keep-print-font">
                                                                                <h5 class="m-0 fw-700 h4 keep-print-font color-primary-700">Overall Required Training Hours</h5>
                                                                            </td>
                                                                            <td class="text-right keep-print-font">
                                                                                <h5 class="m-0 fw-700 h4 keep-print-font">{{ $yearly_hour->training_hour ?? '--' }}</h5>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="text-left keep-print-font">
                                                                                <h5 class="m-0 fw-700 h4 keep-print-font color-primary-700">Total Current Training Hours</h5>
                                                                            </td>
                                                                            <td class="text-right keep-print-font">
                                                                                <h5 class="m-0 fw-700 h4 keep-print-font text-danger">{{ $current_hours }}</h5>
                                                                            </td>
                                                                        </tr>
                                                                        <?php 
                                                                            if(isset($yerly_hour->training_hour)) {
                                                                                $balance = $yearly_hour->training_hour - $current_hours;
                                                                            } else {
                                                                                $balance = 0;
                                                                            }
                                                                        ?>
                                                                        <tr>
                                                                            <td class="text-left keep-print-font">
                                                                                <h5 class="m-0 fw-700 h4 keep-print-font color-primary-700">( - ) Total Balance Training Hours</h5>
                                                                            </td>
                                                                            <td class="text-right keep-print-font">
                                                                                <h5 class="m-0 fw-700 h4 keep-print-font text-danger">
                                                                                    @if($balance >= 0)
                                                                                        {{ number_format((float)$balance, 2, '.', '') ?? '0' }}
                                                                                    @else 
                                                                                        0
                                                                                    @endif
                                                                                </h5>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a href="/record-staff" class="btn btn-success ml-auto float-right"><i class="fal fa-arrow-alt-left"></i> Back</a><br><br>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane mt-1" id="history" role="tabpanel"><br>
                                        <div class="col-sm-12 mb-4">
                                            <div class="card card-primary card-outline">
                                                <div class="card-header">
                                                    <h5 class="card-title w-100"><i class="fal fa-clipboard width-2 fs-xl"></i> CLAIM RECORD 
                                                        @if($training_history->first() != null)
                                                            <a data-page="/claim-all-slip/{{ $staff->staff_id }}/{{ $selectedYear }}/" class="float-right" style="cursor: pointer; margin-right: 25px" onclick="Print(this)"><i class="fal fa-file-pdf" style="color: red; font-size: 25px"></i></a>
                                                        @endif
                                                    </h5>
                                                </div>
                                                <div class="card-body m-4">
                                                    <div class="row">
                                                        <div class="col-sm-6 col-xl-4">
                                                            <div class="p-3 bg-primary-300 rounded overflow-hidden position-relative text-white mb-g">
                                                                <div class="">
                                                                    <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                        {{ \App\TrainingClaim::where('staff_id', $staff->staff_id)->where( DB::raw('YEAR(start_date)'), '=', $selectedYear )->where('status','1')->get()->count() }}
                                                                        <small class="m-0 l-h-n">TOTAL PENDING/UNCOMPLETE</small>
                                                                    </h3>
                                                                </div>
                                                                <i class="fal fa-calendar-alt position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 col-xl-4">
                                                            <div class="p-3 bg-primary-400 rounded overflow-hidden position-relative text-white mb-g">
                                                                <div class="">
                                                                    <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                        {{ \App\TrainingClaim::where('staff_id', $staff->staff_id)->where( DB::raw('YEAR(start_date)'), '=', $selectedYear )->where('status','2')->get()->count() }}
                                                                        <small class="m-0 l-h-n">TOTAL APPROVE</small>
                                                                    </h3>
                                                                </div>
                                                                <i class="fal fa-calendar-check position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 col-xl-4">
                                                            <div class="p-3 bg-primary-400 rounded overflow-hidden position-relative text-white mb-g">
                                                                <div class="">
                                                                    <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                        {{ \App\TrainingClaim::where('staff_id', $staff->staff_id)->where( DB::raw('YEAR(start_date)'), '=', $selectedYear )->where('status','3')->get()->count() }}
                                                                        <small class="m-0 l-h-n">TOTAL REJECTED</small>
                                                                    </h3>
                                                                </div>
                                                                <i class="fal fa-calendar-minus position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="table-responsive">
                                                        <table id="hist" class="table table-bordered table-hover table-striped w-100">
                                                            <thead>
                                                                <tr class="bg-primary-50 text-center" style="white-space: nowrap">
                                                                    <th>#ID</th>
                                                                    <th>Title</th>
                                                                    <th>Start Date</th>
                                                                    <th>End Date</th>
                                                                    <th>Venue</th>
                                                                    <th>Type</th>
                                                                    <th>Category</th>
                                                                    <th>Claim Hour</th>
                                                                    <th>Status</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($training_history as $key => $detail)
                                                                    <tr style="text-transform: uppercase">
                                                                        <td class="text-center">{{ $detail->id ?? '--' }}</td>
                                                                        <td>{{ $detail->title ?? '--' }}</td>
                                                                        <td class="text-center">{{ $detail->start_date ?? '--' }}</td>
                                                                        <td class="text-center">{{ $detail->end_date ?? '--' }}</td>
                                                                        <td class="text-center">{{ $detail->venue ?? '--' }}</td>
                                                                        <td class="text-center">{{ $detail->types->type_name ?? '--' }}</td>
                                                                        <td class="text-center">{{ $detail->categories->category_name ?? '--' }}</td>
                                                                        <td class="text-center">{{ $detail->claim_hour ?? '--' }}</td>
                                                                        <td>
                                                                            <b>{{ $detail->claimStatus->status_name ?? '--' }}</b>
                                                                            <br>
                                                                            @if($detail->status == '2')
                                                                                (  {{ $detail->approved_hour ?? '--' }} )
                                                                            @endif
                                                                            @if($detail->status == '3')
                                                                                ( {{ $detail->reject_reason ?? '--' }} )
                                                                            @endif
                                                                        </td>
                                                                        <td class="text-center"><a href="/claim-info/{{ $detail->id }}" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a></td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                        <br>
                                                        <a href="/record-staff" class="btn btn-success ml-auto float-right"><i class="fal fa-arrow-alt-left"></i> Back</a> 
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>
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

    $(document).ready(function()
    {
        $('#status, #availability, #asset_types, #asset_code_type, #year').select2();

        $("#year").change(function(){
            $("#form_find").submit();
        })

        var table = $('#hist').DataTable({
            columnDefs: [],
                orderCellsTop: true,
                "order": [[ 2, "desc" ]],
                "initComplete": function(settings, json) {
                }
        });
    })

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
