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
                        <center><img src="{{ asset('img/intec_logo.png') }}" style="height: 120px; width: 270px;"></center><br>
                        <h4 style="text-align: center">
                            <b>INTEC EDUCATION COLLEGE COVID19 RISK SCREENING DAILY DECLARATION RESULT</b>
                        </h4>

                        <div class="panel-container show">
                            <div class="panel-content">
                                <div class="table-responsive">
                                    <table id="info" class="table table-bordered table-hover table-striped w-100">
                                        <thead>
                                            @can('view admin')
                                            <tr>
                                                <div class="form-group">
                                                    <th width="15%"><label for="qHeader">NAME :</label></th>
                                                    <td colspan="2"><label for="qHeader">{{ strtoupper($declare->user_name)}}</label></td>
                                                    @if($declare->user_position == 'VSR')
                                                        <th width="15%"><label for="qHeader">IC/PASSPORT NO :</label></th>
                                                    @elseif($declare->user_position == 'STF')
                                                        <th width="15%"><label for="qHeader">STAFF ID :</label></th>
                                                    @else
                                                        <th width="15%"><label for="qHeader">STUDENT ID :</label></th>
                                                    @endif
                                                    <td colspan="2"><label for="qHeader">{{$declare->user_id}}</label></td>
                                                </div>
                                            </tr>
                                            <tr>
                                                <div class="form-group">
                                                    <th width="15%"><label for="qHeader">EMAIL :</label></th>
                                                    <td colspan="2"><label for="qHeader">{{ isset($declare->user_email) ? $declare->user_email : '-'}}</label></td>
                                                    <th width="25%"><label for="qHeader">PHONE NO. :</label></th>
                                                    <td colspan="2"><label for="qHeader">{{ isset($declare->user_phone) ? $declare->user_phone : '-'}}</label></td>
                                                    {{-- <td colspan="2"><label for="qHeader">{{ isset($declare->staffs->staff_phone) ? $declare->staffs->staff_phone : '-'}}</label></td> --}}
                                                </div>
                                            </tr>
                                            @if($declare->user_position == 'STD')
                                            <tr>
                                                <div class="form-group">
                                                    <th width="15%"><label for="qHeader">PROGRAMME :</label></th>
                                                    <td colspan="2"><label for="qHeader"></label>{{ isset($declare->students->programme->programme_name) ? strtoupper($declare->students->programme->programme_name) : '-' }}</td>
                                                    <th width="25%"><label for="qHeader">SESSION :</label></th>
                                                    <td colspan="2"><label for="qHeader"></label>{{ isset($declare->students->current_session) ? strtoupper($declare->students->current_session) : '-'}}</td>
                                                </div>
                                            </tr>
                                            @endif
                                            @endcan
                                            <tr>
                                                <div class="form-group">
                                                    <th width="15%"><label for="qHeader">DECLARATION DATE :</label></th>
                                                    <td colspan="2"><label for="qHeader">{{strtoupper(date(' j F Y', strtotime($declare->declare_date) ))}}</label></td>
                                                    <th width="15%"><label for="qHeader">DECLARATION TIME :</label></th>
                                                    <td colspan="2"><label for="qHeader">{{ date(' h:i:s A', strtotime($declare->declare_time) )}}</label></td>
                                                </div>
                                            </tr>
                                            <tr>
                                                <div class="form-group">
                                                    @if($declare->user_position == 'STF')
                                                    <th width="15%"><label for="qHeader">STAFF DEPARTMENT :</label></th>
                                                    <td colspan="2"><label for="qHeader">{{ strtoupper(isset($declare->staffs->staff_dept) ? $declare->staffs->staff_dept : '-')}}</label></td>
                                                    @endif
                                                    <th width="15%"><label for="qHeader">DEPARTMENT/PLACE TO GO :</label></th>
                                                    <td colspan="4"><label for="qHeader">{{ strtoupper(isset($declare->department->department_name) ? $declare->department->department_name : '-')}}</label></td>
                                                </div>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                
                                    <table id="info" class="table table-bordered table-hover table-striped w-100">
                                        <thead>
                                            <tr>
                                                <div class="form-group">
                                                    <th style="text-align: center" width="4%"><label class="form-label" for="qHeader">NO.</label></th>
                                                    <th style="text-align: center"><label class="form-label" for="qHeader">SELF-DECLARATION CHECKLIST</label></th>
                                                    <th style="text-align: center"><label class="form-label" for="qHeader">ANSWER</label></th>
                                                </div>
                                            </tr>
                                            @if(!empty($declare->q1))
                                            <tr class="q1">
                                                <div class="form-group">
                                                    <td style="text-align: center" width="4%"><label for="q1">1.</label></td>
                                                    <td width="80%"><label for="q1">Have you been confirmed positive with COVID-19 within 14 days?</label></td>
                                                    <td style="text-align: center">
                                                        @if ($declare->q1 == 'Y') YES @endif
                                                        @if ($declare->q1 == 'N') NO @endif
                                                    </td>
                                                </div>
                                            </tr>
                                            @endif
                                            @if(!empty($declare->q2))
                                            <tr class="q2">
                                                <div class="form-group">
                                                    <td style="text-align: center" width="4%"><label for="q2">2.</label></td>
                                                    <td><label for="q2">Have you had close contact with anyone who confirmed positive case of COVID-19 within 10 days?</label></td>
                                                    <td style="text-align: center">
                                                        @if ($declare->q2 == 'Y') YES @endif
                                                        @if ($declare->q2 == 'N') NO @endif
                                                    </td>
                                                </div>
                                            </tr>
                                            @endif
                                            @if(!empty($declare->q3))
                                            <tr class="q3">
                                                <div class="form-group">
                                                    <td style="text-align: center" width="4%"><label for="q3">3.</label></td>
                                                    <td><label for="q3">
                                                        Have you had close contact with any individual on question 2 within 10 days <b>OR</b><br>
                                                        Have you ever attended an event or visited any place involving suspected or positive COVID-19 case within 10 days <b>OR</b><br>
                                                        Are you from an area of Enhanced Movement Control Order (EMCO) in period of 10 days ?</label></td>
                                                    <td style="text-align: center; vertical-align: middle">
                                                        @if ($declare->q3 == 'Y') YES @endif
                                                        @if ($declare->q3 == 'N') NO @endif
                                                    </td>
                                                </div>
                                            </tr>
                                            @endif
                                            @if(!empty($declare->q4a) | !empty($declare->q4b) | !empty($declare->q4c) | !empty($declare->q4d))
                                                <tr>
                                                    <div class="form-group">
                                                        <td style="text-align: center" width="3%" rowspan="5"><label for="q4">4.</label></td>
                                                        <td><label for="q4">Do you experience the following symptoms:</label></td>
                                                        <td colspan="2"></td>
                                                    </div>
                                                </tr>
                                                @if(!empty($declare->q4a))
                                                    <tr>
                                                        <div class="form-group">
                                                            <td width="3%"><label for="q4a"><li>Fever</li></label></td>
                                                            <td style="text-align: center">
                                                                @if ($declare->q4a == 'Y') YES @endif
                                                                @if ($declare->q4a == 'N') NO @endif
                                                            </td>
                                                        </div>
                                                    </tr>
                                                @endif
                                                @if(!empty($declare->q4b))
                                                    <tr>
                                                        <div class="form-group">
                                                            <td width="3%"><label for="q4b"><li>Cough</li></label></td>
                                                            <td style="text-align: center">
                                                                @if ($declare->q4b == 'Y') YES @endif
                                                                @if ($declare->q4b == 'N') NO @endif
                                                            </td>
                                                        </div>
                                                    </tr>
                                                @endif
                                                @if(!empty($declare->q4c))
                                                    <tr>
                                                        <div class="form-group">
                                                            <td width="3%"><label for="q4c"><li>Flu</li></label></td>
                                                            <td style="text-align: center">
                                                                @if ($declare->q4c == 'Y') YES @endif
                                                                @if ($declare->q4c == 'N') NO @endif
                                                            </td>
                                                        </div>
                                                    </tr>
                                                @endif
                                                @if(!empty($declare->q4d))
                                                    <tr>
                                                        <div class="form-group">
                                                            <td width="3%"><label for="q4d"><li>Difficulty in Breathing</li></label></td>
                                                            <td style="text-align: center">
                                                                @if ($declare->q4d == 'Y') YES @endif
                                                                @if ($declare->q4d == 'N') NO @endif
                                                            </td>
                                                        </div>
                                                    </tr>
                                                @endif
                                            @endif
                                            <tr>
                                                <div class="form-group">
                                                    <td colspan="4">
                                                        <label for="confirmation" style="margin-left: 55px;"><b> OVERALL RESULT : </b><b style="font-size: 20px">CATEGORY {{$declare->category}}</b> [ Description on category ]</label>
                                                    </td>
                                                </div>
                                            </tr>
                                        </thead>
                                    </table>
                                    <a style="margin-right:5px" href="{{ URL::previous() }}" class="btn btn-success ml-auto float-right"><i class="fal fa-angle-double-left"></i> Back</a><br>
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
</script>
@endsection