@extends('layouts.admin')

@section('css')
<link href="{{asset('css/app.css')}}" rel="stylesheet" type="text.css">
@endsection

@section('content')
    <main id="js-page-content" role="main" class="page-content"
        style="background-image: url({{ asset('img/bg-form.jpg') }}); background-size: cover">

        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>
                            eVoting <span class="fw-300"><i> </i></span>
                        </h2>
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
                        <div class="panel-content" id="app" >
                            <!-- <div id="app" class=" full-height">
                                <div class="flex-center position-ref" style="height:90%">
                                    <div class="content h-100 w-100 p-3 p-md-5" style="position:absolute;padding-top:1rem !important;">
                                        <router-view></router-view>
                                    </div>
                                </div>
                            </div> -->

                            <router-view></router-view>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </main>
@endsection

@section('script')

<script src="{{ asset('js/app.js') }}"></script>
@endsection
