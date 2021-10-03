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
                            <b>INTEC EDUCATION COLLEGE TRAINING HOURS CLAIM DETAILS</b>
                        </h4>

                        <div class="panel-container show">
                            <div class="panel-content">
                                <div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-striped w-100">
                                            <thead>
                                                <div style="float: left"><i>Submitted Date : {{ date(' j F Y | h:i:s A', strtotime($claim->created_at) )}}</i></div><br>
                                                <tr>
                                                    <div class="form-group">
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label"> Full Name :</label></td>
                                                        <td colspan="3">
                                                            {{ $claim->staffs->staff_name ?? '--'}}
                                                        </td>
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label"> Staff ID :</label></td>
                                                        <td colspan="3">
                                                            {{ $claim->staffs->staff_id ?? '--'}}
                                                        </td>
                                                    </div>
                                                </tr>
                                                <tr>
                                                    <div class="form-group">
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label"> Position :</label></td>
                                                        <td colspan="3">
                                                            {{ $claim->staffs->staff_position ?? '--'}}
                                                        </td>
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label"> Department :</label></td>
                                                        <td colspan="3">
                                                            {{ $claim->staffs->staff_dept ?? '--'}}
                                                        </td>
                                                    </div>
                                                </tr>
                                                <tr>
                                                    <div class="form-group">
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label"> Training Title :</label></td>
                                                        <td colspan="6" style="text-transform: uppercase">
                                                            #{{ $claim->training_id ?? '--'}} : {{ $claim->title ?? '--'}}
                                                        </td>
                                                    </div>
                                                </tr>
                                                <tr>
                                                    <div class="form-group">
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label"> Type of Training :</label></td>
                                                        <td colspan="3" style="text-transform: uppercase">
                                                            {{ $claim->types->type_name ?? '--'}}
                                                        </td>
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label"> Category of Training :</label></td>
                                                        <td colspan="3" style="text-transform: uppercase">
                                                            {{ $claim->categories->category_name ?? '--'}}
                                                        </td>
                                                    </div>
                                                </tr>
                                                <tr>
                                                    <div class="form-group">
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label"> Start Date :</label></td>
                                                        <td colspan="3">
                                                            {{ date(' d/m/Y ', strtotime($claim->start_date) ) ?? '--'}}
                                                        </td>
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label"> End Date :</label></td>
                                                        <td colspan="3">
                                                            {{ date(' d/m/Y ', strtotime($claim->end_date) ) ?? '--'}}
                                                        </td>
                                                    </div>
                                                </tr>
                                                @if($claim->status == '1')
                                                <tr>
                                                    <div class="form-group">
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label"> Time :</label></td>
                                                        <td colspan="3">
                                                            {{ date(' h:i A ', strtotime($claim->start_time) ) ?? '--'}} -  {{ date(' h:i A ', strtotime($claim->end_time) ) ?? '--'}}
                                                        </td>
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label"> Claim Hours :</label></td>
                                                        <td colspan="3">
                                                            {{ $claim->claim_hour ?? '--'}} HOURS
                                                        </td>
                                                    </div>
                                                </tr>
                                                @endif
                                                @if($claim->status == '2' || $claim->status == '3')
                                                <tr>
                                                    <div class="form-group">
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label"> Start Time :</label></td>
                                                        <td colspan="3">
                                                            {{ date(' h:i A ', strtotime($claim->start_time) ) ?? '--'}}
                                                        </td>
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label"> End Time :</label></td>
                                                        <td colspan="3">
                                                            {{ date(' h:i A ', strtotime($claim->end_time) ) ?? '--'}} 
                                                        </td>
                                                    </div>
                                                </tr>
                                                <tr>
                                                    <div class="form-group">
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label"> Claim Hours :</label></td>
                                                        <td colspan="3">
                                                            {{ $claim->claim_hour ?? '--'}} HOURS
                                                        </td>
                                                        @if($claim->status == '2')
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label"> Approved Hours :</label></td>
                                                        <td colspan="3">
                                                            {{ $claim->approved_hour ?? '--'}} HOURS
                                                        </td>
                                                        @endif
                                                        @if($claim->status == '3')
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label"> Reject Reason :</label></td>
                                                        <td colspan="3">
                                                            {{ $claim->reject_reason ?? '--'}} 
                                                        </td>
                                                        @endif
                                                    </div>
                                                </tr>
                                                @endif
                                                <tr>
                                                    <div class="form-group">
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label"> Venue :</label></td>
                                                        <td colspan="3" style="text-transform: uppercase">
                                                            {{ $claim->venue ?? '--'}}
                                                        </td>
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label"> Link :</label></td>
                                                        <td colspan="3">
                                                            @if(isset($claim->link ))
                                                                <a href="{{ $claim->link ?? '--'}}" target="_blank"> {{ $claim->link }} </a>
                                                            @else 
                                                                --
                                                            @endif
                                                        </td>
                                                    </div>
                                                </tr>
                                                <tr>
                                                    <div class="form-group">
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label"> Attachment : </label></td>
                                                        <td colspan="3">
                                                            @foreach ($attachment as $attachments)
                                                                <a target="_blank" href="{{ url('claim')."/".$attachments->file_name }}/Download">{{ $attachments->file_name }}</a>
                                                            @endforeach
                                                        </td>
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label"> Status : </label></td>
                                                        <td colspan="3">
                                                            @if($claim->status=='1')
                                                               <span class="badge badge-done" style="padding : 0.8em 1.6em">{{ strtoupper($claim->claimStatus->status_name) }}</span>
                                                            @elseif($claim->status=='2')
                                                                <span class="badge badge-success" style="padding : 0.8em 1.6em">{{ strtoupper($claim->claimStatus->status_name) }}</span>
                                                            @else
                                                                <span class="badge badge-duplicate" style="padding : 0.8em 1.6em">{{ strtoupper($claim->claimStatus->status_name) }}</span>
                                                            @endif
                                                        </td>
                                                    </div>
                                                </tr>
                                            </thead>
                                        </table>
                                        <a href="{{ url()->previous() }}" class="btn btn-primary ml-auto float-right"><i class="fal fa-arrow-alt-left"></i> Back</a>
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

    $(document).ready( function() {
        $('#type, #category').select2();
    })

</script>
@endsection

