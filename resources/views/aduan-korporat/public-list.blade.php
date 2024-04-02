@extends('layouts.public')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/icomplaint.css') }}">

    <main id="js-page-content" role="main" id="main" class="page-content"
        style="background-image: url({{ asset('img/bg4.jpg') }}); background-size: cover">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" style="background-size: cover">
                        <div class="d-flex justify-content-center" style="color: black">
                            <div class="p-2">
                                <center><img src="{{ asset('img/intec_logo_new.png') }}" style="width: 320px;"
                                        class="responsive" /></center><br>
                                <h2 style="text-align: center" class="title">
                                    i-Complaint
                                </h2>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="panel-container show">
                            <div class="panel-content">
                                @if (Session::has('message'))
                                    <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i
                                            class="icon fal fa-check-circle"></i> {{ Session::get('message') }}</div>
                                @endif

                                <div class="table-responsive all">
                                    <table id="list" class="table table-bordered table-hover table-striped w-100">
                                        <thead>
                                            <tr class="bg-primary-50 text-center">
                                                <th class="text-center">No.</th>
                                                <th class="text-center">Ticket No.</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">View</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="hasinput"></td>
                                                <td class="hasinput"></td>
                                                <td class="hasinput"></td>
                                                <td class="hasinput"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('aduan-korporat.footer')
    </main>
@endsection
@section('script')
    <script>
        $(document).ready(function() {

            $('#list').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/get-lists/",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                            'content')
                    }
                },
                columns: [{
                        className: 'text-center',
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        className: 'text-left',
                        data: 'ticket_no',
                        name: 'ticket_no'
                    },
                    {
                        className: 'text-center',
                        data: 'status',
                        name: 'status'
                    },
                    {
                        className: 'text-center',
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                orderCellsTop: true,
                "order": [
                    [1, "asc"]
                ],
                "initComplete": function(settings, json) {

                }
            });
        });
    </script>
@endsection
