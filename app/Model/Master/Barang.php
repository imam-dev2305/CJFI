<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'm_barang';
    protected $fillable = ['id_barang', 'nm_barang', 'merk', 'create_by', 'update_by'];
    protected $primaryKey = 'id_barang';
    protected $hidden = [
        'created_at', 'updated_at'
    ];
    public $incrementing = false;
}
