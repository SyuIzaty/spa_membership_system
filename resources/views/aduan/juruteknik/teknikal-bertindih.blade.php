@extends('layouts.admin')

@section('content')
<style>
    .dataTables_filter {
        display: none;
    }
</style>
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
                        SENARAI <span class="fw-300"> ADUAN BERTINDIH</span>
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
                            <div class="col-md-12">
                                <ul class="nav nav-tabs nav-fill" role="tablist">
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#staf" role="tab">STAF</a></li>
                                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#pelajar" role="tab" aria-selected="true">PELAJAR</a></li>
                                </ul>
                            </div>
                            <div class="col">
                                <div class="tab-content p-3">
                                    <div class="tab-pane fade" id="staf" role="tabpanel">
                                        <div class="col-sm-12 mb-4">
                                            <div class="table-responsive">
                                                <table id="senarai" class="table table-bordered table-hover table-striped w-100" style="white-space: nowrap; width:100%">
                                                    <thead>
                                                        <tr class="text-center bg-primary-50">
                                                            <th>TIKET</th>
                                                            <th>PENGADU</th>
                                                            <th>LOKASI</th>
                                                            <th>KATEGORI ADUAN</th>
                                                            <th>STATUS TERKINI</th>
                                                            <th>TARIKH ADUAN</th>
                                                            <th>TARIKH SELESAI</th>
                                                            <th>TEMPOH</th>
                                                            <th>TAHAP</th>
                                                            <th>TINDAKAN</th>
                                                        </tr>
                                                        <tr>
                                                            <td class="hasinput"><input type="text" class="form-control"></td>
                                                            <td class="hasinput"><input type="text" class="form-control"></td>
                                                            <td class="hasinput"><input type="text" class="form-control"></td>
                                                            <td class="hasinput"><input type="text" class="form-control"></td>
                                                            <td class="hasinput"><select id="status_aduan" name="status_aduan" class="form-control">
                                                                <option value="">SEMUA</option>
                                                                @foreach($status as $statuses)
                                                                    <option value="{{$statuses->nama_status}}">{{strtoupper($statuses->nama_status)}}</option>
                                                                @endforeach
                                                            </select></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="yyyy-mm-dd"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="yyyy-mm-dd"></td>
                                                            <td class="hasinput"></td>
                                                            <td class="hasinput"></td>
                                                            <td class="hasinput"></td>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade active show" id="pelajar" role="tabpanel">
                                        <div class="col-sm-12 mb-4">
                                            <div class="table-responsive">
                                                <table id="senarai_pelajar" class="table table-bordered table-hover table-striped w-100" style="white-space: nowrap; width:100%">
                                                    <thead>
                                                        <tr class="text-center bg-primary-50">
                                                            <th>TIKET</th>
                                                            <th>PENGADU</th>
                                                            <th>LOKASI</th>
                                                            <th>KATEGORI ADUAN</th>
                                                            <th>STATUS TERKINI</th>
                                                            <th>TARIKH ADUAN</th>
                                                            <th>TARIKH SELESAI</th>
                                                            <th>TEMPOH</th>
                                                            <th>TAHAP</th>
                                                            <th>TINDAKAN</th>
                                                        </tr>
                                                        <tr>
                                                            <td class="hasinput"><input type="text" class="form-control"></td>
                                                            <td class="hasinput"><input type="text" class="form-control"></td>
                                                            <td class="hasinput"><input type="text" class="form-control"></td>
                                                            <td class="hasinput"><input type="text" class="form-control"></td>
                                                            <td class="hasinput"><select id="status_aduan_pelajar" name="status_aduan_pelajar" class="form-control">
                                                                <option value="">SEMUA</option>
                                                                @foreach($status as $statuses)
                                                                    <option value="{{$statuses->nama_status}}">{{strtoupper($statuses->nama_status)}}</option>
                                                                @endforeach
                                                            </select></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="yyyy-mm-dd"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="yyyy-mm-dd"></td>
                                                            <td class="hasinput"></td>
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
        $('#status_aduan').select2();

        $('#senarai thead tr .hasinput').each(function(i)
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


        var table = $('#senarai').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/teknikal-bertindih",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { className: 'text-center', data: 'id_aduan', name: 'id_aduan' },
                    { data: 'nama_pelapor', name: 'aduan.nama_pelapor' },
                    { data: 'lokasi_aduan', name: 'aduan.lokasi_aduan' },
                    { data: 'kategori_aduan', name: 'aduan.kategori.nama_kategori' },
                    { className: 'text-center', data: 'status_aduan', name: 'aduan.status.nama_status' },
                    { className: 'text-center', data: 'tarikh_laporan', name: 'aduan.tarikh_laporan' },
                    { className: 'text-center', data: 'tarikh_selesai_aduan', name: 'aduan.tarikh_selesai_aduan' },
                    { className: 'text-center', data: 'tempoh', name: 'tempoh', orderable: false, searchable: false},
                    { className: 'text-center', data: 'tahap_kategori', name: 'aduan.tahap.jenis_tahap', orderable: false, searchable: false },
                    { className: 'text-center', data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 0, "desc" ]],
                "initComplete": function(settings, json) {

                }
        });
    });

    $(document).ready(function()
    {
        $('#status_aduan_pelajar').select2();

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
                url: "/teknikal-bertindih-pelajar",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { className: 'text-center', data: 'id_aduan', name: 'id_aduan' },
                    { data: 'nama_pelapor', name: 'aduan.nama_pelapor' },
                    { data: 'lokasi_aduan', name: 'aduan.lokasi_aduan' },
                    { data: 'kategori_aduan', name: 'aduan.kategori.nama_kategori' },
                    { className: 'text-center', data: 'status_aduan', name: 'aduan.status.nama_status' },
                    { className: 'text-center', data: 'tarikh_laporan', name: 'aduan.tarikh_laporan' },
                    { className: 'text-center', data: 'tarikh_selesai_aduan', name: 'aduan.tarikh_selesai_aduan' },
                    { className: 'text-center', data: 'tempoh', name: 'tempoh', orderable: false, searchable: false},
                    { className: 'text-center', data: 'tahap_kategori', name: 'aduan.tahap.jenis_tahap', orderable: false, searchable: false },
                    { className: 'text-center', data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 0, "desc" ]],
                "initComplete": function(settings, json) {

                }
        });
    });

</script>

@endsection
