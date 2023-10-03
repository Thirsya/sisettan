@extends('layouts.app')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Table</h1>
        </div>
        <div class="section-body">
            <h2 class="section-title">STS Pemenang</h2>
            <a class="btn btn-info btn-primary active bg-primary" onclick="showPage(1)">(STS) Pemenang 1</a>
            <a class="btn btn-info btn-primary active bg-primary" onclick="showPage(2)">(STS) Pemenang 2</a>
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
                                            <th>Bukti Hak</th>
                                            <th>Bidang</th>
                                            <th>Luas</th>
                                            <th>Penawaran</th>
                                            <th style="width: 250px">Tanggal Perjanjian</th>
                                            <th style="width: 550px">Menu</th>
                                        </tr>
                                        @foreach ($penawaran as $key => $listPenawaran)
                                            <tr>
                                                <td>{{ $listPenawaran->no_urut }}</td>
                                                <td>{{ $listPenawaran->nama }}</td>
                                                <td>{{ $listPenawaran->bukti }}</td>
                                                <td>{{ $listPenawaran->bidang }}</td>
                                                <td>{{ number_format($listPenawaran->luas, 0, ',', '.') }}m<sup>2</sup></td>
                                                <td>Rp {{ number_format($listPenawaran->nilai_penawaran, 0, ',', '.') }}
                                                </td>
                                                <td>
                                                    <form class="updateDateForm" data-id="{{ $listPenawaran->id }}">
                                                        <input type="date" class="tgl_perjanjian_input"
                                                            name="tgl_perjanjian"
                                                            value="{{ $listPenawaran->tgl_perjanjian }}">
                                                        <button type="submit"
                                                            class="ml-2 btn btn-sm btn-success btn-icon">Save</button>
                                                    </form>
                                                </td>

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
                                                        <a href="#" data-id="{{ $listPenawaran->id }}"
                                                            class="ml-2 btn btn-sm btn-danger btn-icon gugur">Di
                                                            Gugurkan</a>
                                                        <a href="{{ route('sts.print', $listPenawaran->id) }}"
                                                            target="_blank" class="ml-2 btn btn-sm btn-info btn-icon">Cetak
                                                            STS</a>

                                                        <a href="{{ route('sts.cetakpernyataan') }}" class="ml-2 btn btn-sm btn-info btn-icon ">Cetak
                                                            Pernyataan</a>
                                                        <a href="{{ route('sts.cetakperjanjian') }}" class="ml-2 btn btn-sm btn-info btn-icon ">Cetak
                                                            Perjanjian</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer text-right">
                                <a class="btn btn-primary" href="{{ route('penawaran.index') }}">Selesai</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div id="page2" style="display: none">
                <br><br><br>
                <div class="card">
                    <div class="card-body">
                        <form method="POST">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-bordered table-md">
                                    <tbody>
                                        <tr style="text-align: center">
                                            <th>No Urut 2</th>
                                            <th>Nama</th>
                                            <th>Bukti Hak</th>
                                            <th>Bidang</th>
                                            <th>Luas</th>
                                            <th>Penawaran</th>
                                            <th style="width: 250px">Tanggal Perjanjian</th>
                                            <th style="width: 550px">Menu</th>
                                        </tr>
                                        @foreach ($penawaran2 as $key => $listPenawaran)
                                            <tr>
                                                <td>{{ $listPenawaran->no_urut }}</td>
                                                <td>{{ $listPenawaran->nama }}</td>
                                                <td>{{ $listPenawaran->bukti }}</td>
                                                <td>{{ $listPenawaran->bidang }}</td>
                                                <td>{{ number_format($listPenawaran->luas, 0, ',', '.') }}m<sup>2</sup>
                                                </td>
                                                <td>Rp {{ number_format($listPenawaran->nilai_penawaran, 0, ',', '.') }}
                                                </td>
                                                <td>
                                                    <form class="updateDateForm" data-id="{{ $listPenawaran->id }}">
                                                        <input type="date" class="tgl_perjanjian_input"
                                                            name="tgl_perjanjian"
                                                            value="{{ $listPenawaran->tgl_perjanjian }}">
                                                        <button type="submit"
                                                            class="ml-2 btn btn-sm btn-success btn-icon">Save</button>
                                                    </form>
                                                </td>

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
                                                        <a href="#" data-id="{{ $listPenawaran->id }}"
                                                            class="ml-2 btn btn-sm btn-danger btn-icon gugur">Di
                                                            Gugurkan</a>
                                                        <a href="{{ route('sts.print', $listPenawaran->id) }}"
                                                            target="_blank" class="ml-2 btn btn-sm btn-info btn-icon">Cetak
                                                            STS</a>

                                                        <a href="#" class="ml-2 btn btn-sm btn-info btn-icon ">Cetak
                                                            Pernyataan</a>
                                                        <a href="#" class="ml-2 btn btn-sm btn-info btn-icon ">Cetak
                                                            Perjanjian</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer text-right">
                                <a class="btn btn-primary" href="{{ route('penawaran.index') }}">Selesai</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </section>
@endsection
@push('customScript')
    <script src="/assets/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.gugur').on('click', function(e) {
                e.preventDefault();

                let penawaranId = $(this).data('id');

                $.ajax({
                    type: 'POST',
                    url: /lelang/sts / $ {
                        penawaranId
                    }
                    /gugur,
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(data) {
                        alert(data.message);

                        // Reload the entire page
                        location.reload();
                    },
                    error: function(error) {
                        alert('Error updating data.');
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.updateDateForm').on('submit', function(e) {
                    e.preventDefault();
                    let penawaranId = $(this).data('id');
                    let tgl_perjanjian = $(this).find('.tgl_perjanjian_input').val();
                    console.log(tgl_perjanjian);
                    $.post(/lelang/sts / $ {
                            penawaranId
                        }
                        /update-date, {
                        "_token": "{{ csrf_token() }}",
                        "tgl_perjanjian": tgl_perjanjian
                    })
                .done(function(data) {
                    alert(data.message);
                    location.reload();
                })
                .fail(function(error) {
                    console.error(error);
                    alert('Error updating date.');
                });
            });
        });
    </script>
    <script>
        function showPage(pageNumber) {
            for (let i = 1; i <= 2; i++) {
                const page = document.getElementById(`page${i}`);
                if (page) {
                    page.style.display = 'none';
                }
            }

            const currentPage = document.getElementById(`page${pageNumber}`);
            if (currentPage) {
                currentPage.style.display = 'block';
            }
        }
    </script>
@endpush

@push('customStyle')
    <link rel="stylesheet" href="/assets/css/select2.min.css">
@endpush
