@section('title', 'Applicant Preferred Programme')
@section('action', route('applicant.create'))

@extends('layouts.applicant')

@section('content')

<h1 class="title">Preferred Program</h1>


<form method="post" action="{{ route('applicant.updateprogramme',$applicant,$programme,$program) }}">

    @csrf
    @method('get')
    @include('partials.errors')
    <div class="field">
        <label class="label">ID</label>
        <div class="control">
            <input type="text" name="id" value="{{ $applicant->id }}" class="input" placeholder="" minlength="3" maxlength="100" required />
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
        <label class="label">2nd Preferred Programme</label>
        <div class="control">
            <div class="select">
                <select name="applicant_programme_2" required>  
                    
                @foreach ($programme as $program)
                <option value={{ $program->id }}>{{ $program->programme_name }}</option>
                @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="field">
        <label class="label">3rd Preferred Programme</label>
        <div class="control">
            <div class="select">
                <select name="applicant_programme_3" required>  
                    
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
 
</div>

@endsection