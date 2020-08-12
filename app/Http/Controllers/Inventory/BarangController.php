<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    function stok(Request $request)
    {
        $barang = $request->barang;
        $gudang = $request->gudang;
        if (empty($barang) || empty($gudang)) {
            return response()->json(["stok" => 0]);
        } else {
            $stok = DB::table('m_stok_barang')
                ->where('id_barang', '=', $barang)
                ->where('id_gudang', '=', $gudang)
                ->get();
            if (!$stok->isEmpty()) {
                return response()->json(["stok" => $stok[0]->stok]);
            } else {
                return response()->json(["stok" => 0]);
            }
        }
    }
}
