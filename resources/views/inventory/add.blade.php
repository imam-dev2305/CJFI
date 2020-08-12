@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">Tambah Mutasi</h1>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $("#mutasi_barang, #mutasi_gd_asal").on("change", function () {
                $.ajax({
                    url: "{{ route('inventory.barang.stok') }}",
                    type: "POST",
                    data: {barang: $("#mutasi_barang").val(), gudang: $("#mutasi_gd_asal").val()},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (respon) {
                        $("#mutasi_kuantitas_tersedia").val(respon.stok);
                    }
                });
            });

            $("#btn_submit").on("click", function () {
                if ($("#mutasi_kuantitas_tersedia") < $("#mutasi_kuantitas")) {
                    alert("Tidak dapat melakukan mutasi karena stok kurang");
                } else {
                    document.getElementById("frm-add-mutasi").submit();
                }
            });
        });
    </script>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    @if(session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <form name="frm-add-mutasi" id="frm-add-mutasi" action="{{ route('inventory.mutasi.store') }}" method="post">
                        @csrf
                        <div class="form-group row">
                            <label class="col-md-3">Barang</label>
                            <div class="col-md-5">
                                <select name="mutasi_barang" id="mutasi_barang" required class="form-control">
                                    <option disabled selected></option>
                                    @foreach($barang as $key=>$val)
                                        <option value="{{ $val->id_barang }}">{{ $val->nm_barang }}</option>
                                    @endforeach
                                </select>
                                @error('mutasi_barang')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3">Gudang Asal</label>
                            <div class="col-md-5">
                                <select name="mutasi_gd_asal" id="mutasi_gd_asal" required class="form-control">
                                    <option disabled selected></option>
                                    @foreach($gudang_asal as $key=>$val)
                                        <option value="{{ $val->id_gudang }}">{{ $val->nm_gudang }}</option>
                                    @endforeach
                                </select>
                                @error('mutasi_gd_asal')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3">Gudang Tujuan</label>
                            <div class="col-md-5">
                                <select name="mutasi_gd_tujuan" id="mutasi_gd_tujuan" class="form-control">
                                    <option disabled selected></option>
                                    @foreach($gudang_tujuan as $key=>$val)
                                        <option value="{{ $val->id_gudang }}">{{ $val->nm_gudang }}</option>
                                    @endforeach
                                </select>
                                @error('mutasi_gd_tujuan')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3">Stok tersedia</label>
                            <div class="col-md-5">
                                <input type="text" name="mutasi_kuantitas_tersedia" id="mutasi_kuantitas_tersedia" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3">Kuantitas</label>
                            <div class="col-md-5">
                                <input type="text" name="mutasi_kuantitas" id="mutasi_kuantitas" class="form-control">
                                @error('mutasi_kuantitas')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <button type="submit" id="btn_submit" class="btn btn-primary"><span class="fa fa-save"></span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
