@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content">
    <div class="subheader">
        <h1 class="subheader-title">
        <i class='subheader-icon fal fa-list'></i>PENGURUSAN ADUAN BERTINDIH
        </h1>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        SENARAI <span class="fw-300"><i>ADUAN BERTINDIH</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="row">
                            <div class="col-auto mt-4">
                                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                    <a class="nav-link mb-2 active" id="staf-tab" data-toggle="pill" href="#staf" role="tab" aria-controls="staf" aria-selected="false" style="border: 1px solid;">
                                        <i class="fal fa-info-circle"></i>
                                        <span class="hidden-sm-down ml-1"> STAF </span>
                                    </a>
                                    <a class="nav-link mb-2" id="pelajar-tab" data-toggle="pill" href="#pelajar" role="tab" aria-controls="pelajar" aria-selected="false" style="border: 1px solid;">
                                        <i class="fal fa-road"></i>
                                        <span class="hidden-sm-down ml-1"> PELAJAR </span>
                                    </a>
                                    <a class="nav-link mb-2" id="luar-tab" data-toggle="pill" href="#luar" role="tab" aria-controls="luar" aria-selected="false" style="border: 1px solid;">
                                        <i class="fal fa-database"></i>
                                        <span class="hidden-sm-down ml-1"> PENGGUNA LUAR </span>
                                    </a>
                                </div>
                            </div>

                            <div class="col">
                                <div class="tab-content" id="v-pills-tabContent">
                                    <div class="tab-pane mt-1 active" id="staf" role="tabpanel"><br>
                                        <div class="col-sm-12 mb-4">
                                            <div class="table-responsive">
                                                <table id="tindih" class="table table-bordered table-hover table-striped w-100" style="white-space: nowrap">
                                                    <thead>
                                                        <tr class="text-center bg-primary-50">
                                                            <th>#TIKET</th>
                                                            <th>PELAPOR</th>
                                                            <th>KATEGORI ADUAN</th>
                                                            <th>TARIKH</th>
                                                            <th>STATUS</th>
                                                            <th>TAHAP</th>
                                                            <th>TINDAKAN</th>
                                                        </tr>
                                                        <tr>
                                                            <td class="hasinput"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Nama"></td>
                                                            <td class="hasinput"><select id="kategori_aduan" name="kategori_aduan" class="form-control">
                                                                <option value="">SEMUA</option>
                                                                @foreach($kategori as $kat)
                                                                    <option value="{{$kat->nama_kategori}}">{{$kat->nama_kategori}}</option>
                                                                @endforeach
                                                            </select></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Tarikh"></td>
                                                            <td class="hasinput"><select id="status_aduan" name="status_aduan" class="form-control">
                                                                <option value="">SEMUA</option>
                                                                @foreach($status as $stt)
                                                                    <option value="{{$stt->nama_status}}">{{$stt->nama_status}}</option>
                                                                @endforeach
                                                            </select></td>
                                                            <td class="hasinput"></td>
                                                            <td class="hasinput"></td>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane mt-1" id="pelajar" role="tabpanel"><br>
                                        <div class="col-sm-12 mb-4">
                                            <div class="table-responsive">
                                                <table id="senarai_pelajar" class="table table-bordered table-hover table-striped w-100" style="white-space: nowrap">
                                                    <thead>
                                                        <tr class="text-center bg-primary-50">
                                                            <th>#TIKET</th>
                                                            <th>PELAPOR</th>
                                                            <th>KATEGORI ADUAN</th>
                                                            <th>TARIKH</th>
                                                            <th>STATUS</th>
                                                            <th>TAHAP</th>
                                                            <th>TINDAKAN</th>
                                                        </tr>
                                                        <tr>
                                                            <td class="hasinput"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Nama"></td>
                                                            <td class="hasinput"><select id="kategori_aduan_pelajar" name="kategori_aduan_pelajar" class="form-control">
                                                                <option value="">SEMUA</option>
                                                                @foreach($kategori as $kat)
                                                                    <option value="{{$kat->nama_kategori}}">{{$kat->nama_kategori}}</option>
                                                                @endforeach
                                                            </select></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Tarikh"></td>
                                                            <td class="hasinput"><select id="status_aduan_pelajar" name="status_aduan_pelajar" class="form-control">
                                                                <option value="">SEMUA</option>
                                                                @foreach($status as $stt)
                                                                    <option value="{{$stt->nama_status}}">{{$stt->nama_status}}</option>
                                                                @endforeach
                                                            </select></td>
                                                            <td class="hasinput"></td>
                                                            <td class="hasinput"></td>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane mt-1" id="luar" role="tabpanel"><br>
                                        <div class="col-sm-12 mb-4">
                                            <div class="table-responsive">
                                                <table id="senarai_luar" class="table table-bordered table-hover table-striped w-100" style="white-space: nowrap">
                                                    <thead>
                                                        <tr class="text-center bg-primary-50">
                                                            <th>#TIKET</th>
                                                            <th>PELAPOR</th>
                                                            <th>KATEGORI ADUAN</th>
                                                            <th>TARIKH</th>
                                                            <th>STATUS</th>
                                                            <th>TAHAP</th>
                                                            <th>TINDAKAN</th>
                                                        </tr>
                                                        <tr>
                                                            <td class="hasinput"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Nama"></td>
                                                            <td class="hasinput"><select id="kategori_aduan_luar" name="kategori_aduan_luar" class="form-control">
                                                                <option value="">SEMUA</option>
                                                                @foreach($kategori as $kat)
                                                                    <option value="{{$kat->nama_kategori}}">{{$kat->nama_kategori}}</option>
                                                                @endforeach
                                                            </select></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Tarikh"></td>
                                                            <td class="hasinput"><select id="status_aduan_luar" name="status_aduan_luar" class="form-control">
                                                                <option value="">SEMUA</option>
                                                                @foreach($status as $stt)
                                                                    <option value="{{$stt->nama_status}}">{{$stt->nama_status}}</option>
                                                                @endforeach
                                                            </select></td>
                                                            <td class="hasinput"></td>
                                                            <td class="hasinput"></td>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>

                    {{-- Start Petunjuk --}}
                    <div class="panel-content py-2 mt-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex pull-left">
                        <div class="row" style="margin-top: -0.75rem;">
                            <div class="col-lg-4.5 col-sm-12">
                                <div class="card-body">
                                    <table id="info" class="table table-bordered table-hover table-striped" style="width: 160%!important">
                                        <thead>
                                            <tr>
                                                <div class="form-group">
                                                    <td><i style="color: red"><b>Petunjuk:</b></i>
                                                        <br><br>
                                                        <label class="medium"><label class="" style="margin-left: 30px;">SEGERA</label></label>
                                                        <label class="low" style="margin-left: 70px !important;"><label class="" style="margin-left: 30px;">BIASA</label></label>
                                                        <label class="none" style="margin-left: 60px !important;"><label class="" style="margin-left: 30px; width: 155px;">BELUM DITENTUKAN</label></label>
                                                    </td>
                                                </div>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- End Petunjuk --}}

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
        $('#status_aduan, #tahap_kategori, #kategori_aduan').select2();

        $('#tindih thead tr .hasinput').each(function(i)
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


        var table = $('#tindih').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/data-bertindih",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { className: 'text-center', data: 'id', name: 'id' },
                    { data: 'nama_pelapor', name: 'nama_pelapor' },
                    { data: 'kategori_aduan', name: 'kategori.nama_kategori' },
                    { className: 'text-center', data: 'tarikh_laporan', name: 'tarikh_laporan' },
                    { className: 'text-center', data: 'status_aduan', name: 'status.nama_status' },
                    { className: 'text-center', data: 'tahap_kategori', name: 'tahap.jenis_tahap', orderable: false, searchable: false },
                    { className: 'text-center', data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 4, "desc" ]],
                "initComplete": function(settings, json) {

                }
        });

        $('#tindih').on('click', '.btn-delete[data-remote]', function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var url = $(this).data('remote');

            Swal.fire({
                title: 'Padam Aduan?',
                text: "Data tidak boleh dikembalikan semula!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, padam aduan!',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.value) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                    url: url,
                    type: 'DELETE',
                    dataType: 'json',
                    data: {method: '_DELETE', submit: true}
                    }).always(function (data) {
                        $('#tindih').DataTable().draw(false);
                    });
                }
            })
        });

    });

    $(document).ready(function()
    {
        $('#status_aduan_pelajar, #tahap_kategori_pelajar, #kategori_aduan_pelajar').select2();

        $('#senarai_pelajar thead tr .hasinput').each(function(i)
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


        var table = $('#senarai_pelajar').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/data-bertindih-pelajar",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { className: 'text-center', data: 'id', name: 'id' },
                    { data: 'nama_pelapor', name: 'nama_pelapor' },
                    { data: 'kategori_aduan', name: 'kategori.nama_kategori' },
                    { className: 'text-center', data: 'tarikh_laporan', name: 'tarikh_laporan' },
                    { className: 'text-center', data: 'status_aduan', name: 'status.nama_status' },
                    { className: 'text-center', data: 'tahap_kategori', name: 'tahap.jenis_tahap', orderable: false, searchable: false },
                    { className: 'text-center', data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 3, "desc" ]],
                "initComplete": function(settings, json) {

                }
        });

        $('#senarai_pelajar').on('click', '.btn-delete[data-remote]', function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var url = $(this).data('remote');

            Swal.fire({
                title: 'Padam Aduan?',
                text: "Data tidak boleh dikembalikan semula!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, padam aduan!',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.value) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                    url: url,
                    type: 'DELETE',
                    dataType: 'json',
                    data: {method: '_DELETE', submit: true}
                    }).always(function (data) {
                        $('#senarai_pelajar').DataTable().draw(false);
                    });
                }
            })
        });

    });

    $(document).ready(function()
    {
        $('#status_aduan_luar, #tahap_kategori_luar, #kategori_aduan_luar').select2();

        $('#senarai_luar thead tr .hasinput').each(function(i)
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


        var table = $('#senarai_luar').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/aduan-bertindih-luar",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { className: 'text-center', data: 'id', name: 'id' },
                    { data: 'nama_pelapor', name: 'nama_pelapor' },
                    { data: 'kategori_aduan', name: 'kategori.nama_kategori' },
                    { className: 'text-center', data: 'tarikh_laporan', name: 'tarikh_laporan' },
                    { className: 'text-center', data: 'status_aduan', name: 'status.nama_status' },
                    { className: 'text-center', data: 'tahap_kategori', name: 'tahap.jenis_tahap', orderable: false, searchable: false },
                    { className: 'text-center', data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 3, "desc" ]],
                "initComplete": function(settings, json) {

                }
        });

        $('#senarai_luar').on('click', '.btn-delete[data-remote]', function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var url = $(this).data('remote');

            Swal.fire({
                title: 'Padam Aduan?',
                text: "Data tidak boleh dikembalikan semula!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, padam aduan!',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.value) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                    url: url,
                    type: 'DELETE',
                    dataType: 'json',
                    data: {method: '_DELETE', submit: true}
                    }).always(function (data) {
                        $('#senarai_luar').DataTable().draw(false);
                    });
                }
            })
        });

    });

</script>

@endsection
