@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content">
    <div class="subheader">
        <h1 class="subheader-title">
        <i class='subheader-icon fal fa-bullhorn'></i>KATEGORI ADUAN
        </h1>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        SENARAI <span class="fw-300">KATEGORI ADUAN</span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        @if (Session::has('message'))
                            <div class="alert alert-success" style="color: #3b6324"> <i class="icon fal fa-check-circle"></i> {{ Session::get('message') }}</div>
                        @endif
                        <div class="table-responsive">
                            <table id="kategori" class="table table-bordered table-hover table-striped w-100">
                                <thead>
                                    <tr class="text-center bg-primary-50" style="white-space: nowrap">
                                        <th>ID</th>
                                        <th>KOD KATEGORI</th>
                                        <th>NAMA KATEGORI</th>
                                        <th>TINDAKAN</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex  pull-right">
                        <a href="javascript:;" data-toggle="modal" id="new" class="btn btn-info ml-auto float-right"><i class="fal fa-plus-square"></i> Tambah Kategori Aduan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="crud-modal" aria-hidden="true" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title w-100"><i class="fal fa-info width-2 fs-xl"></i> KATEGORI ADUAN BARU</h5>
                </div>
                <div class="modal-body">
                    {!! Form::open(['action' => 'Aduan\KategoriAduanController@tambahKategori', 'method' => 'POST']) !!}
                    <p><span class="text-danger">*</span> Maklumat wajib diisi</p>
                        <div class="form-group">
                            <td width="10%"><label class="form-label" for="kod_kategori"><span class="text-danger">*</span> Kod Kategori :</label></td>
                            <td colspan="4"><input value="{{ old('kod_kategori') }}" class="form-control" id="kod_kategori" name="kod_kategori" required>
                                @error('kod_kategori')
                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                @enderror
                            </td>
                        </div>

                        <div class="form-group">
                            <td width="10%"><label class="form-label" for="nama_kategori"><span class="text-danger">*</span> Nama Kategori :</label></td>
                            <td colspan="4"><input value="{{ old('nama_kategori') }}" class="form-control" id="nama_kategori" name="nama_kategori" required>
                                @error('nama_kategori')
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

    <div class="modal fade" id="crud-modals" aria-hidden="true" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title w-100"><i class="fal fa-info width-2 fs-xl"></i> EDIT KATEGORI ADUAN</h5>
                </div>
                <div class="modal-body">
                    {!! Form::open(['action' => 'Aduan\KategoriAduanController@kemaskiniKategori', 'method' => 'POST']) !!}
                    <input type="hidden" name="kategori_id" id="kategori">
                    <p><span class="text-danger">*</span> Maklumat wajib diisi</p>
                    <div class="form-group">
                        <td width="15%"><label class="form-label" for="kod_kategori"><span class="text-danger">*</span> Kod Kategori :</label></td>
                        <td colspan="5"><input class="form-control" id="kod" name="kod_kategori" disabled>
                            @error('kod_kategori')
                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                            @enderror
                        </td>
                    </div>

                    <div class="form-group">
                        <td width="15%"><label class="form-label" for="nama_kategori"><span class="text-danger">*</span> Nama Kategori :</label></td>
                        <td colspan="5"><input class="form-control" id="nama" name="nama_kategori" required>
                            @error('nama_kategori')
                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                            @enderror
                        </td>
                    </div>

                    <div class="footer">
                        <button type="submit" class="btn btn-success ml-auto float-right"><i class="fal fa-save"></i> Kemaskini</button>
                        <button type="button" class="btn btn-secondary ml-auto float-right mr-2" data-dismiss="modal"><i class="fal fa-window-close"></i> Tutup</button>
                    </div>

                    {!! Form::close() !!}
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
        $('#new').click(function () {
            $('#crud-modal').modal('show');
        });

        $('#crud-modals').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var kategori = button.data('kategori')
            var kod = button.data('kod')
            var nama = button.data('nama')

            $('.modal-body #kategori').val(kategori);
            $('.modal-body #nama').val(nama);
            $('.modal-body #kod').val(kod);
        });

        var table = $('#kategori').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/data-kategori-aduan",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { className: 'text-center', data: 'id', name: 'id' },
                    { className: 'text-center', data: 'kod_kategori', name: 'kod_kategori' },
                    { data: 'nama_kategori', name: 'nama_kategori' },
                    { className: 'text-center', data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 2, "asc" ]],
                "initComplete": function(settings, json) {

                }
        });

        $('#kategori').on('click', '.btn-delete[data-remote]', function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var url = $(this).data('remote');

            Swal.fire({
                title: 'Padam Kategori Aduan?',
                text: "Data tidak boleh dikembalikan semula!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya!',
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
                        $('#kategori').DataTable().draw(false);
                    });
                }
            })
        });

    });

</script>

@endsection
