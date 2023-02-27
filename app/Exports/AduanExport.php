<?php

namespace App\Exports;

use DB;
use App\JuruteknikBertugas;
use App\Aduan;
use App\AlatanPembaikan;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;

class AduanExport implements FromCollection, WithHeadings, WithMapping, WithEvents, ShouldAutoSize
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
        $data = $datas = $datass =  '';

        if($this->kategori || $this->status || $this->tahap || $this->bulan)
        {
            $result = new Aduan();

            if($this->tahap != "")
            {
                $result = $result->where('tahap_kategori', $this->tahap);
            }

            if($this->status != "")
            {
                $result = $result->where('status_aduan', $this->status);
            }

            if($this->kategori != "")
            {
                $result = $result->where('kategori_aduan', $this->kategori);
            }

            if($this->bulan != "")
            {
                $result = $result->where('bulan_laporan', $this->bulan);
            }

            $data = $result->get();
        }

        else {
            $data = Aduan::all();
        }

        return collect($data);
    }

    public function map($data): array
    {
        if(!empty($data)) {
            $datas = AlatanPembaikan::where('id_aduan', $data->id)->get();
            $alat = '';
            foreach($datas as $datass){
                $alat .= strtoupper($datass->alat->alat_ganti).', ';
            }

            $dataz = JuruteknikBertugas::where('id_aduan', $data->id)->get();
            $juru = '';
            foreach($dataz as $datazz){
                $juru .= strtoupper($datazz->juruteknik->name).', ';
            }
        }

        return [
            isset($data->id) ? $data->id : '--',
            isset($juru) ? $juru : '--',
            isset($data->nama_pelapor) ? strtoupper($data->nama_pelapor) : '--',
            isset($data->emel_pelapor) ? strtoupper($data->emel_pelapor) : '--',
            isset($data->id_pelapor) ? strtoupper($data->id_pelapor) : '--',
            isset($data->no_tel_pelapor) ? strtoupper($data->no_tel_pelapor) : '--',
            isset($data->tarikh_laporan) ? date(' d-m-Y ', strtotime($data->tarikh_laporan)) : '--',
            isset($data->nama_bilik) ? strtoupper($data->nama_bilik) : '--',
            isset($data->aras_aduan) ? strtoupper($data->aras_aduan) : '--',
            isset($data->blok_aduan) ? strtoupper($data->blok_aduan) : '--',
            isset($data->lokasi_aduan) ?strtoupper( $data->lokasi_aduan) : '--',
            isset($data->kategori->nama_kategori) ? strtoupper($data->kategori->nama_kategori) : '--',
            isset($data->jenis->jenis_kerosakan) ? strtoupper($data->jenis->jenis_kerosakan) : '--',
            isset($data->sebab->sebab_kerosakan) ? strtoupper($data->sebab->sebab_kerosakan) : '--',
            isset($data->kuantiti_unit) ? $data->kuantiti_unit : '--',
            isset($data->caj_kerosakan) ? strtoupper($data->caj_kerosakan) : '--',
            isset($data->maklumat_tambahan) ? strtoupper($data->maklumat_tambahan) : '--',
            isset($data->pengesahan_aduan) ? strtoupper($data->pengesahan_aduan) : '--',
            isset($data->tahap->jenis_tahap) ? $data->tahap->jenis_tahap : '--',
            isset($data->tarikh_serahan_aduan) ? date(' d-m-Y ', strtotime($data->tarikh_serahan_aduan)) : '--',
            isset($data->laporan_pembaikan) ? strtoupper($data->laporan_pembaikan) : '--',
            isset($alat) ? $alat : '--',
            isset($data->ak_upah) ? $data->ak_upah : '--',
            isset($data->ak_bahan_alat) ? $data->ak_bahan_alat : '--',
            isset($data->jumlah_kos) ? $data->jumlah_kos : '--',
            isset($data->tarikh_selesai_aduan) ? date(' d-m-Y ', strtotime($data->tarikh_selesai_aduan)) : '--',
            isset($data->pengesahan_pembaikan) ? strtoupper($data->pengesahan_pembaikan) : '--',
            isset($data->catatan_pembaikan) ? strtoupper($data->catatan_pembaikan) : '--',
            isset($data->status->nama_status) ? strtoupper($data->status->nama_status) : '--',
        ];

    }

    public function headings(): array
    {
        return [
            'ID',
            'JURUTEKNIK BERTUGAS',
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
            'KUANTITI/UNIT',
            'CAJ KEROSAKAN',
            'MAKLUMAT TAMBAHAN',
            'PENGESAHAN ADUAN',
            'TAHAP KATEGORI',
            'TARIKH SERAHAN ADUAN',
            'LAPORAN PEMBAIKAN',
            'BAHAN/ALAT GANTI',
            'KOS UPAH (RM)',
            'KOS BAHAN (RM)',
            'JUMLAH KOS (RM)',
            'TARIKH SELESAI ADUAN',
            'CATATAN PEMBAIKAN',
            'PENGESAHAN PEMBAIKAN',
            'STATUS',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $all = Aduan::get()->count() + 1;
                $cellRange = 'A1:AC'.$all.'';
                $head_title = 'A1:AC1';
                $event->sheet->getDelegate()->getStyle($head_title)->getFont()->setBold(true)->setName('Arial');
                $event->sheet->getDelegate()->getStyle($head_title)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('80e5ff');
                $event->sheet->getStyle($cellRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
            },
        ];
    }
}


