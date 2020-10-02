@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content">

    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2 style="font-size: 25px;">
                        Residential Records <small>| student's residential record</small> <span class="fw-300"><i> </i></span>
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
                                Please check your residential info. Contact INTEC Residential Staff if have any errors.
                            </div>
                            
                            <div class="card-body">
                                
                                <div class="box box-primary" id="printable">
                                    <div class="box-header with-border">
                                        <h3 style="font-weight: bold;" class="box-title">LIST OF RESIDENTIAL RECORDS</h3>
                                    </div>
                                   
                                    <div class="box-body table-responsive">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr class="bg-highlight">
                                                    <th style="text-align:center;">SESSION</th>
                                                    <th style="text-align:center;">SEMESTER</th>
                                                    <th style="text-align:center;">RESIDENTIAL COLLEGE</th>
                                                    <th style="text-align:center;">BLOCK</th>
                                                    <th style="text-align:center;">ROOM</th>
                                                    <th style="text-align:center;">CHECK-IN DATE</th>
                                                    <th style="text-align:center;">CHECK-OUT DATE</th>
                                                    <th style="text-align:center;">STATUS</th>
                                                </tr>
                                            
                                                <tr>
                                                    <td style="text-align: center"></td>
                                                    <td style="text-align: center"></td>
                                                    <td style="text-align: center"></td>
                                                    <td style="text-align: center"></td>
                                                    <td style="text-align: center"></td>
                                                    <td style="text-align: center"></td>
                                                    <td style="text-align: center"></td>
                                                    <td style="text-align: center"></td>
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

