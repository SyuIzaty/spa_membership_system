@extends('layouts.shortcourse_portal')

@section('content')

    <main id="js-page-content" role="main" class="page-content">
        {{-- <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-table'></i> Public View
            </h1>
        </div> --}}
        {{-- <h1 class="text-center heading text-iceps-blue">
            <b class="semi-bold">Featured</b> Short Courses
        </h1> --}}
        <div class="col-xl-12">
            <h1 class="text-center heading">
                <b class="semi-bold text-primary">Latest</b> Short Courses
            </h1>
            <hr class="mt-2 mb-3">
            <div class="row">
                @foreach ($events as $event)
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4" style="">
                        <div class="card mb-3" style="max-width: 540px;">
                            <div class="row no-gutters">
                                <div class="col-md-5 d-flex justify-content-center">
                                    {{-- <img src="/get-file-event/intec_poster.jpg" class="card-img" alt="..."
                                        style="width:137px;height:194px;"> --}}
                                    {{-- <img src="{{ URL::to('/') }}/img/system/intec_poster.jpg" class="card-img" alt="..."
                                        style="width:137px;height:194px;"> --}}
                                    @if (!isset($event->thumbnail_path))
                                        <img src="{{ asset('storage/shortcourse/poster/default/intec_poster.jpg') }}"
                                            class="card-img" style="width:137px;height:194px;">
                                    @else
                                        <img src="{{ asset($event->thumbnail_path) }}" class="card-img" style="width:137px;height:194px;
                                                                background-image:url('{{ asset('storage /shortcourse/poster/default/intec_poster.jpg') }}');
                                                                background-repeat: no-repeat;
                                                                background-size: 137px 194px;">
                                    @endif
                                </div>
                                <div class="col-md-7">
                                    <div class="card-body">
                                        <h5 class="card-title"><b>{{ $event->name }}</b></h5>
                                        <p class="card-text"><small class="text-muted">Published:
                                                {{ $event->created_at_diffForHumans }}</small>
                                        </p>
                                    </div>
                                    <div class="card-footer">
                                        <a href="/shortcourse/{{ $event->id }}"
                                            class="btn btn-sm btn-primary btn btn-block">Detail</a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>


            <hr class="mt-2 mb-3">
            <h1 class="text-center heading">
                <b class="semi-bold text-primary">Upcoming</b> Short Courses
            </h1>
            <hr class="mt-2 mb-3">
            <div class="row justify-content-md-center">
                <div class="col">
                    <div class="panel-content">
                        @csrf
                        @if (session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped w-100 m-0 table-sm" id="event">
                                <thead>
                                    <tr class="bg-primary-50 text-center">
                                        <th>ID</th>
                                        <th>NAME</th>
                                        <th>DATES</th>
                                    </tr>
                                    {{-- <tr>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search ID"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Name"></td> --}}
                                    {{-- <td class="hasinput"><input type="text" class="form-control" placeholder="Search Dates"></td> --}}
                                    {{-- <td></td>
                                    </tr> --}}
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
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
            $('#event thead tr .hasinput').each(function(i) {
                $('input', this).on('keyup change', function() {
                    if (table.column(i).search() !== this.value) {
                        table
                            .column(i)
                            .search(this.value)
                            .draw();
                    }
                });

                $('select', this).on('keyup change', function() {
                    if (table.column(i).search() !== this.value) {
                        table
                            .column(i)
                            .search(this.value)
                            .draw();
                    }
                });
            });


            var table = $('#event').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/events/data/shortcourse",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name-with-href',
                        name: 'name-with-href'
                    },
                    {
                        data: 'dates',
                        name: 'dates'
                    }
                ],
                orderCellsTop: true,
                "order": [
                    [0, "desc"]
                ],
                "columnDefs": [{
                    "targets": 2,
                    "orderable": false
                }],
                "initComplete": function(settings, json) {}
            });
            table.on('order.dt search.dt', function() {
                table.column(0, {
                    search: 'applied',
                    order: 'applied'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();

        });
    </script>
@endsection
