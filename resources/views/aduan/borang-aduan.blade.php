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
                        <div>
                            <p style="padding-left: 40px; padding-right: 40px">
                                *<i><b>PERHATIAN!</b></i> : Sebarang aduan kerosakkan akan diambil tindakan di dalam tempoh <b>tiga (3)</b> hari bekerja. Sekiranya tiada tindakan dibuat sila rujuk kepada <b>Pegawai Fasiliti (Ahmad Yusri/ Mohd Norshah)</b> untuk laporan/semakan. Sebarang aduan adalah diwajibkan secara online. Laporan secara manual atau pun emel adalah tidak akan diproses. 
                            </p>
                        </div>
                        <div class="panel-container show">
                            <div class="panel-content">

                                {!! Form::open(['action' => 'AduanController@simpanAduan', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <p><span class="text-danger">*</span> Maklumat wajib diisi</p>
                                    <div class="table-responsive">
                                        <table id="info" class="table table-bordered table-hover table-striped w-100">
                                            <thead>
                                                <tr>
                                                    <td colspan="5" class="bg-primary-50"><label class="form-label"><i class="fal fa-user"></i> INFO PENGADU</label></td>
                                                </tr>
                                                <tr>
                                                    <th width="20%" style="vertical-align: middle">Nama Penuh : </th>
                                                    <td colspan="2" style="vertical-align: middle">{{ strtoupper($user->name)}}</td>
                                                    <th width="20%" style="vertical-align: middle">ID Staf : </th>
                                                    <td colspan="2" style="vertical-align: middle">{{ strtoupper($user->id)}}</td>
                                                </tr>
                                                <tr>
                                                    <th width="20%" style="vertical-align: middle">Emel : </th>
                                                    <td colspan="2" style="vertical-align: middle">{{ $user->email}}</td>
                                                    <th width="20%" style="vertical-align: middle">No. Telefon : </th>
                                                    <td colspan="2"><input class="form-control" id="no_tel_pelapor" name="no_tel_pelapor"  value="{{ old('no_tel_pelapor') }}"></td>
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
                                                    <th width="20%" style="vertical-align: middle"><span class="text-danger">*</span> Pejabat/Bahagian/ Fakulti/Kolej : </th>
                                                    <td colspan="2"><input class="form-control" id="lokasi_aduan" name="lokasi_aduan"  value="{{ old('lokasi_aduan') }}" placeholder="Pejabat/Bahagian/Fakulti/Kolej">
                                                        @error('lokasi_aduan')
                                                            <p style="color: red">{{ $message }}</p>
                                                        @enderror</td>
                                                    <th width="20%" style="vertical-align: middle"><span class="text-danger">*</span> Blok : </th>
                                                    <td colspan="2"><input class="form-control" id="blok_aduan" name="blok_aduan"  value="{{ old('blok_aduan') }}" placeholder="Blok">
                                                        @error('blok_aduan')
                                                            <p style="color: red">{{ $message }}</p>
                                                        @enderror
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th width="20%" style="vertical-align: middle"><span class="text-danger">*</span> Tingkat/Aras : </th>
                                                    <td colspan="2"><input class="form-control" id="aras_aduan" name="aras_aduan"  value="{{ old('aras_aduan') }}" placeholder="Tingkat/Aras">
                                                        @error('aras_aduan')
                                                            <p style="color: red">{{ $message }}</p>
                                                        @enderror
                                                    </td>
                                                    <th width="20%" style="vertical-align: middle"><span class="text-danger">*</span> Nama Bilik/No. Bilik : </th>
                                                    <td colspan="2"><input class="form-control" id="nama_bilik" name="nama_bilik"  value="{{ old('nama_bilik') }}" placeholder="Nama Bilik/No. Bilik">
                                                        @error('nama_bilik')
                                                            <p style="color: red">{{ $message }}</p>
                                                        @enderror
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th width="20%" style="vertical-align: middle"><span class="text-danger">*</span> Kategori Aduan : </th>
                                                    <td colspan="2">
                                                        <select class="form-control kategori" name="kategori_aduan" id="kategori_aduan" >
                                                            <option value="">Pilih Kategori Aduan</option>
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
                                                        <select class="form-control jenis" name="jenis_kerosakan" id="jenis_kerosakan" >
                                                        </select>
                                                        @error('jenis_kerosakan')
                                                            <p style="color: red">{{ $message }}</p>
                                                        @enderror
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th width="20%" style="vertical-align: top"><span class="text-danger">*</span> Sebab Kerosakan : </th>
                                                    <td colspan="2">
                                                        <select class="form-control sebab" name="sebab_kerosakan" id="sebab_kerosakan" >
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
                                                    <td colspan="4"><textarea rows="5" id="jk_penerangan" name="jk_penerangan" class="form-control">{{ old('jk_penerangan') }}</textarea>
                                                        @error('jk_penerangan')
                                                            <p style="color: red">{{ $message }}</p>
                                                        @enderror
                                                    </td>
                                                </tr>

                                                <tr class="sk_penerangan">
                                                    <th width="20%" style="vertical-align: top">Penerangan Sebab Kerosakan : </th>
                                                    <td colspan="4">
                                                        <textarea rows="5" id="sk_penerangan" name="sk_penerangan" class="form-control">{{ old('sk_penerangan') }}</textarea>
                                                        @error('sk_penerangan')
                                                            <p style="color: red">{{ $message }}</p>
                                                        @enderror
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th width="20%" style="vertical-align: top">Adakah Kerosakan Dicaj ? </th>
                                                        <td colspan="2" style="padding-top: 20px;">
                                                            <input class="ml-5" type="radio" name="caj_kerosakan" id="caj_kerosakan" value="Ya" {{ old('caj_kerosakan') == "Ya" ? 'checked' : '' }}> Ya
                                                            <input class="ml-5" type="radio" name="caj_kerosakan" id="caj_kerosakan" value="Tidak" {{ old('caj_kerosakan') == "Tidak" ? 'checked' : '' }}> Tidak
                                                        </td>
                                                    <th width="20%" style="vertical-align: top">Maklumat Tambahan : </th>
                                                    <td colspan="2"><textarea rows="5" id="maklumat_tambahan" name="maklumat_tambahan" class="form-control" placeholder="Sila isikan maklumat tambahan sekiranya ada">{{ old('maklumat_tambahan') }}</textarea>
                                                        @error('maklumat_tambahan')
                                                            <p style="color: red">{{ $message }}</p>
                                                        @enderror
                                                    </td>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>

                                    <div class="table-responsive">
                                        <table id="muatnaik" class="table table-bordered table-hover table-striped w-100">
                                            <thead>
                                                <tr>
                                                    <td colspan="5" class="bg-primary-50"><label class="form-label"><i class="fal fa-upload"></i> MUATNAIK BUKTI</label></td>
                                                </tr>
                                                <tr>
                                                    <th width="20%" style="vertical-align: middle"> Gambar : </th>
                                                    <td colspan="2">
                                                        <input type="file" class="form-control" id="upload_image" name="upload_image[]" multiple>
                                                        @error('upload_image')
                                                            <p style="color: red">{{ $message }}</p>
                                                        @enderror
                                                    </td>
                                                    <th width="20%" style="vertical-align: middle"> Resit : </th>
                                                    <td colspan="2">
                                                        <input type="file" class="form-control" id="resit_file" name="resit_file[]" accept="application/pdf" multiple>
                                                        {{-- <input type="file" class="form-control" id="resit_file" name="resit_file" accept="application/pdf"> --}}
                                                        @error('resit_file')
                                                            <p style="color: red">{{ $message }}</p>
                                                        @enderror
                                                    </td>
                                                </tr>
                                                
                                            </thead>
                                        </table>
                                    </div>

                                    <div class="table-responsive">
                                        <table id="verifikasi" class="table table-bordered table-hover table-striped w-100">
                                            <thead>
                                                <tr>
                                                    <td colspan="5" class="bg-primary-50"><label class="form-label"><i class="fal fa-check-square"></i> PERAKUAN DAN PENGESAHAN PELAPOR</label></td>
                                                </tr>
                                                <tr>
                                                    <div class="form-group">
                                                        <td colspan="4"><p class="form-label" for="pengesahan_aduan">
                                                        <input style="margin-top: 15px; margin-right: 30px; margin-left: 15px; margin-bottom: 15px;" type="checkbox" name="pengesahan_aduan" id="chk" onclick="btn()"/>
                                                        SAYA, <b><u>{{ strtoupper($user->name) }}</u></b> MENGESAHKAN BUTIRAN PERIBADI DAN ADUAN DIBERIKAN ADALAH BENAR. SAYA BERSETUJU UNTUK DIHUBUNGI BAGI SEBARANG PERTANYAAN LANJUT BERKAITAN ADUAN YANG DIBUAT.</p> 
                                                        <button style="margin-top: 5px;" class="btn btn-danger float-right" id="submit" name="submit" disabled><i class="fal fa-check"></i> Hantar Aduan</button></td>
                                                    </div>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                {!! Form::close() !!}
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

    $(function () {          
        $("input[name=q1]").change(function () {        
        if ($(this).val() == "Y") {
          $(".q2").hide();
          $(".q3").hide();
          $(".q4").hide();
          $(".declare_date2").hide();
          $(".declare_date1").show();
        }
        else {
          $(".q2").show();
          $(".declare_date1").hide();
        }
      });

      $("input[name=q2]").change(function () {        
        if ($(this).val() == "Y") {
          $(".q3").hide();
          $(".q4").hide();
          $(".declare_date1").hide();
          $(".declare_date2").show();
        }
        else {
          $(".q3").show();
          $(".declare_date2").hide();
        }
      });

      $("input[name=q3]").change(function () {        
        if ($(this).val() == "Y") {
          $(".q4").hide();
        }
        else {
          $(".q4").show();
        }
      });

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
                    url:'{!!URL::to('cariJenis')!!}',
                    data:{'id':katid},
                    success:function(data)
                    {
                        console.log(data)
                        op+='<option value="">Pilih Jenis Kerosakan</option>';
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
                    url:'{!!URL::to('cariSebab')!!}',
                    data:{'id':kateid},
                    success:function(data2)
                    {
                        console.log(data2)
                        op+='<option value="">Pilih Sebab Kerosakan</option>';
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

</script>
@endsection

