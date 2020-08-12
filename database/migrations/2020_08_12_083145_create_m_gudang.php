<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableMGudang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('m_gudang');
        Schema::create('m_gudang', function (Blueprint $table) {
            $table->char('id_gudang', 7)->comment('INV-001');
            $table->string('nm_gudang', 100);
            $table->string('alamat', 150);
            $table->enum('status', [1, 0])->comment('1 = Aktif, 0 = Tidak aktif');
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
        Schema::dropIfExists('m_gudang');
    }
}
