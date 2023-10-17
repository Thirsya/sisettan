<style>
    .tepi {
      width:100%;
      height:auto;
      border: 2px ridge black;
    }

    td.colored-column,
    th.colored-column {
        border: 1px solid white;
    }
 </style>

<center>
    <p style="font-size: 9px">Aplikasi Lelang TKD BPPKAD Kota Kediri</p>
    <div class="tepi"></div>
    <br>
    <center style="font-weight: bold">
        <H2>PEMERINTAH KOTA KEDIRI</H2>
        SURAT TANDA SETORAN
        <H2>(STS)</H2>
    </center> <br>
    <table style="float: right">
        <tr>
           <td>Bank </td>
           <td>&nbsp;: </td>
           <td>&nbsp;Bank Jatim </td>
       </tr>
       <tr>
           <td>No. Rek </td>
           <td>&nbsp;: </td>
           <td>&nbsp;0061018399</td>
       </tr>
    </table>
    <br><br><br>
    <table style="float: left">
         <tr>
            <td>Harap diterima uang sebesar </td>
            <td>&nbsp;: </td>
            <td>&nbsp;Rp  </td>
        </tr>
        <tr>
            <td>Dengan Huruf </td>
            <td>&nbsp;: </td>
            <td>&nbsp;...</td>
        </tr>
    </table>
    <br><br><br>
    <p style="float: left">Dengan Perincian Sebagai Berikut :</p><br><br>
    <table border="1" style="width:95%;border-color:black;">
        <tr  style="font-size: 14px; font-weight: normal;">
            <th>Kode Rekening</th>
            <th style="width: 400px">Uraian</th>
            <th>Jumlah (Rp)</th>
        </tr>
        <tr>
            <td>4.1.4.03.01.001</td>
            <td align="justify" style="text-align: justify;">
                Penerimaan Hasil Lelang Sewa Bekas Tanah Kas Desa
                Pembayaran terhadap Sewa Tanah Bekas Tanah
                Kas Desa Milik Pemerintah Kota Kediri sesuai Berita Acara
                <table>
                    <tr>
                      <td class="colored-column">Nomor </td>
                      <td class="colored-column">&nbsp;:</td>
                      <td class="colored-column">590/{{ $daerahList->noba }}//<?= date('Y') ?></td>
                    </tr>
                    <tr>
                      <td class="colored-column">Tanggal </td>
                      <td class="colored-column">&nbsp;:</td>
                      <td class="colored-column">Kediri, <?php echo date("d/m/Y"); ?></td>
                    </tr>
                    <tr>
                        <td class="colored-column">Tentang </td>
                        <td class="colored-column">&nbsp;:</td>
                        <td class="colored-column">Pelaksanaan Lelang Sewa Tanah Pertanian Bekas Tanah Kas Desa {{ $daerahList->kelurahan }}</td>
                    </tr>
                    <tr>
                        <td class="colored-column">Bukti Hak </td>
                        <td class="colored-column">&nbsp;:</td>
                        <td class="colored-column">{{ $daerahList->bukti }} bidang {{ $daerahList->bidang}} lokasi {{ $daerahList->letak }}</td>
                    </tr>
                    <tr>
                        <td class="colored-column">Luas </td>
                        <td class="colored-column">&nbsp;:</td>
                        <td class="colored-column">{{ number_format($daerahList->luas, 0, ',', '.')  }}m<sup>2</sup></td>
                    </tr>
                    <tr>
                        <td class="colored-column">Atas Nama </td>
                        <td class="colored-column">&nbsp;:</td>
                        <td class="colored-column">{{ $daerahList->nama }}</td>
                    </tr>
                    <tr>
                        <td class="colored-column">Masa Sewa </td>
                        <td class="colored-column">&nbsp;:</td>
                        <td class="colored-column">{{ $daerahList->periode }}</td>
                    </tr>
                  </table>
            </td>
            @php
                $totalNilaiPenawaran = 0; // Inisialisasi di luar loop
            @endphp

            @foreach ($penawarans->groupBy('idfk_daftar') as $groupedPenawarans)
                @php
                    $firstPenawaran = $groupedPenawarans->first();
                    $totalNilaiPenawaranGroup = 0; // Inisialisasi total untuk grup ini
                @endphp

                @foreach ($groupedPenawarans as $penawaran)
                    @php
                        $totalNilaiPenawaranGroup += $penawaran->nilai_penawaran; // Akumulasi nilai penawaran dalam grup
                    @endphp
                @endforeach

                <td>Rp {{ number_format($totalNilaiPenawaranGroup, 0, ',', '.') }}</td>
            @endforeach

        </tr>
    </table>
</center>
