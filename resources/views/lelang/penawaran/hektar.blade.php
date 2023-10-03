@extends('layouts.app')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Table</h1>
        </div>
        <div class="section-body">
            <h2 class="section-title">Luas Melebihi 2 Hektar</h2>
            <div id="page1">
                <br><br><br>
                <div class="card">
                    <div class="card-body">
                        <form method="POST">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-bordered table-md">
                                    <tbody>
                                        <tr style="text-align: center">
                                            <th>No Urut</th>
                                            <th>Nama</th>
                                            <th>Alamat</th>
                                            <th>Bukti Hak</th>
                                            <th>Bidang</th>
                                            <th>Luas</th>
                                            <th>Luas di Menangkan</th>
                                            <th>Harga Dasar</th>
                                            <th>Harga Penawaran</th>
                                            <th>Menu</th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
