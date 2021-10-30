@extends('layouts.applicant')
    
@section('content')
<main id="js-page-content" role="main" class="page-content">
    <div class="row">
        <div class="col-xl-12" style="padding: 50px; margin-bottom: 20px">
                
                <center><img src="{{ URL::to('/') }}/img/intec_logo_new.png" height="120" width="320" alt="INTEC"></center>
                    <h4 style="text-align: center">
                        <b>INTEC EDUCATION COLLEGE TRAINING HOUR SLIP {{ $year }}</b>
                    </h4><br>

                    <div class="panel-container show">
                        <div class="panel-content">
                            <div class="card-primary card-outline">
                                <div class="card-body">
                                        <table class="table table-bordered">
                                            <tbody>
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
                                                    
                                                    <div class="table-responsive">
                                                        <table class="table m-0 table-bordered">
                                                            <thead>
                                                                <tr style="white-space: nowrap">
                                                                    <th class="text-center border-top-0 table-scale-border-bottom fw-700"></th>
                                                                    <th class="border-top-0 table-scale-border-bottom fw-700">Title</th>
                                                                    <th class="border-top-0 table-scale-border-bottom fw-700 text-center">Start Date</th>
                                                                    <th class="border-top-0 table-scale-border-bottom fw-700 text-center">End Date</th>
                                                                    <th class="border-top-0 table-scale-border-bottom fw-700 text-center">Venue</th>
                                                                    <th class="border-top-0 table-scale-border-bottom fw-700 text-center">Type</th>
                                                                    <th class="border-top-0 table-scale-border-bottom fw-700 text-center">Category</th>
                                                                    <th class="border-top-0 table-scale-border-bottom fw-700">Status</th>
                                                                    <th class="text-right border-top-0 table-scale-border-bottom fw-700">Approve Hours</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($data as $key => $details)
                                                                    <tr style="text-transform: uppercase">
                                                                        <td class="text-center fw-700">{{ $no++ }}</td>
                                                                        <td class="text-left strong">{{ $details->title ?? '--'}}</td>
                                                                        <td class="text-center">{{ date(' d/m/Y ', strtotime($details->start_date) )}}</td>
                                                                        <td class="text-center">{{ date(' d/m/Y ', strtotime($details->end_date) )}}</td>
                                                                        <td class="text-center">{{ $details->venue ?? '--'}}</td>
                                                                        <td class="text-center">{{ $details->types->type_name ?? '--'}}</td>
                                                                        <td class="text-center">{{ $details->categories->category_name ?? '--'}}</td>
                                                                        <td class="text-left">{{ $details->claimStatus->status_name ?? '--'}}</td>
                                                                        <td class="text-right">{{ $details->approved_hour ?? '--'}}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                        <br><br>
                                                        <table class="table m-0 table-bordered" style="width: 30.5%" align="right">
                                                            <tr>
                                                                <td colspan="1" class="text-right">Overall Required Training Hours : </td>
                                                                <td colspan="1" class="text-right fw-700">{{ $hours->training_hour ?? '0' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="1" class="text-right">Total Current Training Hours : </td>
                                                                <td colspan="1" class="text-right fw-700" style="width : 25%">{{ $data2 ?? '0'}}</td>
                                                            </tr>
                                                            <?php 
                                                                $balance = $hours->training_hour - $data2;
                                                            ?>
                                                            <tr>
                                                                <td colspan="1" class="text-right">( - ) Total Balance Training Hours : </td>
                                                                <td colspan="1" class="text-right fw-700">
                                                                    @if($balance >= 0)
                                                                        {{ number_format((float)$balance, 2, '.', '') ?? '0' }}
                                                                    @else 
                                                                        0
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>  
                                            </tbody>
                                        </table>
                                    <br><br><br><br><br><br>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div style="font-style: italic; font-size: 10px">
                            <p style="float: left">@ Copyright INTEC Education College</p>  
                            <p style="float: right">Printed Date : {{ date(' d/m/Y ', strtotime( \Carbon\Carbon::now()) )}}</p><br>
                        </div>
        </div>
    </div>
</main>

@endsection

@section('script')
<script>
    //
</script>
@endsection

