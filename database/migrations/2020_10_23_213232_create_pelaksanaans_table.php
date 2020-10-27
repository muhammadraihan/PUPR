<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePelaksanaansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pelaksanaans', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('pekerjaan_id')->nullable();
            $table->bigInteger('nomor_pelaksanaan')->nullable();
            $table->date('tanggal_pelaksanaan')->nullable();
            $table->float('rencana_fisik',8,2)->nullable();
            $table->float('realisasi_fisik',8,2)->nullable();
            $table->float('deviasi_fisik',8,2)->nullable();
            $table->float('rencana_keuangan',8,2)->nullable();
            $table->float('realisasi_keuangan',8,2)->nullable();
            $table->float('deviasi_keuangan',8,2)->nullable();
            $table->text('permasalahan')->nullable();
            $table->text('tindakan')->nullable();
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
        Schema::dropIfExists('pelaksanaans');
    }
}
