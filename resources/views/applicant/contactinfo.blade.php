@section('title', 'Profile Applicant')
@section('action', route('applicant.create'))

@extends('layouts.applicant')

@section('content')

<h1 class="title">Contact Information</h1>


<form method="post" action="{{ route('applicant.updatecontact',$applicant,$applicantcontact) }}">

    @csrf
    @method('patch')
    @include('partials.errors')

    <div class="field">
        <label class="label">Address Line 1</label>
        <div class="control">
        
            <input type="text" name="applicant_address_1" value="{{ $applicantcontact->applicant_address_1 }}" class="input" placeholder="" minlength="3" maxlength="100" required />
            
        </div>
    </div>

    <div class="field">
        <label class="label">Address Line 2</label>
        <div class="control">
        
            <input type="text" name="applicant_address_2" value="{{ $applicantcontact->applicant_address_2  }}" class="input" placeholder="" minlength="3" maxlength="100" required />
        
        </div>
    </div>

    <div class="field">
        <label class="label">Postcode</label>
        <div class="control">
       
            <input type="text" name="applicant_poscode" value="{{ $applicantcontact->applicant_poscode  }}" class="input" placeholder="" minlength="3" maxlength="100" required />
        
        </div>
    </div>

    <div class="field">
        <label class="label">City</label>
        <div class="control">
            <div class="select">
                <select name="applicant_city" required>
                    <option value="" disabled selected>Select City</option>
                    
                    <option value="Shah Alam" {{ $applicantcontact->applicant_city === 'Shah Alam' ? 'selected' : null }}>SHAH ALAM</option>
                    <option value="Klang" {{ $applicantcontact->applicant_city=== 'Klang' ? 'selected' : null }}>KLANG</option>
                   
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
                    
                    <option value="SELANGOR" {{  $applicantcontact->applicant_state === 'SELANGOR' ? 'selected' : null }}>SELANGOR</option>
                    <option value="PERAK" {{  $applicantcontact->applicant_state === 'PERAK' ? 'selected' : null }}>PERAK</option>
                    
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
                    <option value="MALAYSIA" {{  $applicantcontact->applicant_county === 'MALAYSIA' ? 'selected' : null }}>MALAYSIAN</option>
                    <option value="USA"  {{  $applicantcontact->applicant_country === 'USA' ? 'selected' : null }}>UNITED STATES OF AMERICA</option>
                
                </select>
            </div>
        </div>
    </div>

    <div class="field">
        <label class="label">Mobile No.</label>
        <div class="control">
        
            <input type="text" name="applicant_phone_mobile" value="{{ $applicantcontact->applicant_phone_mobile }}" class="input" placeholder="" minlength="3" maxlength="100" required />
       
        </div>
    </div>

    <div class="field">
        <label class="label">Office No.</label>
        <div class="control">
        
            <input type="text" name="applicant_phone_office" value="{{ $applicantcontact->applicant_phone_office }}" class="input" placeholder="" minlength="3" maxlength="100" required />
        
        </div>
    </div>

    <div class="field">
        <label class="label">Home No.</label>
        <div class="control">
       
            <input type="text" name="applicant_phone_home" value="{{ $applicantcontact->applicant_phone_home }}" class="input" placeholder="" minlength="3" maxlength="100" required />
        
        </div>
    </div>

    <div class="field">
        <label class="label">Email:</label>
        <div class="control">
        
            <input type="text" name="applicant_email" value="{{ $applicantcontact->applicant_email}}" class="input" placeholder="" minlength="3" maxlength="100" required />
       
        </div>
    </div>


    <div class="field">
        <div class="control">
            <button type="submit" class="button is-link is-outlined">Update</button>
        </div>
    </div>

</form>

@endsection