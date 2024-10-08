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
    <br>
    <center style="font-weight: bold">
        TANAH PERTANIAN BEKAS KAS DESA<br>
        YANG TIDAK TERPILIH PADA LELANG
    </center> <br>
    <table style="float: right">
        <tr>
            <td>Lampiran 2 Berita Acara </td>
        </tr>
    </table>
    <br><br><br>
    <table style="float: left">
        <tr>
            <td>{{ $daerahList->kelurahan }}</td>
        </tr>
    </table>
    <br><br>
    <table border="1" style="width:95%;border-color:black;">
        <tr style="font-size: 14px; font-weight: normal;">
            <th rowspan="2">No</th>
            <th rowspan="2">Bukti</th>
            <th rowspan="2">Alamat</th>
            <th rowspan="2">Harga Dasar</th>
            <th colspan="2">Obyek</th>
        </tr>
        <tr>
            <th>Bidang</th>
            <th>Luas</th>
        </tr>
        @foreach ($penawarans as $listPenawaran)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $listPenawaran->bukti }}</td>
                <td>{{ $listPenawaran->letak }}</td>
                <td>Rp {{ number_format($listPenawaran->harga_dasar, 0, ',', '.') }}</td>
                <td>{{ $listPenawaran->bidang }}</td>
                <td>{{ number_format($listPenawaran->luas, 0, ',', '.') }} m<sup>2</sup></td>
            </tr>
        @endforeach
    </table>
    <br><br>
    <table style="float: right; text-align: center">
        <tr>
            <td>Selaku </td>
        </tr>
        <tr>
            <td>Pengguna Barang </td>
        </tr>
        <tr>
            <td>Milik Pemerintah Kota Kediri </td>
        </tr><br><br><br><br><br>
        <tr>
            <td>NIP.</td>
        </tr>
    </table>
</center>
