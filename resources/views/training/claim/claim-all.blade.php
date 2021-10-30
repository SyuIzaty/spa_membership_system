@extends('layouts.applicant')
    
@section('content')
<main id="js-page-content" role="main" class="page-content">
    <div class="row">
        <div class="col-xl-12" style="padding: 50px; margin-bottom: 20px">
                
                <center><img src="{{ URL::to('/') }}/img/intec_logo_new.png" height="120" width="320" alt="INTEC"></center>
                    <h4 style="text-align: center">
                        <b>INTEC EDUCATION COLLEGE CLAIM RECORD SLIP {{ $year }}</b>
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
                                                    <table id="hist" class="table table-bordered table-hover table-striped w-100">
                                                        <thead>
                                                            <tr class="text-center" style="white-space: nowrap">
                                                                <th>#ID</th>
                                                                <th>Title</th>
                                                                <th>Start Date</th>
                                                                <th>End Date</th>
                                                                <th>Venue</th>
                                                                <th>Type</th>
                                                                <th>Category</th>
                                                                <th>Claim Hour</th>
                                                                <th>Status</th>
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
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>  
                                        </tbody>
                                    </table>
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

