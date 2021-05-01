@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-search'></i> COVID REPORT
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>EXPORT COVID REPORT</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">

                            <ul class="nav nav-pills" role="tablist">
                                <li class="nav-item" style="margin-right: 2px">
                                    <a style="border: solid 1px;  border-radius: 0" data-toggle="tab" class="nav-link" href="#declare" role="tab"><i class="fal fa-check-circle"></i> DECLARED</a>
                                </li>
                                <li class="nav-item">
                                    <a style="border: solid 1px;  border-radius: 0" data-toggle="tab" class="nav-link" href="#undeclare" role="tab"><i class="fal fa-times-circle"></i> UNDECLARED</a>
                                </li>
                            </ul>
    
                            <br><br>

                            <div class="row">
                                <div class="col">
                                    <div class="tab-content" id="v-pills-tabContent">

                                        <div class="tab-pane active" id="declare" role="tabpanel" style="margin-top: -30px"><br>
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

                                        <div class="tab-pane" id="undeclare" role="tabpanel" style="margin-top: -30px"><br>
                                            @if (Session::has('message'))
                                                <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('message') }}</div>
                                            @endif
                                            <form action="{{ route('covidreport') }}" method="GET" id="form_find">
                                                <p><span class="text-danger">*</span> Required fields</p>
                                                <div class="row">
                                                    <div class="col-lg-6 col-sm-6 mb-2">
                                                        <div class="form-group">
                                                            <label><span class="text-danger">*</span> Date : </label>
                                                            <select class="form-control custom-datek" name="datek" id="datek">
                                                                <option value="" selected disabled> Please select </option>
                                                                {{-- <option>All</option> --}}
                                                                @foreach ($datek as $dat)
                                                                    <option value="{{ $dat->declare_date }}" {{ $req_date == $dat->declare_date  ? 'selected' : '' }}>{{  date(' Y-m-d ', strtotime($dat->declare_date)) }}</option>
                                                                @endforeach
                                                            </select> 
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label>Position : </label>
                                                            <select class="form-control custom-cates" name="cates" id="cates">
                                                                <option value="" selected disabled> Please select </option>
                                                                {{-- <option>All</option> --}}
                                                                @foreach ($cates as $post)
                                                                    <option value="{{ $post->user_code }}" {{ $req_cate == $post->user_code  ? 'selected' : '' }}>
                                                                        @if ($post->user_code == 'STF') STAFF @endif
                                                                        @if ($post->user_code == 'STD') STUDENT @endif 
                                                                        @if ($post->user_code == 'VSR') VISITOR @endif 
                                                                    </option>
                                                                @endforeach
                                                            </select> 
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <br>
                                            
                                            <div class="table-responsive">
                                                <table class="table table-bordered" id="reps">
                                                    <thead>
                                                        <tr class="bg-primary-50 text-center">
                                                            {{-- <th>NO</th> --}}
                                                            <th>ID</th>
                                                            <th>NAME</th>
                                                            <th>EMAIL</th>
                                                            <th>POSITION</th>
                                                            <th>DATE REQUEST</th>
                                                        </tr>
                                                        <tr>
                                                            {{-- <td class="hasinput"></td> --}}
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Search ID"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Search Name"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Search Email"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Search Position"></td>
                                                            <td class="hasinput"></td>
                                                        </tr>
                                                    </thead>
                                                    @if (isset($data) && !empty($data))
                                                    <tbody>
                                                        @foreach ($data as $key => $datas)
                                                            <tr>
                                                                {{-- <td class="text-center">{{ $no++ }}</td> --}}
                                                                <td class="text-center">{{ $datas['id'] }}</td>
                                                                <td>{{ isset($datas['name']) ? $datas['name'] : '--' }}</td>
                                                                <td>{{ isset($datas['email']) ? $datas['email'] : '--' }}</td>
                                                                <td class="text-center">
                                                                    @if ($datas['category'] == 'STF') STAFF @endif
                                                                    @if ($datas['category'] == 'STD') STUDENT @endif 
                                                                    @if ($datas['category'] == 'VSR') VISITOR @endif 
                                                                </td>
                                                                @if (isset($req_date) && !empty($req_date))
                                                                    <td class="text-center">{{  date(' Y-m-d ', strtotime($req_date)) }}</td>
                                                                @else
                                                                <td class="text-center">--</td>
                                                                @endif
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    @endif
                                                </table>
                                            </div>

                                            <br>

                                            @if(isset($req_date))
                                                <a class="btn buttons-csv btn-md float-right mb-4" href="/export-undeclare/{{$req_date}}/{{$req_cate}}"><span><i class="fal fa-file-excel"></i> Export</span></a>
                                                @if(empty($exist) && $req_cate == 'STF')
                                                    <a href="{{ route('remainder', ['date' => $req_date, 'cate'=> $req_cate]) }}" class="btn btn-danger ml-auto mr-2 float-right"><i class="fal fa-envelope"></i> Reminder</a><br>
                                                @endif
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

    $("#datek, #cates").change(function(){
        $("#form_find").submit();
    })
    
    $(document).ready(function()
    {
        $('#name, #category, #position, #department, #date, #datek, #cates').select2();

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

        $('#reps thead tr .hasinput').each(function(i)
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

        var table = $('#reps').DataTable({
            columnDefs: [],
                orderCellsTop: true,
                "order": [[ 1, "asc" ]],
                "initComplete": function(settings, json) {
                }
        });

    });
</script>
@endsection
