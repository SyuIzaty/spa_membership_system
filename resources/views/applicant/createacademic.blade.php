@section('title', 'Profile Applicant')
@section('action', route('applicant.create'))

@extends('layouts.applicant')

@section('content')




<head>
  <h1 class="title">Academic Qualification</h1>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
 
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
                <select name="qualification_type" id="qualification_type" data-dependent="subject" required>  
                    <option value="">Select Qualification Type</option>
                    @foreach ($qualifications as $qualification)
                    <option value={{ $qualification->id }}>{{ $qualification->qualification_code }}</option>
                    @endforeach 
                </select>
             </div>
        </div>
    </div>

    <div class="field">
        <label class="label">Subject</label>
        <div class="control">
            <div class="select">
                <select name="subject" id="subject" required>  
                    <option value="">Select Subject</option>
                    @foreach ($subjects as $subject)
                    <option >{{ $subject->subject_name }}</option>
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