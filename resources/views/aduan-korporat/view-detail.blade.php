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

                            <div class="table-responsive "> 
                                <table class="table table-bordered table-hover table-striped w-100" >
                                    <thead>
                                        <tr>
                                            <td colspan="5" class="bg-primary-50"><label class="form-label">PROFILE</label></td>
                                        </tr>
                                        <tr>
                                            <td width="20%" style="vertical-align: middle"><label class="form-label" for="reference">Reference No. </label></td>
                                            <td>{{$data->ticket_no}}</td>

                                            <td width="20%" style="vertical-align: middle"><label class="form-label" for="id">ID </label></td>
                                            <td colspan="6">
                                                @if ($data->staff_id != '')
                                                    <input class="form-control" value="{{$data->staff_id}}" readonly>
                                                    
                                                @elseif ($data->student_id != '')
                                                    <input class="form-control" value="{{$data->staff_id}}" readonly>

                                                @elseif ($data->ic != '')
                                                    <input class="form-control" value="{{$data->ic}}" readonly>

                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="20%" style="vertical-align: middle"><label class="form-label" for="user_name">Full Name </label></td>
                                            <td colspan="6">
                                                <input class="form-control" value="{{$data->name}}" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="20%" style="vertical-align: middle"><label class="form-label" for="user_email">Email </label></td>
                                            <td><input class="form-control" value="{{$data->email}}" readonly></td>

                                            <td width="20%" style="vertical-align: middle"><label class="form-label" for="user_phone">Phone No. </label></td>
                                            <td><input class="form-control" value="{{$data->phone_no}}" readonly></td>
                                        </tr>
                                        <tr>
                                            <td width="20%" style="vertical-align: middle"><label class="form-label" for="user_address">Full Address </label></td>
                                            <td colspan="6"><textarea class="form-control" value="" rows="5" readonly>{{ str_replace('<br />', "\r\n", $data->address) }}</textarea></td>
                                        </tr>
                                    </thead>
                                </table>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped w-100">
                                    <thead>
                                        <tr>
                                            <td colspan="6" class="bg-primary-50"><label class="form-label">DETAILS</label></td>
                                        </tr>                                               
                                        <tr>
                                            <td width="20%" style="vertical-align: middle"><label class="form-label" for="title">Title </label></td>
                                            <td colspan="6">
                                                <input class="form-control" value="{{$data->title}}" readonly></td>                                    
                                        </tr>
                                        <tr>
                                            <td width="20%" style="vertical-align: middle"><label class="form-label" for="description">Description</label></td>
                                            <td colspan="6">
                                                <textarea class="form-control" value="" rows="10" readonly>{{ str_replace('<br />', "\r\n", $data->description)}}</textarea>
                                            </td>
                                        </tr>
                                    </thead>
                                </table>
                            </div>

                            @if ($file->isNotEmpty())
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped w-100">
                                        <thead>
                                            <tr>
                                                <td colspan="5" class="bg-primary-50"><label class="form-label"><i class="fal fa-file"></i> ATTACHMENT</label></td>
                                            </tr>
                                            
                                            <tr>
                                                <td colspan="4" style="vertical-align: middle">
                                                    <ol>
                                                        @foreach ( $file as $f )
                                                            <li>
                                                                <a target="_blank" href="/get-file/{{$f->id}}">{{$f->original_name}}</a>
                                                            </li>
                                                            <br>
                                                        @endforeach
                                                    </ol>
                                                </td>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped w-100">
                                    <thead>
                                        <tr>
                                            <td width="20%" style="vertical-align: middle"><label class="form-label" for="status">Status </label></td>
                                            <td colspan="6">{{$data->getStatus->description}}</td>
                                        </tr>

                                        @if ($data->getRemark != '')
                                            <tr>
                                                <td width="20%" style="vertical-align: middle"><label class="form-label" for="feedback">Feedback </label></td>
                                                <td colspan="6">{!! nl2br($data->getRemark->admin_remark) !!}</td>
                                            </tr>
                                        @endif
                                    </thead>
                                </table>
                            </div>
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

    </script>
@endsection