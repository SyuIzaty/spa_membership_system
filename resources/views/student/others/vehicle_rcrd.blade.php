@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content">

    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2 style="font-size: 25px;">
                        Vehicle Records <small>| student's vehicle record</small> <span class="fw-300"><i> </i></span>
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
                                Please check your vehicle info. Contact INTEC Security Unit if have any errors.
                            </div>
                            
                            <div class="card-body">
                                
                                <div class="box box-primary" id="printable">
                                    <div class="box-header with-border">
                                        <h3 style="font-weight: bold;" class="box-title">LIST OF VEHICLE REGISTERED</h3>
                                    </div>
                                   
                                        <div class="box-body table-responsive">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <tr class="bg-highlight">
                                                        <th style="text-align: center;">SESSION</th>
                                                        <th style="text-align: center;">PLATE NUMBER</th>
                                                        <th style="text-align: center;">STICKER NUMBER</th>
                                                        <th style="text-align: center;">REGISTRATION DATE</th>
                                                        <th style="text-align: center;">VEHICLE TYPE</th>
                                                        <th style="text-align: center;">MODEL</th>
                                                        <th style="text-align: center;">COLOUR</th>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="10"><span style="color: red; font-weight: bold;">ATTENTION</span>
                                                            <li>The record shows the vehicle information registered for each session in INTEC.</li>  
                                                            <li>You are responsible to ensure that your vehicle are registered with valid stickers from the INTEC Security Unit for each current session</li>
                                                            <li>Failure to do so will cause you to be given a warning or fine.</li> 
                                                            <p></p>
                                                            Thank you for your cooperation.
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>           
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

