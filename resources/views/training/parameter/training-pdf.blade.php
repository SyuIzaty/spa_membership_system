@extends('layouts.applicant')
    
@section('content')
<main id="js-page-content" role="main" class="page-content">
    <div class="row">
        <div class="col-xl-12" style="padding: 50px; margin-bottom: 20px">
                
                <center><img src="{{ URL::to('/') }}/img/intec_logo_new.png" height="120" width="320" alt="INTEC"></center>
                <h4 style="text-align: center">
                    <b>{{ strtoupper($train->title) }} INFO</b>
                </h4><br>

                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="card-primary card-outline">
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th width="15%">Title : </th>
                                            <td colspan="8" style="text-transform: uppercase">{{ $train->title ?? '--' }}</td>
                                        </tr>
                                        <tr>
                                            <th width="15%">Venue : </th>
                                            <td colspan="4" style="text-transform: uppercase">{{ $train->venue ?? '--' }}</td>
                                            <th width="15%">Link : </th>
                                            <td colspan="4">{{ $train->link ?? '--' }}</td>
                                        </tr>
                                        <tr>
                                            <th width="15%">Date : </th>
                                            <td colspan="4" style="text-transform: uppercase">{{ isset($train->start_date) ? date('d/m/Y', strtotime($train->start_date)) : '--' }} - {{ isset($train->end_date) ? date('d/m/Y', strtotime($train->end_date)) : '--' }}</td>
                                            <th width="15%">Time : </th>
                                            <td colspan="4" style="text-transform: uppercase">{{ isset($train->start_time) ? date('h:i A', strtotime($train->start_time)) : '--' }} - {{ isset($train->end_time) ? date('h:i A', strtotime($train->end_time)) : '--' }}</td>
                                        </tr>
                                        <tr>
                                            <th width="15%">Type : </th>
                                            <td colspan="4" style="text-transform: uppercase">{{ $train->types->type_name ?? '--' }}</td>
                                            <th width="15%">Category : </th>
                                            <td colspan="4" style="text-transform: uppercase">{{ $train->categories->category_name ?? '--' }}</td>
                                        </tr>
                                        <tr>
                                            <th width="15%">Claim Hour(s) : </th>
                                            <td colspan="8">{{ $train->claim_hour ?? '--' }}</td>
                                        </tr>
                                        
                                        <div class="table-responsive">
                                           
                                            <table class="table table-bordered table-hover table-striped w-100">
                                                <p><b>PARTICIPANT LIST : </b></p> 
                                                <thead>
                                                    <tr class="bg-primary-50 text-center" style="white-space: nowrap">
                                                        <th>NO</th>
                                                        <th>TICKET #ID</th>
                                                        <th>ID</th>
                                                        <th>NAME</th>
                                                        <th>POSITION</th>
                                                        <th>DEPARTMENT</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($participant as $key => $parts)
                                                        <tr style="text-transform: uppercase">
                                                            <td class="text-center">{{ $no++ }}</td>
                                                            <td class="text-center">{{ $parts->id }}</td>
                                                            <td class="text-center">{{ $parts->staff_id ?? '--' }}</td>
                                                            <td>{{ $parts->staffs->staff_name ?? '--' }}</td>
                                                            <td class="text-center">{{ $parts->staffs->staff_position ?? '--' }}</td>
                                                            <td class="text-center">{{ $parts->staffs->staff_dept ?? '--' }}</td>
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

