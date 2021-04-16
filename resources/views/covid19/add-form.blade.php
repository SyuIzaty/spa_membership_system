@extends('layouts.covid')

@section('content')
<body>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-center">
                        <div class="p-2">
                            <center><img src="{{ asset('img/intec_logo.png') }}" style="max-width: 100%" class="responsive"/></center><br>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <center>
                        <div class="col-md-8">
                            <div class="card d-flex align-items-stretch">
                                <div class="card-header text-center">
                                    <span class="font-weight-bold">STANDARD OPERATING PROCEDURE (SOP)</span>
                                </div>
                                <div class="card-body">
                                    <div class="accordion accordion-outline accordion-hover" id="js_demo_accordion-5">
                                        <div class="card">
                                            <div class="card-header">
                                                <a href="javascript:void(0);" class="card-title" data-toggle="collapse" data-target="#js_demo_accordion-5a" aria-expanded="true">
                                                    SOP GUIDELINE IN INTEC EDUCATION COLLEGE
                                                    <span class="ml-auto">
                                                        <span class="collapsed-reveal">
                                                            <i class="fal fa-chevron-up fs-xl"></i>
                                                        </span>
                                                        <span class="collapsed-hidden">
                                                            <i class="fal fa-chevron-down fs-xl"></i>
                                                        </span>
                                                    </span>
                                                </a>
                                            </div>
                                            <div id="js_demo_accordion-5a" class="collapse show" data-parent="#js_demo_accordion-5" style="">
                                                <div class="card-body">
                                                    <table class="table table-bordered table-sm">
                                                        <tr>
                                                            <td class="text-nowrap">Rule 1:</td>
                                                            <td>Register attendance using MySejahtera when entering campus area.</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-nowrap">Rule 2:</td>
                                                            <td>Scan body temperature while entering the campus area with Security Guard on duty.</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-nowrap">Rule 3:</td>
                                                            <td> People with symptoms of fever, cough, cold, sore throat or difficulty breathing are NOT allowed to enter the campus area at all.</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-nowrap">Rule 4:</td>
                                                            <td> Maintain physical distance.</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-nowrap">Rule 5:</td>
                                                            <td> Maintain personal hygiene by always washing hands and using hand sanitiser.</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-nowrap">Rule 6:</td>
                                                            <td> Wear a face mask while on campus.</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        @if (Session::has('message'))
                                            <center><div class="alert alert-success responsive" style="color: #3b6324; background-color: #d3fabc; width: 100%; font-size: 14px;"> {!! session()->get('message') !!}</div></center>
                                        @endif
                                        @if (Session::has('msg'))
                                            <center><div class="alert alert-success responsive" style="color: #3b6324; background-color: #d3fabc; width: 100%; font-size: 14px;"> {!! session()->get('msg') !!}</div></center>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </center>
                </div>
            </div>
        </div>
    </div>
</body>
@endsection
