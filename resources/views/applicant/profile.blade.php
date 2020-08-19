@section('title', 'Profile Applicant')
@section('action', route('applicant.create'))

@extends('layouts.applicant')

@section('content')

<h1 class="title">Profile Information</h1>


<form method="post" action="{{ route('applicant.update',$applicant) }}">

    @csrf
    @method('patch')
    @include('partials.errors')
    <div class="field">
        <label class="label">ID</label>
        <div class="control">
            <input type="text" name="id" value="{{ $applicant->id }}" class="input" placeholder="" minlength="3" maxlength="100" required />
        </div>
    </div>
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
        <label class="label">Gender</label>
        <div class="control">
            <div class="select">
                <select name="applicant_gender" required>
                    <option value="" disabled selected>Select Gender</option>
                    <option value="MALE" {{ $applicant->applicant_gender === 'MALE' ? 'selected' : null }}>MALE</option>
                    <option value="FEMALE" {{ $applicant->applicant_gender === 'FEMALE' ? 'selected' : null }}>FEMALE</option>
                </select>
            </div>
        </div>
    </div>

    <div class="field">
        <label class="label">Religion</label>
        <div class="control">
            <div class="select">
                <select name="applicant_religion" required>
                    <option value="" disabled selected>Select Religion</option>
                    <option value="ISLAM" {{ $applicant->applicant_religion === 'ISLAM' ? 'selected' : null }}>ISLAM</option>
                    <option value="CHRISTIAN" {{ $applicant->applicant_religion === 'CHRISTIAN' ? 'selected' : null }}>CHRISTIAN</option>
                    <option value="BUDDHIST" {{ $applicant->applicant_religion === 'BUDDHIST' ? 'selected' : null }}>BUDDHIST</option>
                    <option value="HINDUISM" {{ $applicant->applicant_religion === 'HINDUISM' ? 'selected' : null }}>HINDUISM</option>
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