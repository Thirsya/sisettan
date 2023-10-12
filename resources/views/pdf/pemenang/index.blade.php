<style type="text/css">
    table {
        border: 1px solid black;
        border-collapse: collapse;
        padding-top: 0px;
        padding-bottom: 0px;
        font-size: 10px;
        font-family: "Courier";
        font-weight: bold;
        margin: 0 auto;
        /* Tambahkan ini untuk mengatur margin otomatis */
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

<center style="font-family:'Arial';font-size: 15px;"><b>KONTROL 5 PEMENANG LELANG SEWA TANAH PERTANIAN
        {{ $daerahList->kelurahan }}</b><br>
    <br><br>
    <table>
        <thead>
            <tr class="btbl">
                <th rowspan="2">No</th>
                <th rowspan="2">Bukti Hak</th>
                <th rowspan="2">Luas</th>
                <th rowspan="2">Harga Dasar</th>
                <th colspan="3">Pemenang I</th>
                <th colspan="2">Pemenang II</th>
                <th colspan="2">Pemenang III</th>
                <th colspan="2">Pemenang IV</th>
                <th colspan="2">Pemenang V</th>
                <th colspan="1">Keterangan</th>
            </tr>
            <tr>
                <th>T.Luas</th>
                <th>Nama</th>
                <th>Nilai</th>
                <th>Nama</th>
                <th>Nilai</th>
                <th>Nama</th>
                <th>Nilai</th>
                <th>Nama</th>
                <th>Nilai</th>
                <th>Nama</th>
                <th>Nilai</th>
            </tr>

        </thead>
        @foreach ($penawaran->groupBy('idfk_tkd') as $idfk_tkd => $listPenawaran)
            @php
                $firstPenawaran = $listPenawaran->first();
                $winners = $winnersWithDetails[$idfk_tkd] ?? [];
            @endphp
            <tr>
                <th>{{ $loop->iteration }}</th>
                <th>{{ $firstPenawaran->bukti }}</th>
                <th>{{ $firstPenawaran->luas }}</th>
                <th>{{ $firstPenawaran->harga_dasar }}</th>
                <th>{{ $firstPenawaran->total_luas }}</th>

                @php
                    $numWinners = count($winners);
                @endphp

                @foreach ($winners as $winner)
                    <th>{{ $winner->nama }}</th>
                    <th>{{ $winner->nilai_penawaran }}</th>
                @endforeach

                @for ($i = $numWinners; $i < 5; $i++)
                    <th></th>
                    <th></th>
                @endfor

                <th>{{ $firstPenawaran->keterangan }}</th>
            </tr>
        @endforeach


    </table>
</center>
