@extends('layouts.public')

@section('content')
    <style>
        .preserveLines {
            white-space: pre-wrap;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/icomplaint.css') }}">

    <main id="js-page-content" role="main" id="main" class="page-content"
        style="background-image: url({{ asset('img/bg4.jpg') }}); background-size: cover">
        <div class="row" style="margin-bottom: 20px;">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" style="background-size: cover">
                        <div class="d-flex justify-content-center" style="color: black">
                            <div class="p-2">
                                <center><img src="{{ asset('img/intec_logo_new.png') }}" style="width: 320px;"
                                        class="responsive" /></center><br>
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
                                    <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i
                                            class="icon fal fa-check-circle"></i> {{ Session::get('message') }}</div>
                                @endif
                                {!! Form::open([
                                    'action' => 'iComplaintGmailController@store',
                                    'method' => 'POST',
                                    'enctype' => 'multipart/form-data',
                                ]) !!}

                                <input type="hidden" id="user_id" name="user_id" value={{ $encryptID }}>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped w-100">
                                        <thead>
                                            <td width="20%" style="vertical-align: middle"><label class="form-label"
                                                    for="userCategory"><span class="text-danger">*</span> User
                                                    Category</label></td>
                                            <td colspan="6">
                                                <select class="form-control userCategory" name="userCategory"
                                                    id="userCategory" required>
                                                    <option disabled selected>Please select</option>
                                                    @foreach ($userCategory as $user)
                                                        <option value="{{ $user->code }}"
                                                            @if (old('userCategory') == $user->code) selected="selected" @endif>
                                                            {{ $user->description }}</option>
                                                    @endforeach
                                                </select>
                                                @error('userCategory')
                                                    <p style="color: red"><strong> {{ $message }} </strong></p>
                                                @enderror
                                            </td>
                                        </thead>
                                    </table>
                                </div>

                                <div class="table-responsive all">
                                    <table class="table table-bordered table-hover table-striped w-100">
                                        <thead>
                                            <tr>
                                                <td colspan="5" class="bg-primary-50"><label
                                                        class="form-label">PROFILE</label></td>
                                            </tr>
                                            <tr>
                                                <td width="20%" style="vertical-align: middle"><label class="form-label"
                                                        for="user_name"><span class="text-danger">*</span> Full Name
                                                    </label></td>
                                                <td colspan="6">
                                                    <input class="form-control" id="user_name" value="{{ $details->name }}"
                                                        readonly>

                                                    @error('user_name')
                                                        <p style="color: red"><strong> {{ $message }} </strong></p>
                                                    @enderror
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="20%" style="vertical-align: middle"><label class="form-label"
                                                        for="user_email"><span class="text-danger">*</span> Email </label>
                                                </td>
                                                <td>
                                                    <input class="form-control intec" id="user_email"
                                                        value="{{ $details->email }}" readonly>
                                                    <span style="font-size: 12px; color: #1487fd;">
                                                        <i>*Feedback notification will be sent to this email.</i></span>

                                                    @error('user_email')
                                                        <p style="color: red"><strong> {{ $message }} </strong></p>
                                                    @enderror
                                                </td>

                                                <td width="20%" style="vertical-align: middle"><label class="form-label"
                                                        for="user_phone"><span class="text-danger">*</span> Phone No.
                                                    </label></td>
                                                <td>
                                                    <input class="form-control user_phone" id="user_phone" name="user_phone"
                                                        placeholder="eg: 0131234567" value="{{ old('user_phone') }}"
                                                        required>

                                                    @error('user_phone')
                                                        <p style="color: red"><strong> {{ $message }} </strong></p>
                                                    @enderror
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="20%" style="vertical-align: middle"><label class="form-label"
                                                        for="user_address"><span class="text-danger">*</span> Full Address
                                                    </label></td>
                                                <td colspan="6">
                                                    <textarea class="form-control preserveLines" name="address" id="address" rows="2" required>{{ old('address') }}</textarea>
                                                </td>

                                                @error('address')
                                                    <p style="color: red"><strong> {{ $message }} </strong></p>
                                                @enderror
                                            </tr>
                                            <tr>
                                                <td width="20%" style="vertical-align: middle"><label class="form-label"
                                                        for="category"><span class="text-danger">*</span> Category</label>
                                                </td>
                                                <td colspan="6">
                                                    <select class="form-control category" name="category" id="category"
                                                        required>
                                                        <option disabled selected value="">Please select</option>
                                                        @foreach ($category as $c)
                                                            <option value="{{ $c->id }}"
                                                                @if (old('category') == $c->id) selected="selected" @endif>
                                                                {{ $c->description }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="20%" style="vertical-align: middle"><label
                                                        class="form-label" for="subcategory">Sub Category</label></td>
                                                <td colspan="6">
                                                    <select class="form-control subcategory" name="subcategory"
                                                        id="subcategory">
                                                        <option disabled selected value="">Please select</option>
                                                        @foreach ($subcategory as $sc)
                                                            <option value="{{ $sc->id }}"
                                                                @if (old('subcategory') == $sc->id) selected="selected" @endif>
                                                                {{ $sc->description }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>

                                <div class="table-responsive all">
                                    <table class="table table-bordered table-hover table-striped w-100">
                                        <thead>
                                            <tr>
                                                <td colspan="6" class="bg-primary-50"><label
                                                        class="form-label">DETAILS</label></td>
                                            </tr>
                                            <tr>
                                                <td width="20%" style="vertical-align: middle"><label
                                                        class="form-label" for="title"><span
                                                            class="text-danger">*</span> Title </label></td>
                                                <td colspan="6">
                                                    <input class="form-control" id="title" name="title"
                                                        value="{{ old('title') }}" required>

                                                    @error('title')
                                                        <p style="color: red"><strong> {{ $message }} </strong></p>
                                                    @enderror
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="20%" style="vertical-align: middle"><label
                                                        class="form-label" for="user_address"><span
                                                            class="text-danger">*</span> Description</label></td>
                                                <td colspan="6">
                                                    <textarea class="form-control preserveLines" name="description" id="description" rows="10" required>{{ old('description') }}</textarea>
                                                </td>

                                                @error('description')
                                                    <p style="color: red"><strong> {{ $message }} </strong></p>
                                                @enderror
                                            </tr>
                                        </thead>
                                    </table>
                                </div>

                                <div class="table-responsive all">
                                    <table class="table table-bordered table-hover table-striped w-100">
                                        <thead>
                                            <tr>
                                                <td colspan="5" class="bg-primary-50"><label
                                                        class="form-label">ATTACHMENT (if available)</label></td>
                                            </tr>
                                            <tr>
                                                <td colspan="6">
                                                    <input type="file" class="form-control" id="attachment"
                                                        name="attachment[]" multiple>
                                                </td>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>

                                @if ($errors->has('attachment.*'))
                                    @foreach ($errors->get('attachment.*') as $error)
                                        <p style="color: red"><strong>{{ $error[0] }}</strong></p>
                                    @endforeach
                                @endif

                                <div class="table-responsive all">
                                    <table class="table table-bordered table-hover table-striped w-100">
                                        <thead>
                                            <tr>
                                                <td colspan="5" class="bg-primary-50"><label
                                                        class="form-label">DISCLAIMER</label></td>
                                            </tr>
                                            <tr>
                                                <td colspan="6">
                                                    <input type="checkbox" name="check" id="agree"
                                                        onclick="agreement()" />&emsp;I declare that all personal
                                                    information and writing submitted by me is genuine and I am responsible
                                                    for it.
                                                </td>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="table-responsive all">
                                    <div class="form-group">
                                        <button style="margin-top: 5px;" class="btn btn-danger float-right"
                                            id="submit" name="submit" disabled><i class="fal fa-check"></i>
                                            Submit</button></td>
                                    </div>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('aduan-korporat.footer')
    </main>
@endsection
@section('script')
    <script>
        function agreement() {
            var agree = document.getElementById("agree")
            var submit = document.getElementById("submit");
            submit.disabled = agree.checked ? false : true;
            if (!submit.disabled) {
                submit.focus();
            }
        }
    </script>
@endsection
