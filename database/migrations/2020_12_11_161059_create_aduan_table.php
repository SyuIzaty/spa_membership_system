<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAduanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aduan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pelapor');
            $table->string('jawatan_pelapor');
            $table->string('no_tel_pelapor');
            $table->string('no_tel_bimbit_pelapor');
            $table->string('no_bilik_pelapor');
            $table->dateTime('tarikh_laporan');
            $table->string('lokasi_aduan');
            $table->string('blok_aduan');
            $table->string('aras_aduan');
            $table->string('nama_bilik');
            $table->string('kategori_aduan');
            $table->string('jenis_kerosakan');
            $table->string('sebab_kerosakan');
            $table->string('status_aduan');
            $table->string('maklumat_tambahan');
            $table->string('tahap_kategori');
            $table->string('juruteknik_bertugas');
            $table->dateTime('tarikh_serahan_aduan');
            $table->string('laporan_pembaikan');
            $table->string('bahan_alat');
            $table->decimal('ak_upah');
            $table->decimal('ak_bahan_alat');
            $table->decimal('jumlah_kos');
            $table->dateTime('tarikh_selesai_aduan');
            $table->string('jk_penerangan');
            $table->string('sk_penerangan');
            $table->string('catatan_pembaikan');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aduan');
    }
}
