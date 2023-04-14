@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content"
        style="background-image: url({{ asset('img/bg-form.jpg') }}); background-size: cover">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-paperclip'></i>ICT EQUIPMENT RENTAL
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>
                            Equipment Rental <span class="fw-300"><i>List</i></span>
                        </h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip"
                                data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip"
                                data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10"
                                data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                            <div class="row">
                                <div class="col-sm-6 col-xl-4">
                                    <div
                                        class="p-3 bg-primary-300 rounded overflow-hidden position-relative text-white mb-g">
                                        <div class="">
                                            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                {{ $count }}
                                                <small class="m-0 l-h-n">TOTAL RECORD <b
                                                        style="font-weight: 900">{{ $currentYear }}</b></small>
                                            </h3>
                                        </div>
                                        <i class="fal fa-users position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1"
                                            style="font-size:6rem"></i>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xl-4">
                                    <div
                                        class="p-3 bg-danger-400 rounded overflow-hidden position-relative text-white mb-g">
                                        <div class="">
                                            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                {{ $count2 }}
                                                <small class="m-0 l-h-n">PENDING/REJECTED RECORD <b
                                                        style="font-weight: 900">{{ $currentYear }}</b></small>
                                            </h3>
                                        </div>
                                        <i class="fal fa-calendar-minus position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1"
                                            style="font-size:6rem"></i>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xl-4">
                                    <div
                                        class="p-3 bg-warning-400 rounded overflow-hidden position-relative text-white mb-g">
                                        <div class="">
                                            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                {{ $count3 }}
                                                <small class="m-0 l-h-n">APPROVED RECORD <b
                                                        style="font-weight: 900">{{ $currentYear }}</b></small>
                                            </h3>
                                        </div>
                                        <i class="fal fa-calendar-check position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4"
                                            style="font-size: 6rem;"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <div class="col-md-6">
                                    <label>Equipment</label>
                                    <select class="selectfilter form-control" name="equipment" id="equipment">
                                        <option value="">Select Option</option>
                                        @foreach ($equipment as $e)
                                            <option value="{{ $e->id }}" <?php if ($selectedequipment == $e->id) {
                                                echo 'selected';
                                            } ?>>
                                                {{ $e->id }}-{{ $e->equipment_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div><br>
                                <table id="rental" class="table table-bordered table-hover table-striped w-100">
                                    <thead>
                                        <tr class="bg-primary-50 text-center" style="white-space: nowrap">
                                            <th>id</th>
                                            <th>Staff ID:</th>
                                            <th>Staff Name:</th>
                                            <th>No. Phone:</th>
                                            <th>Rent Date:</th>
                                            <th>Return Date:</th>
                                            <th>Status:</th>
                                            <th>Action:</th>
                                        </tr>
                                        <tr>
                                            <td class="hasinput"><input type="text" class="form-control"
                                                    placeholder="ID"></td>
                                            <td class="hasinput"><input type="text" class="form-control"
                                                    placeholder="Staff ID"></td>
                                            <td class="hasinput"><input type="text" class="form-control"
                                                    placeholder="Staff Name"></td>
                                            <td class="hasinput"><input type="text" class="form-control"
                                                    placeholder="No. phone"></td>
                                            <td class="hasinput"><input type="text" class="form-control"
                                                    placeholder="Rent Date"></td>
                                            <td class="hasinput"><input type="text" class="form-control"
                                                    placeholder="Return Date"></td>
                                            <td class="hasinput"><input type="text" class="form-control"
                                                    placeholder="Status"></td>
                                            <td class="hasinput"><input type="text" class="form-control"
                                                    placeholder="Action"></td>

                                        </tr>
                                    </thead>

                                </table>
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
        .buttons-csv,
        .buttons-copy,
        .buttons-excel,
        .buttons-print {
            color: white;
            background-color: #606FAD;
            float: right;
            margin: 0px 8px;
        }
    </style>
    <script>
        $(document).ready(function() {

            $('#rental thead tr .hasinput').each(function(i) {
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
            function createDatatable(equipment = null) {
                $('#rental').DataTable().destroy();
                var table = $('#rental').DataTable({
                    processing: true,
                    serverSide: true,
                    autowidth: false,
                    deferRender: true,
                    ajax: {
                        url: "/data_rental",
                        data: {
                            equipment: equipment,
                        },
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    },
                    "dom": "Bltp",
                    "lengthMenu": [
                        [10, 25, 50, -1],
                        [10, 25, 200, "All"]
                    ],
                    iDisplayLength: 10,
                    columns: [{
                            className: 'text-center',
                            data: 'sid',
                            name: 'id'
                        },
                        {
                            className: 'text-center',
                            data: 'staff',
                            name: 'staff_id'
                        },
                        {
                            className: 'text-center',
                            data: 'name',
                            name: 'name'
                        }, //call the data from equipmentStaff table(declare in TestController@data_rental)
                        {
                            className: 'text-center',
                            data: 'phone',
                            name: 'hp_no'
                        },
                        {
                            className: 'text-center',
                            data: 'renDate',
                            name: 'rent_date'
                        },
                        {
                            className: 'text-center',
                            data: 'retDate',
                            name: 'return_date'
                        },
                        {
                            className: 'text-center',
                            data: 'sta',
                            name: 'status'
                        },
                        {
                            className: 'text-center',
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ],
                    orderCellsTop: true,
                    "order": [
                        [1, "asc"]
                    ],
                    "initComplete": function(settings, json) {},
                    "fnDrawCallback": function() {
                        $('.total_record').text(this.fnSettings().fnRecordsTotal());
                    },
                    select: true,
                    buttons: ['csv']
                        [{
                            text: 'Export Current Page',
                            "createEmptyCells": true,
                            // action : newexportaction,
                            customizeData: function(data) {
                                for (var i = 0; i < data.body.length; i++) {
                                    for (var j = 0; j < data.body[i].length; j++) {
                                        data.body[i][j] = '\u200C' + data.body[i][j];
                                    }
                                }
                            },
                            customize: function(doc) {
                                var sSh = doc.xl['styles.xml'];
                                var lastXfIndex = $('cellXfs xf', sSh).length - 1;
                                var s1 =
                                    '<xf numFmtId="0" fontId="0" fillId="0" borderId="1" applyFont="1" applyFill="1" applyBorder="1" xfId="0" applyNumberFormat="0"/>';
                                var s2 =
                                    '<xf numFmtId="0" fontId="2" fillId="5" borderId="1" applyFont="2" applyFill="1" applyBorder="1" xfId="0" applyAlignment="1">' +
                                    '<alignment horizontal="center"/></xf>';
                                var s3 =
                                    '<xf numFmtId="4" fontId="2" fillId="5" borderId="1" applyFont="1" applyFill="1" applyBorder="1" xfId="0" applyNumberFormat="1">' +
                                    '<alignment horizontal="center"/></xf>';
                                // var s3 = '<xf numFmtId="4" fontId="2" fillId="0" borderId="1" applyFont="1" applyFill="1" applyBorder="1" xfId="0" applyNumberFormat="1"/>';

                                sSh.childNodes[0].childNodes[5].innerHTML += s1 + s2 + s3;
                                var border = lastXfIndex + 1;
                                var colorBoldCentered = lastXfIndex + 2;
                                var boldBorder = lastXfIndex + 3;

                                var sheet = doc.xl.worksheets['sheet1.xml'];
                                // var x =  sheet.childNodes[0].childNodes[5].innerHTML;

                                $('row c', sheet).attr('s', border);
                                $('row:eq(0) c', sheet).attr('s', colorBoldCentered);
                                $('row:eq(1) c', sheet).attr('s', boldBorder);
                            }
                        }]
                });
            }

            $('.selectfilter').on('change', function() {
                var equipment = $('#equipment').val();
                createDatatable(equipment);
            });

            $('#rental').on('click', '.btn-delete[data-remote]', function(e) {
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
                            data: {
                                method: '_DELETE',
                                submit: true
                            }
                        }).always(function(data) {
                            $('#rental').DataTable().draw(false);
                        });
                    }
                })
            });

        });
    </script>
@endsection
