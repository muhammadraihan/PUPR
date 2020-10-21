<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataKontraksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_kontraks', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('pekerjaan_id');
            $table->string('pagu');
            $table->string('nilai_kontrak');
            $table->string('panjang_jalan')->nullable();
            $table->string('panjang_jembatan')->nullable();
            // $table->string('lokasi');
            $table->string('tahun_anggaran');
            $table->date('tanggal_kontrak_awal');
            $table->date('tanggal_adendum_kontrak');
            $table->date('tanggal_adendum_akhir');
            $table->date('tanggal_pho');
            $table->date('tanggal_fho');
            $table->string('keterangan');
            $table->string('created_by')->nullable();
            $table->string('edited_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_kontraks');
    }
}
