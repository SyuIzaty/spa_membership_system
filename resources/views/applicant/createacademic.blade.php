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
                    @foreach ($subject as $subjects)
                    <option >{{ $subjects->subject_name }}</option>
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
   {{ csrf_field() }}
</form>



@endsection

<script>
$(document).ready(function(){

 $('.dynamic').change(function(){
  if($(this).val() != '')
  {
   var select = $(this).attr("id");
   var value = $(this).val();
   var dependent = $(this).data('dependent');
   var _token = $('input[name="_token"]').val();
   $.ajax({
    url:"",
    method:"POST",
    data:{select:select, value:value, _token:_token, dependent:dependent},
    success:function(result)
    {
     $('#'+dependent).html(result);
    }

   })
  }
 });

    $('#qualification_type').change(function(){
    $('#subject').val('');  
 });

});
</script>