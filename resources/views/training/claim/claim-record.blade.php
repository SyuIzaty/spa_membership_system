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
                            <b>INTEC EDUCATION COLLEGE TRAINING HOUR RECORDS</b>
                        </h4>

                        <div class="panel-container show">
                            <div class="panel-content">
                                <div class="card-primary card-outline">
                                    <div class="card-body">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <form action="{{ route('claimRecord') }}" method="GET" id="form_find">
                                                        <div class="row">
                                                            <div class="col-lg-6 col-sm-6 mb-2">
                                                                <div class="form-group">
                                                                    <label><span class="text-danger">**</span> Year : </label>
                                                                    <select class="form-control custom-year" name="year" id="year">
                                                                        <option value="" selected disabled> Please select </option>
                                                                        @foreach ($year as $years)
                                                                            <option value="{{ $years->date }}" {{ $req_year == $years->date  ? 'selected' : '' }}>{{  $years->date }}</option>
                                                                        @endforeach
                                                                    </select> 
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-sm-6">
                                                                <div class="form-group">
                                                                    <label><span class="text-danger">**</span> Type : </label>
                                                                    <select class="form-control custom-type" name="type" id="type">
                                                                        <option value="" selected disabled> Please select </option>
                                                                        <option value=""> ALL </option>
                                                                        @foreach ($type as $types)
                                                                            <option value="{{ $types->id }}" {{ $req_type == $types->id  ? 'selected' : '' }}>{{  strtoupper($types->type_name) }}</option>
                                                                        @endforeach
                                                                    </select> 
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </tr>
                                                <i><span class="text-danger">**</span><b> Notes : </b>Please select either year or type to view training hour record</i>
                                                <br><br>
                                                <tr>
                                                    <th width="15%">Name : </th>
                                                    <td colspan="4">{{ $staff->staff_name ?? '--' }}</td>
                                                    <th width="15%">ID/IC Number : </th>
                                                    <td colspan="4">{{ $staff->staff_id ?? '--' }} ( {{ $staff->staff_ic ?? '--' }} )</td>
                                                </tr>
                                                <tr>
                                                    <th width="15%">Email : </th>
                                                    <td colspan="4">{{ $staff->staff_email ?? '--' }}</td>
                                                    <th width="15%">Phone : </th>
                                                    <td colspan="4">{{ $staff->staff_phone ?? '--' }}</td>
                                                </tr>
                                                <tr>
                                                    <th width="15%">Position : </th>
                                                    <td colspan="4">{{ $staff->staff_position ?? '--' }}</td>
                                                    <th width="15%">Department : </th>
                                                    <td colspan="4">{{ $staff->staff_dept ?? '--' }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        @if(isset($data) && !empty($data))
                                            <table class="table table-bordered w-100 text-center">
                                                <thead>
                                                    <tr>
                                                        @foreach($category as $cat)
                                                            <th class="bg-primary-50">{{ $cat->category_name}}</th>
                                                        @endforeach
                                                    </tr>
                                                    <tr>
                                                        @foreach($category as $cat)
                                                        <?php
                                                            $res = new \App\TrainingClaim();

                                                            if($req_type != "" && $req_year != "") {
                                                                $data3 = $res->where( DB::raw('YEAR(start_date)'), '=', $req_year )->where('type', $req_type)->where('category', $cat->id)->where('staff_id', Auth::user()->id)->where('status', '2')->sum('approved_hour');
                                                            } elseif($req_type == "" && $req_year != "") {
                                                                $data3 = $res->where( DB::raw('YEAR(start_date)'), '=', $req_year )->where('category', $cat->id)->where('staff_id', Auth::user()->id)->where('status', '2')->sum('approved_hour');
                                                            } else {  
                                                                $data3 = $res->where('type', $req_type)->where('category', $cat->id)->where('staff_id', Auth::user()->id)->where('status', '2')->sum('approved_hour');
                                                            }
                                                        ?>
                                                        <th>{{ $data3 }}</th>
                                                        @endforeach
                                                    </tr>
                                                </thead>
                                            </table>
                                            <div class="table-responsive">
                                                <table class="table table-striped w-100">
                                                    <thead>
                                                        <tr style="white-space: nowrap">
                                                            <th class="text-center border-top-0 table-scale-border-bottom fw-700"></th>
                                                            <th class="border-top-0 table-scale-border-bottom fw-700">Title</th>
                                                            <th class="border-top-0 table-scale-border-bottom fw-700">Start Date</th>
                                                            <th class="border-top-0 table-scale-border-bottom fw-700">End Date</th>
                                                            <th class="border-top-0 table-scale-border-bottom fw-700">Venue</th>
                                                            <th class="border-top-0 table-scale-border-bottom fw-700">Type</th>
                                                            <th class="border-top-0 table-scale-border-bottom fw-700">Category</th>
                                                            <th class="border-top-0 table-scale-border-bottom fw-700">Status</th>
                                                            <th class="text-right border-top-0 table-scale-border-bottom fw-700">Approve Hours</th>
                                                            <th class="text-right border-top-0 table-scale-border-bottom fw-700">Evaluation Form</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($data as $key => $details)
                                                            <tr style="text-transform: uppercase">
                                                                <td class="text-center fw-700">{{ $no++ }}</td>
                                                                <td class="text-left strong">{{ $details->title ?? '--'}}</td>
                                                                <td class="text-left">{{ date(' d/m/Y ', strtotime($details->start_date) )}}</td>
                                                                <td class="text-left">{{ date(' d/m/Y ', strtotime($details->end_date) )}}</td>
                                                                <td class="text-left">{{ $details->venue ?? '--'}}</td>
                                                                <td class="text-left">{{ $details->types->type_name ?? '--'}}</td>
                                                                <td class="text-left">{{ $details->categories->category_name ?? '--'}}</td>
                                                                <td class="text-left">{{ $details->claimStatus->status_name ?? '--'}}</td>
                                                                <td class="text-right">{{ $details->approved_hour ?? '--'}}</td>
                                                                <td class="text-right fw-700">
                                                                    <?php
                                                                        $exist = \App\TrainingEvaluationHeadResult::where('staff_id', Auth::user()->id)->where('training_id', $details->training_id)->first();
                                                                        $duration = \App\TrainingEvaluationHeadResult::where('staff_id', Auth::user()->id)->where('training_id', $details->training_id)->whereHas('trainingList', function($query){
                                                                                        $query->where('evaluation_status', '1');
                                                                                    })->first();      
                                                                    ?>
                                                                    @if($details->training_id == '0') {{-- others --}}
                                                                        <button class="btn btn-xs btn-secondary" disabled style="pointer-events: none"><i class="fal fa-link"></i></button>
                                                                    @else {{-- list --}}
                                                                        @if( $details->status == '1' || $details->status == '2' ) {{--pending/approve--}}
                                                                            @if(\App\TrainingList::where('id', $details->training_id)->whereNotNull('evaluation')->first())
                                                                            {{-- evaluation in training not null --}}
                                                                                @if(isset($exist))
                                                                                    @if(isset($duration))
                                                                                        {{-- exist and evaluation open but can edit --}}
                                                                                        <a href="/evaluation-form/{{ $details->training_id }}" class="btn btn-warning btn-xs" target="_blank"><i class="fal fa-link"></i></a>  
                                                                                    @else 
                                                                                        {{-- exist and evaluation close but can view --}}
                                                                                        <a href="/evaluation-form/{{ $details->training_id }}" class="btn btn-info btn-xs" target="_blank"><i class="fal fa-link"></i></a>  
                                                                                    @endif
                                                                                @else  
                                                                                {{-- new form  --}}
                                                                                    <a href="/evaluation-form/{{ $details->training_id }}" class="btn btn-success btn-xs" target="_blank"><i class="fal fa-link"></i></a> 
                                                                                @endif
                                                                            @else 
                                                                                <button class="btn btn-xs btn-secondary" disabled style="pointer-events: none"><i class="fal fa-link"></i></button>
                                                                            @endif
                                                                        @else  {{-- external --}}
                                                                            <button class="btn btn-xs btn-secondary" disabled style="pointer-events: none"><i class="fal fa-link"></i></button>
                                                                        @endif
                                                                    @endif

                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                            <br>
                                            <div class="row">
                                                <div class="col-sm-12 col-md-4 ml-sm-auto">
                                                    <table class="table table-clean">
                                                        <tbody>
                                                            <tr class="table-scale-border-top border-left-0 border-right-0 border-bottom-0">
                                                                <td class="text-left keep-print-font">
                                                                    <h5 class="m-0 fw-700 h4 keep-print-font color-primary-700">Overall Required Training Hours</h5>
                                                                </td>
                                                                <td class="text-right keep-print-font">
                                                                    <h5 class="m-0 fw-700 h4 keep-print-font">{{ $hours->training_hour ?? '0' }}</h5>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-left keep-print-font">
                                                                    <h5 class="m-0 fw-700 h4 keep-print-font color-primary-700">Total Current Training Hours</h5>
                                                                </td>
                                                                <td class="text-right keep-print-font">
                                                                    <h5 class="m-0 fw-700 h4 keep-print-font text-danger">{{ $data2 ?? '0' }}</h5>
                                                                </td>
                                                            </tr>
                                                            <?php 
                                                                if(isset($hours->training_hour)) {
                                                                    $balance = $hours->training_hour - $data2;
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
                                        @endif
                                        @if(isset($data) && !empty($data))
                                            <a data-page="/claim-slip/{{Auth::user()->id}}/{{ $req_year }}/{{$req_type}}" class="btn btn-danger text-white float-right mt-2" style="cursor: pointer" onclick="Print(this)"><i class="fal fa-file-pdf"></i> Training Slip {{ $req_year }}</a><br><br>
                                        @endif
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

    $("#year, #type").change(function(){
        $("#form_find").submit();
    })

    $(document).ready(function()
    {
        $('.custom-year, .custom-type').select2();
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

