<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aduan extends Model
{
    use SoftDeletes;
    protected $table = 'aduan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama_pelapor', 'jawatan_pelapor', 'no_tel_pelapor', 'no_tel_bimbit_pelapor', 'no_bilik_pelapor', 'tarikh_laporan', 'lokasi_aduan', 
        'blok_aduan', 'aras_aduan', 'nama_bilik', 'kategori_aduan', 'jenis_kerosakan', 'jk_penerangan', 'sebab_kerosakan', 'sk_penerangan', 
        'status_aduan', 'tahap_kategori', 'juruteknik_bertugas', 'tarikh_serahan_aduan', 'laporan_pembaikan', 'bahan_alat', 'ak_upah', 
        'ak_bahan_alat', 'jumlah_kos', 'tarikh_selesai_aduan', 'catatan_pembaikan', 'maklumat_tambahan'
    ];

    public function jawatan()
    {
        return $this->hasOne('App\JawatanPengadu','id','jawatan_pelapor');
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
        return $this->belongsTo('App\User','juruteknik_bertugas');  
    }
}
