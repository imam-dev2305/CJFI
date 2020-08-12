<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;

class Gudang extends Model
{
    protected $table = 'm_gudang';
    protected $fillable = ['id_gudang', 'nm_gudang', 'alamat', 'status', 'create_by', 'update_by'];
    protected $primaryKey = 'id_gudang';
    protected $hidden = [
        'created_at', 'updated_at'
    ];
    public $incrementing = false;
}
