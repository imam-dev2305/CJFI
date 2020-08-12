<?php

namespace App\Http\Controllers\Inventory;

use App\Model\Inventory\Mutasi;
use App\Http\Controllers\Controller;
use App\Model\Master\Barang;
use App\Model\Master\Gudang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;

class MutasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View::make('inventory.home');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $gudang_tujuan = Gudang::all();
        $gudang_asal = Gudang::all();
        $barang = Barang::all();
        return View::make('inventory.add')->with(['gudang_asal' => $gudang_asal, 'gudang_tujuan' => $gudang_tujuan, 'barang' => $barang]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate_message = [
            'required' => 'Kolom :attribute wajib diisi'
        ];
        $validate_custom_attributes = [
            'mutasi_barang' => 'Barang',
            'mutasi_gd_asal' => 'Gudang Asal',
            'mutasi_gd_tujuan' => 'Gudang Tujuan',
            'mutasi_kuantitas' => 'Kuantitas'
        ];
        $validate = Validator::make($request->all(), [
            'mutasi_barang' => ['required'],
            'mutasi_gd_asal' => ['required'],
            'mutasi_gd_tujuan' => ['required', 'different:mutasi_gd_asal']
        ], $validate_message, $validate_custom_attributes);
        if ($validate->fails()) {
            return redirect('inventory/mutasi/add')
                ->withErrors($validate)
                ->withInput();
        }
        $last_mutasi = Mutasi::latest()->first();
        if ($last_mutasi === null) {
            $no_mutasi = 'MU-001';
        } else {
            $last_no_mutasi = explode('-', $last_mutasi->no_mutasi)[1];
            $next_no_mutasi = intval($last_no_mutasi) + 1;
            $start = 0;
            $jumlah_angka_setelah_nol = strlen($next_no_mutasi);
            $jumlah_digit_no_mutasi = 3;
            $jumlah_nol = "";
            for ($i = $start; $i < ($jumlah_digit_no_mutasi - $jumlah_angka_setelah_nol); $i++) {
                $jumlah_nol .= "0";
            }
            $no_mutasi = "MU-".str_pad($next_no_mutasi, $jumlah_digit_no_mutasi, $jumlah_nol, STR_PAD_LEFT);
        }
        $mutasi = new Mutasi();
        $mutasi->no_mutasi = $no_mutasi;
        $mutasi->id_barang = $request->mutasi_barang;
        $mutasi->gd_asal = $request->mutasi_gd_asal;
        $mutasi->gd_tujuan = $request->mutasi_gd_tujuan;
        $mutasi->quantity = $request->mutasi_kuantitas;
        $mutasi->create_by = Auth::user()->id_user;
        $mutasi->save();
        $update_stok_gd_asal = DB::table('m_stok_barang')
            ->where('id_barang', $request->mutasi_barang)
            ->where('id_gudang', $request->mutasi_gd_asal)
            ->update(["stok" => ($request->mutasi_kuantitas_tersedia - $request->mutasi_kuantitas)]);
        $stok_tujuan = DB::table('m_stok_barang')
            ->where('id_barang', $request->mutasi_barang)
            ->where('id_gudang', $request->mutasi_gd_tujuan)
            ->get();
        if ($stok_tujuan->isEmpty()) {
            $kuantitas_tambahan = $request->mutasi_kuantitas;
            $update_stok_gd_tujuan = DB::table('m_stok_barang')
                ->updateOrInsert(
                    ["id_barang" => $request->mutasi_barang, "id_gudang" => $request->mutasi_gd_tujuan],
                    ["stok" => $kuantitas_tambahan, "create_by" => Auth::user()->id_user]
                );
        } else {
            $kuantitas_tambahan = ($request->mutasi_kuantitas + $stok_tujuan[0]->stok);
            $update_stok_gd_tujuan = DB::table('m_stok_barang')
                ->where('id_barang', $request->mutasi_barang)
                ->where('id_gudang', $request->mutasi_gd_tujuan)
                ->update(["stok" => $kuantitas_tambahan, "update_by" => Auth::user()->id_user]);
        }
        if (!$mutasi->wasChanged()) {
            return redirect('inventory/mutasi/add')
                ->with('status', 'Berhasil menambahkan mutasi');
        } else {
            return redirect('inventory/mutasi/add')
                ->with('status', 'Gagal menambahkan mutasi');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $mutasi = DB::table('t_mutasi')
            ->join('m_barang', 't_mutasi.id_barang', '=', 'm_barang.id_barang')
            ->join(DB::raw('m_gudang c'), 't_mutasi.gd_asal', '=', 'c.id_gudang')
            ->join(DB::raw('m_gudang d'), 't_mutasi.gd_tujuan', '=', 'd.id_gudang')
            ->select(DB::raw('no_mutasi, m_barang.nm_barang, c.nm_gudang as gd_asal, d.nm_gudang as gd_tujuan, quantity'))
            ->get();
        return response()->json(["data" => $mutasi]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
