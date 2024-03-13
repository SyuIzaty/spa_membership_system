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
        <i class='subheader-icon fal fa-list'></i>PENGURUSAN ADUAN KEEP IN VIEW (KIV)
        </h1>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        SENARAI <span class="fw-300"> ADUAN KEEP IN VIEW (KIV)</span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        @if (Session::has('status'))
                            <div class="alert alert-success" style="color: #3b6324"> <i class="icon fal fa-check-circle"></i> {{ Session::get('status') }}</div>
                        @endif
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="nav nav-tabs nav-fill" role="tablist">
                                    @can('view complaint - admin')
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#staf" role="tab">STAF</a></li>
                                    @endcan
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
                                                                @foreach($status->whereIn('kod_status', ['AK']) as $statuses)
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
                                                                @foreach($status->whereIn('kod_status', ['AK']) as $statuses)
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

                    <div class="modal fade" id="crud-modals" aria-hidden="true" data-keyboard="false" data-backdrop="static">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="card-title w-100"><i class="fal fa-info width-2 fs-xl"></i> PENUKARAN STATUS</h5>
                                </div>
                                <div class="modal-body">
                                    {!! Form::open(['action' => 'Aduan\AduanController@tukarStatus', 'method' => 'POST']) !!}
                                    <input type="hidden" name="status_id" id="id">
                                    <b>PERHATIAN!</b> : Pastikan maklumat disahkan benar sebelum membuat sebarang penukaran status.
                                    <br><br>
                                    <p><span class="text-danger">*</span> Wajib diisi</p>
                                    <div class="form-group int">
                                        <td width="15%"><label class="form-label" for="kod_status"><span class="text-danger">*</span> Status :</label></td>
                                        <td colspan="7">
                                            <select class="form-control kod_status" name="kod_status" id="kod_status" required>
                                                <option value="" disabled selected> Sila Pilih </option>
                                                @foreach ($status->whereIn('kod_status', ['AS','LK','LU']) as $statuses)
                                                    <option value="{{ $statuses->kod_status }}" {{ old('kod_status') ==  $statuses->kod_status  ? 'selected' : '' }}>{{ $statuses->nama_status }}</option>
                                                @endforeach
                                            </select>
                                            @error('kod_status')
                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                            @enderror
                                        </td>
                                    </div>
                                    <div class="form-group int">
                                        <td width="15%"><label class="form-label" for="sebab_tukar_status"><span class="text-danger">*</span> Sebab :</label></td>
                                        <td colspan="7">
                                            <textarea rows="5" cols="30" class="form-control" maxlength="300" name="sebab_tukar_status" id="sebab_tukar_status" required></textarea>
                                            <p align="right" class="mt-2">Tidak melebihi 300 huruf</p>
                                            @error('sebab_tukar_status')
                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                            @enderror
                                        </td>
                                    </div>
                                    <div class="footer">
                                        <button type="submit" class="btn btn-success ml-auto float-right"><i class="fal fa-save"></i> Simpan</button>
                                        <button type="button" class="btn btn-secondary ml-auto float-right mr-2" data-dismiss="modal"><i class="fal fa-window-close"></i> Tutup</button>
                                    </div>
                                    {!! Form::close() !!}
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

        $('#kod_status').select2({
            dropdownParent: $('#crud-modals')
        });

        $('#crud-modals').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')

            $('.modal-body #id').val(id);
        });

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
                url: "/data-kiv",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { className: 'text-center', data: 'id', name: 'id' },
                    { data: 'nama_pelapor', name: 'nama_pelapor' },
                    { data: 'lokasi_aduan', name: 'lokasi_aduan' },
                    { data: 'kategori_aduan', name: 'kategori.nama_kategori' },
                    { className: 'text-center', data: 'status_aduan', name: 'status.nama_status' },
                    { className: 'text-center', data: 'tarikh_laporan', name: 'tarikh_laporan' },
                    { className: 'text-center', data: 'tarikh_selesai_aduan', name: 'tarikh_selesai_aduan' },
                    { className: 'text-center', data: 'tempoh', name: 'tempoh', orderable: false, searchable: false},
                    { className: 'text-center', data: 'tahap_kategori', name: 'tahap.jenis_tahap', orderable: false, searchable: false },
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
                url: "/data-kiv-pelajar",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { className: 'text-center', data: 'id', name: 'id' },
                    { data: 'nama_pelapor', name: 'nama_pelapor' },
                    { data: 'lokasi_aduan', name: 'lokasi_aduan' },
                    { data: 'kategori_aduan', name: 'kategori.nama_kategori' },
                    { className: 'text-center', data: 'status_aduan', name: 'status.nama_status' },
                    { className: 'text-center', data: 'tarikh_laporan', name: 'tarikh_laporan' },
                    { className: 'text-center', data: 'tarikh_selesai_aduan', name: 'tarikh_selesai_aduan' },
                    { className: 'text-center', data: 'tempoh', name: 'tempoh', orderable: false, searchable: false},
                    { className: 'text-center', data: 'tahap_kategori', name: 'tahap.jenis_tahap', orderable: false, searchable: false },
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
