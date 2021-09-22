@extends('layouts.shortcourse_portal')

@section('content')

    <main id="js-page-content" role="main" class="page-content">
        <div class="col-xl-12">
            <h1 class="text-center heading">
                <b class="semi-bold text-primary">Latest</b> Short Courses
            </h1>
            <hr class="mt-2 mb-3">
            <div class="row">
                @foreach ($events as $event)
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                        <div class="card mb-3" style="max-width: 540px;">
                            <div class="row no-gutters">
                                <div class="col-md-5 d-flex justify-content-center">
                                    @if (!isset($event->thumbnail_path))
                                        <img src="{{ asset('storage/shortcourse/poster/default/intec_poster.jpg') }}"
                                            class="card-img" style="align-self:center; object-fit:cover;">
                                    @else
                                        <img src="{{ asset($event->thumbnail_path) }}" class="card-img" style="
                                                    background-image:url('{{ asset('storage /shortcourse/poster/default/intec_poster.jpg') }}');
                                                    background-repeat: no-repeat;
                                                    background-size: 137px 194px;">
                                    @endif
                                </div>
                                <div class="col-md-7 d-flex flex-column justify-content-between">
                                    <div class="card-body">
                                        <h5 class="card-title" style="
                                                display: -webkit-box;
                                                -webkit-line-clamp: 3;
                                                -webkit-box-orient: vertical;
                                                text-align: start;
                                                overflow: hidden;
                                                text-overflow: ellipsis;"><b>{{ $event->name }}</b></h5>
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
                        <div class="row row-md-12">
                            <div class="col-sm-8">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped w-100 m-0 table-sm"
                                        id="event">
                                        <thead>
                                            <tr class="bg-primary-50 text-center">
                                                <th>ID</th>
                                                <th>NAME</th>
                                                <th>TOPIC</th>
                                                <th>FROM</th>
                                                <th>TO</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="table-responsive">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">Filters</h5>
                                            <div class="form-group" id="form-group-category">
                                                <span style="color: purple">
                                                    <h3>Category</h3>
                                                </span>
                                                <select class="form-control category " name="category" id="category"
                                                    data-select2-id="category" tabindex="-1" aria-hidden="true">
                                                    <option value='-1'>
                                                        All
                                                    </option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}">
                                                            {{ $category->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group" id="form-group-subcategory" style="display:none">
                                                <span style="color: purple">
                                                    <h3>Sub-Category</h3>
                                                </span>
                                                <select class="form-control subcategory " name="subcategory"
                                                    id="subcategory" data-select2-id="subcategory" tabindex="-1"
                                                    aria-hidden="true">
                                                    <option value='-1'>
                                                        All
                                                    </option>
                                                    @foreach ($subcategories as $subcategory)
                                                        <option value="{{ $subcategory->id }}">
                                                            {{ $subcategory->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group" id="form-group-topic" style="display:none">
                                                <span style="color: purple">
                                                    <h3>Topic</h3>
                                                </span>
                                                <select class="form-control topic " name="topic" id="topic"
                                                    data-select2-id="topic" tabindex="-1" aria-hidden="true">
                                                    <option value='-1'>
                                                        All
                                                    </option>
                                                    @foreach ($topics as $topic)
                                                        <option value="{{ $topic->id }}">
                                                            {{ $topic->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
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
    <script>
        $(document).ready(function() {

            $('.category, .subcategory, .topic').select2();

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
                    },
                    data: function(d) {
                        d.category_id = $('#category').find(":selected").val();
                        d.subcategory_id = $('#subcategory').find(":selected").val();
                        d.topic_id = $('#topic').find(":selected").val();
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
                        data: 'topic_list_string',
                        name: 'topic_list_string'
                    },
                    {
                        data: 'datetime_start_toDayDateTimeString',
                        name: 'datetime_start_toDayDateTimeString'
                    },

                    {
                        data: 'datetime_end_toDayDateTimeString',
                        name: 'datetime_end_toDayDateTimeString'
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

            $('#category').change(function(event) {
                var category_id = $('#category').find(":selected").val();
                $('#form-group-topic').hide();
                $('#form-group-subcategory').hide();

                $.get("/category/subcategories/" + category_id, function(data) {
                    $('#subcategory').empty();
                    $('#subcategory').append(`
                        <option value = '-1'> All </option>
                    `);
                    data.forEach(function(x) {
                        $('#subcategory').append(`
                            <option value = '${x.id}'> ${x.name} </option>
                        `);
                    })
                }).done(function(data) {
                    if (category_id != -1) {
                        $('#form-group-subcategory').show();
                    }
                    $('#event').DataTable().ajax.reload();
                });

            });

            $('#subcategory').change(function(event) {
                var subcategory_id = $('#subcategory').find(":selected").val();
                $('#form-group-topic').hide();
                $.get("/category/subcategory/topics/" + subcategory_id, function(data) {
                    $('#topic').empty();
                    $('#topic').append(`
                        <option value = '-1'> All </option>
                    `);
                    data.forEach(function(x) {
                        $('#topic').append(`
                            <option value = '${x.id}'> ${x.name} </option>
                        `);
                    })
                }).done(function(data) {
                    if (subcategory_id != -1) {
                        $('#form-group-topic').show();
                    }
                    $('#event').DataTable().ajax.reload();

                });
            });

            $('#topic').change(function(event) {
                var subcategory_id = $('#subcategory').find(":selected").val();

                $('#event').DataTable().ajax.reload();
            });

        });
    </script>
@endsection
