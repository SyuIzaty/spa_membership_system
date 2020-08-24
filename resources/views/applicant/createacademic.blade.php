@section('title', 'Profile Applicant')
@section('action', route('applicant.create'))

@extends('layouts.applicant')

@section('content')

<h1 class="title">Academic Qualification</h1>


<form method="post" action="{{ route('applicant.storeacademic',$applicant,$applicantacademic) }}">

    @csrf
    @method('get')
    @include('partials.errors')

    
    <div class="field">
        <label class="label">Highest Qualification</label>
        <div>Complete following fields with qualification details</div>
    </div>
    <div class="field">
        <label class="label">Qualification Type</label>
       
        <div class="control">
            <div class="select">
                <select name="qualification_type" required>  
                    <option value="$qualification">Select Qualification Type</option>
                    @foreach ($qualifications as $qualification)
                    <option value={{ $qualification->id }}>{{ $qualification->qualification_code }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    

    <div class="field">
        <div class="control">
            <button type="submit" class="button is-link is-outlined">Create</button>
            <a href="{{route('applicant.contactinfo',$applicant)}}" button type="back"  class="button is-link is-outlined">back</a></button>
        </div>
    </div>

</form>

@endsection