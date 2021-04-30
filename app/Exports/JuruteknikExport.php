<?php

namespace App\Exports;

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
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class JuruteknikExport implements FromCollection, WithHeadings, WithMapping, WithEvents, ShouldAutoSize
{
    use Exportable;
    public function __construct(String $juruteknik = null, String $stat = null, String $kate = null, String $bul = null)
    {
        $this->juruteknik = $juruteknik;
        $this->stat = $stat;
        $this->kate = $kate;
        $this->bul = $bul;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = $datas = $datass =  '';

        if($this->juruteknik || $this->stat || $this->kate || $this->bul)
        {
            $result = new JuruteknikBertugas();
            
            if($this->juruteknik != "")
            {
                $result = $result->where('juruteknik_bertugas', $this->juruteknik);
            }

            if($this->stat != "")
            {
                $result = $result->whereHas('aduan', function($query){
                    $query->where('status_aduan', $this->stat);
                });
            }

            if($this->kate != "")
            {
                $result = $result->whereHas('aduan', function($query){
                    $query->where('kategori_aduan', $this->kate);
                });
            }

            if($this->bul != "")
            {
                $result = $result->whereHas('aduan', function($query){
                    $query->where('bulan_laporan', $this->bul);
                });
            }

            $data = $result->get();
        }

        // dd($data);
        
        return collect($data);
    }

    public function map($data): array
    {
        if(!empty($data)) {
            $datas = AlatanPembaikan::where('id_aduan', $data->id_aduan)->get();
            $alat = '';
            foreach($datas as $datass){
                $alat .= strtoupper($datass->alat->alat_ganti).', ';
            }
        }

        return [
            isset($data->id_aduan) ? $data->id_aduan : '--',
            isset($data->juruteknik->name) ? strtoupper($data->juruteknik->name) : '--',
            isset($data->aduan->nama_pelapor) ? strtoupper($data->aduan->nama_pelapor) : '--',
            isset($data->aduan->emel_pelapor) ? strtoupper($data->aduan->emel_pelapor) : '--',
            isset($data->aduan->id_pelapor) ? strtoupper($data->aduan->id_pelapor) : '--',
            isset($data->aduan->no_tel_pelapor) ? strtoupper($data->aduan->no_tel_pelapor) : '--',
            isset($data->aduan->tarikh_laporan) ? date(' d-m-Y ', strtotime($data->aduan->tarikh_laporan)) : '--',
            isset($data->aduan->nama_bilik) ? strtoupper($data->aduan->nama_bilik) : '--',
            isset($data->aduan->aras_aduan) ? strtoupper($data->aduan->aras_aduan) : '--',
            isset($data->aduan->blok_aduan) ? strtoupper($data->aduan->blok_aduan) : '--',
            isset($data->aduan->lokasi_aduan) ?strtoupper( $data->aduan->lokasi_aduan) : '--',
            isset($data->aduan->kategori->nama_kategori) ? strtoupper($data->aduan->kategori->nama_kategori) : '--',
            isset($data->aduan->jenis->jenis_kerosakan) ? strtoupper($data->aduan->jenis->jenis_kerosakan) : '--',
            isset($data->aduan->sebab->sebab_kerosakan) ? strtoupper($data->aduan->sebab->sebab_kerosakan) : '--',
            isset($data->aduan->kuantiti_unit) ? $data->aduan->kuantiti_unit : '--',
            isset($data->aduan->caj_kerosakan) ? strtoupper($data->aduan->caj_kerosakan) : '--',
            isset($data->aduan->maklumat_tambahan) ? strtoupper($data->aduan->maklumat_tambahan) : '--',
            isset($data->aduan->pengesahan_aduan) ? strtoupper($data->aduan->pengesahan_aduan) : '--',
            isset($data->aduan->tahap->jenis_tahap) ? $data->aduan->tahap->jenis_tahap : '--',
            isset($data->aduan->tarikh_serahan_aduan) ? date(' d-m-Y ', strtotime($data->aduan->tarikh_serahan_aduan)) : '--',
            isset($data->aduan->laporan_pembaikan) ? strtoupper($data->aduan->laporan_pembaikan) : '--',
            isset($alat) ? $alat : '--',
            isset($data->aduan->ak_upah) ? $data->aduan->ak_upah : '--',
            isset($data->aduan->ak_bahan_alat) ? $data->aduan->ak_bahan_alat : '--',
            isset($data->aduan->jumlah_kos) ? $data->aduan->jumlah_kos : '--',
            isset($data->aduan->tarikh_selesai_aduan) ? date(' d-m-Y ', strtotime($data->aduan->tarikh_selesai_aduan)) : '--',
            isset($data->aduan->pengesahan_pembaikan) ? strtoupper($data->aduan->pengesahan_pembaikan) : '--',
            isset($data->aduan->catatan_pembaikan) ? strtoupper($data->aduan->catatan_pembaikan) : '--',
            isset($data->aduan->status->nama_status) ? strtoupper($data->aduan->status->nama_status) : '--',
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
                $all = JuruteknikBertugas::get()->count() + 1;
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
