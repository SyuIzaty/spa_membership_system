@extends('layouts.admin')
     
@section('content')
<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
    <div class="subheader">
        <h1 class="subheader-title">
        <i class='subheader-icon fal fa-list'></i>ADUAN
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
                                <center><div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc; width: 655px; font-size: 15px;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('message') }}</div></center>
                            @endif
                            <table id="aduan" class="table table-bordered table-hover table-striped w-100">
                                <thead>
                                    <tr class="text-center bg-primary-50" style="white-space: nowrap">
                                        <th style="width:20px">NO</th>
                                        <th style="width:30px">ID</th>
                                        <th style="text-align: center; width: 250px">LOKASI</th>
                                        <th style="width: 300px">ADUAN</th>
                                        <th style="width: 150px">TARIKH ADUAN</th>
                                        <th style="text-align: center">JURUTEKNIK</th>
                                        <th>STATUS</th>
                                        <th>PENGESAHAN</th>
                                        <th>TINDAKAN</th>
                                    </tr>
                                    <tr>
                                        <td class="hasinput"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="ID"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Lokasi"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Aduan"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Tarikh"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Juruteknik"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Status"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Pengesahan"></td>
                                        <td class="hasinput"></td>
                                    </tr>
                                </thead>
                            </table>
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
                url: "/data_aduan",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { className: 'text-center', data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { className: 'text-center', data: 'id', name: 'id' },
                    { data: 'lokasi_aduan', name: 'lokasi_aduan' },
                    { data: 'kategori_aduan', name: 'kategori_aduan' },
                    { className: 'text-center', data: 'tarikh_laporan', name: 'tarikh_laporan' },
                    { data: 'juruteknik_bertugas', name: 'juruteknik_bertugas' },
                    { className: 'text-center', data: 'status_aduan', name: 'status_aduan' },
                    { className: 'text-center', data: 'pengesahan_pembaikan', name: 'pengesahan_pembaikan' },
                    { className: 'text-center', data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 4, "desc" ]],
                "initComplete": function(settings, json) {

                } 
        });

    });

</script>

@endsection

