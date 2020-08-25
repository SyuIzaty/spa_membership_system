@section('title', 'Profile Applicant')


@extends('layouts.applicant')

@section('content')

<h1 class="title">Contact Information</h1>


<form method="post" action="{{ route('applicant.updatecontact',$applicant,$applicantcontact,$appcontact1) }}">

    @csrf
    @method('patch')
    @include('partials.errors')
    
    <div class="field">
        <label class="label">ID</label>
        <div class="control">
            <input type="text" name="id" value="{{ $applicant->id }}" class="input" placeholder="" minlength="3" maxlength="100" required />
        </div>
    
    <div class="field">
        <label class="label">Address Line 1</label>
        <div class="control">
        
            <input type="text" name="applicant_address_1" value="{{ $appcontact1->applicant_address_1 }}" class="input" placeholder="" minlength="3" maxlength="100" required />
        
        </div>
    </div>

    <div class="field">
        <label class="label">Address Line 2</label>
        <div class="control">
        
            <input type="text" name="applicant_address_2" value="{{ $appcontact1->applicant_address_2  }}" class="input" placeholder="" minlength="3" maxlength="100" required />
       
        </div>
    </div>

    <div class="field">
        <label class="label">Postcode</label>
        <div class="control">
       
            <input type="text" name="applicant_poscode" value="{{ $appcontact1->applicant_poscode  }}" class="input" placeholder="" minlength="3" maxlength="100" required />
        
        </div>
    </div>

    <div class="field">
        <label class="label">City</label>
        <div class="control">
            <div class="select">
                <select name="applicant_city" required>
                    <option value="" disabled selected>Select City</option>
                    
                    <option value="ShahAlam" {{ $appcontact1->applicant_city === 'ShahAlam' ? 'selected' : null }}>SHAH ALAM</option>
                    <option value="Klang" {{ $appcontact1->applicant_city=== 'Klang' ? 'selected' : null }}>KLANG</option>
                   
                </select>
            </div>
        </div>
    </div>

    <div class="field">
        <label class="label">State</label>
        <div class="control">
            <div class="select">
                <select name="applicant_state" required>
                    <option value="" disabled selected>Select State</option>
                    
                    <option value="SELANGOR" {{  $appcontact1->applicant_state === 'SELANGOR' ? 'selected' : null }}>SELANGOR</option>
                    <option value="PERAK" {{  $appcontact1->applicant_state === 'PERAK' ? 'selected' : null }}>PERAK</option>
                    
                </select>
            </div>
        </div>
    </div>

    <div class="field">
        <label class="label">Country</label>
        <div class="control">
            <div class="select">
                <select name="applicant_country" required>
                
                    <option value="" disabled selected>Select Country</option>
                    <option value="MALAYSIA" {{  $appcontact1->applicant_country === 'MALAYSIA' ? 'selected' : null }}>MALAYSIAN</option>
                    <option value="USA"  {{  $appcontact1->applicant_country === 'USA' ? 'selected' : null }}>UNITED STATES OF AMERICA</option>
                
                </select>
            </div>
        </div>
    </div>

    <div class="field">
        <label class="label">Mobile No.</label>
        <div class="control">
        
            <input type="text" name="applicant_phone_mobile" value="{{ $appcontact1->applicant_phone_mobile }}" class="input" placeholder="" minlength="3" maxlength="100" required />
       
        </div>
    </div>

    <div class="field">
        <label class="label">Office No.</label>
        <div class="control">
        
            <input type="text" name="applicant_phone_office" value="{{ $appcontact1->applicant_phone_office }}" class="input" placeholder="" minlength="3" maxlength="100" required />
        
        </div>
    </div>

    <div class="field">
        <label class="label">Home No.</label>
        <div class="control">
       
            <input type="text" name="applicant_phone_home" value="{{ $appcontact1->applicant_phone_home }}" class="input" placeholder="" minlength="3" maxlength="100" required />
        
        </div>
    </div>

    <div class="field">
        <label class="label">Email:</label>
        <div class="control">
        
            <input type="text" name="applicant_email" value="{{ $appcontact1->applicant_email}}" class="input" placeholder="" minlength="3" maxlength="100" required />
       
        </div>
    </div>


    <div class="field">
        <div class="control">
            <button type="submit"  class="button is-link is-outlined">Update</button>
            <a href="{{route('applicant.createacademic',$applicant)}}" button type="back"  class="button is-link is-outlined">Next</a></button>
        </div>
    </div>

</form>

@endsection