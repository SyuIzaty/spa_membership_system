<?php

namespace App\Exports;

use App\Aduan;
use App\JuruteknikBertugas;
use App\AlatanPembaikan;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use DB;

class AduanExport implements FromCollection, WithHeadings
{
    use Exportable;
    public function __construct(String $kategori = null , String $status = null , String $tahap = null , String $bulan = null)
    {
        $this->kategori = $kategori;
        $this->status = $status;
        $this->tahap = $tahap;
        $this->bulan = $bulan;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $cond = "1";

        if($this->kategori && $this->kategori != "All")
        {
            $cond .= " AND kategori_aduan = '".$this->kategori."' ";
        }

        if( $this->status != "" && $this->status != "All")
        {
            $cond .= " AND status_aduan = '".$this->status."' ";
        }

        if( $this->tahap != "" && $this->tahap != "All")
        {
            $cond .= " AND tahap_kategori = '".$this->tahap."' ";
        }

        if( $this->bulan != "" && $this->bulan != "All")
        {
            $cond .= " AND bulan_laporan = '".$this->bulan."' ";
        }  

        $list =  Aduan::whereRaw($cond)
        ->join('kategori_aduan','cms_kategori_aduan.kod_kategori','=','cdd_covid_declarations.kategori_aduan')
        ->join('status_aduan','cms_status_aduan.kod_status','=','cdd_covid_declarations.status_aduan')
        ->join('tahap_kategori','cms_tahap_kategori.kod_tahap','=','cdd_covid_declarations.tahap_kategori')
        ->join('sebab_kerosakan','cms_sebab_kerosakan.id','=','cdd_covid_declarations.sebab_kerosakan')
        ->join('jenis_kerosakan','cms_jenis_kerosakan.id','=','cdd_covid_declarations.jenis_kerosakan')
        ->get();

        $collected1 = collect($list)->groupBy('id')->toarray();

        $collected = collect($list)->groupBy('id')->transform(function($item,$key){
            $data = [
                'Id'                    => "",
                'Nama'                  => "",
                'Emel'                  => "",
                'Id_pelapor'            => "",
                'No_telefon'            => "",
                'Tarikh_laporan'        => "",
                'Bilik'                 => "",
                'Aras'                  => "",
                'Blok'                  => "",
                'Lokasi'                => "",
                'Kategori'              => "",
                'Jenis'                 => "",
                'Sebab'                 => "",
                'Kuantiti'              => "",
                'Caj'                   => "",
                'Maklumat_tambahan'     => "",
                'Pengesahan_aduan'      => "",
                'Tahap_kategori'        => "",
                'Tarikh_serahan'        => "",
                'Laporan_pembaikan'     => "",
                'Bahan_alat'            => "",
                'Kos_upah'              => "",
                'Kos_bahan'             => "",
                'Jumlah_kos'            => "",
                'Tarikh_selesai'        => "",
                'Catatan'               => "",
                'Pengesahan_pembaikan'  => "",
                'Status'                => "",
                'Juruteknik'            => "",
            ];
            foreach($item as $ikey => $ivalue)
            {
                if($ikey == 0)
                {
                    $data['Id'] =$ivalue->id;
                    $data['Nama'] =$ivalue->nama_pelapor;
                    $data['Emel'] =$ivalue->emel_pelapor;
                    $data['Id_pelapor'] =$ivalue->id_pelapor;
                    $data['No_telefon'] =$ivalue->no_tel_pelapor;
                    $data['Tarikh_laporan'] =$ivalue->tarikh_laporan;
                    $data['Bilik'] =$ivalue->nama_bilik;
                    $data['Aras'] =$ivalue->aras_aduan;
                    $data['Blok'] =$ivalue->blok_aduan;
                    $data['Lokasi'] =$ivalue->lokasi_aduan;
                    $data['Kategori'] =$ivalue->kategori_aduan;
                    $data['Jenis'] =$ivalue->jenis_kerosakan;
                    $data['Sebab'] =$ivalue->sebab_kerosakan;
                    $data['Kuantiti'] =$ivalue->kuantiti_unit;
                    $data['Caj'] =$ivalue->caj_kerosakan;
                    $data['Maklumat_tambahan'] =$ivalue->maklumat_tambahan;
                    $data['Pengesahan_aduan'] =$ivalue->pengesahan_aduan;
                    $data['Tahap_kategori'] =$ivalue->tahap_kategori;
                    $data['Tarikh_serahan'] =$ivalue->tarikh_serahan_aduan;
                    $data['Laporan_pembaikan'] =$ivalue->laporan_pembaikan;
                    $data['Bahan_alat'] =$ivalue->laporan_pembaikan;
                    $data['Kos_upah'] =$ivalue->ak_upah;
                    $data['Kos_bahan'] =$ivalue->ak_bahan_alat;
                    $data['Jumlah_kos'] =$ivalue->jumlah_kos;
                    $data['Tarikh_selesai'] =$ivalue->tarikh_selesai_aduan;
                    $data['Catatan'] =$ivalue->catatan_pembaikan;
                    $data['Pengesahan_pembaikan'] =$ivalue->pengesahan_pembaikan;
                    $data['Status'] =$ivalue->status_aduan;
                    $data['Juruteknik'] =$ivalue->status_aduan;
                }

            }
            return $data;
        });

        return $collected;
    }

    public function headings(): array
    {
        return [
            'ID',
            'NAMA PELAPOR',
            'EMEL PELAPOR',
            'ID PELAPOR',
            'NO TELEFON',
            'TARIKH LAPORAN',
            'BILIK',
            'ARAS',
            'BLOK',
            'LOKASI',
            'KATEGORI ADUAN',
            'JENIS KEROSAKAN',
            'SEBAB KEROSAKAN',
            'KUANTITI / UNIT',
            'CAJ KEROSAKAN',
            'MAKLUMAT TAMBAHAN',
            'PENGESAHAN ADUAN',
            'TAHAP KATEGORI',
            'TARIKH SERAHAN ADUAN',
            'LAPORAN PEMBAIKAN',
            'BAHAN/ALAT GANTI',
            'KOS UPAH',
            'KOS BAHAN / ALAT GANTI',
            'JUMLAH KOS',
            'TARIKH SELESAI ADUAN',
            'CATATAN PEMBAIKAN',
            'PENGESAHAN PEMBAIKAN',
            'STATUS TERKINI',
            'JURUTEKNIK BERTUGAS',
        ];
    }
}

