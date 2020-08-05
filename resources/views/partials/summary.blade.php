<div class="content">
  <a href="{{ route('applicant.showapp',$applicant) }}">
  
  
    <h1 class="applicant_name">{{ $applicant->applicant_name }}</h1>
  </a>
  
  <p><b>Name        :</b> {{ $applicant->applicant_name }}</p>
  <p><b>IC          :</b> {{ $applicant->applicant_ic }}</p>
  <p><b>Email       :</b> {{ $applicant->applicant_email }}</p>
  <p><b>Phone       :</b> {{ $applicant->applicant_phone }}</p>
  <p><b>Nationality :</b> {{ $applicant->applicant_nationality }}</p>
  <p><b>Programme   :</b> {{  $applicant->applicant_programme}} }}</p>
  
 
  <form method="post" action="{{ route('applicant.destroy',$applicant) }}">
    @csrf @method('delete')
    <div class="field is-grouped">
      <div class="control">
        <a
          href="{{ route('applicant.edit',$applicant)}}"
          class="button is-info is-outlined"
        >
          Edit
        </a>
      </div>
      <div class="control">
        <button type="submit" class="button is-danger is-outlined">
          Delete
        </button>
      </div>
    </div>
  </form>
</div>