@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
    <div class="subheader">
        <h1 class="subheader-title">
        <i class='subheader-icon fal fa-list'></i>PENGURUSAN ADUAN INDIVIDU
        </h1>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        SENARAI <span class="fw-300"><i>ADUAN DIBUAT</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="table-responsive">
                            @if (Session::has('message'))
                                <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('message') }}</div>
                            @endif
                            <table id="aduan" class="table table-bordered table-hover table-striped w-100">
                                <thead>
                                    <tr class="text-center bg-primary-50" style="white-space: nowrap">
                                        <th>#TIKET</th>
                                        <th>LOKASI</th>
                                        <th>ADUAN</th>
                                        <th>STATUS</th>
                                        <th>JURUTEKNIK</th>
                                        <th>PENGESAHAN</th>
                                        <th>TARIKH</th>
                                        <th>MASA</th>
                                        <th>TINDAKAN</th>
                                    </tr>
                                    <tr>
                                        <td class="hasinput"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Lokasi"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Aduan"></td>
                                        <td class="hasinput">
                                            <select id="status_aduan" name="status_aduan" class="form-control">
                                                <option value="" selected> Semua</option>
                                                @foreach ($status as $stat)
                                                    <option value="{{ $stat->kod_status }}">{{ $stat->nama_status }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Juruteknik"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Pengesahan"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Tarikh"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Masa"></td>
                                        <td class="hasinput"></td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="crud-modal" aria-hidden="true" data-keyboard="false" data-backdrop="static">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="card-header bg-primary text-white">
                                <h5 class="card-title w-100"><i class="fal fa-info width-2 fs-xl"></i>SEBAB PEMBATALAN ADUAN</h5>
                            </div>
                            <div class="modal-body">
                                {!! Form::open(['action' => 'Aduan\AduanController@batalAduan', 'method' => 'POST']) !!}
                                <input type="hidden" name="aduan_id" id="aduan">

                                    <div class="form-group">
                                        <td colspan="5">
                                            <textarea rows="5" id="sebab_pembatalan" maxlength="300" name="sebab_pembatalan" class="form-control" placeholder="Sila isikan sebab pembatalan..." required>{{ old('maklumat_tambahan') }}</textarea>
                                            <p align="right" class="mt-2">Tidak melebihi 300 huruf</p>
                                            @error('sebab_pembatalan')
                                                <p style="color: red">{{ $message }}</p>
                                            @enderror
                                        </td>
                                    </div>

                                <div class="footer">
                                    <button type="submit" class="btn btn-danger ml-auto float-right"><i class="fal fa-save"></i> Hantar</button>
                                    <button type="button" class="btn btn-success ml-auto float-right mr-2" data-dismiss="modal"><i class="fal fa-window-close"></i> Tutup</button>
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
                                                <td style="width: 195px"><i style="color: red"><b>Petunjuk:</b></i>
                                                    <br><br>
                                                    <label class="low" style="margin-left: 14px !important"><label class="" style="margin-left: 30px;">DISAHKAN</label></label>
                                                    <label class="high" style="margin-left: 85px !important"><label class="" style="margin-left: 30px; width: 130px">BELUM DISAHKAN</label></label>
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

</main>
@endsection

@section('script')

<script>
    $(document).ready(function()
    {
        $('#status_aduan').select2();

        $('#crud-modal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')

            $('.modal-body #aduan').val(id);
        })

        $('#aduan thead tr .hasinput').each(function(i)
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

        var table = $('#aduan').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/data-aduan-individu",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { className: 'text-center', data: 'id', name: 'id' },
                    { data: 'lokasi_aduan', name: 'lokasi_aduan' },
                    { data: 'kategori_aduan', name: 'kategori_aduan' },
                    { className: 'text-center', data: 'status_aduan', name: 'status_aduan' },
                    { data: 'juruteknik_bertugas', name: 'juruteknik_bertugas' },
                    { className: 'text-center', data: 'pengesahan_pembaikan', name: 'pengesahan_pembaikan' },
                    { className: 'text-center', data: 'tarikh', name: 'tarikh_laporan' },
                    { className: 'text-center', data: 'masa', name: 'tarikh_laporan' },
                    { className: 'text-center', data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 6, "desc" ]],
                "initComplete": function(settings, json) {

                }
        });

    });

</script>

@endsection

