@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-file'></i> File Classification
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip"
                                data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip"
                                data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10"
                                data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                            <div class="row">
                                <div class="tab-content col-md-12">
                                    <div class="row">
                                        <div class="col-md-12 grid-margin stretch-card">
                                            <div class="card">
                                                <div class="card-header"><b>Notes</b>
                                                </div>
                                                <div class="card-body">
                                                    {{-- <div class="row">
                                                        <div class="form-group col-md-12">
                                                            <table class="table table-bordered">
                                                                <tbody>
                                                                    <tr class="card-header text-center">
                                                                        <th style="background-color:#EEE2C7; vertical-align: middle;"
                                                                            rowspan="2">Forms
                                                                            Code</th>
                                                                        <td class="text-center"
                                                                            style="background-color:#ffffff;">
                                                                            (Work Process)/(INTEC Code)/(Department
                                                                            Code)/(Unit Code)/(No. of
                                                                            Documents)-(No. of
                                                                            Forms)
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-center">
                                                                            i.e: <b>WP/INTEC/QA/RC/01-01</b>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div> --}}
                                                </div>
                                            </div>
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
        $(document).ready(function() {


        });
    </script>
@endsection
