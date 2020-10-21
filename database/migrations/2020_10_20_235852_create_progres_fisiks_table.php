<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgresFisiksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('progres_fisiks', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->decimal('rencana',3,1)->nullable();
            $table->decimal('realisasi',3,1)->nullable();
            $table->decimal('devisiasi',3,1)->nullable();
            $table->text('permasalahan')->nullable();
            $table->text('tindakan')->nullable();
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
        Schema::dropIfExists('progres_fisiks');
    }
}
