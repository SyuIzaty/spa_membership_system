@extends('layouts.admin')

@section('content')
<style>
    .dataTables_filter {
        display: none;
    }
</style>
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
                        SENARAI <span class="fw-300">ADUAN DIBUAT</span>
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
                            <div class="alert alert-danger alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                                </button>
                                <div class="d-flex align-items-center">
                                    <div class="alert-icon width-8">
                                        <span class="icon-stack icon-stack-md">
                                            <i class="base-2 icon-stack-3x color-danger-400"></i>
                                            <i class="base-10 text-white icon-stack-1x"></i>
                                            <i class="fal fa-info-circle color-danger-800 icon-stack-2x"></i>
                                        </span>
                                    </div>
                                    <div class="flex-1 pl-1">
                                        <ul class="mb-0 pb-0">
                                            <li>Pengadu wajib mengesahkan semua pembaikan yang dilakukan selepas status aduan bertukar kepada
                                                <b style="text-transform: uppercase">Aduan Selesai</b>, <b style="text-transform: uppercase">Selesai (Lantikan Kontraktor)</b>,
                                                <b style="text-transform: uppercase">Selesai (Lantikan UiTM)</b>, atau <b style="text-transform: uppercase">Aduan Bertindih</b>.
                                            </li>
                                            <li>Kegagalan untuk mengesahkan tindakan ini akan dianggap sebagai tidak sah dan akan diberi perhatian lanjut.</li>
                                            <li>Jika anda menghadapi sebarang masalah, sila berhubung dengan juruteknik yang ditugaskan kepada aduan anda atau hubungi pihak Fasiliti.</li>
                                          </ul>
                                    </div>
                                </div>
                            </div>
                            @if (Session::has('message'))
                                <div class="alert alert-success" style="color: #3b6324"> <i class="icon fal fa-check-circle"></i> {{ Session::get('message') }}</div>
                            @endif
                            <table id="aduan" class="table table-bordered table-hover table-striped w-100">
                                <thead>
                                    <tr class="text-center bg-primary-50" style="white-space: nowrap">
                                        <th>TIKET ID</th>
                                        <th>LOKASI</th>
                                        <th>KATEGORI ADUAN</th>
                                        <th>JENIS KEROSAKAN</th>
                                        <th>SEBAB KEROSAKAN</th>
                                        <th>TARIKH ADUAN</th>
                                        <th>STATUS TERKINI</th>
                                        <th>JURUTEKNIK</th>
                                        <th>PENGESAHAN PEMBAIKAN</th>
                                        <th>PDF</th>
                                        <th>TINDAKAN</th>
                                    </tr>
                                    <tr>
                                        <td class="hasinput"><input type="text" class="form-control"></td>
                                        <td class="hasinput"><input type="text" class="form-control"></td>
                                        <td class="hasinput"><input type="text" class="form-control"></td>
                                        <td class="hasinput"><input type="text" class="form-control"></td>
                                        <td class="hasinput"><input type="text" class="form-control"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="yyyy-mm-dd"></td>
                                        <td class="hasinput"><select id="status_aduan" name="status_aduan" class="form-control">
                                            <option value="">SEMUA</option>
                                            @foreach($status as $statuses)
                                                <option value="{{$statuses->nama_status}}">{{ strtoupper($statuses->nama_status)}}</option>
                                            @endforeach
                                        </select></td>
                                        <td class="hasinput"></td>
                                        <td class="hasinput"></td>
                                        <td class="hasinput"></td>
                                        <td class="hasinput"></td>
                                    </tr>
                                </thead>
                            </table>
                            <a href="/export-excel-pengadu/{{Auth::user()->id}}" id="buttonfull" class="btn btn-info float-right" style="margin-top: 15px">
                                <i class="fal fa-file-excel"></i> Excel Report
                            </a>
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
                                    <button type="submit" class="btn btn-success ml-auto float-right"><i class="fal fa-save"></i> Hantar</button>
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
                    { data: 'kategori_aduan', name: 'kategori.nama_kategori' },
                    { data: 'jenis_kerosakan', name: 'jenis.jenis_kerosakan' },
                    { data: 'sebab_kerosakan', name: 'sebab.sebab_kerosakan' },
                    { className: 'text-center', data: 'tarikh_laporan', name: 'tarikh_laporan' },
                    { className: 'text-center', data: 'status_aduan', name: 'status.nama_status' },
                    { data: 'juruteknik_bertugas', name: 'juruteknik_bertugas', orderable: false, searchable: false },
                    { className: 'text-center', data: 'pengesahan_pembaikan', name: 'pengesahan_pembaikan', orderable: false, searchable: false },
                    { className: 'text-center', data: 'pdf', name: 'pdf', orderable: false, searchable: false },
                    { className: 'text-center', data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 0, "desc" ]],
                "initComplete": function(settings, json) {

                }
        });

    });

    function Print(button)
    {
        var url = $(button).data('page');
        var printWindow = window.open( '{{url("/")}}'+url+'', 'Print', 'left=200, top=200, width=950, height=500, toolbar=0, resizable=0');
        printWindow.addEventListener('load', function(){
            printWindow.print();
        }, true);
    }

</script>

@endsection

