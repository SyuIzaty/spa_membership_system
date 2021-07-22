@extends('layouts.admin')

@section('content')

    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-table'></i> Open View
            </h1>
        </div>
        <h1 class="text-center heading text-iceps-blue">
            <b class="semi-bold">Featured</b> Short Courses
        </h1>
        <hr class="mt-2 mb-3">
        <div class="row">
            @foreach ($events as $event)
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                    <div class="card mb-3" style="max-width: 540px;">
                        <div class="row no-gutters">
                            <div class="col-md-4">
                                <img src="/get-file-event/intec_poster.jpg" class="card-img" alt="..."
                                    style="width:137px;height:194px;">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title"><b>{{ $event->name }}</b></h5>
                                    <p class="card-text"><small
                                            class="text-muted">Published: {{ $event->created_at_diffForHumans }}</small>
                                    </p>
                                    <a href="/event/public-view/{{$event->id}}" class="btn btn-sm btn-primary btn btn-block">Detail</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </main>

@endsection
