@section('title', 'Profile Applicant')
@section('action', route('applicant.create'))

@extends('layouts.applicant')

@section('content')

<h1 class="title">Academic Information</h1>


<form method="post" action="{{ route('applicant.updateacademic',$applicant,$qualifications,$academic,$academics) }}">

    @csrf
    @method('get')
    @include('partials.errors')

    <div class="field">
        <label class="label">Highest Qualification</label>
        <div>Complete following fields with qualification details</div>
    </div>
    <div class="field">
        <label class="label">Qualification Type</label>
        {{ $qualifications->qualification_name }}
        <div class="control">
            <div class="select">
                <select name="qualification_type" required>  
                    <option value="$qualification">Select Qualification Type</option>
                    @foreach ($qualification as $qualifications)
                    <option value={{ $qualifications->id }}>{{ $qualifications->qualification_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

   

    
    
   

    <div class="field">
        <div class="control">
            <button type="submit" class="button is-link is-outlined">Update</button>
        </div>
    </div>

</form>

@endsection