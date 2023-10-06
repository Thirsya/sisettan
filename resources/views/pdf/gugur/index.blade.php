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

<table>
<thead>
    <tr class="btbl">
        <th>NO</th>
        <th colspan="2">BUKTI | BIDANG</th>
        <th>LETAK</th>
        <th>LUAS</th>
        <th>HARGA DASAR</th>
        <th>NAMA PENAWAR</th>
        <th>NILAI</th>
        <th>KETERANGAN</th>
    </tr>
</thead>
</table>
</center>
