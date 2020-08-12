<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableMBarang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('m_barang');
        Schema::create('m_barang', function (Blueprint $table) {
            $table->char('id_barang', 7);
            $table->string('nm_barang', 150);
            $table->string('merk', 100);
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
        Schema::dropIfExists('m_barang');
    }
}
