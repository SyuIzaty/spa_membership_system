@extends('layouts.admin')

@section('content')

<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-search'></i> LAPORAN PDF
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>LAPORAN ADUAN</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                            <form action="{{ route('pdfLaporan') }}" method="GET" id="form_find">
                                <div class="row">
                                    <div class="col-md-6 mt-2">
                                        <label>Juruteknik</label>
                                        <select class="selectfilter form-control custom-juruteknik" name="juruteknik" id="juruteknik">
                                            <option value="">Pilih Juruteknik</option>
                                            {{-- <option>All</option> --}}
                                            @foreach($juruteknik as $juru)
                                                <option value="{{$juru->id}}" {{ $selectedjuruteknik == $juru->id  ? 'selected' : '' }}>{{$juru->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                   <div class="col-md-6 mt-2">
                                        <label>Status</label>
                                        <select class="selectfilter form-control custom-status" name="status" id="status">
                                            <option value="">Pilih Status</option>
                                            {{-- <option>All</option> --}}
                                            @foreach($status as $stat)
                                                <option value="{{$stat->kod_status}}" {{ $selectedstatus == $stat->kod_status  ? 'selected' : '' }}>{{strtoupper($stat->nama_status)}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <label>Kategori</label>
                                        <select class="selectfilter form-control custom-kategori" name="kategori" id="kategori">
                                            <option value="">Pilih Kategori</option>
                                            {{-- <option>All</option> --}}
                                            @foreach($kategori as $kat)
                                                <option value="{{$kat->kod_kategori}}" {{ $selectedkategori == $kat->kod_kategori  ? 'selected' : '' }}>{{$kat->nama_kategori}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                     <div class="col-md-6 mt-2">
                                        <label>Bulan</label>
                                        <select class="selectfilter form-control custom-bulan" name="bulan" id="bulan">
                                            <option value="">Pilih Bulan</option>
                                            {{-- <option>All</option> --}}
                                            @foreach($bulan as $bul)
                                                <option value="{{$bul->bulan_laporan}}" {{ $selectedbulan == $bul->bulan_laporan ? 'selected' : '' }}>{{$bul->bulan_laporan}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <br>
                            </form>
                            <br>
                            <a class="btn buttons-pdf btn-md float-right mb-4 text-white" data-page="/pdfLaporan/{{$selectedjuruteknik}}/{{$selectedstatus}}/{{$selectedkategori}}/{{$selectedbulan}}" onclick="Print(this)"><span><i class="fal fa-file-pdf"></i> PDF</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('script')
<style>
    .buttons-pdf{
        /* color: white; */
        background-color: #ad606a;
        float: right;
    }
</style>
<script >

    $("#juruteknik, #kategori, #status, #bulan").change(function(){
        $("#form_find").submit();
    })

    function Print(button)
    {
        var url = $(button).data('page');
        var printWindow = window.open( '{{url("/")}}'+url+'', 'Print', 'left=200, top=200, width=950, height=500, toolbar=0, resizable=0');
        printWindow.addEventListener('load', function(){
            printWindow.print();
        }, true);
    }
    
    $(document).ready(function()
    {
        $('.custom-kategori, .custom-status, .custom-juruteknik, .custom-bulan').select2();

    });

</script>
@endsection
