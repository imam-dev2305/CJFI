@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">Mutasi</h1>
@stop

@section('js')
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#example').dataTable({
                ajax: '{{ route('inventory.mutasi.data') }}',
                columns: [
                    {data: "no_mutasi"},
                    {data: "nm_barang"},
                    {data: "gd_asal"},
                    {data: "gd_tujuan"},
                    {data: "quantity"}
                ]
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
                    <div class="row">
                        <a class="btn btn-primary" href="{{ route('inventory.mutasi.add') }}" title="Tambah Mutasi Baru"><span class="fa fa-plus"></span></a>
                    </div>
                </div>
                <div class="card-body">
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                        <tr>
                            <th>No Mutasi</th>
                            <th>Barang</th>
                            <th>Gudang Asal</th>
                            <th>Gudang Tujuan</th>
                            <th>Kuantitas</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>No Mutasi</th>
                            <th>Barang</th>
                            <th>Gudang Asal</th>
                            <th>Gudang Tujuan</th>
                            <th>Kuantitas</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
