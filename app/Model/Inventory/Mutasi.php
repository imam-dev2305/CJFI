<?php

namespace App\Model\Inventory;

use Illuminate\Database\Eloquent\Model;

class Mutasi extends Model
{
    protected $table = 't_mutasi';
    protected $fillable = ['no_mutasi', 'id_barang', 'gd_asal', 'gd_tujuan', 'quantity', 'create_by', 'update_by'];
    protected $primaryKey = 'no_mutasi';
    protected $hidden = [
        'created_at', 'updated_at'
    ];
    public $incrementing = false;

    public function barang()
    {
        return $this->hasMany('App\Model\Master\Barang', 'id_barang', 'id_barang');
    }

    public function gudang_asal()
    {
        return $this->hasMany('App\Model\Master\Gudang', 'id_gudang', 'gd_asal');
    }

    public function gudang_tujuan()
    {
        return $this->hasMany('App\Model\Master\Gudang', 'id_gudang', 'gd_tujuan');
    }
}
