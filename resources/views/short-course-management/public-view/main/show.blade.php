@extends('layouts.admin')

@section('content')

    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-table'></i> Open View (Details)
            </h1>
        </div>
        <h1 class="text-center heading text-iceps-blue">
            Short Course - <b class="semi-bold">{{$event->name}}</b>
        </h1>
        <hr class="mt-2 mb-3">
        <div class="row">
        </div>
    </main>

@endsection
