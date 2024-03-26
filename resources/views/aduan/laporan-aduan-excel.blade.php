<head>
    <meta charset="UTF-8">
    <title>LAPORAN ADUAN</title>
</head>

<body>
    <table width="100%">
        <tr>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black">TIKET</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black">KATEGORI PENGADU</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black">ID PENGADU</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black">NAMA PENGADU</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black">NO. TELEFON PENGADU</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black">EMEL PENGADU</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black">LOKASI (PEJABAT/BAHAGIAN/FAKULTI/KOLEJ)</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black">BLOK</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black">TINGKAT/ARAS</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black">NAMA BILIK/NO. BILIK</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black">KATEGORI ADUAN</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black">JENIS KEROSAKAN</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black">PENERANGAN (JIKA ADA)</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black">SEBAB KEROSAKAN</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black">PENERANGAN (JIKA ADA)</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black">KUANTITI/UNIT</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black">MAKLUMAT TAMBAHAN</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black">TAHAP KATEGORI</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black">TAHUN ADUAN</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black">BULAN ADUAN</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black">TARIKH ADUAN</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black">TARIKH SERAHAN</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black">TARIKH SELESAI</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black">TEMPOH (HARI)</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black">LAPORAN PEMBAIKAN</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black">NOTIS JURUTEKNIK</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black">JURUTEKNIK</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black">STATUS TERKINI</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black">PENGESAHAN PEMBAIKAN</th>
        </tr>
        @foreach($data as $key => $datas)
            <tr>
                <td style="width: 200px; text-align: center; border: 1px solid black">{{ $datas->id ?? '-'}}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black">
                    @php
                        $category = \App\User::where('id', $datas->id_pelapor)->value('category');
                    @endphp

                    @if($category == 'STF')
                        STAF
                    @elseif($category == 'STD')
                        PELAJAR
                    @else
                        -
                    @endif
                </td>
                <td style="width: 200px; text-align: center; border: 1px solid black">{{ $datas->id_pelapor ?? '-'}}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black">{{ $datas->nama_pelapor ?? '-'}}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black">{{ $datas->no_tel_pelapor ?? '-'}}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black">{{ $datas->emel_pelapor ?? '-'}}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black">{{ strtoupper($datas->lokasi_aduan) ?? '-' }}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black">{{ strtoupper($datas->blok_aduan) ?? '-' }}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black">{{ strtoupper($datas->aras_aduan) ?? '-' }}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black">{{ strtoupper($datas->nama_bilik) ?? '-'  }}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black">{{ $datas->kategori->nama_kategori ?? '-' }}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black">{{ strtoupper($datas->jenis->jenis_kerosakan) ?? '-' }}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black">{{ isset($datas->jk_penerangan) ? strtoupper($datas->jk_penerangan) : '-'  }}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black">{{ strtoupper($datas->sebab->sebab_kerosakan) ?? '-' }}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black">{{ isset($datas->sk_penerangan) ? strtoupper($datas->sk_penerangan) : '-'  }}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black">{{ $datas->kuantiti_unit ?? '-'  }}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black">{{ strtoupper($datas->maklumat_tambahan) ?? '-'  }}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black">{{ $datas->tahap->jenis_tahap ?? '-'  }}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black">
                    {{ isset($datas->tarikh_laporan) ? date('Y', strtotime($datas->tarikh_laporan)) : '-' }}
                </td>
                <td style="width: 200px; text-align: center; border: 1px solid black">
                    {{ isset($datas->tarikh_laporan) ? date('m', strtotime($datas->tarikh_laporan)) : '-' }}
                </td>
                <td style="width: 200px; text-align: center; border: 1px solid black">{{ isset($datas->tarikh_laporan) ? date('d-m-Y', strtotime($datas->tarikh_laporan)) : '-' }}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black">{{ isset($datas->tarikh_serahan_aduan) ? date('d-m-Y', strtotime($datas->tarikh_serahan_aduan)) : '-' }}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black">{{ isset($datas->tarikh_selesai_aduan) ? date('d-m-Y', strtotime($datas->tarikh_selesai_aduan)) : '-' }}</td>
                <td style="width: 200px; text-align: left; border: 1px solid black">
                    @php
                        if ($datas->status_aduan == 'AB') {
                            $tempoh = '-';
                        } else {
                            $tarikhLaporan = \Carbon\Carbon::parse($datas->tarikh_laporan);
                            $tarikhSelesaiAduan = $datas->tarikh_selesai_aduan ? \Carbon\Carbon::parse($datas->tarikh_selesai_aduan) : \Carbon\Carbon::now();
                            $duration = $tarikhLaporan->diffInDays($tarikhSelesaiAduan)+1;
                            $status = $datas->tarikh_selesai_aduan ? 'SELESAI' : 'KELEWATAN';

                            $tempoh =  $status . ': ' . $duration;
                        }
                    @endphp
                    {{$tempoh}}
                </td>
                <td style="width: 200px; text-align: center; border: 1px solid black">{{ strtoupper($datas->laporan_pembaikan) ?? '-'  }}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black">{{ strtoupper($datas->notis_juruteknik) ?? '-'  }}</td>
                <td style="width: 200px; text-align: left; border: 1px solid black">
                    @php
                        $juruteknik = \App\JuruteknikBertugas::where('id_aduan', $datas->id)->get();
                        $count = count($juruteknik);
                    @endphp
                    @forelse($juruteknik as $index => $senarai_juruteknik)
                        @if($senarai_juruteknik->juruteknik)
                            {{ $senarai_juruteknik->juruteknik->name }}
                            @if($index < $count - 1)
                                ,
                            @endif
                        @endif
                    @empty
                        -
                    @endforelse
                </td>
                <td style="width: 200px; text-align: center; border: 1px solid black">{{ strtoupper($datas->status->nama_status) ?? '-'  }}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black">{{ $datas->pengesahan_pembaikan ?? '-'  }}</td>
            </tr>
        @endforeach
    </table>
</body>
