<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = 'm_stok_barang';
    protected $fillable = ['id_barang', 'id_gudang', 'stok', 'create_by', 'update_by'];
    protected $primaryKey = ['id_gudang', 'id_barang'];
    protected $hidden = [
        'created_at', 'updated_at'
    ];
    public $incrementing = false;
}
