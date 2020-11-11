@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content">
    <div class="subheader">
        <h1 class="subheader-title">
        <i class='subheader-icon fal fa-university'></i>Unsuccessful Lead
        </h1>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Lead <span class="fw-300"><i>List</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <table id="in_lead_un" class="table table-bordered table-hover table-striped w-100">
                            <thead>
                                <tr class="bg-primary-50 text-center">
                                    <th>Name</th>
                                    <th>IC No.</th>
                                    <th>Email</th>
                                    <th>Phone No.</th>
                                    <th>Group</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    @role('sales manager|admin assistant')
                                    <th>Owner</th>
                                    @endrole
                                    <th>Action</th>
                                </tr>
                                <tr>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Search Name"></td>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Search IC"></td>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Search Email"></td>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Search Phone"></td>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Search Group"></td>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Search Date"></td>
                                    <td class="hasinput">
                                        <select id="leads_status" name="leads_status" class="form-control">
                                            <option value="">All</option>
                                            <option value="Not Show">Not Show</option>
                                            <option value="DUMB">DUMB</option>
                                        </select>
                                    </td>
                                    @role('sales manager|admin assistant')
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Search Owner"></td>
                                    @endrole
                                    <td class="hasinput"></td>
                                </tr>
                            </thead>
                        </table>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="crud-modal" aria-hidden="true" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="card-header">
                    <h5 class="card-title w-100">CHANGE OWNER</h5>
                </div>
                <div class="modal-body">
                    {!! Form::open(['action' => 'LeadController@updateAssign', 'method' => 'POST']) !!}
                    <input type="hidden" name="lead_id" id="lead">
                    
                    <div class="card-body">
                        <table class="table table-bordered table-hover table-striped w-100" style="table-layout:fixed">
                            <thead>
                                <tr align="center" class="card-header">
                                    <th style="width: 50px;">No.</th>
                                    <th>Assign To</th>
                                    <th style="width: 100px;">Select</th>
                                </tr>
                                @foreach($members as $non)
                                <tr>
                                    <td align="center">{{ $no++ }}</td>
                                    <td>{{$non->name}}</td>
                                    <td align="center">
                                        <input type="radio" name="assigned_to" value="{{ $non->id }}">
                                    </td>
                                </tr>
                                @endforeach
                            </thead>
                        </table>
                    </div>
                     
                    <div class="footer">
                        <button type="submit" class="btn btn-primary ml-auto float-right"><i class="fal fa-save"></i> Save</button>
                    </div>
                    {!! Form::close() !!}
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

        $('#crud-modal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) 
            var lead = button.data('lead') 
            var create = button.data('create')

            $('.modal-body #lead').val(lead);
            $('.modal-body #create').val(create); 
            $( "input:radio").val([create]);
        });

        $('#in_lead_un thead tr .hasinput').each(function(i)
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


        var table = $('#in_lead_un').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/api/inactiveUnLead/list",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { data: 'leads_name', name: 'leads_name' },
                    { data: 'leads_ic', name: 'leads_ic' },
                    { data: 'leads_email', name: 'leads_email' },
                    { data: 'leads_phone', name: 'leads_phone'},
                    { data: 'leads_group', name: 'leads_group'},
                    { data: 'created_at', name: 'created_at'},
                    { data: 'leads_status', name: 'leads_status'},
                    @role('sales manager|admin assistant')
                    { data: 'assigned_to', name: 'assigned_to'},
                    @endrole
                    { data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 1, "asc" ]],
                "initComplete": function(settings, json) {

                } 
        });

        $('#in_lead_un').on('click', '.btn-delete[data-remote]', function (e) {
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
                        $('#in_lead_un').DataTable().draw(false);
                    });
                }
            })
        });

    });

</script>

@endsection
