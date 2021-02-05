@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
    <div class="subheader">
        <h1 class="subheader-title">
        <i class='subheader-icon fal fa-paperclip'></i>Category A Management
        </h1>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Category A <span class="fw-300"><i>List</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <table id="catA" class="table table-bordered table-hover table-striped w-100">
                            <thead>
                                <tr class="bg-primary-50 text-center">
                                    <th style="width:15px">No</th>
                                    <th>ID</th>
                                    <th>NAME</th>
                                    <th>POSITION</th>
                                    <th>QUARANTINE DAY</th>
                                    <th>DATE DECLARE</th>
                                    <th>TIME DECLARE</th>
                                    <th>FOLLOW UP</th>
                                    <th>ACTION</th>
                                </tr>
                                <tr>
                                    <td class="hasinput"></td>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="ID"></td>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Name"></td>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Position"></td>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Day"></td>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Date"></td>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Time"></td>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Follow Up"></td>
                                    <td class="hasinput"></td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="crud-modals" aria-hidden="true" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="card-header">
                    <h5 class="card-title w-100"><i class="fal fa-plus-square"></i>  ADD FOLLOW UP NOTE</h5>
                </div>
                <div class="modal-body">
                    {!! Form::open(['action' => 'CovidController@updateFollowup', 'method' => 'POST']) !!}
                    <input type="hidden" name="followup_id" id="followup">
                    
                    <td width="15%"><label class="form-label" for="follow_up">NOTES :</label></td>
                    <td colspan="5"><textarea cols="5" rows="10" class="form-control" id="name" name="follow_up"></textarea>
                        @error('follow_up')
                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                        @enderror
                    </td>
                    <br>
                    <div class="footer">
                        <button type="submit" class="btn btn-primary ml-auto float-right"><i class="fal fa-save"></i> Save</button>
                        <button type="button" class="btn btn-success ml-auto float-right mr-2" data-dismiss="modal"><i class="fal fa-window-close"></i> Close</button>
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
        $('#crud-modals').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) 
            var followup = button.data('followup') 
            var name = button.data('name')

            $('.modal-body #followup').val(followup); 
            $('.modal-body #name').val(name); 
        });

        $('#catA thead tr .hasinput').each(function(i)
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

        var table = $('#catA').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/AList",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { className: 'text-center', data: 'id', name: 'id' },
                    { className: 'text-center', data: 'user_id', name: 'user_id' },
                    { className: 'text-center', data: 'user_name', name: 'user_name' },
                    { className: 'text-center', data: 'user_post', name: 'user_post' },
                    { className: 'text-center', data: 'quarantine_day', name: 'quarantine_day' },
                    { className: 'text-center', data: 'date', name: 'date' },
                    { className: 'text-center', data: 'time', name: 'time' },
                    { className: 'text-center', data: 'follow_up', name: 'follow_up' },
                    { className: 'text-center', data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 5, "desc" ], [ 2, "asc"]],
                "initComplete": function(settings, json) {

                } 
        });

        $('#catA').on('click', '.btn-delete[data-remote]', function (e) {
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
                        $('#catA').DataTable().draw(false);
                    });
                }
            })
        });

    });

</script>
@endsection

