@extends('layouts.admin')

@section('css')
<link href="{{asset('css/app.css')}}" rel="stylesheet" type="text.css">
<!-- <link href="https://unpkg.com/primevue/resources/themes/saga-blue/theme.css " rel="stylesheet"> -->
@endsection

@section('content')
    <main id="js-page-content" role="main" class="page-content"
        style="background-image: url({{ asset('img/bg-form.jpg') }}); background-size: cover">

        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>
                            eVoting <small>Management</small><span class="fw-300"><i></i></span>
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
                            <!-- <div v-for="test in [{no:'1'},{no:'2'}]">
                                @{{test.no}}
                            </div>
                            <example-component/> -->
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
