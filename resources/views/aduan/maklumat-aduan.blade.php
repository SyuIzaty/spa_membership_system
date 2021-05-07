@extends('layouts.admin')

@section('content')

<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">

    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr bg-primary">
                    <h2>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>

                <div class="panel-container show">
                    <div class="panel-content">
                        <center><img src="{{ asset('img/intec_logo.png') }}" style="height: 120px; width: 270px;"></center><br>
                        <h4 style="text-align: center">
                            <b>BORANG E-ADUAN INTEC EDUCATION COLLEGE</b>
                        </h4>
                        
                        <div class="panel-container show">
                            <div class="panel-content">
                                @if (Session::has('simpanPengesahan'))
                                    <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('simpanPengesahan') }}</div>
                                @endif
                                <div class="table-responsive">
                                <table id="info" class="table table-bordered table-hover table-striped w-100">
                                    <thead>
                                        <tr>
                                            <td colspan="5" class="bg-primary-50"><label class="form-label"><i class="fal fa-user"></i> INFO PENGADU</label></td>
                                        </tr>
                                        <tr>
                                            <th width="20%" style="vertical-align: middle">Nama Penuh : </th>
                                            <td colspan="2" style="vertical-align: middle">{{ strtoupper($aduan->nama_pelapor)}}</td>
                                            <th width="20%" style="vertical-align: middle">ID Staf : </th>
                                            <td colspan="2" style="vertical-align: middle">{{ strtoupper($aduan->id_pelapor)}}</td>
                                        </tr>
                                        <tr>
                                            <th width="20%" style="vertical-align: middle">Emel : </th>
                                            <td colspan="2" style="vertical-align: middle">{{ $aduan->emel_pelapor}}</td>
                                            <th width="20%" style="vertical-align: middle">No. Telefon : </th>
                                            <td colspan="2" style="vertical-align: middle">{{ $aduan->no_tel_pelapor}}</td>
                                        </tr>
                                    </thead>
                                </table>
                                </div>

                                <div class="table-responsive">
                                <table id="aduan" class="table table-bordered table-hover table-striped w-100">
                                    <thead>
                                        <tr>
                                            <td colspan="5" class="bg-primary-50"><label class="form-label"><i class="fal fa-info"></i> BUTIRAN ADUAN</label></td>
                                        </tr>
                                        <tr>
                                            <th width="20%" style="vertical-align: middle">Pejabat/Bahagian/ Fakulti/Kolej : </th>
                                            <td colspan="2" style="vertical-align: middle">{{ strtoupper($aduan->lokasi_aduan) }}</td>
                                            <th width="20%" style="vertical-align: middle">Blok : </th>
                                            <td colspan="2" style="vertical-align: middle">{{ strtoupper($aduan->blok_aduan) }}</td>
                                        </tr>
                                        <tr>
                                            <th width="20%" style="vertical-align: middle">Tingkat/Aras : </th>
                                            <td colspan="2" style="vertical-align: middle">{{ strtoupper($aduan->aras_aduan) }}</td>
                                            <th width="20%" style="vertical-align: middle">Nama Bilik/No. Bilik : </th>
                                            <td colspan="2" style="vertical-align: middle">{{ strtoupper($aduan->nama_bilik) }}</td>
                                        </tr>

                                        <tr>
                                            <th width="20%" style="vertical-align: middle">Kategori Aduan : </th>
                                            <td colspan="2" style="vertical-align: middle">{{ strtoupper($aduan->kategori->nama_kategori) }}</td>
                                            <th width="20%" style="vertical-align: middle">Jenis Kerosakan : </th>
                                            <td colspan="2" style="vertical-align: middle">
                                                <div>{{ strtoupper($aduan->jenis->jenis_kerosakan) }}</div word-break: break-all>
                                                @if($aduan->jenis->jenis_kerosakan == 'Lain-lain') 
                                                    <div> Penerangan : {{ strtoupper($aduan->jk_penerangan ?? '--') }}</div>
                                                @endif 
                                            </td>
                                        </tr>

                                        <tr>
                                            <th width="20%" style="vertical-align: top">Sebab Kerosakan : </th>
                                            <td colspan="2" style="vertical-align: middle">
                                                <div>{{ strtoupper($aduan->sebab->sebab_kerosakan) }}</div word-break: break-all>
                                                @if($aduan->sebab->sebab_kerosakan == 'Lain-lain')
                                                    <div> Penerangan : {{ strtoupper($aduan->sk_penerangan ?? '--') }}</div>
                                                @endif
                                            </td>
                                            <th width="20%" style="vertical-align: middle">Kuantiti/Unit : </th>
                                            <td colspan="2" style="vertical-align: middle">{{ $aduan->kuantiti_unit}}</td>
                                        </tr>
                                       
                                        <tr>
                                            <th width="20%" style="vertical-align: top">Maklumat Tambahan : </th>
                                            <td colspan="4" style="vertical-align: middle">{{ isset($aduan->maklumat_tambahan) ? $aduan->maklumat_tambahan : '-'}}</td>
                                        </tr>
                                    </thead>
                                </table>
                                </div>

                                <div class="table-responsive">
                                <table id="muatnaik" class="table table-bordered table-hover table-striped w-100">
                                    <thead>
                                        <tr>
                                            <td colspan="5" class="bg-primary-50"><label class="form-label"><i class="fal fa-upload"></i> BUKTI DIMUATNAIK</label></td>
                                        </tr>
                                        <tr>
                                            <th width="20%" style="vertical-align: middle"> Gambar : </th>
                                            <td colspan="2">
                                                @if(isset($imej->first()->upload_image))
                                                    @foreach($imej as $imejAduan)
                                                        <img src="/get-file-resit/{{ $imejAduan->upload_image }}" style="width:150px; height:130px;" class="img-fluid mr-2">
                                                    @endforeach
                                                @else
                                                    <span>Tiada Gambar Sokongan</span>
                                                @endif
                                            </td>

                                            <th width="20%" style="vertical-align: middle">Resit : </th>
                                            <td colspan="2" style="vertical-align: middle">
                                                @if(isset($resit->first()->nama_fail))
                                                    @foreach ($resit as $failResit)
                                                        <a target="_blank" href="{{ url('resit')."/".$failResit->nama_fail }}/Download"">{{ $failResit->nama_fail }}</a>
                                                    @endforeach
                                                @else
                                                    <span>Tiada Dokumen Sokongan</span>
                                                @endif
                                            </td>
                                        </tr>
                                        
                                    </thead>
                                </table>
                                </div>

                                <div class="table-responsive">
                                <table id="verifikasi" class="table table-bordered table-hover table-striped w-100">
                                    <thead>
                                        <tr>
                                            <td colspan="5" class="bg-primary-50">
                                                <label class="form-label">
                                                    <i class="fal fa-check-circle"></i> STATUS TERKINI ADUAN : 
                                                        @if($aduan->status_aduan=='BS')
                                                        {
                                                           <span class="badge badge-new">{{ strtoupper($aduan->status->nama_status) }}</span>
                                                        }
                                                        @elseif($aduan->status_aduan=='DJ')
                                                        {
                                                            <span class="badge badge-sent">{{ strtoupper($aduan->status->nama_status) }}</span>
                                                        }
                                                        @elseif($aduan->status_aduan=='TD')
                                                        {
                                                            <span class="badge badge-done">{{ strtoupper($aduan->status->nama_status) }}</span>
                                                        }
                                                        @elseif($aduan->status_aduan=='AS')
                                                        {
                                                            <span class="badge badge-success">{{ strtoupper($aduan->status->nama_status) }}</span>
                                                        }
                                                        @elseif($aduan->status_aduan=='LK') 
                                                        {
                                                            <span class="badge badge-success2">{{ strtoupper($aduan->status->nama_status) }}</span>
                                                        }
                                                        @elseif($aduan->status_aduan=='LU') 
                                                        {
                                                            <span class="badge badge-success2">{{ strtoupper($aduan->status->nama_status) }}</span>
                                                        }
                                                        @elseif($aduan->status_aduan=='AK')
                                                        {
                                                            <span class="badge badge-kiv">{{ strtoupper($aduan->status->nama_status) }}</span>
                                                        }
                                                        @else 
                                                        {
                                                            <span class="badge badge-duplicate">{{ strtoupper($aduan->status->nama_status) }}</span>
                                                        }
                                                        @endif
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th width="20%" style="vertical-align: middle">Tarikh Aduan Dibuat : </th>
                                            <td colspan="2" style="vertical-align: middle">{{ date(' j F Y | h:i:s A ', strtotime($aduan->tarikh_laporan)) }}</td>
                                            <th width="20%" style="vertical-align: middle">Tarikh Aduan Selesai : </th>
                                            <td colspan="2" style="vertical-align: middle">
                                                @if(isset($aduan->tarikh_selesai_aduan))
                                                    {{ date(' j F Y | h:i:s A ', strtotime($aduan->tarikh_selesai_aduan)) }}
                                                @else
                                                    --
                                                @endif
                                            </td>
                                        </tr>
                                        {!! Form::open(['action' => 'AduanController@simpanPengesahan', 'method' => 'POST']) !!}
                                        <input type="hidden" name="id" value="{{ $aduan->id }}">
                                            @if($aduan->status_aduan == 'AS' || $aduan->status_aduan == 'LK'|| $aduan->status_aduan == 'DP')
                                                @if(isset($aduan->pengesahan_pembaikan))
                                                    <tr>
                                                        <div class="form-group">
                                                            <td colspan="5"><p class="form-label">
                                                            <input style="margin-top: 15px; margin-right: 30px; margin-left: 15px" type="checkbox" checked disabled>
                                                            SAYA, <b><u>{{ strtoupper($aduan->nama_pelapor) }}</u></b> MENGESAHKAN BAHAWA ADUAN YANG DIBUAT TELAH DILAKUKAN PEMBAIKAN. </p> 
                                                        </div>
                                                    </tr>
                                                @else
                                                    <tr>
                                                        <div class="form-group">
                                                            <td colspan="5"><p class="form-label" for="pengesahan_pembaikan">
                                                            <input style="margin-top: 15px; margin-right: 30px; margin-left: 15px; margin-bottom: 15px;" type="checkbox" name="pengesahan_pembaikan" id="chk" onclick="btn()"/>
                                                            SAYA, <b><u>{{ strtoupper($aduan->nama_pelapor) }}</u></b> MENGESAHKAN BAHAWA ADUAN YANG DIBUAT TELAH DILAKUKAN PEMBAIKAN. </p> 
                                                            <button style="margin-top: 5px;" class="btn btn-danger float-right" id="submit" name="submit" disabled><i class="fal fa-check"></i> Hantar Pengesahan</button></td>
                                                        </div>
                                                    </tr>
                                                @endif
                                            @endif
                                        {!! Form::close() !!}
                                            
                                    </thead>
                                </table>
                                </div>
                                <a href="/aduan" class="btn btn-success ml-auto float-right" ><i class="fal fa-angle-double-left"></i> Kembali</a><br>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</main>

@endsection

@section('script')
<script>

    function btn()
    {
        var chk = document.getElementById("chk")
        var submit = document.getElementById("submit");
        submit.disabled = chk.checked ? false : true;
        if(!submit.disabled){
            submit.focus();
        }
    }

</script>
@endsection

