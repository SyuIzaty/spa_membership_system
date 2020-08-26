@section('title', 'Profile Applicant')
@section('action', route('applicant.create'))

@extends('layouts.applicant')

@section('content')


<head>
  <meta charset="utf-8">
  <h1 class="title">Academic Qualification</h1>
  <style>
  input, label {
    line-height: 1.5em;
  }
  </style>
  <script src="https://code.jquery.com/jquery-3.5.0.js"></script>
</head>



<form method="post" action="{{ route('applicant.storeacademic',$applicant,$applicantacademic) }}">

    @csrf
    @method('get')
    @include('partials.errors')

    <div class="field">
        <label class="label">ID</label>
        <div class="control">
            <input type="text" name="id" value="{{ $applicant->id }}" />
        </div>
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

    
<br>
    <div class="field">
        <div class="control">
            <button type="submit" class="button is-link is-outlined">Add</button>
            <a href="{{route('applicant.contactinfo',$applicant)}}" button type="back"  class="button is-link is-outlined">back</a></button>
        </div>
    </div>
   
</form>



@endsection
<script>
$( "select" )
  .change(function() {
    var str = "";
    $( "select option:selected" ).each(function() {
      str += $( this ).text() + " ";
    });
    $( "div" ).text( str );
  })
  .trigger( "change" );
</script>