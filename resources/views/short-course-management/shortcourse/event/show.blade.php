@extends('layouts.shortcourse_portal')

@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <x-ShortCourseManagement.PublicViewEventDetail :errors=$errors :event=$event/>
    </main>

@endsection
