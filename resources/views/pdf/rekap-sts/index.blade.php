<style>
    .tepi {
        width: 100%;
        height: auto;
        border: 2px ridge black;
    }
</style>

<center>
    <p style="font-size: 9px">Aplikasi Lelang TKD BPPKAD Kota Kediri</p>
    <img src="storage/images/kota.png" style="width: 50px;height: auto;float: left">
    <h5>PEMERINTAH KOTA KEDIRI</h5>
    <div class="tepi"></div>
    <br>
    <center style="font-weight: bold">
        REKAPITULASI PEMENANG LELANG TAHUN {{ $daerahList->tahun }}<BR>
        TANAH KAS DESA {{ $daerahList->kelurahan }}<br>
    </center> <br>
    <table style="float: left">
        <tr>
            <td>Nomor </td>
            <td>&nbsp;: </td>
            <td>&nbsp;590/{{ $daerahList->noba }}/TKD//{{ $daerahList->tahun }}</td>
        </tr>
        <tr>
            <td>Periode </td>
            <td>&nbsp;: </td>
            <td>&nbsp;{{ $daerahList->periode }}</td>
        </tr>
    </table>
    <br><br><br>
    <table border="1" style="width:95%;border-color:black;">
        <tr style="border-bottom:3pt double;">
            <th>No</th>
            <th>Nama</th>
            <th>Bidang Tanah</th>
            <th>Luas</th>
            <th>Harga Dasar</th>
            <th>Penawaran</th>
        </tr>
        @php
            $totalNilaiPenawaranSum = 0;
            $totalLuasSum = 0;
            $totalNilaiHargaDasarSum = 0;
        @endphp

        @foreach ($penawarans->groupBy('idfk_daftar') as $groupedPenawarans)
            @php
                $firstPenawaran = $groupedPenawarans->first();
                $totalNilaiPenawaran = 0;
                $totalNilaiHargaDasar = 0;
            @endphp
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>({{ $firstPenawaran->no_urut }}){{ $firstPenawaran->nama }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @foreach ($groupedPenawarans as $penawaran)
                <tr>
                    <td></td>
                    <td></td>
                    <td>{{ $penawaran->bukti }} Bidang {{ $penawaran->bidang }}</td>
                    <td>{{ $penawaran->luas }}</td>
                    <td>{{ $penawaran->harga_dasar }}</td>
                    <td>{{ $penawaran->nilai_penawaran }}</td>
                </tr>
                @php
                    $totalNilaiPenawaran += $penawaran->nilai_penawaran;
                    $totalNilaiHargaDasar += $penawaran->harga_dasar;
                @endphp
            @endforeach
            <tr>
                <td></td>
                <td></td>
                <td>Sub Total</td>
                <td>{{ $penawaran->total_luas }}</td>
                <td>{{ $totalNilaiHargaDasar }}</td>
                <td>{{ $totalNilaiPenawaran }}</td>
            </tr>

            @php
                $totalNilaiPenawaranSum += $totalNilaiPenawaran;
                $totalLuasSum += $penawaran->total_luas;
                $totalNilaiHargaDasarSum += $totalNilaiHargaDasar;
            @endphp
        @endforeach

        <br>
        <tr>
            <th></th>
            <th></th>
            <th>Total</th>
            <th>{{ $totalLuasSum }}</th>
            <th>{{ $totalNilaiHargaDasarSum }}</th>
            <th>{{ $totalNilaiPenawaranSum }}</th>
        </tr>
    </table>
</center>
