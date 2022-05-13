@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content">
    <div class="subheader">
        <h1 class="subheader-title">
        <i class='subheader-icon fal fa-list'></i>PENGURUSAN ADUAN KIV
        </h1>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        SENARAI <span class="fw-300"><i>ADUAN KIV</i></span>
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
                            <table id="kiv" class="table table-bordered table-hover table-striped w-100" style="white-space: nowrap">
                                <thead>
                                    <tr class="text-center bg-primary-50">
                                        <th>#TIKET</th>
                                        <th>PELAPOR</th>
                                        <th>LOKASI</th>
                                        <th>ADUAN</th>
                                        <th>TARIKH</th>
                                        <th>MASA</th>
                                        <th>STATUS</th>
                                        <th>TAHAP</th>
                                        <th>TINDAKAN</th> 
                                    </tr>
                                    <tr>
                                        <td class="hasinput"></td> 
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Nama"></td>
                                         <td class="hasinput"><input type="text" class="form-control" placeholder="Lokasi"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Kategori"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Tarikh"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Masa"></td>
                                        <td class="hasinput"><select id="status_aduan" name="status_aduan" class="form-control">
                                            <option value="">Semua</option>
                                            <option value="KIV (Keep In View)">KIV (Keep In View)</option>
                                        </select></td>
                                        <td class="hasinput"><select id="tahap_kategori" name="tahap_kategori" class="form-control">
                                            <option value="">Semua</option>
                                            <option value="BIASA">Biasa</option>
                                            <option value="SEGERA">Segera</option>
                                            <option value="BELUM DITENTUKAN">Belum Ditentukan</option>
                                        </select></td>
                                        <td class="hasinput"></td> 
                                    </tr>
                                </thead>
                            </table>
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
        $('#status_aduan, #tahap_kategori').select2();
        
        $('#kiv thead tr .hasinput').each(function(i)
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


        var table = $('#kiv').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/senaraiKiv",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { className: 'text-center', data: 'id', name: 'id' },
                    { className: 'text-center', data: 'nama_pelapor', name: 'nama_pelapor' },
                    { data: 'lokasi_aduan', name: 'lokasi_aduan' },
                    { data: 'kategori_aduan', name: 'kategori_aduan' },
                    { className: 'text-center', data: 'tarikh', name: 'tarikh_laporan' },
                    { className: 'text-center', data: 'masa', name: 'tarikh_laporan' },
                    { className: 'text-center', data: 'status_aduan', name: 'status_aduan' },
                    { className: 'text-center', data: 'tahap_kategori', name: 'tahap_kategori' },
                    { className: 'text-center', data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 4, "desc" ]],
                "initComplete": function(settings, json) {

                } 
        });

        $('#kiv').on('click', '.btn-delete[data-remote]', function (e) {
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
                        $('#kiv').DataTable().draw(false);
                    });
                }
            })
        });

    });

</script>

@endsection
