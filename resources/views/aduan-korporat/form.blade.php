@extends('layouts.public')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Sora:wght@700&display=swap');

    .title{
        font-family: 'Sora', sans-serif;
        font-size: 30px;
        
    }
    
</style>
<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg4.jpg')}}); background-size: cover">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="background-size: cover">
                    <div class="d-flex justify-content-center" style="color: black">
                        <div class="p-2">
                            <center><img src="{{ asset('img/intec_logo_new.png') }}" style="height: 120px; width: 320px;" class="responsive"/></center><br>
                            <h2 style="text-align: center" class="title">
                                i-Complaint
                            </h2>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="panel-container show">
                        <div class="panel-content">
                            @if (Session::has('message'))
                                    <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('message') }}</div>
                            @endif
                            {{-- {!! Form::open(['action' => 'AduanKorporatController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!} --}}
                            <form id="form-id" action="/store" method="post" enctype='multipart/form-data'>
                                @csrf
                            {{-- <input type="hidden" class="form-control name" id="name" name="name">
                            <input type="hidden" class="form-control email" id="email" name="email"> --}}
                                
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-striped w-100">
                                            <thead>
                                                <td width="20%" style="vertical-align: middle"><label class="form-label" for="userCategory">User Category</label></td>
                                                <td colspan="6">
                                                    <select class="form-control userCategory" name="userCategory" id="userCategory" required>
                                                        <option disabled value="">Please select</option>
                                                        @foreach ($userCategory as $user) 
                                                            <option value="{{ $user->code }}" @if (old('userCategory') == $user->code) selected="selected" @endif>{{ $user->description }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </thead>
                                        </table>
                                    </div>

                                    <div class="table-responsive stfstd">
                                        <table class="table table-bordered table-hover table-striped w-100">
                                            <thead>
                                                <td width="20%" style="vertical-align: middle">
                                                    <label class="form-label intecStf" for="user_id"><span class="text-danger">*</span> Staff ID </label>
                                                    <label class="form-label intecStd" for="user_id"><span class="text-danger">*</span> Student ID </label>
                                                </td>
                                                <td colspan="6">
                                                    <input class="form-control user_id" id="user_id" name="user_id">
                                                    @error('user_id')
                                                        <p style="color: red"><strong> {{ $message }} </strong></p>
                                                    @enderror
                                                </td>
                                            </thead>
                                        </table>
                                    </div>

                                    <div class="table-responsive all" style="display:none"> 
                                        <table class="table table-bordered table-hover table-striped w-100" >
                                            <thead>
                                                <tr>
                                                    <td colspan="5" class="bg-primary-50"><label class="form-label">PROFILE</label></td>
                                                </tr>
                                                <tr class="icOther">
                                                    <td width="20%" style="vertical-align: middle">
                                                        <label class="form-label icOther" for="ic"><span class="text-danger">*</span> IC/Passport No. </label>
                                                    </td>
                                                    <td colspan="6">
                                                        <input class="form-control icOther" id="ic" name="ic" placeholder="eg: 951108112233">
                                                        <span style="font-size: 12px; color: red;"><i>*Without -</i></span>

                                                        @error('ic')
                                                            <p style="color: red"><strong> {{ $message }} </strong></p>
                                                        @enderror
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="20%" style="vertical-align: middle"><label class="form-label" for="user_name"><span class="text-danger">*</span> Full Name </label></td>
                                                    <td colspan="6">
                                                        <input class="form-control intec" id="user_name" name="user_name" readonly>
                                                        <input class="form-control other" id="other_name" name="other_name">
                                                        @error('user_name')
                                                            <p style="color: red"><strong> {{ $message }} </strong></p>
                                                        @enderror
                                                        @error('other_name')
                                                            <p style="color: red"><strong> {{ $message }} </strong></p>
                                                        @enderror
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="20%" style="vertical-align: middle"><label class="form-label" for="user_email"><span class="text-danger">*</span> Email </label></td>
                                                    <td>
                                                        <input class="form-control intec" id="user_email" name="user_email" readonly>
                                                        <input class="form-control other" id="other_email" name="other_email" placeholder="eg: intec@intec.edu.my">
                                                        <span style="font-size: 12px; color: red;"><i>*Feedback will be sent to this email.</i></span>

                                                        @error('user_email')
                                                            <p style="color: red"><strong> {{ $message }} </strong></p>
                                                        @enderror
                                                        @error('other_email')
                                                            <p style="color: red"><strong> {{ $message }} </strong></p>
                                                        @enderror
                                                    </td>

                                                    <td width="20%" style="vertical-align: middle"><label class="form-label" for="user_phone"><span class="text-danger">*</span>  Phone No. </label></td>
                                                    <td>
                                                        <input class="form-control user_phone" id="user_phone" name="user_phone" placeholder="eg: 0131234567" required>
                                                        <span style="font-size: 12px; color: red;"><i>*Without -</i></span>

                                                        @error('user_phone')
                                                            <p style="color: red"><strong> {{ $message }} </strong></p>
                                                        @enderror
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="20%" style="vertical-align: middle"><label class="form-label" for="user_address"><span class="text-danger">*</span> Full Address </label></td>
                                                    <td colspan="6">
                                                        <textarea class="form-control" name="address" id="address" rows="2" required></textarea>
                                                    </td>

                                                    @error('address')
                                                            <p style="color: red"><strong> {{ $message }} </strong></p>
                                                    @enderror
                                                </tr>
                                                <tr>
                                                    <td width="20%" style="vertical-align: middle"><label class="form-label" for="category"><span class="text-danger">*</span> Category</label></td>
                                                    <td colspan="6">
                                                        <select class="form-control category" name="category" id="category" required>
                                                            <option disabled selected value="">Please select</option>
                                                            @foreach ($category as $c) 
                                                                <option value="{{ $c->id }}" @if (old('category') == $c->id) selected="selected" @endif>{{ $c->description }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>

                                    <div class="table-responsive all" style="display:none">
                                        <table class="table table-bordered table-hover table-striped w-100">
                                            <thead>
                                                <tr>
                                                    <td colspan="6" class="bg-primary-50"><label class="form-label">DETAILS</label></td>
                                                </tr>                                               
                                                <tr>
                                                    <td width="20%" style="vertical-align: middle"><label class="form-label" for="title"><span class="text-danger">*</span> Title </label></td>
                                                    <td colspan="6">
                                                        <input class="form-control" id="title" name="title" required>

                                                        @error('title')
                                                            <p style="color: red"><strong> {{ $message }} </strong></p>
                                                        @enderror
                                                    </td>                                    
                                                </tr>
                                                <tr>
                                                    <td width="20%" style="vertical-align: middle"><label class="form-label" for="user_address"><span class="text-danger">*</span> Description</label></td>
                                                    <td colspan="6">
                                                        <textarea class="form-control" name="description" id="description" rows="5" required></textarea>
                                                    </td>

                                                    @error('description')
                                                        <p style="color: red"><strong> {{ $message }} </strong></p>
                                                    @enderror
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>

                                    <div class="table-responsive all" style="display:none">
                                        <table class="table table-bordered table-hover table-striped w-100">
                                            <thead>
                                                <tr>
                                                    <td colspan="5" class="bg-primary-50"><label class="form-label">ATTACHMENT (if available)</label></td>
                                                </tr>                                               
                                                <tr>
                                                    <td colspan="6">
                                                        <input type="file" class="form-control" id="attachment" name="attachment[]" multiple>

                                                        @error('attachment')
                                                            <p style="color: red">{{ $message }}</p>
                                                        @enderror                                                    
                                                    </td>                                    
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>

                                    <div class="table-responsive all" style="display:none">
                                        <table class="table table-bordered table-hover table-striped w-100">
                                            <thead>
                                                <tr>
                                                    <td colspan="5" class="bg-primary-50"><label class="form-label">DISCLAIMER</label></td>
                                                </tr>                                               
                                                <tr>
                                                    <td colspan="6">
                                                        <input type="checkbox" name="check" id="agree" onclick="agreement()"/>&emsp;I declare that all personal information and writing submitted by me is genuine and I am responsible for it.
                                                    </td>                                    
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <div class="table-responsive all" style="display:none">
                                        <div class="form-group">
                                            <button style="margin-top: 5px;" class="btn btn-danger float-right" id="submit" name="submit" disabled><i class="fal fa-check"></i> Submit</button></td>
                                        </div>
                                    </div>
                            {{-- {!! Form::close() !!} --}}
                                </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
@section('script')
    <script>

    $(document).ready( function() {

//start validate

        $("#submit").click(function(e){
            var valid = Validate();
            if(valid)
            {

                $('#form-id').submit(function() { 
                    // submit the form 
                    $(this).ajaxSubmit(); 
                    // return false to prevent normal browser submit and page navigation 
                    return false; 
                });
            }
        });

        function Validate() {

        var cat = document.getElementById("userCategory").value;
        var mobile = document.getElementById("user_phone").value;
        var address = document.getElementById("address").value;
        var category = document.getElementById("category").value;
        var title = document.getElementById("title").value;
        var description = document.getElementById("description").value;

        if (cat == "STF" || cat == "STD")
        {
            if(isNaN(mobile))
            {
                Swal.fire("Invalid phone number! It should be numbers only.");
                event.preventDefault();
                return false;
            }

            if(mobile.length > 11 || mobile.length < 10)
            {
                Swal.fire("Invalid phone number! It should be 10 or 11 digits only.");
                event.preventDefault();
                return false;
            }

            if(address == '')
            {
                Swal.fire("Address is required!");
                event.preventDefault();
                return false;
            }

            if(category == '')
            {
                Swal.fire("Category is required!");
                event.preventDefault();
                return false;
            }

            if(title == '')
            {
                Swal.fire("Title is required!");
                event.preventDefault();
                return false;
            }

            if(description == '')
            {
                Swal.fire("Description is required!");
                event.preventDefault();
                return false;
            }
        }

        else if(cat == "VSR" || cat == "SPL" || cat == "SPR" || cat == "SPS")
        {
            var name = document.getElementById("other_name").value;
            var email = document.getElementById("other_email").value;
            var ic = document.getElementById("ic").value;
            var mobile = document.getElementById("user_phone").value;
            var address = document.getElementById("address").value;
            var category = document.getElementById("category").value;
            var title = document.getElementById("title").value;
            var description = document.getElementById("description").value;


            var mailformat =  /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

                if(isNaN(ic))
                {
                    Swal.fire("Invalid IC/Passport number format! It should be numbers only.");
                    event.preventDefault();
                    return false;
                }

                if(ic.length > 12 || ic.length < 8)
                {
                    Swal.fire("Invalid IC/Passport number! It should be 12 digits (for IC number) or 8 digits (for passport number) only.");
                    event.preventDefault();
                    return false;
                }

                if(name == '')
                {
                    Swal.fire("Name is required!");
                    event.preventDefault();
                    return false;
                }

                if (!mailformat.test(email)) 
                {
                    Swal.fire("Invalid email format!");
                    event.preventDefault();
                    return false;
                }

                if(isNaN(mobile))
                {
                    Swal.fire("Invalid phone number! It should be numbers only.");
                    event.preventDefault();
                    return false;
                }

                if(mobile.length > 11 || mobile.length < 10)
                {
                    Swal.fire("Invalid phone number! It should be 10 or 11 digits only.");
                    event.preventDefault();
                    return false;
                }

                if(address == '')
                {
                    Swal.fire("Address is required!");
                    event.preventDefault();
                    return false;
                }

                if(category == '')
                {
                    Swal.fire("Category is required!");
                    event.preventDefault();
                    return false;
                }

                if(title == '')
                {
                    Swal.fire("Title is required!");
                    event.preventDefault();
                    return false;
                }

                if(description == '')
                {
                    Swal.fire("Description is required!");
                    event.preventDefault();
                    return false;
                }
        }
        

        return true;
}


//end validation

        if($('.user_id').val()!=''){
            search($('.user_id'));
        }

        $(function() { 
            $(document).on('change','.user_id',function(){

                search($(this));
            });
        });

        function search(elem){

            var user_id = elem.val();   

            $.ajax({
                type:'get',
                url:'{!!URL::to('search')!!}',
                data:{'id':user_id},
                success:function(data)
                {
                    $('#user_id').html(data.id);
                    $('#user_name').val(data.name);
                    $('#name').val(data.name);
                    $('#user_email').val(data.email);
                    $('#email').val(data.email);
                    
                    if (data == ''){ 
                        Swal.fire("ID not exist!");
                        $(".all").hide(); //all details
                    }

                    else
                    {
                        $(".all").show(); //all details
                        $(".icOther").hide(); //other ic

                        var val = $("#userCategory").val();

                        if(val == "STF" || val == "STD"){
                            $(".intec").show(); // staff/student name & email
                        } else {
                            $(".intec").hide(); // staff/studentname & email
                        }
                    }
                    
                }
            });
        }


      $(".stfstd").hide(); // div staff/student id

      $( "#userCategory" ).change(function() {
        var val = $("#userCategory").val();
        if(val == "STF"){
            $(".stfstd").show(); // div staff/student id
            $(".intecStf").show(); // staff id
            $(".all").hide(); //all details

            $(".intecStd").hide(); // student id
            $(".other").hide(); // other name & email

        } 
        
        else if(val == "STD"){
            $(".stfstd").show(); // div staff/student id
            $(".intecStd").show(); // student id
            $(".all").hide(); //all details

            $(".intecStf").hide(); // staff id
            $(".other").hide(); // other name & email
        }

        else if(val == "VSR" || val == "SPL" || val == "SPR" || val == "SPS"){
            $(".all").show(); // all details
            $(".other").show(); // other name & email
            $(".icOther").show(); // ic

            $(".stfstd").hide(); // div staff/student id
            $(".intec").hide(); // staff/student name & email

        }
      });

      $("#userCategory").change(function() {
            $("#user_name").val("");
            $("#user_email").val("");
            $("#other_name").val("");
            $("#other_email").val("");
            $("#user_id").val("");
            $("#user_phone").val("");
      });

        $('.userCategory').val('{{ old('userCategory') }}'); 
        $(".userCategory").change(); 
        $('.user_id').val('{{ old('user_id') }}');
        $(".user_id").change(); 
        $('.user_category').val('{{ old('user_category') }}'); 
        $(".user_category").change(); 
        $('.user_phone').val('{{ old('user_phone') }}');
        $('#other_name').val('{{ old('other_name') }}');
        $('#other_email').val('{{ old('other_email') }}');
    });

    function agreement()
    {
        var agree = document.getElementById("agree")
        var submit = document.getElementById("submit");
        submit.disabled = agree.checked ? false : true;
        if(!submit.disabled){
            submit.focus();
        }
    }
    </script>
@endsection
