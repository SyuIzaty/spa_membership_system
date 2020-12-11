@extends('layouts.aduan')
@section('content')
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-center">
                    <div class="p-2">
                        <img src="{{ asset('img/intec_logo.png') }}" class="responsive"/>
                    </div>
                </div>
            </div>
            <hr class="mb-2 mt-3">
            <div class="card-body">
                {!! Form::open(['action' => 'AduanController@simpanAduan', 'method' => 'POST']) !!}
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="row">
                    <div class="col-md-12">
                        <p><span class="text-danger">*</span> Maklumat wajib diisi</p>
                        <div class="card-header">
                            <h4 class="card-title w-100"><b>INFO PENGADU :</b></h4>
                        </div>
                    </div><br><br><br><br><br><br>
                    <div class="form-group col-md-8">
                        <span class="text-danger">*</span> {{Form::label('title', 'Nama Pelapor')}}
                        {{Form::text('nama_pelapor', '', ['class' => 'form-control', 'placeholder' => 'Nama Pelapor', 'id' => 'nama_pelapor', 'onkeyup' => 'this.value = this.value.toUpperCase()'])}}
                        @error('nama_pelapor')
                            <p style="color: red">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-md-4 form-group">
                        <span class="text-danger">*</span> {{ Form::label('title', 'Jawatan') }}
                        <select class="form-control jawatan_pelapor" name="jawatan_pelapor" id="jawatan_pelapor">
                            <option value="">-- Pilih Jawatan --</option>
                            @foreach ($jawatan as $jwtn) 
                                <option value="{{ $jwtn->id }}" {{ old('jawatan_pelapor') ? 'selected' : '' }}>{{ $jwtn->nama_jawatan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 form-group">
                        {{ Form::label('title', 'No Telefon') }}
                        {{ Form::text('no_tel_pelapor', '', ['class' => 'form-control', 'placeholder' => 'No Telefon']) }}
                        @error('no_tel_pelapor')
                            <p style="color: red">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-md-4 form-group">
                        <span class="text-danger">*</span> {{ Form::label('title', 'No Telefon Bimbit') }}
                        {{ Form::text('no_tel_bimbit_pelapor', '', ['class' => 'form-control', 'placeholder' => 'No Telefon Bimbit']) }}
                        @error('no_tel_bimbit_pelapor')
                            <p style="color: red">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-md-4 form-group no_bilik_pelapor">
                        {{ Form::label('title', 'No Bilik') }}
                        {{ Form::text('no_bilik_pelapor', '', ['class' => 'form-control', 'placeholder' => 'No Bilik']) }}
                        @error('no_bilik_pelapor')
                            <p style="color: red">{{ $message }}</p>
                        @enderror
                    </div>
                   
                    <div class="col-md-12">
                        <div class="card-header">
                            <h4 class="card-title w-100"><b>BUTIRAN ADUAN :</b></h4>
                        </div>
                    </div><br><br><br><br>

                    <div class="form-group col-md-6">
                        <span class="text-danger">*</span> {{Form::label('title', 'Pejabat/Bahagian/Fakulti/Kolej')}}
                        {{Form::text('lokasi_aduan', '', ['class' => 'form-control', 'placeholder' => 'Pejabat/Bahagian/Fakulti/Kolej'])}}
                        @error('lokasi_aduan')
                            <p style="color: red">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <span class="text-danger">*</span> {{Form::label('title', 'Blok')}}
                        {{Form::text('blok_aduan', '', ['class' => 'form-control', 'placeholder' => 'Blok'])}}
                        @error('blok_aduan')
                            <p style="color: red">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <span class="text-danger">*</span> {{Form::label('title', 'Tingkat/Aras')}}
                        {{Form::text('aras_aduan', '', ['class' => 'form-control', 'placeholder' => 'Aras'])}}
                        @error('aras_aduan')
                            <p style="color: red">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <span class="text-danger">*</span> {{Form::label('title', 'Nama Bilik/No. Bilik')}}
                        {{Form::text('nama_bilik', '', ['class' => 'form-control', 'placeholder' => 'Nama Bilik/No. Bilik'])}}
                        @error('nama_bilik')
                            <p style="color: red">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <span class="text-danger">*</span> {{Form::label('title', 'Kategori Aduan')}}
                        <select class="form-control kategori" name="kategori_aduan" id="kategori_aduan" >
                            <option value="">-- Pilih Kategori Aduan --</option>
                            @foreach ($kategori as $kat) 
                                <option value="{{ $kat->kod_kategori }}" {{ old('kategori_aduan') ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
                            @endforeach
                        </select>
                        @error('kategori_aduan')
                            <p style="color: red">{{ $message }}</p>
                        @enderror
                    </div>
                   
                    <div class="col-md-4 form-group">
                        <span class="text-danger">*</span> {{Form::label('title', 'Jenis Kerosakan')}}
                        <select class="form-control jenis" name="jenis_kerosakan" id="jenis_kerosakan" >
                        </select>
                        @error('jenis_kerosakan')
                            <p style="color: red">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="col-md-4 form-group">
                        <span class="text-danger">*</span> {{Form::label('title', 'Sebab Kerosakan')}}
                        <select class="form-control sebab" name="sebab_kerosakan" id="sebab_kerosakan" >
                        </select>
                        @error('sebab_kerosakan')
                            <p style="color: red">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group col-md-6 jk_penerangan">
                        {{Form::label('title', 'Penerangan Jenis Kerosakan')}}
                        {{Form::textarea('jk_penerangan', '', ['class' => 'form-control', 'placeholder' => 'Penerangan', 'cols' => '5', 'rows' => '5', 'id' => 'jk_penerangan'])}}
                        @error('jk_penerangan')
                            <p style="color: red">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group col-md-6 sk_penerangan">
                        {{Form::label('title', 'Penerangan Sebab Kerosakan')}}
                        {{Form::textarea('sk_penerangan', '', ['class' => 'form-control', 'placeholder' => 'Penerangan', 'cols' => '5', 'rows' => '5'])}}
                        @error('sk_penerangan')
                            <p style="color: red">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <div class="card-header">
                            <h4 class="card-title w-100"><b><span class="text-danger">*</span> PERAKUAN DAN PENGESAHAN PELAPOR :</b></h4>
                        </div>
                    </div>
                    <br><br><br><br>

                    <div class="col-md-12">
                    <div class="card-body" style="font-size: 15px">
                        <label for="chk" class="form-group col-md-12">
                            <input type="checkbox" name="chk" id="chk"  onclick="btn()"/>
                            Saya <input class="border-0" id="nama" name="nama" style="width: 500px; font-weight:bold; text-decoration: underline; text-align: center;" placeholder="____________________________________________________________________" readonly> dengan ini mengesahkan bahawa aduan ini telah diambil tindakan dan berpuas hati dengan kualiti serta perkhidmatan yang telah diberikan
                        </label>
                      </div>
                    </div>
                </div>
                <button class="btn btn-primary float-right" id="hantar" name="hantar" disabled><i class="fal fa-check"></i> Hantar Aduan</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('.jawatan_pelapor, #kategori_aduan, #jenis_kerosakan, #sebab_kerosakan').select2();

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
                        op+='<option value="">-- Pilih Jenis Kerosakan --</option>';
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
                        op+='<option value="">-- Pilih Sebab Kerosakan --</option>';
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

        $('#nama_pelapor').on('change', function() {
            $('#nama').val($(this).val());
        });

        // sama dgn func btn()
        // $("#chk").change(function() {
        // if ($(this).is(':checked')) {
        //     $('#hantar').show();
        // } else {
        //     $('#hantar').hide();
        // }
        // });
        // $("#chk").trigger("change");

        function btn()
    {
        var chk = document.getElementById("chk")
        var hantar = document.getElementById("hantar");
        hantar.disabled = chk.checked ? false : true;
        if(!hantar.disabled){
            hantar.focus();
        }
    }

    $(".no_bilik_pelapor").hide();

    $( "#jawatan_pelapor" ).change(function() {
    var val = $("#jawatan_pelapor").val();
    if(val==1){
        $(".no_bilik_pelapor").show();
    } else {
        $(".no_bilik_pelapor").hide();
    }
    });

    $(".jk_penerangan").hide();

    $( "#jenis_kerosakan" ).change(function() {
    var val = $("#jenis_kerosakan").val();
    if(val==5 || val==10 || val==18 || val==24 || val==28){
        $(".jk_penerangan").show();
    } else {
        $(".jk_penerangan").hide();
    }
    });

    $(".sk_penerangan").hide();

    $( "#sebab_kerosakan" ).change(function() {
    var val = $("#sebab_kerosakan").val();
    if(val==8 || val==17 || val==32 || val==40 || val==47){
        $(".sk_penerangan").show();
    } else {
        $(".sk_penerangan").hide();
    }
    });
    
    </script>
@endsection
