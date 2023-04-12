@extends('layouts.public')

@section('content')
<style>
    .preserveLines {
        white-space: pre-wrap;
    }

    .page-item.active .page-link {
        z-index: 3;
        color: #fff;
        background-color: #1A237E;
        border-color: #886ab5;
    }

</style>
<link rel="stylesheet" href="{{ asset('css/icomplaint.css') }}">
<link rel="stylesheet" href="{{ asset('css/indicator.css') }}">
<main id="js-page-content" role="main" id="main" class="page-content"  style="background-image: url({{asset('img/bg4.jpg')}}); background-size: cover">
    <div class="row" style="margin-bottom: 20px;">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="background-size: cover">
                    <div class="d-flex justify-content-center" style="color: black">
                        <div class="p-2">
                            <center><img src="{{ asset('img/intec_logo_new.png') }}" style="width: 320px;" class="responsive"/></center><br>
                            <h3 style="text-align: center" class="title">
                                Semak Aduan
                            </h3>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="panel-container show">
                        <div class="panel-content">
                            <div class="table-responsive">
                                @if (Session::has('message'))
                                    <div class="alert alert-success" style="color: #838383"> <i class="icon fal fa-check-circle"></i> {{ Session::get('message') }}</div>
                                @endif
                                <table id="aduan" class="table table-bordered table-hover table-striped w-100" style="white-space: nowrap">
                                    <thead>
                                        <tr class="text-center" style="white-space: nowrap; background-color: #1A237E; color:white">
                                            <th>#TIKET</th>
                                            <th>LOKASI</th>
                                            <th>ADUAN</th>
                                            <th>STATUS</th>
                                            <th>JURUTEKNIK</th>
                                            <th>PENGESAHAN</th>
                                            <th>TARIKH</th>
                                            <th>TINDAKAN</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div><br>
                            <a href="/eAduan?ic_no={{$id}}" class="btn btn-success ml-auto float-right" ><i class="fal fa-arrow-alt-left"></i> Kembali</a><br>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="crud-modal" aria-hidden="true" data-keyboard="false" data-backdrop="static">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="card-header text-white" style="background-color: #1A237E">
                                <h5 class="card-title w-100"><i class="fal fa-info width-2 fs-xl"></i>SEBAB PEMBATALAN ADUAN</h5>
                            </div>
                            <div class="modal-body">
                                {!! Form::open(['action' => 'Aduan\AduanUmumController@batalAduan', 'method' => 'POST']) !!}
                                <input type="hidden" name="aduan_id" id="aduan">

                                    <div class="form-group">
                                        <td colspan="5">
                                            <textarea rows="5" id="sebab_pembatalan" name="sebab_pembatalan" class="form-control" placeholder="Sila isikan sebab pembatalan..." required>{{ old('maklumat_tambahan') }}</textarea>
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

            </div>
        </div>
    </div>
    <p class="text-center text-black mt-4">Copyright © {{ \Carbon\Carbon::now()->format('Y') }} INTEC Education College. All Rights Reserved</p>
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

            var id = "<?php echo $id; ?>";

            var table = $('#aduan').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/data-aduan-umum/"+ id,
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                },
                columns: [
                        { className: 'text-center', data: 'id', name: 'id' },
                        { data: 'lokasi_aduan', name: 'lokasi_aduan' },
                        { data: 'kategori_aduan', name: 'kategori.kod_kategori' },
                        { className: 'text-center', data: 'status_aduan', name: 'status.kod_status' },
                        { data: 'juruteknik_bertugas', name: 'juruteknik.juruteknik_bertugas' },
                        { className: 'text-center', data: 'pengesahan_pembaikan', name: 'pengesahan_pembaikan' },
                        { className: 'text-center', data: 'tarikh', name: 'tarikh_laporan' },
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
