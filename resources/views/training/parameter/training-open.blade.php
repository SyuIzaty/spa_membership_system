@extends('layouts.public')

@section('content')
<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="background-image: url({{asset('img/training-bg.jpg')}}); background-size: cover">
                    <div class="d-flex justify-content-center" style="color: black">
                        <div class="p-2">
                            <center><img src="{{ asset('img/intec_logo.png') }}" style="max-width: 100%" class="responsive"/></center><br>
                            <h4 style="text-align: center; margin-top: -25px">
                                <b>{{ strtoupper($training->title) }} {{ date('Y', strtotime($training->start_date)) }} OPEN ATTENDANCE</b>
                            </h4>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="panel-container show">
                        <div class="panel-content" align="center">
                            <form  action="{{ url('training-open-attendance/'. $training->id) }}" method="GET" id="form_find">
                                <div>
                                    <div class="table-responsive">
                                        <table class="table table-striped w-50">
                                            <tr>
                                                <td width="35%" style="vertical-align: middle"><label class="form-label" for="ids"><span class="text-danger">**</span> Staff ID / IC Number :</label></td>
                                                <td colspan="3"><input class="form-control" id="ids" name="ids" value="{{ $request->ids }}" required></td>
                                                <td style="vertical-align: middle"><button type="submit" id="btn-search" class="btn btn-sm btn-success float-right"><i class="fal fa-location-arrow"></i></button></td>
                                            <tr>
                                        </table>
                                        <i><span class="text-danger">**</span><b> Notes : </b>Please key in staff ID or identification number (IC) to view details</i>
                                    </div>
                                </div>
                            </form>
                            <hr>
                            @if(Session::has('message'))
                                <script type="text/javascript">

                                function massage() {
                                Swal.fire(
                                            'Successful!',
                                            'Attendance Has Been Submitted and Recorded!',
                                            'success'
                                        );
                                }
                                window.onload = massage;
                                </script>
                            @endif
                            <div class="panel-container show">
                                <div class="panel-content">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="card-primary card-outline">
                                                <div class="card-body">
                                                    <table id="train" class="table table-bordered table-hover table-striped w-100 mb-1">
                                                        <thead>
                                                            <tr class="text-center">
                                                                <div class="form-group">
                                                                    <td colspan="6">
                                                                        @if(isset($training->upload_image))
                                                                            <a data-fancybox="gallery" href="/get-train-image/{{ $training->upload_image }}"><img src="/get-train-image/{{ $training->upload_image }}" style="width:800px; height:400px" class="img-fluid"></a>
                                                                        @else 
                                                                            <img src="{{ URL::to('/') }}/img/default.png" alt="default" style="width:800px; height:400px">
                                                                        @endif
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td width="15%"><label class="form-label"> TRAINING TITLE : </label></td>
                                                                    <td colspan="6">{{ $training->title ?? '--' }}</td>
                                                                </div>
                                                            </tr>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td width="15%"><label class="form-label"> DATE : </label></td>
                                                                    <td colspan="3">
                                                                        {{ isset($training->start_date) ? date('d/m/Y', strtotime($training->start_date)) : 'dd/mm/YYYY' }} - {{ isset($training->end_date) ? date('d/m/Y', strtotime($training->end_date)) : 'dd/mm/YYYY' }}
                                                                    </td>
                                                                    <td width="15%"><label class="form-label"> TIME : </label></td>
                                                                    <td colspan="3">
                                                                        {{ isset($training->start_time) ? date('h:i A', strtotime($training->start_time)) : 'h:i A' }} - {{ isset($training->end_time) ? date('h:i A', strtotime($training->end_time)) : 'h:i A' }}
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td width="15%"><label class="form-label"> VENUE : </label></td>
                                                                    <td colspan="6">{{ strtoupper($training->venue) ?? '--' }}</td>
                                                                </div>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                    @if($request->ids != '' && isset($data))
                                                        <br>
                                                        <table id="info" class="table table-bordered table-hover table-striped w-100 mb-1">
                                                            <ol class="breadcrumb breadcrumb-md breadcrumb-arrow">
                                                                <li>
                                                                    <a href="#" disabled style="pointer-events: none">
                                                                        <i class="fal fa-caret-right"></i>
                                                                        <span class="hidden-md-down">Personal Information</span>
                                                                    </a>
                                                                </li>
                                                                <p></p>
                                                            </ol>
                                                            <thead>
                                                                <tr>
                                                                    <div class="form-group">
                                                                        <td width="15%"><label class="form-label"> NAME : </label></td>
                                                                        <td colspan="6">{{ $data->staff_name ?? '--' }}</td>
                                                                    </div>
                                                                </tr>
                                                                <tr>
                                                                    <div class="form-group">
                                                                        <td width="15%"><label class="form-label"> STAFF ID : </label></td>
                                                                        <td colspan="3">{{ $data->staff_id ?? '--' }}</td>
                                                                        <td width="15%"><label class="form-label"> IC/PASSPORT NO. : </label></td>
                                                                        <td colspan="3">{{ $data->staff_ic ?? '--' }}</td>
                                                                    </div>
                                                                </tr>
                                                                <tr>
                                                                    <div class="form-group">
                                                                        <td width="15%"><label class="form-label"> PHONE NO. : </label></td>
                                                                        <td colspan="3">{{ $data->staff_phone ?? '--' }}</td>
                                                                        <td width="15%"><label class="form-label"> EMAIL : </label></td>
                                                                        <td colspan="3">{{ $data->staff_email ?? '--' }}</td>
                                                                    </div>
                                                                </tr>
                                                                <tr>
                                                                    <div class="form-group">
                                                                        <td width="15%"><label class="form-label"> POSITION : </label></td>
                                                                        <td colspan="3">{{ $data->staff_position ?? '--' }}</td>
                                                                        <td width="15%"><label class="form-label"> DEPARTMENT : </label></td>
                                                                        <td colspan="3">{{ $data->staff_dept ?? '--' }}</td>
                                                                    </div>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                        <br><br>
                                                        {!! Form::open(['action' => 'TrainingController@confirmAttendance', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <input type="hidden" name="staff_id" value="{{ $data->staff_id }}">
                                                        <input type="hidden" name="train_id" value="{{ $training->id }}">
                                                            <div class="footer">
                                                                <button type="submit" class="btn btn-success"><i class="fal fa-info-circle"></i> Confirm Attendance</button>	
                                                            </div>
                                                        {!! Form::close() !!}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
        
        // $("#datek, #cates").change(function(){
        //     $("#form_find").submit();
        // })

        $(document).ready(function() {
            $('#ids').on('click', '#btn-search', function(e) {
                e.preventDefault();
                $("#form_find").submit();
            });
        });

    </script>
@endsection
