<style type="text/css">
    table{
        border: 1px solid black;
        border-collapse: collapse;
        padding-top: 0px;
        padding-bottom: 0px;
        font-size: 10px;
        font-family: "Courier";
        font-weight: bold;
        margin: 0 auto; /* Tambahkan ini untuk mengatur margin otomatis */
    }

    th {
        border: 1px solid black;
        border-collapse: collapse;
        padding-top: 0px;
        padding-bottom: 0px;
        font-family: 'Arial';
        text-align: center;
    }
    .btbl {
        border-bottom: 2px solid black;
    }
</style>

<center style="font-family:'Arial';font-size: 15px;"><b>PEMENANG LELANG SEWA TANAH PERTANIAN YANG GUGUR {{ $daerahList->kelurahan }}</b><br>
Masa Sewa {{ $daerahList->periode }}<br>
<br><br>
<table>
<thead>
    <tr class="btbl">
        <th>NO</th>
        <th>BUKTI</th>
        <th>BIDANG</th>
        {{-- <th>LETAK</th> --}}
        <th>LUAS</th>
        <th>HARGA DASAR</th>
        <th>NAMA PENAWAR</th>
        <th>NILAI</th>
        <th>KETERANGAN</th>
    </tr>
    @foreach ($penawarans as $key => $penawaran)
        <tr class="btbl">
            <td>{{ $loop->iteration }}</td>
            <th>{{ $penawaran->bukti }}</th>
            <th>{{ $penawaran->bidang }}</th>
            {{-- <th>{{ $penawaran->alamat }}</th> --}}
            <th>{{ number_format($penawaran->luas, 0, ',', '.') }} m<sup>2</sup></th>
            <th>Rp {{ number_format($penawaran->harga_dasar, 0, ',', '.') }}</th>
            <th>{{ $penawaran->nama }}</th>
            <th>Rp {{ number_format($penawaran->nilai_penawaran, 0, ',', '.') }}</th>
            <th>{{ $penawaran->keterangan }}</th>
        </tr>
    @endforeach
</thead>
</table>
</center>
