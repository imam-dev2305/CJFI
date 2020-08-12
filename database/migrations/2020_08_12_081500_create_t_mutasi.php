<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableTMutasi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_mutasi', function (Blueprint $table) {
            $table->char('no_mutasi', 6)->comment('MI-001, MO-002');
            $table->char('id_barang', 7);
            $table->char('gd_asal', 7)->nullable();
            $table->char('gd_tujuan', 7);
            $table->integer('quantity');
            $table->char('create_by', 7);
            $table->char('update_by', 7)->nullable();
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
        Schema::dropIfExists('t_mutasi');
    }
}
