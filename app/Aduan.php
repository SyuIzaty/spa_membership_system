<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aduan extends Model
{
    use SoftDeletes;
    protected $table = 'cms_aduan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama_pelapor', 'emel_pelapor', 'id_pelapor', 'no_tel_pelapor', 'nama_bilik', 'aras_aduan','blok_aduan', 'lokasi_aduan', 'kategori_aduan',
        'jenis_kerosakan', 'jk_penerangan', 'sebab_kerosakan', 'sk_penerangan', 'kuantiti_unit', 'caj_kerosakan', 'maklumat_tambahan', 'pengesahan_aduan',
        'pengesahan_pembaikan', 'tarikh_laporan', 'status_aduan', 'bulan_laporan', 'tahap_kategori', 'tarikh_serahan_aduan', 'laporan_pembaikan', 'bahan_alat', 'ak_upah',
        'ak_bahan_alat', 'jumlah_kos', 'tarikh_selesai_aduan', 'catatan_pembaikan', 'sebab_pembatalan', 'tukar_status', 'sebab_tukar_status', 'notis_juruteknik'
    ];

    public function pengadu()
    {
        return $this->hasOne('App\User','id','id_pelapor');
    }

    public function jawatan()
    {
        return $this->hasOne('App\JawatanPengadu','id','jawatan_pelapor');
    }

    public function penukaran()
    {
        return $this->hasOne('App\Staff','staff_id','tukar_status');
    }

    public function kategori()
    {
        return $this->hasOne('App\KategoriAduan','kod_kategori','kategori_aduan');
    }

    public function jenis()
    {
        return $this->hasOne('App\JenisKerosakan','id','jenis_kerosakan');
    }

    public function sebab()
    {
        return $this->hasOne('App\SebabKerosakan','id','sebab_kerosakan');
    }

    public function status()
    {
        return $this->hasOne('App\StatusAduan','kod_status','status_aduan');
    }

    public function tahap()
    {
        return $this->hasOne('App\TahapKategori','kod_tahap','tahap_kategori');
    }

    public function juruteknik()
    {
        return $this->hasmany('App\JuruteknikBertugas','id_aduan', 'id');
    }

    public function stafJuruteknik()
    {
        return $this->hasOne('App\JuruteknikBertugas','id_aduan', 'id');
    }
}
