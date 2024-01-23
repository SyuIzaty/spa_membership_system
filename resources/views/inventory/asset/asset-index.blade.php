@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
    <div class="subheader">
        <h1 class="subheader-title">
        <i class='subheader-icon fal fa-dolly-flatbed'></i>ASSET LIST MANAGEMENT
        </h1>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        List <span class="fw-300"><i>Of Asset</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true"><i class="fal fa-times"></i></span>
                            </button>
                            <div class="d-flex align-items-center">
                                <div class="flex-1 pl-1">
                                    <i class="fal fa-exclamation-circle mr-2"></i>
                                    Please ensure that you select a minimum of <b>ONE</b> checkbox for the asset when generating a QR code, and generate QR codes only for assets with a <b>FINANCE CODE</b>.
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            {!! Form::open(['id' => 'print_mem_form', 'action' => ['Inventory\AssetManagementController@print_barcode'], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                            <table id="list_asset" class="table table-bordered table-hover table-striped w-100">
                                <thead>
                                    <tr class="bg-primary-50 text-center" style="white-space: nowrap">
                                        <th><input type="checkbox" id="all_mem"></th>
                                        <th>ID</th>
                                        <th>DEPARTMENT</th>
                                        <th>CODE TYPE</th>
                                        <th>FINANCE CODE</th>
                                        <th>ASSET CODE</th>
                                        <th>ASSET NAME</th>
                                        <th>ASSET TYPE</th>
                                        <th>ASSET CLASS</th>
                                        <th>CUSTODIAN</th>
                                        <th>STATUS</th>
                                        <th>AVAILABILITY</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex pull-right">
                        <button class="btn btn-info ml-auto float-right mr-2" id="test" name="action" value="Print"><i class="fal fa-print"></i> Print Qrcode</button>
                        {!! Form::close() !!}
                        @if (Auth::user()->hasPermissionTo('admin management'))
                            <a class="btn btn-primary float-right" href="/asset-detail"><i class="fal fa-plus-square"></i> Add Asset</a><br><br>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>
@endsection

@section('script')

<script>

    $('#department_id, #asset_code_type, #asset_type, #availability, #asset_class').select2();

    $("#all_mem").click(function(){
        var filter = false;
        var check = $(this).prop("checked") ? 0 : 1;
        $('.memfilter').each(function(){
            if($(this).val()){
                filter = true;
            }
        });

        if( !$(this).is(':checked') && !filter){
            $('.mem_checkbox_submit').val();
        }

        $('#uncheck_mem_1').val( check );
        $('#list_asset').DataTable().ajax.reload();
    });

    $('.memfilter').on('keyup',function(){
        $('#all_mem').prop('checked',false);
    });

    $(document).ready(function()
    {
        $('#list_asset thead tr .hasinput').each(function(i)
        {
            $('input', this).on('keyup change', function()
            {
                if (list_asset_table.column(i+1).search() !== this.value)
                {
                    list_asset_table
                        .column(i+1)
                        .search(this.value)
                        .draw();
                }
            });

            $('select', this).on('keyup change', function()
            {
                if (list_asset_table.column(i+1).search() !== this.value)
                {
                    list_asset_table
                        .column(i+1)
                        .search(this.value)
                        .draw();
                }
            });
        });

        var list_asset_table = $('#list_asset').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/data-asset-list",
                data: function ( d ) {
                    d.checkall = $('#all_mem').is(':checked') ? 1 : 0;
                    d.checked = $('.mem_checkbox_submit').val();
                    d.department_id = $('#department_id').val();
                    d.asset_code_type = $('#asset_code_type').val();
                    d.finance_code = $('#finance_code').val();
                    d.asset_code = $('#asset_code').val();
                    d.asset_name = $('#asset_name').val();
                    d.asset_type = $('#asset_type').val();
                    d.asset_class = $('#asset_class').val();
                    d.custodian_id = $('#custodian_id').val();
                    d.status = $('#status').val();
                    d.availability = $('#availability').val();
                    d.uncheck = $('#uncheck_mem_1').val();
                },
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { data: 'checkone', name: 'checkone', orderable: false, searchable: false},
                    { className: 'text-center', data: 'id', name: 'id' },
                    { className: 'text-center', data: 'department_id', name: 'department_id' },
                    { className: 'text-center', data: 'asset_code_type', name: 'asset_code_type' },
                    { className: 'text-center', data: 'finance_code', name: 'finance_code' },
                    { className: 'text-center', data: 'asset_code', name: 'asset_code' },
                    { className: 'text-center', data: 'asset_name', name: 'asset_name' },
                    { className: 'text-center', data: 'asset_type', name: 'asset_type' },
                    { className: 'text-center', data: 'asset_class', name: 'asset_class' },
                    { className: 'text-center', data: 'custodian_id', name: 'custodian_id'},
                    { className: 'text-center', data: 'status', name: 'status'},
                    { className: 'text-center', data: 'availability', name: 'availability'},
                    { className: 'text-center', data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 1, "desc" ]],
                "initComplete": function(settings, json) {

                }
        });

        $('#list_asset').on('click', '.btn-delete[data-remote]', function (e) {
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
                        $('#list_asset').DataTable().draw(false);
                    });
                }
            })
        });

    });

    $(document).on('change','.mem_checkbox', function(){
        var checked = $('.mem_checkbox_submit').val() ? $('.mem_checkbox_submit').val().split(',') : [];
        var value = $(this).val();
        var status = $(this).is(":checked");
        if(status){
            checked.push( value );
        }else{
            $('#all_mem').prop("checked",false);
            var idx = checked.indexOf(value);
            if(  idx !== -1){
                checked.splice(idx,1);
            }
        }
        $('.mem_checkbox_submit').val( checked.join(',') );
        $('#list_asset').DataTable().ajax.reload();

    });

    $('.memfiler').bind('keyup change',function(){
        $(this).parent().parent().parent().find('input[type="checkbox"]').prop('checked',false);
    })

    $('#list_asset').on('draw.dt',function(){
        $('.mem_checkbox').each(function(){
            $('#uncheck_mem_1').val(0);
            var checked = $('.mem_checkbox_submit').val() ? $('.mem_checkbox_submit').val().split(',') : [];
            if( checked.indexOf( $(this).val() ) !== -1){
                $(this).prop('checked','checked');
            }
        })
    });

</script>

@endsection
