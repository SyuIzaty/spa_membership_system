@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
    <div class="subheader">
        <h1 class="subheader-title">
        <i class='subheader-icon fal fa-paperclip'></i> Covid Report Export
        </h1>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>EXPORT UNDECLARED REPORT</h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>

                <div class="panel-container show">
                    <div class="panel-content">
                            <form action="{{ route('unregister') }}" method="GET" id="form_find">
                                <p><span class="text-danger">*</span> Required fields</p>
                                <div class="row">
                                    <div class="col-lg-6 col-sm-6 mb-2">
                                        <div class="form-group">
                                            <label><span class="text-danger">*</span> Date : </label>
                                            <select class="form-control custom-date" name="date" id="date">
                                                <option value="" selected disabled> Please select </option>
                                                {{-- <option>All</option> --}}
                                                @foreach ($dates as $dat)
                                                    <option value="{{ $dat->declare_date }}" {{ $req_date == $dat->declare_date  ? 'selected' : '' }}>{{  date(' Y-m-d ', strtotime($dat->declare_date)) }}</option>
                                                @endforeach
                                            </select> 
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Position : </label>
                                            <select class="form-control custom-category" name="category" id="category">
                                                <option value="" selected disabled> Please select </option>
                                                {{-- <option>All</option> --}}
                                                @foreach ($posts as $post)
                                                    <option value="{{ $post->category }}" {{ $req_post == $post->category  ? 'selected' : '' }}>
                                                        @if ($post->category == 'STF') STAFF @endif
                                                        @if ($post->category == 'STD') STUDENT @endif 
                                                    </option>
                                                @endforeach
                                            </select> 
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <br>
                            
                        <div class="table-responsive">
                            <table class="table table-bordered" id="rep">
                                <thead>
                                    <tr class="bg-primary-50 text-center">
                                        <th>NO</th>
                                        <th>ID</th>
                                        <th>NAME</th>
                                        <th>EMAIL</th>
                                        <th>POSITION</th>
                                        <th>DATE REQUEST</th>
                                    </tr>
                                    <tr>
                                        <td class="hasinput"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search ID"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Name"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Email"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Position"></td>
                                        <td class="hasinput"></td>
                                    </tr>
                                </thead>
                                @if (isset($datas) && !empty($datas))
                                <tbody>
                                    @foreach ($datas as $key => $data)
                                        <tr>
                                            <td class="text-center">{{ $no++ }}</td>
                                            <td class="text-center">{{ $data->id }}</td>
                                            <td>{{ isset($data->name) ? $data->name : '--' }}</td>
                                            <td>{{ isset($data->email) ? $data->email : '--' }}</td>
                                            <td class="text-center">
                                                @if ($data->category == 'STF') STAFF @endif
                                                @if ($data->category == 'STD') STUDENT @endif 
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
                        @if (isset($req_date))
                        {{-- <div class="panel-content rounded-bottom  border-left-0 border-right-0 border-bottom-0 text-muted d-flex float-right"> --}}
                            <a class="btn buttons-csv btn-md float-right mb-4" href="/export-unregister/{{$req_date}}/{{$req_post}}"><span><i class="fal fa-file-excel"></i> Export</span></a>
                        {{-- </div> --}}
                        @endif
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
<script>

    $("#date, #category").change(function(){
        $("#form_find").submit();
    })
    
    $(document).ready(function()
        {
            $('.custom-date, .custom-category').select2();

            $('#rep thead tr .hasinput').each(function(i)
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

        var table = $('#rep').DataTable({
            columnDefs: [],
                orderCellsTop: true,
                "order": [[ 1, "asc" ]],
                "initComplete": function(settings, json) {
                }
        });

        });

    </script>
@endsection