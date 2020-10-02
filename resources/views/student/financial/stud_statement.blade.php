@extends('layouts.admin')

@section('css') 
<link rel="stylesheet" href="{{ asset('css/print_select.css') }}" />
@endsection

@section('content')
<main id="js-page-content" role="main" class="page-content">

    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2 style="font-size: 25px;">
                        Financial Statement <small>| student's financial statement</small> <span class="fw-300"><i> </i></span>
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
                                Please check your financial statement details. Contact Bursary Office if have an errors.
                            </div>
            
                            <div class="card-body">
                                <div align="right" id="non-printable"><a class="btn btn-app" onclick="javascript:window.print()"><i class="fal fa-print"></i> Print </a></div>
                                <div class="box box-primary" id="printable">
                                    <div class="box-header with-border" align="center">
                                      <div><img src="{{ URL::to('/') }}/img/intec_logo_new.png" height="70" width="180" alt="INTEC"></div>
                                      <div><p></p><h3 valign="center" class="box-title"><strong>INTEC EDUCATION COLLEGE<br>STUDENT'S FINANCIAL STATEMENT</strong></h3><p></p></div>
                                    </div>
                                    
                                    <div class="box-body table-responsive">
                                      <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <th style="width: 10%">Student's Name</th>
                                                <td colspan="5"></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 10%">Student ID</th>
                                                <td colspan="5"></td>
                                            </tr>
                                             <tr>
                                                <th style="width: 10%">IC/Passport Number</th>
                                                <td colspan="5"></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 10%">Address</th>
                                                <td colspan="5"></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 10%">Phone Number</th>
                                                <td colspan="5"></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 10%">Sponsor</th>
                                                <td colspan="5"></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 10%">Programme</th>
                                                <td colspan="5"></td>
                                            </tr>

                                            <tr class="bg-highlight">
                                                <th style="width: 10%; text-align: center;">SEMESTER/SESSION</th>
                                                <th style="width: 10%; text-align: center;">DEBIT (MYR)</th>
                                                <th style="width: 10%; text-align: center;">CREDIT (MYR)</th>
                                                <th style="width: 10%; text-align: center;">EXEMPTION (MYR)</th>
                                                <th style="width: 10%; text-align: center;">BALANCE (MYR)</th>
                                                <th style="width: 3%;"></th>
                                            </tr>
                                            <tr>
                                                <td style="text-align: center;"></td>
                                                <td style="text-align: center;"></td>
                                                <td style="text-align: center;"></td>
                                                <td style="text-align: center;"></td>
                                                <td style="text-align: center;"></td>
                                                <td style="text-align: center;"><a href="javascript:void(0)" id="details" data-toggle="modal">Details</a>
                                            </tr>
                                            <tr>
                                                <th style="width: 10%; text-align: right;"><right>TOTAL</right></th>
                                                <th style="text-align: center;"></th>
                                                <th style="text-align: center;"></th>
                                                <th style="text-align: center;"></th>
                                                <th style="text-align: center;"></th>
                                                <th></th>
                                            </tr>
                                        </tbody>
                                      </table>
                                    </div>

                                    <!-- Start Details modal based on session bill -->
                                    <div class="modal fade" id="modal" aria-hidden="true" >
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="detailsModal"><strong>DETAILS FOR SESSION ?</strong></h4>
                                                </div>

                                                <div class="modal-body">
                                                    <table class="table table-bordered">
                                                        <tbody>
                                                            <tr class="bg-highlight">
                                                                <th>FEES / SERVICES / FINES</th>
                                                                <th>CODE</th>
                                                                <th style="text-align: right;">DEBIT (MYR)</th>
                                                            </tr>
                                                            <!-- dummy data -->
                                                            <tr>		
                                                                <td>Tabung Aktiviti Pelajar</td>
                                                                <td>A1234</td>
                                                                <td style="text-align: right;">20</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>	
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                </div>
                                                    
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Details modal -->

                                    <div class="box-header with-border">
                                      <h3 class="box-title"><strong>IMPORTANT REMINDER</strong></h3>
                                    </div>
                                    <div class="box-body">
                                        <li>Payment can be made by ONLINE PAYMENT : <a href="#" target="_blank">https://</a></li>  
                                        <li>Failure to do so will result in cancellation of course registration, suspension of examination results and any other actions as imposed in the Student's Payment Rules and Regulations</li> 
                                        <p></p>
                                        Thank you for your cooperation.
                                        <p></p><p></p>
                                        b/p Bendahari <br>
                                        INTEC Education College
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

$(document).ready(function () {

/* Show Details Modal */
$('body').on('click', '#details', function () {
$('#detailsModal');
$('#modal').modal('show');
});

});

</script>

@endsection

