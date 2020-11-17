@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content">
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-plus-circle'></i> Study Plan Details: {{$std->plan_progs}} <span class="fw-300"><i></i></span>
        </h1>
    </div>
    <div class="row">

        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
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
                        
                        <div class="row">
                            <div class="col-sm-12">
                                {!! Form::open(['action' => ['StudyPlanController@updateDetail'], 'method' => 'POST'])!!}
                                {{Form::hidden('id', $std->id)}}
                                    <div class="card card-primary card-outline">
                                        <div class="card-header">
                                            <h5 class="card-title w-100">STUDY PLAN INFO</h5>
                                        </div>
                                        
                                        <div class="card-body">
                                            @if (Session::has('message'))
                                                <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('message') }}</div>
                                            @endif
                                            <table id="st_plan" class="table table-bordered table-hover table-striped w-100">
                                                <thead>
                                                    <p><span class="text-danger">*</span> Required fields</p>
                                                    <tr>
                                                        <div class="form-group">
                                                            <td width="15%"><label class="form-label" for="plan_progs"><span class="text-danger">*</span> Programme :</label></td>
                                                            <td width="40%">
                                                                <select class="form-control" name="plan_progs" id="plan_progs" >
                                                                    <option value="">-- Select Programme --</option>
                                                                    @foreach($program as $progs)
                                                                        <option value="{{$progs->id}}"  {{ $std->plan_progs == $progs->id ? 'selected="selected"' : '' }} placeholder="Programme">{{$progs->programme_name}}</option><br>
                                                                    @endforeach
                                                                    @error('plan_progs')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                                </select>
                                                            </td>
                                                            <td width="15%"><label class="form-label" for="plan_sm"><span class="text-danger">*</span> Study Mode :</label></td>
                                                            <td width="50%">
                                                                <select class="form-control" name="plan_sm" id="plan_sm" >
                                                                    <option value="">-- Select Programme --</option>
                                                                    @foreach($mode as $mod)
                                                                        <option value="{{$mod->id}}"  {{ $std->plan_sm == $mod->id ? 'selected="selected"' : '' }} placeholder="Mode">{{$mod->mode_name}}</option><br>
                                                                    @endforeach
                                                                    @error('plan_sm')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                                </select><br>
                                                            </td>
                                                        </div>
                                                    </tr>

                                                    <tr>
                                                        <div class="form-group">
                                                            <td width="15%"><label class="form-label" for="plan_stat"><span class="text-danger">*</span> Status</label></td>
                                                            <td width="40%">
                                                                <select class="form-control" id="plan_stat" name="plan_stat">
                                                                    <option value="">-- Select Course Status --</option>
                                                                    <option value="1" {{ old('plan_stat', $std->plan_stat) == '1' ? 'selected':''}} >Active</option>
                                                                    <option value="0" {{ old('plan_stat', $std->plan_stat) == '0' ? 'selected':''}} >Inactive</option>
                                                                </select>
                                                                @error('plan_stat')
                                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                @enderror
                                                            </td>
                                                            <td width="15%"><label class="form-label" for="plan_semester"><span class="text-danger">*</span> Effective Semester :</label></td>
                                                            <td colspan="3"><input class="form-control" id="plan_semester" name="plan_semester" value="{{ $std->plan_semester }}">
                                                                @error('plan_semester')
                                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                @enderror
                                                            </td>
                                                        </div>
                                                    </tr>
                                                
                                                </thead>
                                            </table>
                                                <button type="submit" class="btn btn-primary ml-auto float-right"><i class="fal fa-save"></i> Update</button>
                                        </div>
                                    </div>
                                {!! Form::close() !!}
                                
                                <br>

                                <div class="card card-primary card-outline">
                                    <div class="card-header">
                                        <h5 class="card-title w-100">STUDY PLAN HEADER</h5>
                                    </div>
                                    
                                    <div class="card-body">
                                        <table class="table table-bordered table-hover table-striped w-100" style="table-layout:fixed">
                                            <thead>
                                                <tr align="center" class="card-header">
                                                    <th style="width: 50px;">No.</th>
                                                    <th>Course Code</th>
                                                    <th>Course Name</th>
                                                    <th>Type</th>
                                                    <th>Credit Hours</th>
                                                    <th>Action</th>
                                                </tr>
                                                @foreach($stdHd as $planHd)
                                                {{-- @dd($stdHd) --}}
                                                <tr align="center"  class="data-row">
                                                    <td>{{ $no++ }}</td>
                                                    <td class="std_hd_course">{{$planHd->std_hd_course}}</td>
                                                    <td class="std_hd_course">{{$planHd->courses->course_name}}</td>
                                                    <td>
                                                        @if ($planHd->std_hd_type == 'C') Core @endif
                                                        @if ($planHd->std_hd_type == 'E') Elective @endif
                                                    </td>
                                                    <td class="std_hd_cr_hr">{{$planHd->std_hd_cr_hr}}</td>
                                                    <td>
                                                        @if($planHd->std_hd_type == 'E')
                                                            @php $data = []; @endphp
                                                        {{-- <a href="javascript:;" data-toggle="modal" id="news" class="btn btn-warning btn-sm"><i class="fal fa-plus-square"></i> Add Elective Courses</a> --}}
                                                        {{-- @php
                                                            $data = array_column($planHd->studyEl->toArray(), 'std_elec_course');
                                                        @endphp --}}
                                                        @php
                                                            foreach ($planHd->studyEl as $value)
                                                                $data[] = $value->std_elec_course;
                                                        @endphp
                                                        <a href="" data-toggle="modal" data-target="#elec-modal" data-elec="{{ implode(" , ",$data) }}" data-hd="{{$planHd->id}}" class="btn btn-warning btn-sm"><i class="fal fa-plus-square"></i> Add Elective Courses </a>
                                                        @endif
                                                        <button class="btn btn-danger btn-sm deletePlan" data-id="{{$planHd->id}}" data-action="{{route('deletePlanHeader', $planHd->id)}}"><i class="fal fa-trash"></i> Delete</button>
                                                        <meta name="csrf-token" content="{{ csrf_token() }}">
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </thead>
                                            <tbody>
                                                <tr align="center">
                                                    <td colspan="3"></td>
                                                    <td style="border-left-style: hidden;" colspan="1"><b>TOTAL CREDIT HOURS :</b></td>
                                                    <td colspan="1"><b>{{ $total }}</b></td>
                                                    <td style="border-left-style: hidden;" colspan="1"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <a href="javascript:;" data-toggle="modal" id="new" class="btn btn-primary ml-auto float-right"><i class="fal fa-plus-square"></i> Add Course</a>
                                    </div>
                                </div>
                            
                            </div>
                        </div>

                        <div class="modal fade" id="crud-modal" aria-hidden="true" >
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="card-header">
                                        <h5 class="card-title w-100">ADD COURSE</h5>
                                    </div>
                                    <div class="modal-body">
                                        {!! Form::open(['action' => 'StudyPlanController@createPlanHeader', 'method' => 'POST']) !!}
                                        {{Form::hidden('id', $std->id)}}
    
                                            <div class="form-group">
                                                <td width="15%"><label class="form-label" for="std_hd_course"> Course :</label></td>
                                                <td colspan="7">
                                                    <select class="std_hd_course form-control" name="std_hd_course" id="std_hd_course" >
                                                        <option value="">-- Select Course --</option>
                                                        @foreach ($planCourse as $crs) 
                                                        <option value="{{ $crs->id }}" {{ old('std_hd_course') ? 'selected' : '' }}>
                                                        [{{ $crs->id }}] {{ $crs->course_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('std_hd_course')
                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                    @enderror
                                            </div>

                                            <div class="form-group">
                                                    <td width="15%"><label class="form-label" for="std_hd_cr_hr"> Credit Hours :</label></td>
                                                    <td colspan="7">
                                                        <input type="number" class="form-control" id="std_hd_cr_hr" name="std_hd_cr_hr" readonly>
                                                        @error('std_hd_cr_hr')
                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                        @enderror
                                                    </td>
                                            </div>

                                            <div class="form-group">
                                                <td width="15%"><label class="form-label" for="std_hd_type"> Type :</label></td>
                                                <td colspan="7">
                                                    <select class="form-control" id="std_hd_type" name="std_hd_type">
                                                        <option value="">-- Select Type --</option>
                                                        <option value="C" {{ old('std_hd_type') == '0' ? 'selected':''}} >Core</option>
                                                        <option value="E" {{ old('std_hd_type') == '1' ? 'selected':''}} >Elective</option>
                                                    </select>
                                                    @error('std_hd_type')
                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                    @enderror
                                                </td>
                                            </div>
                                         
                                        <div class="footer">
                                            <button type="submit" class="btn btn-primary ml-auto float-right"><i class="fal fa-save"></i> Save</button>
                                            <button type="button" class="btn btn-success ml-auto float-right mr-2" data-dismiss="modal"><i class="fal fa-window-close"></i> Close</button>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="elec-modal" aria-hidden="true" >
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="card-header">
                                        <h5 class="card-title w-100">LIST OF COURSES</h5>
                                    </div>
                                    <div class="modal-body">
                                        {!! Form::open(['action' => 'StudyPlanController@electiveInfo', 'method' => 'POST']) !!}
                                        <input type="hidden" name="hd" id="hd">
                                        <input type="hidden" name="std" value="{{ $std->id }}">
                                        {{-- @dd($stdHd) --}}
                                        
                                            <div class="form-group"  style="max-height: 500px; overflow-y: auto;">
                                                <table class="table table-bordered table-hover table-striped w-100" style="table-layout:fixed">
                                                    <thead>
                                                        <tr align="center" class="card-header">
                                                            <th>Course Code</th>
                                                            <th>Course Name</th>
                                                            <th>Credit Hours</th>
                                                            <th style="width: 80px;">Action</th>
                                                        </tr>
                                                        @foreach($planCourse as $courses)
                                                        <tr align="center" class="data-row">
                                                            <td align="left" >{{ $courses->course_code }}</td>
                                                            <td align="left" >{{ $courses->course_name }}</td>
                                                            <td align="left" >{{ $courses->credit_hours }}</td>
                                                            <td>  
                                                                <input type="checkbox" name="std_elec_course[]" value="{{ $courses->course_code }}" multiple="multiple">
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </thead>
                                                </table>
                                            </div>

                                        <div class="footer">
                                            <button type="submit" class="btn btn-primary ml-auto float-right"><i class="fal fa-save"></i> Save</button>
                                            <button type="button" class="btn btn-success ml-auto float-right mr-2" data-dismiss="modal"><i class="fal fa-window-close"></i> Close</button>
                                        </div>
                                        {!! Form::close() !!}
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
    $(document).ready(function()
    {
        $('#new').click(function () {
            $('#crud-modal').modal('show');
        });

        $('#elec-modal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var hd = button.data('hd')
        var elec = button.data('elec')

        var data = elec.split(" , ");

        console.log(data)

        $('.modal-body #hd').val(hd); 
        $('.modal-body #data').val(data);
        $("input:checkbox").val(data);
    });

        // $('#news').click(function () {
        //     $('#elec-modal').modal('show');
        // });

        // $('#elec-modal').on('show.bs.modal', function(event) {
        //     var button = $(event.relatedTarget) 
        //     var source = button.data('source') 
        //     var name = button.data('name')

        //     $('.modal-body #source').val(source); // # for id in form 
        //     $('.modal-body #name').val(name); 
        // });

        if($('.std_hd_course').val()!=''){
            updateCr($('.std_hd_course'));
        }
        $(document).on('change','.std_hd_course',function(){
            updateCr($(this));
        });

        function updateCr(elem){
            var course_id=elem.val();   

            $.ajax({
                type:'get',
                url:'{!!URL::to('findCourseCr')!!}',
                data:{'id':course_id},
                success:function(data)
                {
                    $('#std_hd_cr_hr').val(data.credit_hours);
                }
                // error:function(){
                //     console.log('success');
                // }, // ni tak perlu pun
            });
        }

        $('#follow_track thead tr .hasinput').each(function(i)
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

        var table = $('#follow_track').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/api/followTrack/list",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { data: 'follow_title', name: 'follow_title' },
                    { data: 'follow_type_id', name: 'follow_type_id' },
                    { data: 'follow_date', name: 'follow_date' },
                    { data: 'status_id', name: 'status_id'},
                    { data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 1, "asc" ]],
                "initComplete": function(settings, json) {

                } 
        });

    });

    $('.deletePlan').click(function() {
            console.log('asdaa');
            var id = $(this).data('id');
            var url = '{{route("deletePlanHeader", "id")}}';
            url = url.replace('id', id );
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
                        type: 'DELETE',
                        url: url,
                        data: {_token: CSRF_TOKEN},
                        dataType: 'JSON',
                        success: function () {
                            Swal.fire({ text: "Successfully delete the data.", icon: 'success'
                            }).then(() => {
                                location.reload();
                            });
                        }
                    });
                }
            })
        })

</script>

@endsection
