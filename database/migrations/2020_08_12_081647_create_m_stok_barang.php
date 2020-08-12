<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableMStokBarang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('m_stok_barang');
        Schema::create('m_stok_barang', function (Blueprint $table) {
            $table->char('id_barang', 7);
            $table->char('id_gudang', 7);
            $table->integer('stok');
            $table->char('create_by', 7);
            $table->char('update_by', 7)->nullable();
            $table->primary(['id_barang', 'id_gudang']);
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
        Schema::dropIfExists('m_stok_barang');
    }
}
