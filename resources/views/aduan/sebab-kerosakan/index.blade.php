@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content">
    <div class="subheader">
        <h1 class="subheader-title">
        <i class='subheader-icon fal fa-filter'></i>SEBAB KEROSAKAN
        </h1>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        SENARAI <span class="fw-300">SEBAB KEROSAKAN</span>
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
                            <table id="sebab" class="table table-bordered table-hover table-striped w-100">
                                <thead>
                                    <tr class="text-center bg-primary-50" style="white-space: nowrap">
                                        <th>ID</th>
                                        <th>KATEGORI ADUAN</th>
                                        <th>SEBAB KEROSAKAN</th>
                                        <th>TINDAKAN</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex  pull-right">
                        <a href="javascript:;" data-toggle="modal" id="new" class="btn btn-info ml-auto float-right"><i class="fal fa-plus-square"></i> Tambah Sebab Kerosakan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="crud-modal" aria-hidden="true" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title w-100"><i class="fal fa-info width-2 fs-xl"></i> SEBAB KEROSAKAN BARU</h5>
                </div>
                <div class="modal-body">
                    {!! Form::open(['action' => 'Aduan\SebabKerosakanController@tambahSebab', 'method' => 'POST']) !!}
                    <p><span class="text-danger">*</span> Maklumat wajib diisi</p>
                        <div class="form-group">
                            <td width="10%"><label class="form-label" for="jenis_kerosakan"><span class="text-danger">*</span> Kategori Aduan :</label></td>
                            <td colspan="4">
                                <select name="kategori_aduan" id="kategori_aduan" class="kategori_aduan form-control" required>
                                    <option value="" selected disabled>Sila Pilih</option>
                                    @foreach ($kategori as $kat)
                                        <option value="{{ $kat->kod_kategori }}" {{ old('kategori_aduan') ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
                                    @endforeach
                                 </select>
                                @error('kategori_aduan')
                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                @enderror
                            </td>
                        </div>
                        <div class="form-group">
                            <td width="10%"><label class="form-label" for="sebab_kerosakan"><span class="text-danger">*</span> Sebab Kerosakan :</label></td>
                            <td colspan="4"><input value="{{ old('sebab_kerosakan') }}" class="sebab_kerosakan form-control" id="sebab_kerosakan" name="sebab_kerosakan" required>
                                @error('sebab_kerosakan')
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
                    <h5 class="card-title w-100"><i class="fal fa-info width-2 fs-xl"></i> EDIT SEBAB KEROSAKAN</h5>
                </div>
                <div class="modal-body">
                    {!! Form::open(['action' => 'Aduan\SebabKerosakanController@kemaskiniSebab', 'method' => 'POST']) !!}
                    <input type="hidden" name="sebab_id" id="sebab">
                    <p><span class="text-danger">*</span> Maklumat wajib diisi</p>

                    <div class="form-group">
                        <td width="10%"><label class="form-label" for="kategori_aduan">Kategori Aduan :</label></td>
                        <td colspan="4">
                            <select name="kategori_aduan" id="kategori_aduan" class="kategori form-control" disabled>
                                <option value="" selected disabled>Sila Pilih</option>
                                @foreach ($kategori as $kat)
                                    <option value="{{ $kat->kod_kategori }}">{{ $kat->nama_kategori }}</option>
                                @endforeach
                             </select>
                            @error('kategori_aduan')
                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                            @enderror
                        </td>
                    </div>
                    <div class="form-group">
                        <td width="10%"><label class="form-label" for="sebab_kerosakan"><span class="text-danger">*</span> Sebab Kerosakan :</label></td>
                        <td colspan="4"><input class="sebab form-control" id="sebab_kerosakan" name="sebab_kerosakan" required>
                            @error('sebab_kerosakan')
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

            $('#kategori_aduan').select2({
                dropdownParent: $('#crud-modal')
            });
        });

        $('#crud-modals').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var sebab = button.data('sebab')
            var kategori = button.data('kategori')
            var kerosakan = button.data('kerosakan')

            $('.modal-body #sebab').val(sebab);
            $('.modal-body .kategori').val(kategori);
            $('.modal-body .sebab').val(kerosakan);

            $('.kategori').select2({
                dropdownParent: $('#crud-modals')
            });
        })

        var table = $('#sebab').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/sebabKerosakan",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { className: 'text-center', data: 'id', name: 'id' },
                    { className: 'text-center', data: 'kategori_aduan', name: 'kategori.nama_kategori' },
                    { data: 'sebab_kerosakan', name: 'sebab_kerosakan' },
                    { className: 'text-center', data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 2, "asc" ]],
                "initComplete": function(settings, json) {

                }
        });

        $('#sebab').on('click', '.btn-delete[data-remote]', function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var url = $(this).data('remote');

            Swal.fire({
                title: 'Padam Sebab Kerosakan?',
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
                        $('#sebab').DataTable().draw(false);
                    });
                }
            })
        });

    });

</script>

@endsection
