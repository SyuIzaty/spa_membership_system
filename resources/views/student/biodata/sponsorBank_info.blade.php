@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content">

    {{-- <div class="subheader">
        <h1>
            <i class='subheader-icon fal fa-plus-circle'></i> Basic Info <small>| student's basic information</small>
        </h1>
    </div> --}}

    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2 style="font-size: 25px;">
                        Sponsorship and Bank Info <small>| student's sponsorship and bank information</small> <span class="fw-300"><i> </i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>

                </div>

                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="card card-primary card-outline">
                            
                            <div class="alert alert-warning alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h5><i class="icon fal fa-info"></i> Message</h5>
                                Please check your bank and sponsorship information.
                            </div>

                        <div class="card-header bg-highlight">
                            <h5 class="card-title w-100">BANK ACCOUNT DETAILS</h5>
                        </div>
                            <div class="card-body">
                                <table id="bank" class="table table-bordered table-hover table-striped w-100">
                                    <thead>
                                        <tr>
                                            <td width="21%"><b>Account Number:</b></td>
                                            <td colspan="10"> </td>
                                        </tr>

                                        <tr>
                                            <td width="21%"><b>Bank Name :</b></td>
                                            <td colspan="10"> </td>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="card card-primary card-outline">
                        <div class="card-header bg-highlight">
                            <h5 class="card-title w-100">SPONSORSHIP DETAILS</h5>
                        </div>
                            <div class="card-body">
                                <table id="sponsor" class="table table-bordered table-hover table-striped w-100">
                                    <thead>
                                        <tr>
                                            <td width="21%"><b>Sponsor Name :</b></td>
                                            <td colspan="10"> </td>
                                        </tr>

                                        <tr>
                                            <td width="21%"><b>Sponsorship Status :</b></td>
                                            <td colspan="10"> </td>
                                        </tr>

                                        <tr>
                                            <td width="21%"><b>Amount Per Semester :</b></td>
                                            <td colspan="5"> </td>
                                            <td width="21%"><b>Amount Per Year :</b></td>
                                            <td colspan="5"> </td>
                                        </tr>

                                        <tr>
                                            <td width="21%"><b>Guarantor I :</b></td>
                                            <td colspan="5"> </td>
                                            <td width="21%"><b>Guarantor's Address :</b></td>
                                            <td colspan="5"> </td>
                                        </tr>

                                        <tr>
                                            <td width="21%"><b>Guarantor II :</b></td>
                                            <td colspan="5"> </td>
                                            <td width="21%"><b>Guarantor's Address :</b></td>
                                            <td colspan="5"> </td>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</main>
@endsection

