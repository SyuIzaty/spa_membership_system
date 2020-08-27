@section('title', 'New Applicant')

@extends('layouts.applicant2')

@section('content')

<h1 class="title">NEW APPLICATION</h1>


<form method="post" action="{{ route('applicant.store') }}">

    @csrf
    @include('partials.errors')

    <div class="field">
        <label class="label">Name</label>
        <div class="control">
            <input type="text" name="applicant_name" value="{{ old('applicant_name') }}" class="input" placeholder="Your Name" minlength="3" maxlength="100" required />
        </div>
    </div>

    <div class="field">
        <label class="label">IC No.</label>
        <div class="control">
            <input type="text" name="applicant_ic" value="{{ old('applicant_ic') }}" class="input" placeholder="920123101234"  required />
        </div>
    </div>

    <div class="field">
        <label class="label">Email</label>
        <div class="control">
            <input type="text" name="applicant_email" value="{{ old('applicant_email') }}" class="input" placeholder="yourmail@mail.com"  required />
        </div>
    </div>

    <div class="field">
        <label class="label">Mobile No.</label>
        <div class="control">
            <input type="text" name="applicant_phone" value="{{ old('applicant_phone') }}" class="input" placeholder="0123456789"  required />
        </div>
    </div>

    <div class="field">
        <label class="label">Preferred Program</label>
    </div>
    <div class="field">
        <label class="label">1st Preferred Programme (Required)</label>
        <div class="control">
            <div class="select">
                <select name="applicant_programme" required>  
                    <option value="$program">Select Programme</option>
                    @foreach ($programme as $program)
                    <option value={{ $program->id }}>{{ $program->programme_code }}-{{ $program->programme_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="field">
        <label class="label">2nd Preferred Programme (Optional)</label>
        <div class="control">
            <div class="select">
                <select name="applicant_programme_2" required>  
                <option value="$program">Select Programme</option>
                    @foreach ($programme as $program)
                    <option value={{ $program->id }}>{{ $program->programme_code }}-{{ $program->programme_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="field">
        <label class="label">3rd Preferred Programme (Required)</label>
        <div class="control">
            <div class="select">
                <select name="applicant_programme_3" required>  
                <option value="$program">Select Programme</option>
                    @foreach ($programme as $program)
                    <option value={{ $program->id }}>{{ $program->programme_code }}-{{ $program->programme_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="field">
        <label class="label">Nationality</label>
        <div class="control">
            <div class="select">
                <select name="applicant_nationality" required>
                    <option value="" disabled selected>Select Nationality</option>
                    <option value="MALAYSIAN" {{ old('applicant_nationality') === 'MALAYSIAN' ? 'selected' : null }}>MALAYSIAN</option>
                    <option value="INTERNATIONAL" {{ old('applicant_nationality') === 'INTERNATIONAL' ? 'selected' : null }}>INTERNATIONAL</option>
                </select>
            </div>
        </div>
    </div>

    <div class="field">
        <div class="control">
            <button type="submit" class="button is-link is-outlined">Register</button>
        </div>
    </div>

</form>

@endsection