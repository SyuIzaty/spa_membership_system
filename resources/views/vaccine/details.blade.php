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
                            <b>INTEC EDUCATION COLLEGE VACCINATION FORM DETAILS</b>
                        </h4>

                        <div class="panel-container show">
                            <div class="panel-content">
                                <div class="table-responsive">
                                    <table id="info" class="table table-bordered table-hover table-striped w-100">
                                        <thead>
                                            <tr>
                                                <div class="form-group">
                                                    <th width="15%"><label for="qHeader">NAME :</label></th>
                                                    <td colspan="2"><label for="qHeader">{{$vaccine->staffs->staff_name}}</label></td>
                                                    <th width="15%"><label for="qHeader">STAFF ID :</label></th>
                                                    <td colspan="2"><label for="qHeader">{{$vaccine->user_id}}</label></td>
                                                </div>
                                            </tr>
                                            <tr>
                                                <div class="form-group">
                                                    <th width="15%"><label for="qHeader">EMAIL :</label></th>
                                                    <td colspan="2"><label for="qHeader">{{ $vaccine->staffs->staff_email ?? '-'}}</label></td>
                                                    <th width="25%"><label for="qHeader">PHONE NO. :</label></th>
                                                    <td colspan="2"><label for="qHeader">{{ $vaccine->staffs->staff_phone ?? '-'}}</label></td>
                                                </div>
                                            </tr>
                                            <tr>
                                                <div class="form-group">
                                                    <th width="15%"><label for="qHeader">POSITION :</label></th>
                                                    <td colspan="2"><label for="qHeader">{{ $vaccine->staffs->staff_position ?? '-'}}</label></td>
                                                    <th width="25%"><label for="qHeader">DEPARTMENT :</label></th>
                                                    <td colspan="2"><label for="qHeader">{{ $vaccine->staffs->staff_dept ?? '-'}}</label></td>
                                                </div>
                                            </tr>
                                            <tr>
                                                <div class="form-group">
                                                    <th width="15%"><label for="qHeader">CREATED DATE :</label></th>
                                                    <td colspan="2"><label for="qHeader">{{strtoupper(date(' d/m/Y | h:i A', strtotime($vaccine->created_at) ))}}</label></td>
                                                    <th width="15%"><label for="qHeader">UPDATED DATE :</label></th>
                                                    <td colspan="2"><label for="qHeader">{{strtoupper(date(' d/m/Y | h:i A', strtotime($vaccine->updated_at) ))}}</label></td>
                                                </div>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>

                                <div class="panel-container show">
                                    <div class="panel-content">
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li class="nav-item active">
                                                <a data-toggle="tab" class="nav-link" href="#indv" role="tab">Individual</a>
                                            </li>
                                            @if($vaccine->q5 != '')
                                            <li class="nav-item">
                                                <a data-toggle="tab" class="nav-link" href="#dept" role="tab">Dependent</a>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="tab-content col-md-12">
                                        <div class="tab-pane active" id="indv" role="tabpanel">
                                            <table id="info" class="table table-bordered table-hover table-striped w-100">
                                                <thead>
                                                    <tr>
                                                        <div class="form-group">
                                                            <th style="text-align: center" width="4%"><label class="form-label" for="qHeader">NO.</label></th>
                                                            <th style="text-align: center"><label class="form-label" for="qHeader">VACCINATION CHECKLIST</label></th>
                                                            <th style="text-align: center"><label class="form-label" for="qHeader">ANSWER</label></th>
                                                        </div>
                                                    </tr>
                                                    @if(!empty($vaccine->q1))
                                                    <tr class="q1">
                                                        <div class="form-group">
                                                            <td style="text-align: center" width="4%"><label for="q1">1.</label></td>
                                                            <td width="50%"><label for="q1">Have Already Registered To Receive The COVID-19 Vaccine ?</label></td>
                                                            <td style="text-align: center">
                                                                @if ($vaccine->q1 == 'Y') YES @endif
                                                                @if ($vaccine->q1 == 'N') NO @endif
                                                            </td>
                                                        </div>
                                                    </tr>
                                                    @endif
                                                    @if(!empty($vaccine->q1_reason))
                                                    <tr class="q1">
                                                        <div class="form-group">
                                                            <td style="text-align: center" width="4%"><label for="q1_reason"></label></td>
                                                            <td width="50%"><label for="q1_reason">Reason :</label></td>
                                                            <td style="text-align: center">
                                                                {{ strtoupper($vaccine->reasons->reason_name) ?? '--' }}
                                                                @if(!empty($vaccine->q1_reason == 4))
                                                                    : {{ $vaccine->q1_other_reason }}
                                                                @endif
                                                            </td>
                                                        </div>
                                                    </tr>
                                                    @endif
                                                    @if(!empty($vaccine->q2))
                                                    <tr class="q2">
                                                        <div class="form-group">
                                                            <td style="text-align: center" width="4%"><label for="q2">2.</label></td>
                                                            <td><label for="q2">Have You Received An Appointment Date For The Vaccine Injection ?</label></td>
                                                            <td style="text-align: center">
                                                                @if ($vaccine->q2 == 'Y') YES @endif
                                                                @if ($vaccine->q2 == 'N') NO @endif
                                                            </td>
                                                        </div>
                                                    </tr>
                                                    @endif
            
                                                    @if(!empty($vaccine->q3))
                                                    <tr class="q3">
                                                        <div class="form-group">
                                                            <td style="text-align: center" width="4%"><label for="q3">3.</label></td>
                                                            <td><label for="q3">Have You Finished Receiving Your First Dose Vaccine ?</label></td>
                                                            <td style="text-align: center">
                                                                @if ($vaccine->q3 == 'Y') YES @endif
                                                                @if ($vaccine->q3 == 'N') NO @endif
                                                            </td>
                                                        </div>
                                                    </tr>
                                                    @endif
                                                    @if(!empty($vaccine->q3_date))
                                                    <tr class="q3_date">
                                                        <div class="form-group">
                                                            <td style="text-align: center" width="4%"><label for="q3_date"></label></td>
                                                            <td><label for="q3_date">First Dose Appointment Date :</label></td>
                                                            <td style="text-align: center">
                                                                {{ date('d-m-Y | h:i A', strtotime($vaccine->q3_date)) ?? '--'}}
                                                            </td>
                                                        </div>
                                                    </tr>
                                                    @endif
                                                    @if(!empty($vaccine->q3_effect))
                                                    <tr class="q3_effect">
                                                        <div class="form-group">
                                                            <td style="text-align: center" width="4%"><label for="q3_effect">4.</label></td>
                                                            <td><label for="q3_effect">First Dose Side Effect</label></td>
                                                            <td style="text-align: center">
                                                                @if ($vaccine->q3_effect == 'Y') YES @endif
                                                                @if ($vaccine->q3_effect == 'N') NO @endif
                                                            </td>
                                                        </div>
                                                    </tr>
                                                    @endif
                                                    @if(!empty($vaccine->q3_effect_remark))
                                                    <tr class="q3_effect_remark">
                                                        <div class="form-group">
                                                            <td style="text-align: center" width="4%"><label for="q3_effect_remark"></label></td>
                                                            <td><label for="q3_effect_remark">Side Effect Description</label></td>
                                                            <td style="text-align: center">
                                                                {{ strtoupper($vaccine->q3_effect_remark) ?? '--'}}
                                                            </td>
                                                        </div>
                                                    </tr>
                                                    @endif
            
                                                   
                                                    @if(!empty($vaccine->q4))
                                                    <tr class="q4">
                                                        <div class="form-group">
                                                            <td style="text-align: center" width="4%"><label for="q4">5.</label></td>
                                                            <td><label for="q4">Have You Finished Receiving Your Second Dose VSaccine ?</label></td>
                                                            <td style="text-align: center">
                                                                @if ($vaccine->q4 == 'Y') YES @endif
                                                                @if ($vaccine->q4 == 'N') NO @endif
                                                            </td>
                                                        </div>
                                                    </tr>
                                                    @endif
                                                    @if(!empty($vaccine->q4_date))
                                                    <tr class="q4_date">
                                                        <div class="form-group">
                                                            <td style="text-align: center" width="4%"><label for="q4_date"></label></td>
                                                            <td><label for="q4_date">Second Dose Appointment Date :</label></td>
                                                            <td style="text-align: center">
                                                                {{ date('d-m-Y | h:i A', strtotime($vaccine->q4_date)) }}
                                                            </td>
                                                        </div>
                                                    </tr>
                                                    @endif
                                                    @if(!empty($vaccine->q4_effect))
                                                    <tr class="q4_effect">
                                                        <div class="form-group">
                                                            <td style="text-align: center" width="4%"><label for="q4_effect">6.</label></td>
                                                            <td><label for="q4_effect">Second Dose Side Effect</label></td>
                                                            <td style="text-align: center">
                                                                @if ($vaccine->q4_effect == 'Y') YES @endif
                                                                @if ($vaccine->q4_effect == 'N') NO @endif
                                                            </td>
                                                        </div>
                                                    </tr>
                                                    @endif
                                                    @if(!empty($vaccine->q4_effect_remark))
                                                    <tr class="q4_effect_remark">
                                                        <div class="form-group">
                                                            <td style="text-align: center" width="4%"><label for="q4_effect_remark"></label></td>
                                                            <td><label for="q4_effect_remark">Side Effect Description</label></td>
                                                            <td style="text-align: center">
                                                                {{ strtoupper($vaccine->q4_effect_remark) ?? '--' }}
                                                            </td>
                                                        </div>
                                                    </tr>
                                                    @endif
                                                </thead>
                                            </table>
                                        </div>
                                        @if($vaccine->q5 != '')
                                        <div class="tab-pane" id="dept" role="tabpanel">
                                            <table id="infos" class="table table-bordered table-hover table-striped w-100">
                                                <thead>
                                                    <tr>
                                                        <div class="form-group">
                                                            <th style="text-align: center" width="4%"><label class="form-label" for="qHeader">NO.</label></th>
                                                            <th style="text-align: center"><label class="form-label" for="qHeader">DEPENDENT VACCINATION CHECKLIST</label></th>
                                                            <th style="text-align: center"><label class="form-label" for="qHeader">ANSWER</label></th>
                                                        </div>
                                                    </tr>
                                                    @if(!empty($vaccine->q5))
                                                    <tr class="q5">
                                                        <div class="form-group">
                                                            <td style="text-align: center" width="4%"><label for="q5">1.</label></td>
                                                            <td width="50%"><label for="q5">Do You Have a Spouse ?</label></td>
                                                            <td style="text-align: center">
                                                                @if ($vaccine->q5 == 'Y') YES @endif
                                                                @if ($vaccine->q5 == 'N') NO @endif
                                                            </td>
                                                        </div>
                                                    </tr>
                                                    @endif
                                                    @if(!empty($vaccine->q5_appt))
                                                    <tr class="q5_appt">
                                                        <div class="form-group">
                                                            <td style="text-align: center" width="4%"><label for="q5_appt">2.</label></td>
                                                            <td width="50%"><label for="q5_appt">Has Your Spouse Received a Vaccination Appointment ?</label></td>
                                                            <td style="text-align: center">
                                                                @if ($vaccine->q5_appt == 'Y') YES @endif
                                                                @if ($vaccine->q5_appt == 'N') NO @endif
                                                            </td>
                                                        </div>
                                                    </tr>
                                                    @endif
                                                    @if(!empty($vaccine->q5_name))
                                                    <tr class="q5_name">
                                                        <div class="form-group">
                                                            <td style="text-align: center" width="4%"><label for="q5_name"></label></td>
                                                            <td><label for="q5_name">Spouse Name : </label></td>
                                                            <td style="text-align: center">{{ strtoupper( $vaccine->q5_name )}}</td>
                                                        </div>
                                                    </tr>
                                                    @endif
                                                    @if(!empty($vaccine->q5_first_dose))
                                                    <tr class="q5_first_dose">
                                                        <div class="form-group">
                                                            <td style="text-align: center" width="4%"><label for="q5_first_dose"></label></td>
                                                            <td><label for="q5_first_dose">First Dose Appointment Date :</label></td>
                                                            <td style="text-align: center">
                                                                {{ date('d-m-Y | h:i A', strtotime($vaccine->q5_first_dose)) ?? '--'}}
                                                            </td>
                                                        </div>
                                                    </tr>
                                                    @endif
                                                    @if(!empty($vaccine->q5_second_dose))
                                                    <tr class="q5_second_dose">
                                                        <div class="form-group">
                                                            <td style="text-align: center" width="4%"><label for="q5_second_dose"></label></td>
                                                            <td><label for="q5_second_dose">Second Dose Appointment Date :</label></td>
                                                            <td style="text-align: center">
                                                                {{ date('d-m-Y | h:i A', strtotime($vaccine->q5_second_dose)) ?? '--'}}
                                                            </td>
                                                        </div>
                                                    </tr>
                                                    @endif
                                                    @if(!empty($vaccine->q6))
                                                    <tr class="q6">
                                                        <div class="form-group">
                                                            <td style="text-align: center" width="4%"><label for="q6">3.</label></td>
                                                            <td><label for="q6">Do You Have Children 18 Years and Above ?</label></td>
                                                            <td style="text-align: center">
                                                                @if ($vaccine->q6 == 'Y') YES @endif
                                                                @if ($vaccine->q6 == 'N') NO @endif
                                                            </td>
                                                        </div>
                                                    </tr>
                                                    @endif
                                                    @if($vaccine->q6 == 'Y')
                                                    <tr>
                                                        <div class="form-group">
                                                            <td colspan="5">
                                                                <table class="table table-bordered text-center">
                                                                    <thead>
                                                                        <tr class="bg-primary-50">
                                                                            <td>Child Name</td>
                                                                            <td>Has Your Children Received a Vaccination Appointment ?</td>
                                                                            <td>First Dose Appointment Date</td>
                                                                            <td>Second Dose Appointment Date</td>
                                                                        </tr>
                                                                        <tr>
                                                                            @foreach ($dependent as $childs)
                                                                            <tr class="data-row">
                                                                                <td style="text-align: center">{{ isset($childs->child_name) ? strtoupper($childs->child_name) : '--' }}</td>
                                                                                <td style="text-align: center">
                                                                                    @if ($childs->child_appt == 'Y') YES @endif
                                                                                    @if ($childs->child_appt == 'N') NO @endif
                                                                                </td>
                                                                                <td style="text-align: center">{{ isset($childs->first_dose_date) ? date('d-m-Y | h:i A', strtotime($childs->first_dose_date)) : '--' }}</td>
                                                                                <td style="text-align: center">{{ isset($childs->second_dose_date) ? date('d-m-Y | h:i A', strtotime($childs->second_dose_date)) : '--' }}</td>
                                                                            </tr>
                                                                            @endforeach
                                                                        
                                                                        </tr>
                                                                    </thead>
                                                                </table>
                                                            </td>
                                                        </div>
                                                    </tr>
                                                    @endif
                                                </thead>
                                            </table>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                
                                <a style="margin-right:5px" href="{{ URL::previous() }}" class="btn btn-success ml-auto float-right"><i class="fal fa-arrow-alt-left"></i> Back</a><br>
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
    //
</script>
@endsection