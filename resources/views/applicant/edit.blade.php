@section('title', 'Edit Applicant')
@section('action', route('applicant.create'))

@extends('layouts.applicant')

@section('content')

<h1 class="title">Profile:{{$applicant->applicant_name}}</h1>


<form method="post" action="{{ route('applicant.update',$applicant,$programme,$program) }}">

    @csrf
    @method('patch')
    @include('partials.errors')

    <div class="field">
        <label class="label">Name</label>
        <div class="control">
            <input type="text" name="applicant_name" value="{{ $applicant->applicant_name }}" class="input" placeholder="Your Name" minlength="3" maxlength="100" required />
        </div>
    </div>

    <div class="field">
        <label class="label">IC No.</label>
        <div class="control">
            <input type="text" name="applicant_ic" value="{{$applicant->applicant_ic}}" class="input" placeholder=""  required />
        </div>
    </div>

    <div class="field">
        <label class="label">Email</label>
        <div class="control">
            <input type="text" name="applicant_email" value="{{$applicant->applicant_email}}" class="input" placeholder="yourmail@mail.com"  required />
        </div>
    </div>

    <div class="field">
        <label class="label">Mobile No.</label>
        <div class="control">
            <input type="text" name="applicant_phone" value="{{$applicant->applicant_phone}}" class="input" placeholder="0123456789"  required />
        </div>
    </div>

    <div class="field">
        <label class="label">Nationality</label>
        <div class="control">
            <div class="select">
                <select name="applicant_nationality" required>
                    <option value="" disabled selected>Select Nationality</option>
                    <option value="MALAYSIAN" {{ $applicant->applicant_nationality === 'MALAYSIAN' ? 'selected' : null }}>MALAYSIAN</option>
                    <option value="INTERNATIONAL" {{ $applicant->applicant_nationality === 'INTERNATIONAL' ? 'selected' : null }}>INTERNATIONAL</option>
                </select>
            </div>
        </div>
    </div>


    
    
    <div class="field">
        <label class="label">Preferred Program</label>
    </div>
    <div class="field">
        <label class="label">1st Preferred Programme</label>
        <div class="control">
            <div class="select">
                <select name="applicant_programme" required>  
                    
                @foreach ($programme as $program)
                <option value={{ $program->id }}>{{ $program->programme_name }}</option>
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