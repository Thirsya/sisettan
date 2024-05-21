<style>
    .tepi {
        width: 100%;
        height: auto;
        border: 2px ridge black;
    }
</style>

<center>
    <p style="font-size: 9px">Aplikasi Lelang TKD BPPKAD Kota Kediri</p>
    {{-- <img src="public/images/kota.png" style="width: 50px;height: auto;float: left"> --}}
    <img src="{{ public_path('images/kota.png') }}" style="width: 50px; height: auto; float: left;">
    <h5>PEMERINTAH KOTA KEDIRI</h5>
    <div class="tepi"></div>
    <br>
    <center style="font-weight: bold">
        REKAPITULASI PEMENANG LELANG TAHUN {{ $tahunSelected }}<BR>
        TANAH KAS DESA {{ $daerahList->kelurahan }}<br>
    </center> <br>
    <table style="float: left">
        <tr>
            <td>Nomor </td>
            <td>&nbsp;: </td>
            <td>&nbsp;590/{{ $daerahList->noba }}/TKD//{{ $tahunSelected }}</td>
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
                $totalNilaiLuas = 0;
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
                    <td>{{ number_format($penawaran->luas, 0, ',', '.') }} m<sup>2</td>
                    <td>Rp {{ number_format($penawaran->harga_dasar, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($penawaran->nilai_penawaran, 0, ',', '.') }}</td>
                </tr>
                @php
                    $totalNilaiLuas += $penawaran->luas;
                    $totalNilaiPenawaran += $penawaran->nilai_penawaran;
                    $totalNilaiHargaDasar += $penawaran->harga_dasar;
                @endphp
            @endforeach
            <tr>
                <td></td>
                <td></td>
                <td>Sub Total</td>
                <td>{{ number_format($totalNilaiLuas, 0, ',', '.') }} m<sup>2</td>
                <td>Rp {{ number_format($totalNilaiHargaDasar, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($totalNilaiPenawaran, 0, ',', '.') }}</td>
            </tr>

            @php
                $totalNilaiPenawaranSum += $totalNilaiPenawaran;
                $totalLuasSum += $totalNilaiLuas;
                $totalNilaiHargaDasarSum += $totalNilaiHargaDasar;
            @endphp
        @endforeach

        <br>
        <tr>
            <th></th>
            <th></th>
            <th>Total</th>
            <th>{{ number_format($totalLuasSum, 0, ',', '.') }} m<sup>2</th>
            <th>Rp {{ number_format($totalNilaiHargaDasarSum, 0, ',', '.') }}</th>
            <th>Rp {{ number_format($totalNilaiPenawaranSum, 0, ',', '.') }}</th>
        </tr>
    </table>
</center>
