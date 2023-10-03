@extends('layouts.app')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Table</h1>
        </div>
        <div class="section-body">
            <h2 class="section-title">Luas Melebihi 2 Hektar</h2>
            <div id="page1">
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
                                            {{-- <th>Luas di Menangkan</th> --}}
                                            <th>Harga Dasar</th>
                                            <th>Harga Penawaran</th>
                                            <th>Menu</th>
                                        </tr>
                                        @foreach ($penawaran as $key => $listPenawaran)
                                            <tr>
                                                <td>{{ $listPenawaran->no_urut }}</td>
                                                <td>{{ $listPenawaran->nama }}</td>
                                                <td>{{ $listPenawaran->alamat }}</td>
                                                <td>{{ $listPenawaran->bukti }}</td>
                                                <td>{{ $listPenawaran->bidang }}</td>
                                                <td>{{ number_format($listPenawaran->luas, 0, ',', '.') }}m<sup>2</sup></td>
                                                <td>Rp {{ number_format($listPenawaran->harga_dasar, 0, ',', '.') }}</td>
                                                <td>Rp {{ number_format($listPenawaran->nilai_penawaran, 0, ',', '.') }}</td>
                                                <td>
                                                    <div class="d-flex justify-content-end">
                                                        <form action="{{ route('penawaran.destroy', $listPenawaran->id) }}"
                                                            method="POST" class="ml-2">
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <input type="hidden" name="_token"
                                                                value="{{ csrf_token() }}">
                                                            <button class="btn btn-sm btn-danger btn-icon confirm-delete"
                                                                type="submit">
                                                                <i class="fas fa-times"></i> Delete </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
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
