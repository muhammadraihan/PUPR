<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembebasanLahansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembebasan_lahans', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('pekerjaan_id');
            $table->string('kebutuhan');
            $table->string('sudah_bebas');
            $table->string('belum_bebas');
            $table->string('dokumentasi_id');
            $table->string('permasalahan')->nullable();
            $table->string('tindak_lanjut')->nullable();
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
        Schema::dropIfExists('pembebasan_lahans');
    }
}
