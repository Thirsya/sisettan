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
        <H2>PEMENANG LELANG SEWA TANAH PERTANIAN</H2>
        MASA TANAM {{ $daerahList->periode }}
    </center>
    <table style="float: right;font-size:13px;">
        <tr>
            <td>LAMPIRAN BERITA ACARA </td>
        </tr>
        <tr>
            <td>Nomor</td>
            <td>&nbsp;: </td>
            <td>&nbsp;590/{{ $daerahList->noba }}//<?= date('Y') ?></td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td>&nbsp;: </td>
            <td>&nbsp;<?= date('d/m/Y') ?></td>
        </tr>
    </table>
    <br><br>
    <table style="float: left;font-size:13px;">
        <tr>
            <td>{{ $daerahList->kelurahan }}</td>
        </tr>
    </table>
    <br><br>
    <table border="1" style="font-size:12px;width:95%;border-color:black;">
        <tr style="font-weight: normal;">
            <th rowspan="2">No</th>
            <th rowspan="2">Bukti Hak</th>
            <th rowspan="2">Alamat</th>
            <th rowspan="2">Harga Dasar</th>
            <th colspan="2">Obyek</th>
            <th colspan="2">Penawar Tertinggi I</th>
            <th colspan="2">Penawar Tertinggi II</th>
        </tr>
        <tr>
            <th>Bidang</th>
            <th>Luas</th>
            <th>Nama</th>
            <th>Harga Penawaran</th>
            <th>Nama</th>
            <th>Harga Penawaran</th>
        </tr>
        @foreach ($penawarans->groupBy('idfk_tkd') as $listPenawaran)
            @php
                $firstPenawaran = $listPenawaran->first();
                $totalNilaiPenawaran = 0;
                $totalNilaiHargaDasar = 0;
                $totalNilaiLuas = 0;
            @endphp
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $firstPenawaran->bukti }}</td>
                <td>{{ $firstPenawaran->letak }}</td>
                <td>{{ $firstPenawaran->harga_dasar }}</td>
                <td>{{ $firstPenawaran->bidang }}</td>
                <td>{{ $firstPenawaran->luas }}</td>
                <td>{{ $firstPenawaran->nama }}</td>
                <td>{{ $firstPenawaran->nilai_penawaran }}</td>
                <td>{{ $firstPenawaran->nama2 }}</td>
                <td>{{ $firstPenawaran->nilai_penawaran2 }}</td>
            </tr>
        @endforeach
    </table><br>
    <table style="float: right; text-align: center; padding-right: 30px">
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
