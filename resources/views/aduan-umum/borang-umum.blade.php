@extends('layouts.public')

@section('content')
<style>
    .preserveLines {
        white-space: pre-wrap;
    }

    .breadcrumb-arrow li a:after {
        left: 100%;
        border-color: transparent;
        border-left-color: #1A237E;
    }

    .breadcrumb-arrow li a {
        color: #fff;
        display: inline-block;
        background: #1A237E;
        text-decoration: none;
        position: relative;
        height: 2.5em;
        line-height: 2.5em;
        padding: 0 10px 0 5px;
        text-align: center;
        margin-right: 22px;
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
                                Borang E-Aduan
                            </h3>
                            <br>
                            <div>
                                <p style="padding-left: 30px; padding-right: 30px; font-size: 12px">
                                    <b>PERHATIAN!</b> : Sebarang aduan kerosakkan akan diambil tindakan di dalam tempoh <b>lima (5)</b> hari bekerja. Sekiranya tiada tindakan dibuat sila rujuk kepada <b>Pegawai Fasiliti/IITU</b> untuk laporan/semakan. Sebarang aduan adalah diwajibkan secara online. Laporan secara manual atau pun emel adalah tidak akan diproses.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="panel-container show">
                        <div class="panel-content">
                            {!! Form::open(['action' => 'Aduan\AduanUmumController@simpanAduan', 'method' => 'POST', 'id' => 'data', 'enctype' => 'multipart/form-data']) !!}
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="table-responsive">
                                    <p><span class="text-danger">*</span> Maklumat wajib diisi</p>
                                    <table id="info" class="table table-bordered table-hover table-striped w-100">
                                        <thead>
                                            <tr>
                                                <td colspan="5" style="border-left-style: hidden; border-right-style: hidden; border-top-style: hidden; padding: 0px">
                                                    <ol class="breadcrumb breadcrumb-md breadcrumb-arrow">
                                                        <li>
                                                            <a href="#" disabled style="pointer-events: none">
                                                                <i class="fal fa-user"></i>
                                                                <span class=""><b> INFO PENGADU</b></span>
                                                            </a>
                                                        </li>
                                                        <p></p>
                                                    </ol>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th width="20%" style="vertical-align: middle"><span class="text-danger">*</span> Nama Penuh : </th>
                                                <td colspan="2" style="vertical-align: middle">
                                                    <input class="form-control" id="nama_pelapor" maxlength="100" name="nama_pelapor"  value="{{ $exist->nama_pelapor ?? old('nama_pelapor') }}" required>
                                                    @error('nama_pelapor')
                                                        <p style="color: red">{{ $message }}</p>
                                                    @enderror
                                                </td>
                                                <th width="20%" style="vertical-align: middle"><span class="text-danger">*</span> No Kad Pengenalan : </th>
                                                <td colspan="2" style="vertical-align: middle">
                                                    <input class="form-control" id="id_pelapor" name="id_pelapor" value="{{ $id }}" required readonly>
                                                    @error('id_pelapor')
                                                        <p style="color: red">{{ $message }}</p>
                                                    @enderror
                                                </td>
                                            </tr>
                                            <tr>
                                                <th width="20%" style="vertical-align: middle"><span class="text-danger">*</span> Emel : </th>
                                                <td colspan="2" style="vertical-align: middle">
                                                    <input class="form-control" id="emel_pelapor" name="emel_pelapor"  value="{{ $exist->emel_pelapor ?? old('emel_pelapor') }}" required>
                                                    @error('emel_pelapor')
                                                        <p style="color: red">{{ $message }}</p>
                                                    @enderror
                                                </td>
                                                <th width="20%" style="vertical-align: middle"><span class="text-danger">*</span> No. Telefon : </th>
                                                <td colspan="2">
                                                    <input class="form-control" id="no_tel_pelapor" name="no_tel_pelapor"  value="{{ $exist->no_tel_pelapor ?? old('no_tel_pelapor') }}" required>
                                                    @error('no_tel_pelapor')
                                                        <p style="color: red">{{ $message }}</p>
                                                    @enderror
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" class="pt-4" style="border-left-style: hidden; border-right-style: hidden; padding: 0px">
                                                    <ol class="breadcrumb breadcrumb-md breadcrumb-arrow">
                                                        <li>
                                                            <a href="#" disabled style="pointer-events: none">
                                                                <i class="fal fa-info"></i>
                                                                <span class=""><b>BUTIRAN ADUAN</b></span>
                                                            </a>
                                                        </li>
                                                        <p></p>
                                                    </ol>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th width="20%" style="vertical-align: middle"><span class="text-danger">*</span> Pejabat/Bahagian/ Fakulti/Kolej : </th>
                                                <td colspan="2"><input class="form-control" id="lokasi_aduan" maxlength="50" name="lokasi_aduan"  value="{{ old('lokasi_aduan') }}" required placeholder="Pejabat/Bahagian/Fakulti/Kolej">
                                                    @error('lokasi_aduan')
                                                        <p style="color: red">{{ $message }}</p>
                                                    @enderror</td>
                                                <th width="20%" style="vertical-align: middle"><span class="text-danger">*</span> Blok : </th>
                                                <td colspan="2"><input class="form-control" id="blok_aduan" maxlength="50" name="blok_aduan"  value="{{ old('blok_aduan') }}" required placeholder="Blok">
                                                    @error('blok_aduan')
                                                        <p style="color: red">{{ $message }}</p>
                                                    @enderror
                                                </td>
                                            </tr>
                                            <tr>
                                                <th width="20%" style="vertical-align: middle"><span class="text-danger">*</span> Tingkat/Aras : </th>
                                                <td colspan="2"><input class="form-control" id="aras_aduan" maxlength="50" name="aras_aduan"  value="{{ old('aras_aduan') }}" required placeholder="Tingkat/Aras">
                                                    @error('aras_aduan')
                                                        <p style="color: red">{{ $message }}</p>
                                                    @enderror
                                                </td>
                                                <th width="20%" style="vertical-align: middle"><span class="text-danger">*</span> Nama Bilik/No. Bilik : </th>
                                                <td colspan="2"><input class="form-control" id="nama_bilik" maxlength="50" name="nama_bilik"  value="{{ old('nama_bilik') }}" required placeholder="Nama Bilik/No. Bilik">
                                                    @error('nama_bilik')
                                                        <p style="color: red">{{ $message }}</p>
                                                    @enderror
                                                </td>
                                            </tr>
                                            <tr>
                                                <th width="20%" style="vertical-align: middle"><span class="text-danger">*</span> Kategori Aduan : </th>
                                                <td colspan="2">
                                                    <select class="form-control kategori" name="kategori_aduan" id="kategori_aduan" required>
                                                        <option value="" disabled selected> Sila Pilih</option>
                                                        @foreach ($kategori as $kat)
                                                            <option value="{{ $kat->kod_kategori }}" {{ old('kategori_aduan') ==  $kat->kod_kategori  ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('kategori_aduan')
                                                        <p style="color: red">{{ $message }}</p>
                                                    @enderror
                                                </td>
                                                <th width="20%" style="vertical-align: middle"><span class="text-danger">*</span> Jenis Kerosakan : </th>
                                                <td colspan="2">
                                                    <select class="form-control jenis" name="jenis_kerosakan" id="jenis_kerosakan" required>
                                                    </select>
                                                    @error('jenis_kerosakan')
                                                        <p style="color: red">{{ $message }}</p>
                                                    @enderror
                                                </td>
                                            </tr>
                                            <tr>
                                                <th width="20%" style="vertical-align: top"><span class="text-danger">*</span> Sebab Kerosakan : </th>
                                                <td colspan="2">
                                                    <select class="form-control sebab" name="sebab_kerosakan" id="sebab_kerosakan" required>
                                                    </select>
                                                    @error('sebab_kerosakan')
                                                        <p style="color: red">{{ $message }}</p>
                                                    @enderror
                                                </td>
                                                <th width="20%" style="vertical-align: middle">Kuantiti/Unit : </th>
                                                <td colspan="2"><input type="number" class="form-control" id="kuantiti_unit" name="kuantiti_unit"  value="{{ old('kuantiti_unit') }}" placeholder="Kuantiti/Unit ">
                                                    @error('kuantiti_unit')
                                                        <p style="color: red">{{ $message }}</p>
                                                    @enderror
                                                </td>
                                            </tr>
                                            <tr class="jk_penerangan">
                                                <th width="20%" style="vertical-align: top">Penerangan Jenis Kerosakan : </th>
                                                <td colspan="4"><textarea rows="3" maxlength="150" id="jk_penerangan" name="jk_penerangan" class="form-control">{{ old('jk_penerangan') }}</textarea>
                                                    <p align="right" class="mt-2">Tidak melebihi 150 huruf</p>
                                                    @error('jk_penerangan')
                                                        <p style="color: red">{{ $message }}</p>
                                                    @enderror
                                                </td>
                                            </tr>
                                            <tr class="sk_penerangan">
                                                <th width="20%" style="vertical-align: top">Penerangan Sebab Kerosakan : </th>
                                                <td colspan="4">
                                                    <textarea rows="3" id="sk_penerangan" maxlength="150" name="sk_penerangan" class="form-control">{{ old('sk_penerangan') }}</textarea>
                                                    <p align="right" class="mt-2">Tidak melebihi 150 huruf</p>
                                                    @error('sk_penerangan')
                                                        <p style="color: red">{{ $message }}</p>
                                                    @enderror
                                                </td>
                                            </tr>
                                            <tr>
                                                <th width="20%" style="vertical-align: top">Maklumat Tambahan : </th>
                                                <td colspan="4"><textarea rows="3" maxlength="150" id="maklumat_tambahan" name="maklumat_tambahan" class="form-control" placeholder="Sila isikan maklumat tambahan sekiranya ada">{{ old('maklumat_tambahan') }}</textarea>
                                                    <p align="right" class="mt-2">Tidak melebihi 150 huruf</p>
                                                    @error('maklumat_tambahan')
                                                        <p style="color: red">{{ $message }}</p>
                                                    @enderror
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" class="pt-4" style="border-left-style: hidden; border-right-style: hidden; padding: 0px">
                                                    <ol class="breadcrumb breadcrumb-md breadcrumb-arrow">
                                                        <li>
                                                            <a href="#" disabled style="pointer-events: none">
                                                                <i class="fal fa-upload"></i>
                                                                <span class=""><b>MUATNAIK BUKTI</b></span>
                                                            </a>
                                                        </li>
                                                        <p></p>
                                                    </ol>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th width="20%" style="vertical-align: middle"><span class="text-danger">*</span>  Gambar : </th>
                                                <td colspan="2">
                                                    <input type="file" class="form-control" id="upload_image" name="upload_image[]" accept="image/png,image/jpg,image/jpeg" {{ old('upload_image') }} multiple required>
                                                    @error('upload_image')
                                                        <p style="color: red">{{ $message }}</p>
                                                    @enderror
                                                </td>
                                                <th width="20%" style="vertical-align: middle"> Resit : </th>
                                                <td colspan="2">
                                                    <input type="file" class="form-control" id="resit_file" name="resit_file[]" {{ old('resit_file') }} accept="application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" multiple>
                                                    @error('resit_file')
                                                        <p style="color: red">{{ $message }}</p>
                                                    @enderror
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" class="pt-4" style="border-left-style: hidden; border-right-style: hidden; padding: 0px">
                                                    <ol class="breadcrumb breadcrumb-md breadcrumb-arrow">
                                                        <li>
                                                            <a href="#" disabled style="pointer-events: none">
                                                                <i class="fal fa-check-square"></i>
                                                                <span class=""><b> PERAKUAN DAN PENGESAHAN PELAPOR</b></span>
                                                            </a>
                                                        </li>
                                                        <p></p>
                                                    </ol>
                                                </td>
                                            </tr>
                                            <tr>
                                                <div class="form-group">
                                                    <td colspan="5"><p class="form-label" for="pengesahan_aduan">
                                                    <input style="margin-top: 15px; margin-right: 30px; margin-left: 15px; margin-bottom: 15px;" type="checkbox" name="pengesahan_aduan" required id="chk" onclick="btn()"/>
                                                    BUTIRAN PERIBADI DAN ADUAN YANG DIBERIKAN ADALAH BENAR. SAYA BERSETUJU UNTUK DIHUBUNGI BAGI SEBARANG PERTANYAAN LANJUT BERKAITAN ADUAN YANG DIBUAT
                                                    <button style="margin-top: 5px;" class="btn btn-danger float-right" type="submit" id="submit" name="submit" disabled><i class="fal fa-check"></i> Hantar Aduan</button></td>
                                                </div>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            {!! Form::close() !!}
                            <br>
                            <a href="/eAduan?ic_no={{$id}}" class="btn btn-success ml-auto float-right" ><i class="fal fa-arrow-alt-left"></i> Kembali</a><br>
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

function btn()
    {
        var chk = document.getElementById("chk")
        var submit = document.getElementById("submit");
        submit.disabled = chk.checked ? false : true;
        if(!submit.disabled){
            submit.focus();
        }
    }

    $(function () {

      $(".jk_penerangan").hide();

        $( "#jenis_kerosakan" ).change(function() {
        var val = $("#jenis_kerosakan").val();
        if(val==16 || val==23 || val==32 || val==38 || val==42){
            $(".jk_penerangan").show();
        } else {
            $(".jk_penerangan").hide();
        }
      });

      $(".sk_penerangan").hide();

        $( "#sebab_kerosakan" ).change(function() {
        var val = $("#sebab_kerosakan").val();
        if(val==65 || val==75 || val==97 || val==106 || val==115){
            $(".sk_penerangan").show();
        } else {
            $(".sk_penerangan").hide();
        }
      });

    })

    $(document).ready(function() {
        $('.kategori, .jenis, .sebab').select2();

        if($('.kategori').val()!=''){
                updateJenis($('.kategori'));
            }
            $(document).on('change','.kategori',function(){
                updateJenis($(this));
            });

            function updateJenis(elem){
            var katid=elem.val();
            var op=" ";

            $.ajax({
                type:'get',
                url:'{!!URL::to('cari-jenis-umum')!!}',
                data:{'id':katid},
                success:function(data)
                {
                    console.log(data)
                    op+='<option value="" disabled selected> Sila Pilih</option>';
                    for (var i=0; i<data.length; i++)
                    {
                        var selected = (data[i].id=="{{old('jenis_kerosakan', $aduan->jenis_kerosakan)}}") ? "selected='selected'" : '';
                        op+='<option value="'+data[i].id+'" '+selected+'>'+data[i].jenis_kerosakan+'</option>';
                    }

                    $('.jenis').html(op);
                },
                error:function(){
                    console.log('success');
                },
            });
        }

        if($('.kategori').val()!=''){
                updateSebab($('.kategori'));
            }
            $(document).on('change','.kategori',function(){
                updateSebab($(this));
            });

            function updateSebab(elem){
            var kateid=elem.val();
            var op=" ";

            $.ajax({
                type:'get',
                url:'{!!URL::to('cari-sebab-umum')!!}',
                data:{'id':kateid},
                success:function(data2)
                {
                    console.log(data2)
                    op+='<option value="" disabled selected> Sila Pilih</option>';
                    for (var i=0; i<data2.length; i++)
                    {
                        var selected = (data2[i].id=="{{old('sebab_kerosakan', $aduan->sebab_kerosakan)}}") ? "selected='selected'" : '';
                        op+='<option value="'+data2[i].id+'" '+selected+'>'+data2[i].sebab_kerosakan+'</option>';
                    }

                    $('.sebab').html(op);
                },
                error:function(){
                    console.log('success');
                },
            });
        }

    });

    $(document).ready(function () {
        $("#data").submit(function () {
            $("#submit").attr("disabled", true);
            return true;
        });
    });

    </script>
@endsection
