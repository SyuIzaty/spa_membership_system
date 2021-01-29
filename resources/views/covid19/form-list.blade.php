@extends('layouts.admin')

@section('content')

@can('view form')
<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}})">

    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr" style="background-color:rgb(97 63 115)">
                    <h2>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>

                </div>

                <div class="panel-container show">
                    <div class="panel-content">
                        <center><img src="{{ asset('img/intec_logo.png') }}" style="height: 120px; width: 270px;"></center><br>
                        <h4 style="text-align: center">
                            <b>INTEC EDUCATION COLLEGE COVID19 RISK SCREENING DAILY DECLARATION FORM</b>
                        </h4>
                        <div>
                            <p style="padding-left: 40px; padding-right: 40px">
                                *<i><b>IMPORTANT!</b></i> : All staff / students / contractors / visitors are required to make a daily declaration of COVID-19 risk screening on every working day 
                                (whether working in the office or from home) as stated in item 5.1 (ii) regarding COVID-19 UiTM prevention measures. 
                                However, you are encouraged to make a declaration on a daily basis including public holidays and other holidays.
                            </p>
                        </div>

                        <div class="panel-container show">
                            <div class="panel-content">
                                {!! Form::open(['action' => 'CovidController@formStore', 'method' => 'POST']) !!}
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                @if(empty($exist))
                                    <div>
                                        <table class="table table-bordered table-hover table-striped w-100">
                                            <thead>
                                                <tr>
                                                    <div class="form-group">
                                                        <th style="text-align: center; border-left-style: hidden; border-right-style: hidden"><label>Full Name : </label><b style="font-size: 15px; letter-spacing: 1px; padding-left: 18px; color: rgb(27, 57, 3); font-weight: normal">{{ strtoupper($user->name)}}</b></th>
                                                        <th style="text-align: center; border-right-style: hidden"><label>Staff ID / Student ID: </label><b style="font-size: 15px; letter-spacing: 1px; padding-left: 18px; color: rgb(27, 57, 3); font-weight: normal">{{ strtoupper($user->id)}}</b></th>
                                                        <th style="text-align: center; border-right-style: hidden"><label>Email : </label><b style="font-size: 15px; letter-spacing: 1px; padding-left: 18px; color: rgb(27, 57, 3); font-weight: normal">{{ $user->email}}</b></th>
                                                        <th style="text-align: center; border-right-style: hidden"><label>Phone No. : </label></th>
                                                        <th style=" border-right-style: hidden">
                                                            <input class="form-control" id="user_phone" name="user_phone"  value="{{ old('user_phone') }}">
                                                            {{-- @error('user_phone')
                                                                <p style="color: red">{{ $message }}</p>
                                                            @enderror --}}
                                                        </th>
                                                    </div>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>

                                    <table id="info" class="table table-bordered table-hover table-striped w-100">
                                        <thead>
                                            <tr>
                                                <div class="form-group">
                                                    <th style="text-align: center" width="4%"><label class="form-label" for="qHeader">NO.</label></th>
                                                    <th style="text-align: center"><label class="form-label" for="qHeader">DECLARATION CHECKLIST</label></th>
                                                    <th style="text-align: center"><label class="form-label" for="qHeader">YES</label></th>
                                                    <th style="text-align: center"><label class="form-label" for="qHeader">NO</label></th>
                                                </div>
                                            </tr>
                                            <tr class="q1">
                                                <div class="form-group">
                                                    <td style="text-align: center" width="4%"><label for="q1">1.</label></td>
                                                    <td width="80%"><label for="q1">Have you been confirmed positive with COVID-19 within 14 days? <b style="color: red">@error('q1')* required @enderror</b></label></td>
                                                    <td style="text-align: center"><input type="radio" name="q1" id="q1" value="Y" {{ old('q1') == "Y" ? 'checked' : '' }}></td>
                                                    <td style="text-align: center"><input type="radio" name="q1" id="q1" value="N" {{ old('q1') == "N" ? 'checked' : '' }}></td>
                                                </div>
                                            </tr>
                                            <tr class="q2" style="display: none">
                                                <div class="form-group">
                                                    <td style="text-align: center" width="4%"><label for="q2">2.</label></td>
                                                    <td><label for="q2">Have you had close contact with anyone who confirmed positive case of COVID-19 within 10 days? <b style="color: red">@error('q2')* required @enderror</b></label></td>
                                                    <td style="text-align: center"><input type="radio" name="q2" id="q2" value="Y" {{ old('q2') == "Y" ? 'checked' : '' }}></td>
                                                    <td style="text-align: center"><input type="radio" name="q2" id="q2" value="N" {{ old('q2') == "N" ? 'checked' : '' }}></td>
                                                </div>
                                            </tr>
                                            <tr class="q3" style="display: none">
                                                <div class="form-group">
                                                    <td style="text-align: center" width="4%"><label for="q3">3.</label></td>
                                                    <td><label for="q3">
                                                        Have you had close contact with any individual on question 2 within 10 days <br><br> OR <br><br>
                                                        Have you ever attended an event or visited any place involving suspected or positive COVID-19 case within 10 days <br><br> OR <br><br>
                                                        Are you from an area of Enhanced Movement Control Order (EMCO) in period of 10 days ? <b style="color: red">@error('q3')* required @enderror</b></label></td>
                                                    <td style="text-align: center; vertical-align: middle"><input type="radio" name="q3" id="q3" value="Y" {{ old('q3') == "Y" ? 'checked' : '' }}></td>
                                                    <td style="text-align: center; vertical-align: middle"><input type="radio" name="q3" id="q3" value="N" {{ old('q3') == "N" ? 'checked' : '' }}></td>
                                                </div>
                                            </tr>
                                           
                                            <tr class="q4" style="display: none">
                                                <div class="form-group">
                                                    <td style="text-align: center" width="3%" rowspan="5"><label for="q4">4.</label></td>
                                                    <td><label for="q4">Do you experience the following symptoms:</label></td>
                                                    <td colspan="2"></td>
                                                </div>
                                            </tr>
                                            <tr class="q4" style="display: none">
                                                <div class="form-group">
                                                    <td width="3%"><label for="q4a"><li>Fever <b style="color: red">@error('q4a')* required @enderror</b></li></label></td>
                                                    <td style="text-align: center"><input type="radio" name="q4a" id="q4a" value="Y" {{ old('q4a') == "Y" ? 'checked' : '' }}></td>
                                                    <td style="text-align: center"><input type="radio" name="q4a" id="q4a" value="N" {{ old('q4a') == "N" ? 'checked' : '' }}></td>
                                                </div>
                                            </tr>
                                            <tr class="q4" style="display: none">
                                                <div class="form-group">
                                                    <td width="3%"><label for="q4b"><li>Cough <b style="color: red">@error('q4b')* required @enderror</b></li></label></td>
                                                    <td style="text-align: center"><input type="radio" name="q4b" id="q4b" value="Y" {{ old('q4b') == "Y" ? 'checked' : '' }}></td>
                                                    <td style="text-align: center"><input type="radio" name="q4b" id="q4b" value="N" {{ old('q4b') == "N" ? 'checked' : '' }}></td>
                                                </div>
                                            </tr>
                                            <tr class="q4" style="display: none">
                                                <div class="form-group">
                                                    <td width="3%"><label for="q4c"><li>Flu <b style="color: red">@error('q4c')* required @enderror</b></li></label></td>
                                                    <td style="text-align: center"><input type="radio" name="q4c" id="q4c" value="Y" {{ old('q4c') == "Y" ? 'checked' : '' }}></td>
                                                    <td style="text-align: center"><input type="radio" name="q4c" id="q4c" value="N" {{ old('q4c') == "N" ? 'checked' : '' }}></td>
                                                </div>
                                            </tr>
                                            <tr class="q4" style="display: none">
                                                <div class="form-group">
                                                    <td width="3%"><label for="q4d"><li>Difficulty in Breathing <b style="color: red">@error('q4d')* required @enderror</b></li></label></td>
                                                    <td style="text-align: center"><input type="radio" name="q4d" id="q4d" value="Y" {{ old('q4d') == "Y" ? 'checked' : '' }}></td>
                                                    <td style="text-align: center"><input type="radio" name="q4d" id="q4d" value="N" {{ old('q4d') == "N" ? 'checked' : '' }}></td>
                                                </div>
                                            </tr>
                                           
                                            <tr>
                                                <div class="form-group">
                                                    <td colspan="4"><label class="form-label" for="confirmation">
                                                    <input style="margin-top: 15px; margin-right: 30px; margin-left: 15px; margin-bottom: 15px;" type="checkbox" name="chk" id="chk" onclick="btn()"/>
                                                    <b> I CERTIFY THAT ALL INFORMATION PROVIDED IS CORRECT AND ACCURATE. ACTION MAY BE TAKEN IF THE INFORMATION PROVIDED IS FALSE.</b></label> 
                                                    <button style="margin-top: 5px;" class="btn btn-primary float-right" id="submit" name="submit" disabled><i class="fal fa-check"></i> Submit Declaration</button></td>
                                                </div>
                                            </tr>
                                        </thead>
                                    </table>
                                @else
                                    <table id="info" class="table table-bordered table-hover table-striped w-100">
                                        <thead>
                                            <tr align="center" class="data-row">
                                                <td valign="top" colspan="4" class="dataTables_empty">
                                                    <b style="font-family: 'Times New Roman', Times, serif; color: rgb(97 63 115)"> ' YOU HAVE MADE SELF DECLARATION FOR TODAY ' </b><br><br>
                                                    <table>
                                                        <tr><td style="background-color: rgb(97 63 115);color: white;">
                                                        <p class="mb-0 mt-0" style="font-size: 40px">{{ date(' j ', strtotime($exist->created_at) )}}
                                                        <sup style="top: -16px; font-size: 20px;">{{ date(' M Y ', strtotime($exist->created_at) )}}</sup>
                                                        <p style="margin-top: -32px;margin-left: 58px;margin-bottom: -15px;font-size: 21px;">{{ date(' l ', strtotime($exist->created_at) )}}</p></p>
                                                        <hr class="mb-0 mt-0">
                                                        <p align="center" class="mb-0 mt-0">{{$exist->category}}</p>
                                                    </td></tr>
                                                    </table>
                                                    <a style="margin-top: 20px;" class="btn btn-primary" href="/declare-info/{{$exist->id}}"><i class="fal fa-eye"></i> Today's Declaration Result</a>
                                                </td>
                                            </tr>
                                        </thead>
                                    </table>
                                @endif
                                       
                                {!! Form::close() !!}
                            </div>
                        </div>
                    
                    </div>
                </div>

            </div>
        </div>
    </div>

</main>
@endcan

@can('view list')
<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}})">
    <div class="subheader">
        <h1 class="subheader-title">
        <i class='subheader-icon fal fa-calendar-times'></i>Declaration Management
        </h1>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Today Declaration <span class="fw-300"><i>List</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <table id="declare" class="table table-bordered table-hover table-striped w-100">
                            <thead>
                                <tr class="bg-primary-50 text-center">
                                    <th style="width:25px">No</th>
                                    <th>ID</th>
                                    <th>NAME</th>
                                    <th>CATEGORY</th>
                                    <th>DATE CREATED</th>
                                    <th>TIME CREATED</th>
                                    <th>ACTION</th>
                                </tr>
                                <tr>
                                    <td class="hasinput"></td>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="ID"></td>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Name"></td>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Category"></td>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Date Created"></td>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Time Created"></td>
                                    <td class="hasinput"></td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

</main>
@endcan

@endsection
@section('script')
<script>

    function btn()
    {
        var chk = document.getElementById("chk")
        var submit = document.getElementById("submit");
        submit.disabled = chk.checked ? false : true;
        if(!submit.disabled){
            submit.focus();
        }
    }

    $(function () {          
      $("input[name=q1]").change(function () {        
        if ($(this).val() == "Y") {
          $(".q2").hide();
          $(".q3").hide();
          $(".q4").hide();
        }
        else {
          $(".q2").show();
        }
      });

      $("input[name=q2]").change(function () {        
        if ($(this).val() == "Y") {
          $(".q3").hide();
          $(".q4").hide();
        }
        else {
          $(".q3").show();
        }
      });

      $("input[name=q3]").change(function () {        
        if ($(this).val() == "Y") {
          $(".q4").hide();
        }
        else {
          $(".q4").show();
        }
      });

    })

    $(document).ready(function()
    {

        $('#declare thead tr .hasinput').each(function(i)
        {
            $('input', this).on('keyup change', function()
            {
                if (table.column(i).search() !== this.value)
                {
                    table
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });

            $('select', this).on('keyup change', function()
            {
                if (table.column(i).search() !== this.value)
                {
                    table
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        });


        var table = $('#declare').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/declareList",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { className: 'text-center', data: 'id', name: 'id' },
                    { className: 'text-center', data: 'user_id', name: 'user_id' },
                    { className: 'text-center', data: 'user_name', name: 'user_name' },
                    { className: 'text-center', data: 'category', name: 'category' },
                    { className: 'text-center', data: 'date', name: 'date' },
                    { className: 'text-center', data: 'time', name: 'time' },
                    { className: 'text-center', data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 2, "asc" ]],
                "initComplete": function(settings, json) {

                } 
        });

        $('#declare').on('click', '.btn-delete[data-remote]', function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var url = $(this).data('remote');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                    url: url,
                    type: 'DELETE',
                    dataType: 'json',
                    data: {method: '_DELETE', submit: true}
                    }).always(function (data) {
                        $('#declare').DataTable().draw(false);
                    });
                }
            })
        });

         

    });

</script>
@endsection

