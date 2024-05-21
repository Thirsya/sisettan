<style>
    .tepi {
        width: 100%;
        height: auto;
        border: 2px ridge black;
    }
</style>

<center>
    <p style="font-size: 9px">Aplikasi Lelang TKD BPPKAD Kota Kediri</p>
    <div class="tepi"></div>
    <center>
        <h3>Rekap Hasil Lelang Berdasarkan Lampiran BA</h3>
    </center>
    <table style="float: left">
        <tr>
            <td style="font-weight: bold">Rekap PerKelurahan</td>
        </tr>
    </table>
    <br><br>
    <table border="1" style="width:95%;border-color:black;">
        <tr style="font-size: 9px; font-weight: normal;">
            <th>No</th>
            <th>Kelurahan</th>
            <th>Jumlah Bidang</th>
            <th>Jumlah Luas Bidang (m2)</th>
            <th>Jumlah Harga Dasar (Rp)</th>
            <th>Jumlah Harga Penawaran (Rp)</th>
            <th>Peserta</th>
            <th>Penawaran</th>
            <th>Tidak Laku</th>
        </tr>
        @foreach ($cetakSekota as $listCetakSekota)
            <tr>
                <td style="text-align: right">{{ $loop->iteration }}</td>
                <td>{{ $listCetakSekota->kelurahan }}</td>
                <td style="text-align: right">{{ number_format($listCetakSekota->total_bidang, 0, ',', '.') }}
                <td style="text-align: right">{{ number_format($listCetakSekota->total_luas, 0, ',', '.') }}
                <td style="text-align: right">
                    {{ number_format($listCetakSekota->total_harga_dasar, 0, ',', '.') }}
                <td style="text-align: right">
                    {{ number_format($listCetakSekota->total_nilai_penawaran, 0, ',', '.') }}
                <td style="text-align: right">{{ number_format($listCetakSekota->total_daftar, 0, ',', '.') }}
                <td style="text-align: right">
                    {{ number_format($listCetakSekota->total_penawaran, 0, ',', '.') }}
                <td style="text-align: right">
                    {{ number_format($listCetakSekota->total_tidak_laku, 0, ',', '.') }}
            </tr>
        @endforeach
        @php
            $totalBidang = $totalLuas = $totalHargaDasar = $totalNilaiPenawaran = $totalDaftar = $totalPenawaran = $totalTidakLaku = 0;
        @endphp
        @foreach ($cetakSekota as $listCetakSekota)
            @php
                $totalBidang += $listCetakSekota->total_bidang;
                $totalLuas += $listCetakSekota->total_luas;
                $totalHargaDasar += $listCetakSekota->total_harga_dasar;
                $totalNilaiPenawaran += $listCetakSekota->total_nilai_penawaran;
                $totalDaftar += $listCetakSekota->total_daftar;
                $totalPenawaran += $listCetakSekota->total_penawaran;
                $totalTidakLaku += $listCetakSekota->total_tidak_laku;
            @endphp
            <!-- ... -->
        @endforeach
        <tr>
            <td colspan="2" style="text-align: left;font-weight:bold">Total:</td>
            <td style="text-align: right">{{ number_format($totalBidang, 0, ',', '.') }}</td>
            <td style="text-align: right">{{ number_format($totalLuas, 0, ',', '.') }}</td>
            <td style="text-align: right">{{ number_format($totalHargaDasar, 0, ',', '.') }}</td>
            <td style="text-align: right">{{ number_format($totalNilaiPenawaran, 0, ',', '.') }}</td>
            <td style="text-align: right">{{ number_format($totalDaftar, 0, ',', '.') }}</td>
            <td style="text-align: right">{{ number_format($totalPenawaran, 0, ',', '.') }}</td>
            <td style="text-align: right">{{ number_format($totalTidakLaku, 0, ',', '.') }}</td>
        </tr>
    </table>
    <br><br>
    <table style="float: left">
        <tr>
            <td style="font-weight: bold">Rekap PerKecamatan</td>
        </tr>
    </table>
    <br><br>
    <table border="1" style="width:95%;border-color:black;">
        <tr style="font-size: 9px; font-weight: normal;">
            <th>Kecamatan</th>
            <th>Jumlah Luas Bidang (m2)</th>
            <th>Jumlah Harga Dasar (Rp)</th>
            <th>Jumlah Harga Penawaran (Rp)</th>
        </tr>
        @foreach ($cetakSekotaKecamatan as $listCetakSekotaKecamatan)
            <tr>
                <td>Kec. {{ $listCetakSekotaKecamatan->kecamatan }}</td>
                <td style="text-align: right">{{ number_format($listCetakSekotaKecamatan->total_luas, 0, ',', '.') }}
                <td style="text-align: right">
                    {{ number_format($listCetakSekotaKecamatan->total_harga_dasar, 0, ',', '.') }}
                <td style="text-align: right">
                    {{ number_format($listCetakSekotaKecamatan->total_nilai_penawaran, 0, ',', '.') }}
            </tr>
        @endforeach
        @php
            $totalLuas = $totalHargaDasar = $totalNilaiPenawaran = 0;
        @endphp
        @foreach ($cetakSekotaKecamatan as $listCetakSekotaKecamatan)
            @php
                $totalLuas += $listCetakSekotaKecamatan->total_luas;
                $totalHargaDasar += $listCetakSekotaKecamatan->total_harga_dasar;
                $totalNilaiPenawaran += $listCetakSekotaKecamatan->total_nilai_penawaran;
            @endphp
            <!-- ... -->
        @endforeach
        <tr>
            <td style="text-align: left;font-weight:bold">Total:</td>
            <td style="text-align: right">{{ number_format($totalLuas, 0, ',', '.') }}</td>
            <td style="text-align: right">{{ number_format($totalHargaDasar, 0, ',', '.') }}</td>
            <td style="text-align: right">{{ number_format($totalNilaiPenawaran, 0, ',', '.') }}</td>
        </tr>
    </table>
</center>
