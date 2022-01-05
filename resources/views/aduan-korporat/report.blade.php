@extends('layouts.admin')

@section('content')
<style>
    .swal2-container {
        z-index: 10000;
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
                                    <select class="form-control programme selectfilter" name="programme" id="programme">
                                        <option disabled selected>Please Select</option>
                                        @foreach ($programme as $programmes)
                                        <option value="{{ $programmes->id }}">{{ $programmes->id }} - {{ $programmes->programme_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label>Session</label>
                                    <select class="form-control selectfilter session" name="session1" id="session">
                                    </select>
                                </div>
                            </div>
                            <table class="table table-bordered" id="class-group">
                                <thead>
                                    <tr class="bg-primary-50 text-center">
                                        <th class="text-center">No.</th>
                                        <th class="text-center">Ticket No.</th>
                                        <th class="text-center">Category</th>
                                        <th class="text-center">User Category</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Assigned Department</th>
                                        <th class="text-center">Duration</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex float-right">
                            <a class="btn btn-success btn-sm float-right mb-2" href="javascript:;" data-toggle="modal" id="new">Offer Subject</a>
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
        $('#programme, #session').select2();

        $('#programme2, #session2').select2({
            dropdownParent: $('#crud-modal')
        });

        $('#new').click(function () {
            $('#crud-modal').modal('show');
        });

        $("#all").change(function(){
            var filter = false;
            $('.searchfilter').each(function(){
                if($(this).val()){
                    filter = true;
                }
            });

            if( !$(this).is(':checked') && !filter){
                $('.course_checkbox_submit').val();
            }

            $('#course').DataTable().ajax.reload();
            $('.course_checkbox').prop("checked",$(this).prop("checked"));
        });

        $("#all").click(function(){
            if(!$(this).is(':checked')){
                $('#uncheck').val(1);
            }
        });

        $('.course_checkbox').click(function(){
            if(!$(this).prop("checked")){
                $('#all').prop("checked",false);
            }
        });

        $('.searchfilter').bind('change keyup',function(){
            $('#all').prop('checked',false);
        });

        $('#course thead tr .hasinput').each(function(i)
        {
            $('input', this).on('keyup change', function()
            {
                if (student_table.column(i+1).search() !== this.value)
                {
                    student_table
                        .column(i+1)
                        .search(this.value)
                        .draw();
                }
            });

            $('select', this).on('keyup change', function()
            {
                if (student_table.column(i+1).search() !== this.value)
                {
                    student_table
                        .column(i+1)
                        .search(this.value)
                        .draw();
                }
            });
        });

        var selected = [];


        $('#merge_table thead tr .hasinput').each(function(i)
        {
            $('input', this).on('keyup change', function()
            {
                if (table.column(i).search() !== this.value)
                {
                    table
                        .column(1)
                        .search(this.value)
                        .draw();
                }
            });
        });

        var table = $('#merge_table').DataTable({
            processing: true,
            serverSide: true,
            autowidth: false,
            ajax: {
                url: "/data_mergecourse",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { data: 'id', name: 'id' },
                    { data: 'programme_code', name: 'programme_code' },
                    { data: 'merge_code', name: 'merge_code' },
                    { data: 'course', name: 'course' },
                    { data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 1, "asc" ]],
                "initComplete": function(settings, json) {
                },
        });
    });
        $(document).ready(function() {
            $('#programme').on('change', function() {
                var programme = $(this).val();
                if(programme) {
                    $.ajax({
                        url: '/exam-programme/'+programme,
                        type: "GET",
                        data : {"_token":"{{ csrf_token() }}"},
                        dataType: "json",
                        success:function(data) {
                            if(data){
                                $('#session').empty();
                                $('#session').focus;
                                $('select[name="session1"]').append(`<option value="" selected disabled>Please Choose</option>`);
                                $.each(data, function(key, value){
                                    $('select[name="session1"]').append('<option value="'+ value.academic_session_code +'">' + value.academic_session_code + '</option>');
                                });
                            }else{
                                $('#session').empty();
                            }
                        }
                    });
                }else{
                $('#session').empty();
                }
            });
        });

        $(document).ready(function() {
            $('#programme2').on('change', function() {
                var programme2 = $(this).val();
                if(programme2) {
                    $.ajax({
                        url: '/exam-programme/'+programme2,
                        type: "GET",
                        data : {"_token":"{{ csrf_token() }}"},
                        dataType: "json",
                        success:function(data) {
                            if(data){
                                $('#session2').empty();
                                $('#session2').focus;
                                $('select[name="session"]').append(`<option value="" selected disabled>Please Choose</option>`);
                                $.each(data, function(key, value){
                                    $('select[name="session"]').append('<option value="'+ value.academic_session_code +'">' + value.academic_session_code + '</option>');
                                });
                            }else{
                                $('#session2').empty();
                            }
                        }
                    });
                }else{
                $('#session2').empty();
                }
            });
        });

    $(document).ready(function()
    {
        function createDatatable(programme = null ,session = null)
        {
            var check = $.fn.DataTable.isDataTable('#class-group');

            if(check){
                $('#class-group').DataTable().destroy();
            }

            var table = $('#class-group').DataTable({
            processing: true,
            serverSide: true,
            autowidth: false,
            ajax: {
                url: "/data_classgroup",
                data: {programme:programme, session:session},
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { data: 'id', name: 'id'},
                    { data: 'academic_session', name: 'academic_session'},
                    { data: 'programme_code', name: 'programme_code'},
                    { data: 'course_code', name: 'course_code'},
                    { data: 'group_code', name: 'group_code'},
                    { data: 'lect_one', name: 'lect_one'},
                    { data: 'lect_two', name: 'lect_two'},
                    { data: 'lect_venue', name: 'lect_venue'},
                    { data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 1, "asc" ]],
                "initComplete": function(settings, json) {
                },
            });
        }

        $.ajaxSetup({
            headers:{
            'X-CSRF-Token' : $("input[name=_token]").val()
            }
        });

        $('#programme').on('change',function(){
            $('#session').val('').change();
        });

        $('.selectfilter').on('change',function(){
            var programme = $('#programme').val();
            var session = $('#session').val();
            if(programme && session){

                createDatatable(programme,session);
            }
        });

    });

</script>
@endsection
