@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content">

    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2 style="font-size: 25px;">
                        Address & Contact Info <small>| student's address and contact information</small> <span class="fw-300"><i> </i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>

                </div>

                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="card card-primary card-outline" id="details">
                            
                            <div class="alert alert-warning alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h5><i class="icon fal fa-info"></i> Message</h5>
                                Please check your address information. Update the information if have any errors.
                            </div>
                            
                            @if (Session::has('message'))
                            <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('message') }}</div>
                            @endif

                            <div class="card-header bg-highlight">
                                <h5 class="card-title w-100">ADDRESS & CONTACT DETAILS</small></h5>
                            </div>
                                <div class="card-body">
                                    <table id="permanent_address" class="table table-bordered table-hover table-striped w-100">
                                        <thead>
                                            <tr>
                                                <td width="21%"><b>Address :</b></td>
                                                <td colspan="10"> {{ $student->studentContactInfo->students_address_1 }}, {{ $student->studentContactInfo->students_address_2 }}, {{ $student->studentContactInfo->students_poscode }}, {{ $student->studentContactInfo->students_city }}, {{ $student->studentContactInfo->state->state_name }}</td>
                                            </tr>

                                            <tr>
                                                <td width="21%"><b>Phone No. :</b></td>
                                                <td colspan="10"> {{ $student->students_phone }} </td>
                                            </tr>

                                            <tr>
                                                <td width="21%"><b>Email :</b></td>
                                                <td colspan="10"> {{ $student->students_email }} </td>
                                            </tr>

                                            <tr>
                                                <td width="21%"><b>INTEC Email :</b></td>
                                                <td colspan="10">  </td>
                                            </tr>
                                        </thead>
                                    </table> 
                                    <a class="btn btn-warning ml-auto float-right" href="/student/biodata/addressContact_edit/{{Auth::user()->id}}"><i class="fal fa-pencil"></i> Edit</a> 
                                     
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

