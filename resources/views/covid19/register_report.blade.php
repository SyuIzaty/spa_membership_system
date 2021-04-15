@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-search'></i> Covid Report Export
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>EXPORT DECLARED REPORT</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                            {{-- <form action="{{url('export_applicant')}}" method="GET" id="upload_form"> --}}
                                <div class="row">
                                    <div class="col-md-6 mt-2">
                                        <label>Name</label>
                                        <select class="selectfilter form-control" name="name" id="name">
                                            <option value="">Select Name</option>
                                            <option>All</option>
                                            @foreach($name as $names)
                                                <option value="{{$names->user_id}}" <?php if($request->name == $names->user_id) echo "selected"; ?> >{{$names->user_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <label>Category</label>
                                        <select class="selectfilter form-control" name="category" id="category">
                                            <option value="">Select Category</option>
                                            <option>All</option>
                                            @foreach($category as $cat)
                                                <option value="{{$cat->category}}" <?php if($request->category == $cat->category) echo "selected"; ?> >{{$cat->category}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <label>Position</label>
                                        <select class="selectfilter form-control" name="position" id="position">
                                            <option value="">Select Position</option>
                                            <option>All</option>
                                            @foreach($position as $post)
                                                <option value="{{$post->user_code}}" {{ $request->position == $post->user_code ? 'selected="selected"' : ''}}>{{$post->user_type}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <label>Department</label>
                                        <select class="selectfilter form-control" name="department" id="department">
                                            <option value="">Select Department</option>
                                            <option>All</option>
                                            @foreach($department as $depart)
                                                <option value="{{ $depart->id }}" {{ $request->department == $depart->id ? 'selected="selected"' : ''}}>{{ $depart->department_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <label>Date</label>
                                        <select class="selectfilter form-control" name="date" id="date">
                                            <option value="">Select Date</option>
                                            <option>All</option>
                                            @foreach($date as $dates)
                                                <option value="{{ $dates->declare_date }}" {{ $request->date == $dates->declare_date  ? 'selected="selected"' : ''}}>{{ date(' Y-m-d ', strtotime($dates->declare_date)) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <br>
                            {{-- </form> --}}
                            <div class="table-responsive">
                                <table class="table table-bordered" id="rep">
                                    <thead>
                                        <tr class="bg-primary-50 text-center">
                                            <th>ID</th>
                                            <th>NAME</th>
                                            <th>IC NO</th>
                                            <th>EMAIL</th>
                                            <th>PHONE</th>
                                            <th>Q1</th>
                                            <th>Q2</th>
                                            <th>Q3</th>
                                            <th>Q4A</th>
                                            <th>Q4B</th>
                                            <th>Q4C</th>
                                            <th>Q4D</th>
                                            <th>CATEGORY</th>
                                            <th>POSITION</th>
                                            <th>DEPARTMENT</th>
                                            <th>FORM TYPE</th>
                                            <th>DECLARE DATE</th>
                                            <th>CREATED AT</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('script')
<style>
    .buttons-csv{
        color: white;
        background-color: #606FAD;
        float: right;
    }
</style>
<script >

    $(document).ready(function()
    {
        $('#name, #category, #position, #department, #date').select2();

        function createDatatable(name = null, category = null, position = null, department = null, date = null)
        {
            $('#rep').DataTable().destroy();
            var table = $('#rep').DataTable({
            processing: true,
            // serverSide: true,
            autowidth: false,
            ajax: {
                url: "/data_covidexport",
                data: {name:name, category:category, position:position, department:department, date:date},
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            "dom" : "Bltp",
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            iDisplayLength: 10,
            columnDefs: [{ "visible": false,"targets":[17]}],
            columns: [
                    { data: 'user_id', name: 'user_id' },
                    { data: 'user_name', name: 'user_name' },
                    { data: 'user_ic', name: 'user_ic' },
                    { data: 'user_email', name: 'user_email' },
                    { data: 'user_phone', name: 'user_phone' },
                    { data: 'q1', name: 'q1' },
                    { data: 'q2', name: 'q2' },
                    { data: 'q3', name: 'q3' },
                    { data: 'q4a', name: 'q4a' },
                    { data: 'q4b', name: 'q4b' },
                    { data: 'q4c', name: 'q4c' },
                    { data: 'q4d', name: 'q4d' },
                    { data: 'category', name: 'category' },
                    { data: 'user_position', name: 'user_position' },
                    { data: 'department_id', name: 'department_id' },
                    { data: 'form_type', name: 'form_type' },
                    { data: 'declare_date', name: 'declare_date' },
                    { data: 'created_at', name: 'created_at' },
                ],
                orderCellsTop: true,
                "order": [[ 16, "desc" ]],
                "initComplete": function(settings, json) {
                },
                select : true,
                buttons: [
                    {
                        extend : 'csv',
                        text : '<i class="fal fa-file-excel"></i> Export',
                        exportOptions : {
                            modifier : {
                                order : 'original',  // 'current', 'applied', 'index',  'original'
                                page : 'all',      // 'all',     'current'
                                search : 'none',     // 'none',    'applied', 'removed'
                                // selected: null
                            }
                        }
                    }
                ]
            });
        }

        $('.selectfilter').on('change',function(){
            var name = $('#name').val();
            var category = $('#category').val();
            var position = $('#position').val();
            var department = $('#department').val();
            var date = $('#date').val();
            createDatatable(name,category,position,department,date);
        });

    });
</script>
@endsection
