@extends('layouts.admin')

@section('content')
{{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script> --}}
{{-- <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>  --}}
{{-- <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script> --}}
<style>
    .swal2-container {
        z-index: 10000;
    }

    .dataTables_wrapper .dt-buttons {
        float: right; 
        margin-top: 20px;
        margin-bottom: 20px;
    }
</style>
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-file-alt'></i> i-Complaint
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>Report</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                            @if(session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session()->get('message') }}
                                </div>
                            @endif
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <label>Year</label>
                                    <select class="form-control year selectYear" name="year" id="year">
                                        <option disabled selected>Please Select</option>
                                        @foreach ($year as $y)
                                            <option value="{{ $y }}">{{ $y }}</option>                                        
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label>Month</label>
                                    <select class="form-control selectfilter month" name="months" id="month">
                                    </select>
                                </div>
                            </div>
                            <table class="table table-bordered" id="report">
                                <thead>
                                    <tr class="bg-primary-50 text-center">
                                        <th class="text-center">No.</th>
                                        <th class="text-center">Ticket No.</th>
                                        <th class="text-center">Date</th>
                                        <th class="text-center">Category</th>
                                        <th class="text-center">User Category</th>
                                        <th class="text-center">Assigned Department</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Duration</th>
                                        <th class="text-center">Date of Completion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="hasinput"></td>
                                        <td class="hasinput"></td>
                                        <td class="hasinput"></td>
                                        <td class="hasinput"></td>
                                        <td class="hasinput"></td>
                                        <td class="hasinput"></td>
                                        <td class="hasinput"></td>
                                        <td class="hasinput"></td>
                                        <td class="hasinput"></td>
                                    </tr>
                                </tbody>
                            </table>
                            <a href="/iComplaint-Reports" id="buttonfull" class="btn btn-success float-right" style="color: rgb(0, 0, 0); margin-top: 15px; margin-bottom: 15px;">
                                <i class="fal fa-file-excel"></i> Report
                            </a>
                            <button class="btn btn-success float-right" id="buttonyear" style="color: rgb(0, 0, 0); margin-top: 15px; margin-bottom: 15px; display:none">
                                <i class="fal fa-file-excel"></i> Report
                            </button>
                            <button class="btn btn-success float-right" id="buttonyearmonth" style="color: rgb(0, 0, 0); margin-top: 15px; margin-bottom: 15px; display:none">
                                <i class="fal fa-file-excel"></i> Report
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        $('#year').on('change', function() {
            var year = $(this).val();
            if(year) {
                $.ajax({
                    url: '/get-year/'+year,
                    type: "GET",
                    data : {"_token":"{{ csrf_token() }}"},
                    dataType: "json",
                    success:function(data) {
                        if(data){
                            $('#month').empty();
                            $('#month').focus;
                            $('select[name="months"]').append(`<option value="" selected disabled>Please Choose</option>`);
                            $.each(data, function(key, value){
                                $('select[name="months"]').append('<option value="'+ value +'">' + value + '</option>');
                            });
                            $("#buttonfull").hide();
                            $("#buttonyearmonth").hide();
                            $("#buttonyear").show();
                            $('#buttonyear').click(function()
                            {
                                window.location = "/iComplaint-Report-Year/" + year;
                            });
                        }else{
                            $('#month').empty();
                        }
                    }
                });
            }else{
            $('#month').empty();
            }
        });
    });

    $(document).ready(function()
    {
        var table = $('#report').DataTable({
            processing: true,
            serverSide: true,
            autowidth: false,
            ajax: {
                url: "/all-report",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { className: 'text-center', data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false },
                    { className: 'text-center', data: 'ticket_no', name: 'ticket_no'},
                    { className: 'text-center', data: 'date', name: 'date'},
                    { className: 'text-center', data: 'category', name: 'category'},
                    { className: 'text-center', data: 'user_category', name: 'user_category'},
                    { className: 'text-center', data: 'department', name: 'department'},
                    { className: 'text-center', data: 'status', name: 'status'},
                    { className: 'text-center', data: 'duration', name: 'duration'},
                    { className: 'text-center', data: 'complete', name: 'complete'},
                ],
                orderCellsTop: true,
                "order": [[ 0, "asc" ]],
                "initComplete": function(settings, json) {
                },
            });

        function createDatatableYear(year = null)
        {
            $('#report').dataTable().fnDestroy();

            var table = $('#report').DataTable({
            processing: true,
            serverSide: true,
            autowidth: false,
            ajax: {
                url: "/year-report",
                data: {year:year},
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                { className: 'text-center', data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false },
                    { className: 'text-center', data: 'ticket_no', name: 'ticket_no'},
                    { className: 'text-center', data: 'date', name: 'date'},
                    { className: 'text-center', data: 'category', name: 'category'},
                    { className: 'text-center', data: 'user_category', name: 'user_category'},
                    { className: 'text-center', data: 'department', name: 'department'},
                    { className: 'text-center', data: 'status', name: 'status'},
                    { className: 'text-center', data: 'duration', name: 'duration'},
                    { className: 'text-center', data: 'complete', name: 'complete'},
            ],
                orderCellsTop: true,
                "order": [[ 0, "asc" ]],
                "initComplete": function(settings, json) {
                },
            });
        }

        function createDatatable(year = null,month = null)
        {
            $('#report').dataTable().fnDestroy();

            var table = $('#report').DataTable({
            processing: true,
            serverSide: true,
            autowidth: false,
            ajax: {
                url: "/year-month-report",
                data: {year:year, month:month},
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                { className: 'text-center', data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false },
                    { className: 'text-center', data: 'ticket_no', name: 'ticket_no'},
                    { className: 'text-center', data: 'date', name: 'date'},
                    { className: 'text-center', data: 'category', name: 'category'},
                    { className: 'text-center', data: 'user_category', name: 'user_category'},
                    { className: 'text-center', data: 'department', name: 'department'},
                    { className: 'text-center', data: 'status', name: 'status'},
                    { className: 'text-center', data: 'duration', name: 'duration'},
                    { className: 'text-center', data: 'complete', name: 'complete'},
            ],
                orderCellsTop: true,
                "order": [[ 0, "asc" ]],
                "initComplete": function(settings, json) {
                },
                dom: 'frtipB',
               
                buttons: [
                    { extend: 'excel', text: 'Report', className: 'btn btn-danger', title: 'i-Complaint Report' },
                ]   
            });
        }

        $.ajaxSetup({
            headers:{
            'X-CSRF-Token' : $("input[name=_token]").val()
            }
        });

        $('#year').on('change',function(){
            $('#month').val('').change();
        });

        $('.selectYear').on('change',function(){
            var year = $('#year').val();
            
            if(year){
                createDatatableYear(year);
            }
        });


        $('.selectfilter').on('change',function(){
            var year = $('#year').val();
            var month = $('#month').val();
            
            if(year && month){
                createDatatable(year,month);
                $("#buttonfull").hide();
                $("#buttonyear").hide();
                $("#buttonyearmonth").show();
                $('#buttonyearmonth').click(function()
                {
                    window.location = "/iComplaint-Report-Year-Month/" + year +"/"+ month;
                });

            }
        });

    });

</script>
@endsection
