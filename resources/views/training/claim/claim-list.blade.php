@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
    <div class="subheader">
        <h1 class="subheader-title">
        <i class='subheader-icon fal fa-clone'></i>CLAIM HOUR MANAGEMENT
        </h1>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                         CLAIM HOUR<span class="fw-300"><i>LIST</i></span>
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
                            <div class="col-sm-6 col-xl-4">
                                <div class="p-3 bg-warning-300 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            {{ \App\TrainingClaim::where( DB::raw('YEAR(start_date)'), '=', $selectedYear )->where('status','1')->get()->count() }}
                                            <small class="m-0 l-h-n">TOTAL PENDING/UNCOMPLETE <b style="font-weight: 900">{{ $selectedYear }}</b></small>
                                        </h3>
                                    </div>
                                    <i class="fal fa-calendar-alt position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-4">
                                <div class="p-3 bg-success-400 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            {{ \App\TrainingClaim::where( DB::raw('YEAR(start_date)'), '=', $selectedYear )->where('status','2')->get()->count() }}
                                            <small class="m-0 l-h-n">TOTAL APPROVE  <b style="font-weight: 900">{{ $selectedYear }}</b></small>
                                        </h3>
                                    </div>
                                    <i class="fal fa-calendar-check position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-4">
                                <div class="p-3 bg-danger-400 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            {{ \App\TrainingClaim::where( DB::raw('YEAR(start_date)'), '=', $selectedYear )->where('status','3')->get()->count() }}
                                            <small class="m-0 l-h-n">TOTAL REJECTED  <b style="font-weight: 900">{{ $selectedYear }}</b></small>
                                        </h3>
                                    </div>
                                    <i class="fal fa-calendar-minus position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-auto">
                                {{-- <div class="col-lg-6 col-sm-6 mb-2"> --}}
                                    <form action="{{ route('claimList') }}" method="GET" id="form_find">
                                    <div class="form-group">
                                        <label>Year Selection : </label>
                                        <select class="selectfilter form-control" name="year" id="year">
                                            {{-- <option value="" selected disabled> Please select </option> --}}
                                            {{-- <option value="ALL"> ALL </option> --}}
                                            @foreach ($year as $years)
                                                <option value="{{ $years->year }}" {{ $selectedYear == $years->year ? 'selected' : '' }}>{{ $years->year }} -> {{ $selectedYear }}</option>
                                            @endforeach
                                        </select> 
                                    </div>
                                    </form>
                                    <br>
                                {{-- </div> --}}
                                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                    <a class="nav-link mb-2 active" id="pendings-tab" data-toggle="pill" href="#pendings" role="tab" aria-controls="pendings" aria-selected="false" style="border: 1px solid;">
                                        <i class="fal fa-info-circle"></i>
                                        <span class="hidden-sm-down ml-1"> PENDING  <b style="font-weight: 900"></b></span>
                                    </a>
                                    <a class="nav-link mb-2" id="approves-tab" data-toggle="pill" href="#approves" role="tab" aria-controls="approves" aria-selected="false" style="border: 1px solid;">
                                        <i class="fal fa-certificate"></i>
                                        <span class="hidden-sm-down ml-1"> APPROVED  <b style="font-weight: 900"></b></span>
                                    </a>
                                    <a class="nav-link mb-2" id="rejects-tab" data-toggle="pill" href="#rejects" role="tab" aria-controls="rejects" aria-selected="false" style="border: 1px solid;">
                                        <i class="fal fa-adjust"></i>
                                        <span class="hidden-sm-down ml-1"> REJECTED  <b style="font-weight: 900"></b></span>
                                    </a>
                                </div>
                            </div>
                            
                            <div class="col">
                                <div class="tab-content" id="v-pills-tabContent">

                                    <div class="tab-pane active" id="pendings" role="tabpanel" style="margin-top: 5px"><br>
                                        <div class="col-sm-12 mb-4">
                                            @if (Session::has('message'))
                                                <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('message') }}</div>
                                            @endif
                                            @if (Session::has('notification'))
                                                <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('notification') }}</div>
                                            @endif
                                            <div class="table-responsive">
                                                <table id="pending" class="table table-bordered table-hover table-striped w-100">
                                                    <thead>
                                                        <tr class="text-center bg-primary-50">
                                                            <th>#ID</th>
                                                            <th>STAFF</th>
                                                            <th>TITLE</th>
                                                            <th>TYPE</th>
                                                            <th>CATEGORY</th>
                                                            <th>DATE</th>
                                                            <th>TIME</th>
                                                            <th>PENDING</th>
                                                            <th>APPROVE</th>
                                                            <th>REJECT</th>
                                                            <th>ACTION</th>
                                                        </tr>
                                                        <tr>
                                                            <td class="hasinput"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Search Staff"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Search Title"></td>
                                                            <td class="hasinput">
                                                                <select id="data_types_P" name="data_types_P" class="form-control">
                                                                    <option value="">All</option>
                                                                    @foreach($data_type as $data_types)
                                                                        <option value="{{$data_types->type_name}}">{{strtoupper($data_types->type_name)}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td class="hasinput">
                                                                <select id="data_categorys_P" name="data_categorys_P" class="form-control">
                                                                    <option value="">All</option>
                                                                    @foreach($data_category as $data_categorys)
                                                                        <option value="{{$data_categorys->category_name}}">{{strtoupper($data_categorys->category_name)}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Search Date"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Search Time"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Search Duration"></td>
                                                            <td class="hasinput"></td>
                                                            <td class="hasinput"></td>
                                                            <td class="hasinput"></td>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="approves" role="tabpanel" style="margin-top: 5px"><br>
                                        <div class="col-sm-12 mb-4">
                                             <div class="table-responsive">
                                                <table id="approve" class="table table-bordered table-hover table-striped w-100">
                                                    <thead>
                                                        <tr class="text-center bg-primary-50">
                                                            <th>#ID</th>
                                                            <th>STAFF</th>
                                                            <th>TITLE</th>
                                                            <th>TYPE</th>
                                                            <th>CATEGORY</th>
                                                            <th>DATE</th>
                                                            <th>TIME</th>
                                                            <th>CLAIM HOURS</th>
                                                            <th>APPROVE HOURS</th>
                                                            <th>APPROVE BY</th>
                                                            <th>ACTION</th>
                                                        </tr>
                                                        <tr>
                                                            <td class="hasinput"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Search Staff"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Search Title"></td>
                                                            <td class="hasinput">
                                                                <select id="data_types_A" name="data_types_A" class="form-control">
                                                                    <option value="">All</option>
                                                                    @foreach($data_type as $data_types)
                                                                        <option value="{{$data_types->type_name}}">{{strtoupper($data_types->type_name)}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td class="hasinput">
                                                                <select id="data_categorys_A" name="data_categorys_A" class="form-control">
                                                                    <option value="">All</option>
                                                                    @foreach($data_category as $data_categorys)
                                                                        <option value="{{$data_categorys->category_name}}">{{strtoupper($data_categorys->category_name)}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Search Date"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Search Time"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Search Claim Hour"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Search Approve Hour"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Search Approve By"></td>
                                                            <td class="hasinput"></td>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="rejects" role="tabpanel" style="margin-top: 5px"><br>
                                        <div class="col-sm-12 mb-4">
                                            <div class="table-responsive">
                                                <table id="reject" class="table table-bordered table-hover table-striped w-100">
                                                    <thead>
                                                        <tr class="text-center bg-primary-50">
                                                            <th>#ID</th>
                                                            <th>STAFF</th>
                                                            <th>TITLE</th>
                                                            <th>TYPE</th>
                                                            <th>CATEGORY</th>
                                                            <th>DATE</th>
                                                            <th>TIME</th>
                                                            <th>CLAIM HOURS</th>
                                                            <th>REJECT REASONS</th>
                                                            <th>APPROVE BY</th>
                                                            <th>ACTION</th>
                                                        </tr>
                                                        <tr>
                                                            <td class="hasinput"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Search Staff"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Search Title"></td>
                                                            <td class="hasinput">
                                                                <select id="data_types_R" name="data_types_R" class="form-control">
                                                                    <option value="">All</option>
                                                                    @foreach($data_type as $data_types)
                                                                        <option value="{{$data_types->type_name}}">{{strtoupper($data_types->type_name)}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td class="hasinput">
                                                                <select id="data_categorys_R" name="data_categorys_R" class="form-control">
                                                                    <option value="">All</option>
                                                                    @foreach($data_category as $data_categorys)
                                                                        <option value="{{$data_categorys->category_name}}">{{strtoupper($data_categorys->category_name)}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Search Date"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Search Time"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Search Claim Hour"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Search Reasons"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Search Approve By"></td>
                                                            <td class="hasinput"></td>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex  pull-right">
                                        <a class="btn btn-info ml-auto mr-2 float-right" href="/export-latest-claim/{{ $selectedYear }}"><i class="fal fa-file-excel"></i> Export {{ $selectedYear }}</a>
                                        <a class="btn btn-warning float-right" href="/export-claim"><i class="fal fa-file-excel"></i> Export All</a>
                                    </div>
                                </div>
                            </div>
                    
                        </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="crud-approve" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title w-100"><i class="fal fa-info width-2 fs-xl"></i>APPROVE CLAIM #<label class="id"></label></h5>
                </div>
                <div class="modal-body">
                    {!! Form::open(['action' => 'TrainingController@approveClaim', 'method' => 'POST']) !!}
                    <input type="hidden" name="claim_id" id="claim">
                    <p><span class="text-danger">*</span> Required fields</p>
                    
                    <table class="table table-bordered table-hover table-striped w-100">
                        <thead>
                            <tr>
                                <div class="form-group">
                                    <td width="15%" style="vertical-align: middle"><label class="form-label"> Staff :</label></td>
                                    <td colspan="6" style="text-transform: uppercase">
                                        <label class="staff" style="vertical-align: middle"></label>
                                    </td>
                                </div>
                            </tr>
                            <tr>
                                <div class="form-group">
                                    <td width="15%" style="vertical-align: middle"><label class="form-label"> Training Title :</label></td>
                                    <td colspan="6" style="text-transform: uppercase">
                                        <label class="title" style="vertical-align: middle"></label>
                                    </td>
                                </div>
                            </tr>
                            <tr>
                                <div class="form-group">
                                    <td width="15%" style="vertical-align: middle"><label class="form-label"> Type of Training :</label></td>
                                    <td colspan="3" style="text-transform: uppercase">
                                        <label class="type" style="vertical-align: middle"></label>
                                    </td>
                                    <td width="15%" style="vertical-align: middle"><label class="form-label"> Category of Training :</label></td>
                                    <td colspan="3" style="text-transform: uppercase">
                                        <label class="category" style="vertical-align: middle"></label>
                                    </td>
                                </div>
                            </tr>
                            <tr>
                                <div class="form-group">
                                    <td width="15%" style="vertical-align: middle"><label class="form-label"> Date :</label></td>
                                    <td colspan="3">
                                        <label class="date" style="vertical-align: middle"></label>
                                    </td>
                                    <td width="15%" style="vertical-align: middle"><label class="form-label"> Time :</label></td>
                                    <td colspan="3">
                                        <label class="time" style="vertical-align: middle"></label>
                                    </td>
                                </div>
                            </tr>
                            <tr>
                                <div class="form-group">
                                    <td width="15%" style="vertical-align: middle"><label class="form-label"> Venue :</label></td>
                                    <td colspan="6">
                                        <label class="venue" style="vertical-align: middle"></label>
                                    </td>
                                   
                                </div>
                            </tr>
                            <tr>
                                <div class="form-group">
                                    <td width="15%" style="vertical-align: middle"><label class="form-label"> Claim Hours :</label></td>
                                    <td colspan="3" style="vertical-align: middle">
                                        <label class="hour"></label>
                                    </td>
                                    <td width="15%" style="vertical-align: middle"><label class="form-label"><span class="text-danger">*</span>  Approve Hours : </label></td>
                                    <td colspan="3">
                                        <input type="number" step="any" class="form-control" id="approved_hour" name="approved_hour" required>
                                        @error('approved_hour')
                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                        @enderror
                                    </td>
                                </div>
                            </tr>
                        </thead>
                    </table>

                    <div class="footer">
                        <button type="submit" class="btn btn-success ml-auto float-right"><i class="fal fa-save"></i> Approve</button>
                        <button type="button" class="btn btn-primary ml-auto float-right mr-2" data-dismiss="modal"><i class="fal fa-window-close"></i> Close</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="crud-reject" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title w-100"><i class="fal fa-info width-2 fs-xl"></i>REJECT CLAIM #<label class="ids"></label></h5>
                </div>
                <div class="modal-body">
                    {!! Form::open(['action' => 'TrainingController@rejectClaim', 'method' => 'POST']) !!}
                    <input type="hidden" name="claim_id" id="claims">
                    <p><span class="text-danger">*</span> Required fields</p>

                    <table class="table table-bordered table-hover table-striped w-100">
                        <thead>
                            <tr>
                                <div class="form-group">
                                    <td width="15%" style="vertical-align: middle"><label class="form-label"> Staff :</label></td>
                                    <td colspan="6" style="text-transform: uppercase">
                                        <label class="staffs" style="vertical-align: middle"></label>
                                    </td>
                                </div>
                            </tr>
                            <tr>
                                <div class="form-group">
                                    <td width="15%" style="vertical-align: middle"><label class="form-label"> Training Title :</label></td>
                                    <td colspan="6" style="text-transform: uppercase">
                                        <label class="titles" style="vertical-align: middle"></label>
                                    </td>
                                </div>
                            </tr>
                            <tr>
                                <div class="form-group">
                                    <td width="15%" style="vertical-align: middle"><label class="form-label"> Type of Training :</label></td>
                                    <td colspan="3" style="text-transform: uppercase">
                                        <label class="types" style="vertical-align: middle"></label>
                                    </td>
                                    <td width="15%" style="vertical-align: middle"><label class="form-label"> Category of Training :</label></td>
                                    <td colspan="3" style="text-transform: uppercase">
                                        <label class="categorys" style="vertical-align: middle"></label>
                                    </td>
                                </div>
                            </tr>
                            <tr>
                                <div class="form-group">
                                    <td width="15%" style="vertical-align: middle"><label class="form-label"> Date :</label></td>
                                    <td colspan="3">
                                        <label class="dates" style="vertical-align: middle"></label>
                                    </td>
                                    <td width="15%" style="vertical-align: middle"><label class="form-label"> Time :</label></td>
                                    <td colspan="3">
                                        <label class="times" style="vertical-align: middle"></label>
                                    </td>
                                </div>
                            </tr>
                            <tr>
                                <div class="form-group">
                                    <td width="15%" style="vertical-align: middle"><label class="form-label"> Venue :</label></td>
                                    <td colspan="6">
                                        <label class="venues" style="vertical-align: middle"></label>
                                    </td>
                                   
                                </div>
                            </tr>
                            <tr>
                                <div class="form-group">
                                    <td width="15%" style="vertical-align: middle"><label class="form-label"> Claim Hours :</label></td>
                                    <td colspan="3" style="vertical-align: middle">
                                        <label class="hours"></label>
                                    </td>
                                    <td width="15%" style="vertical-align: middle"><label class="form-label"><span class="text-danger">*</span>  Reject Reason : </label></td>
                                    <td colspan="3">
                                        <textarea rows="5" class="form-control" id="reject_reason" name="reject_reason" required></textarea>
                                        @error('reject_reason')
                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                        @enderror
                                    </td>
                                </div>
                            </tr>
                        </thead>
                    </table>

                    <div class="footer">
                        <button type="submit" class="btn btn-warning ml-auto float-right"><i class="fal fa-save"></i> Reject</button>
                        <button type="button" class="btn btn-primary ml-auto float-right mr-2" data-dismiss="modal"><i class="fal fa-window-close"></i> Close</button>
                    </div>
                    {!! Form::close() !!}
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
        $("#year").change(function(){
            $("#form_find").submit();
        })

        $('#data_types_P, #data_categorys_P, #data_types_A, #data_categorys_A, #data_types_R, #data_categorys_R, #year').select2();

        $('#crud-approve').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) 
            var claim = button.data('claim') 
            var title = button.data('title') 
            var type = button.data('type') 
            var category = button.data('category') 
            var date = button.data('date') 
            var time = button.data('time') 
            var venue = button.data('venue') 
            var hour = button.data('hour') 
            var staff = button.data('staff') 

            $('.modal-body .claim').val(claim); 
            $('.id').html(claim); 
            $('.modal-body .title').html(title); 
            $('.modal-body .type').html(type); 
            $('.modal-body .category').html(category); 
            $('.modal-body .date').html(date); 
            $('.modal-body .time').html(time); 
            $('.modal-body .venue').html(venue); 
            $('.modal-body .hour').html(hour); 
            $('.modal-body .staff').html(staff); 
        })

        $('#crud-reject').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) 
            var claims = button.data('claims') 
            var titles = button.data('titles') 
            var types = button.data('types') 
            var categorys = button.data('categorys') 
            var dates = button.data('dates') 
            var times = button.data('times') 
            var venues = button.data('venues') 
            var hours = button.data('hours') 
            var staffs = button.data('staffs')

            $('.modal-body #claims').val(claims); 
            $('.ids').html(claims);
            $('.modal-body .titles').html(titles); 
            $('.modal-body .types').html(types); 
            $('.modal-body .categorys').html(categorys); 
            $('.modal-body .dates').html(dates); 
            $('.modal-body .times').html(times); 
            $('.modal-body .venues').html(venues); 
            $('.modal-body .hours').html(hours); 
            $('.modal-body .staffs').html(staffs); 
        })

        $('#pending thead tr .hasinput').each(function(i)
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

        var year = document.getElementById("year");
        var selectedYear = year.value;

        var table = $('#pending').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/data-pending-claim",
                data:{'year':selectedYear},
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { className: 'text-center', data: 'id', name: 'id' },
                    { data: 'staff_id', name: 'staff_id' },
                    { data: 'title', name: 'title' },
                    { className: 'text-center', data: 'type', name: 'type' },
                    { className: 'text-center', data: 'category', name: 'category' },
                    { className: 'text-center', data: 'date', name: 'date' },
                    { className: 'text-center', data: 'time', name: 'time' },
                    { className: 'text-center', data: 'duration', name: 'duration' },
                    { className: 'text-center', data: 'approve', name: 'approve', orderable: false, searchable: false },
                    { className: 'text-center', data: 'reject', name: 'reject', orderable: false, searchable: false },
                    { className: 'text-center', data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                createdRow: function (row, data, dataIndex, cells) {
                    if (data.stylesheet) {
                        $.each(data.stylesheet, function (k, rowStyle) {
                            $(cells[rowStyle.col]).css(rowStyle.style);
                        });
                    }
                },
                orderCellsTop: true,
                "order": [[ 5, "desc" ]],
                "initComplete": function(settings, json) {

                } 
        });

        $('#pending').on('click', '.btn-delete[data-remote]', function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var url = $(this).data('remote');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                    url: url,
                    type: 'DELETE',
                    dataType: 'json',
                    data: {method: '_DELETE', submit: true}
                    }).always(function (data) {
                        $('#pending').DataTable().draw(false);
                    });
                }
            })
        });

        $('#approve thead tr .hasinput').each(function(i)
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

        var table = $('#approve').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/data-approve-claim",
                data:{'year':selectedYear},
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { className: 'text-center', data: 'id', name: 'id' },
                    { data: 'staff_id', name: 'staff_id' },
                    { data: 'title', name: 'title' },
                    { className: 'text-center', data: 'type', name: 'type' },
                    { className: 'text-center', data: 'category', name: 'category' },
                    { className: 'text-center', data: 'date', name: 'date' },
                    { className: 'text-center', data: 'time', name: 'time' },
                    { className: 'text-center', data: 'claim_hour', name: 'claim_hour' },
                    { className: 'text-center', data: 'approved_hour', name: 'approved_hour' },
                    { className: 'text-center', data: 'assigned_by', name: 'assigned_by' },
                    { className: 'text-center', data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                createdRow: function (row, data, dataIndex, cells) {
                    if (data.stylesheet) {
                        $.each(data.stylesheet, function (k, rowStyle) {
                            $(cells[rowStyle.col]).css(rowStyle.style);
                        });
                    }
                },
                orderCellsTop: true,
                "order": [[ 5, "desc" ]],
                "initComplete": function(settings, json) {

                } 
        });

        $('#reject thead tr .hasinput').each(function(i)
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

        var table = $('#reject').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/data-reject-claim",
                data:{'year':selectedYear},
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { className: 'text-center', data: 'id', name: 'id' },
                    { data: 'staff_id', name: 'staff_id' },
                    { data: 'title', name: 'title' },
                    { className: 'text-center', data: 'type', name: 'type' },
                    { className: 'text-center', data: 'category', name: 'category' },
                    { className: 'text-center', data: 'date', name: 'date' },
                    { className: 'text-center', data: 'time', name: 'time' },
                    { className: 'text-center', data: 'claim_hour', name: 'claim_hour' },
                    { data: 'reject_reason', name: 'reject_reason' },
                    { className: 'text-center', data: 'assigned_by', name: 'assigned_by' },
                    { className: 'text-center', data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                createdRow: function (row, data, dataIndex, cells) {
                    if (data.stylesheet) {
                        $.each(data.stylesheet, function (k, rowStyle) {
                            $(cells[rowStyle.col]).css(rowStyle.style);
                        });
                    }
                },
                orderCellsTop: true,
                "order": [[ 5, "desc" ]],
                "initComplete": function(settings, json) {

                } 
        });

        $('#approve').on('click', '.btn-delete[data-remote]', function (e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var url = $(this).data('remote');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                        $.ajax({
                        url: url,
                        type: 'DELETE',
                        dataType: 'json',
                        data: {method: '_DELETE', submit: true}
                        }).always(function (data) {
                            $('#approve').DataTable().draw(false);
                        });
                    }
                })
        });

        $('#reject').on('click', '.btn-delete[data-remote]', function (e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var url = $(this).data('remote');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                        $.ajax({
                        url: url,
                        type: 'DELETE',
                        dataType: 'json',
                        data: {method: '_DELETE', submit: true}
                        }).always(function (data) {
                            $('#reject').DataTable().draw(false);
                        });
                    }
                })
        });

    });

    


</script>

@endsection
