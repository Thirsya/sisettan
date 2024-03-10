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
                <br><br>
                <div class="card">
                    <div class="card-body">
                        {{-- <form method="POST"> --}}
                        {{-- @csrf --}}
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
                                        <th>Menu</th>
                                    </tr>
                                    @foreach ($penawaran as $key => $listPenawaran)
                                        <tr>
                                            <td>{{ $listPenawaran->no_urut }}</td>
                                            <td>{{ $listPenawaran->id }}</td>
                                            <td>{{ $listPenawaran->nama }}</td>
                                            <td>{{ $listPenawaran->bukti }}</td>
                                            <td>{{ $listPenawaran->bidang }}</td>
                                            <td>{{ number_format($listPenawaran->luas, 0, ',', '.') }}m<sup>2</sup></td>
                                            <td>Rp {{ number_format($listPenawaran->nilai_penawaran, 0, ',', '.') }}
                                            </td>
                                            <td>
                                                <form class="updateDateForm" data-id="{{ $listPenawaran->id }}">
                                                    <input type="date" class="tgl_perjanjian_input" name="tgl_perjanjian"
                                                        value="{{ $listPenawaran->tgl_perjanjian }}">
                                                    <button type="submit"
                                                        class="ml-2 btn btn-sm btn-success btn-icon">Save</button>
                                                </form>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-info btn-icon toggle-details ml-3"
                                                    data-target="#details-{{ $listPenawaran->id }}">
                                                    <i class="fas fa-chevron-down"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr id="details-{{ $listPenawaran->id }}" style="display: none">
                                            <td colspan="10">
                                                <br>
                                                <h6>Aksi</h6>
                                                <table class="table table-bordered table-md">
                                                    <tr style="text-align: center">
                                                        <th>Hapus Data</th>
                                                        <th>Digugurkan</th>
                                                        <th>Cetak STS</th>
                                                        <th>Cetak Pertanyataan</th>
                                                        <th>Cetak Perjanjian</th>
                                                        <th>Upload Dokumen</th>
                                                    </tr>
                                                    <tr style="text-align: center;">
                                                        <td>
                                                            <form
                                                                action="{{ route('penawaran.destroy', $listPenawaran->id) }}"
                                                                method="POST" class="ml-2">
                                                                <input type="hidden" name="_method" value="DELETE">
                                                                <input type="hidden" name="_token"
                                                                    value="{{ csrf_token() }}">
                                                                <button
                                                                    class="btn btn-sm btn-danger btn-icon confirm-delete"
                                                                    type="submit">
                                                                    <i class="fas fa-times"></i> Delete </button>
                                                            </form>
                                                        </td>
                                                        <td>
                                                            <a href="#" data-id="{{ $listPenawaran->id }}"
                                                                class="ml-2 btn btn-sm btn-danger btn-icon gugur">Di
                                                                Gugurkan</a>
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('sts.print', $listPenawaran->id) }}"
                                                                target="_blank"
                                                                class="ml-2 btn btn-sm btn-info btn-icon">Cetak
                                                                STS</a>
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('sts.cetakpernyataan') }}"
                                                                class="ml-2 btn btn-sm btn-info btn-icon ">Cetak
                                                                Pernyataan</a>
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('sts.cetakperjanjian') }}"
                                                                class="ml-2 btn btn-sm btn-info btn-icon ">Cetak
                                                                Perjanjian</a>
                                                        </td>
                                                        <td>
                                                            <a href="#" data-toggle="dropdown"
                                                                class="ml-2 btn btn-sm btn-info btn-icon">Upload STS</a>
                                                            <div
                                                                class="dropdown-menu
                                                                dropdown-menu-right">
                                                                <a class="dropdown-item has-icon" href="#"
                                                                    data-toggle="modal" data-target="#modal-upload"
                                                                    data-id="{{ $listPenawaran->id }}">
                                                                    Dokumen
                                                                </a>
                                                            </div>
                                                        </td>

                                                    </tr>
                                                </table>
                                                <br />
                                                <h6>Preview Upload Dokumen STS</h6>
                                                <table class="table table-bordered table-md">
                                                    <tr>
                                                        <th>Surat Tanda Setor</th>
                                                        <th>Surat Pernyataan</th>
                                                        <th>Surat Perjanjian</th>
                                                        <th>Berita Acara</th>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            @if ($listPenawaran->surat_tanda_setor)
                                                                <?php $listPenawaran->suratUrl = Storage::url('sts/' . $listPenawaran->surat_tanda_setor); ?>
                                                                <button type="button" class="btn btn-primary preview-btn"
                                                                    data-key="{{ $key }}"
                                                                    data-penawaran="{{ json_encode($listPenawaran, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) }}">
                                                                    Preview File
                                                                </button>
                                                            @endif
                                                        </td>
                                                        {{-- <td>{{ $listPenawaran->surat_tanda_setor }}</td> --}}
                                                        <td>{{ $listPenawaran->surat_pernyataan }}</td>
                                                        <td>{{ $listPenawaran->surat_perjanjian }}</td>
                                                        <td>{{ $listPenawaran->berita_acara }}</td>
                                                    </tr>
                                                </table>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a class="btn btn-primary" href="{{ route('penawaran.index') }}">Selesai</a>
                    </div>
                    {{-- </form> --}}
                </div>
            </div>
        </div>
        <div id="page2" style="display: none">
            <br><br>
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
                                        <th style="width: 570px">Menu</th>
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
                                                    <input type="date" class="tgl_perjanjian_input" name="tgl_perjanjian"
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
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <button class="btn btn-sm btn-danger btn-icon confirm-delete"
                                                            type="submit">
                                                            <i class="fas fa-times"></i> Delete </button>
                                                    </form>
                                                    <a href="#" data-id="{{ $listPenawaran->id }}"
                                                        class="ml-2 btn btn-sm btn-danger btn-icon gugur">Di Gugurkan</a>
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
                </div>
                <div class="card-footer text-right">
                    <a class="btn btn-primary" href="{{ route('penawaran.index') }}">Selesai</a>
                </div>
                </form>
            </div>
        </div>
        </div>
    </section>
    <div class="modal fade" id="previewFileModal" tabindex="-1" aria-labelledby="previewFileModalLabel"
        aria-hidden="true" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Preview BA</h5>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>
    @include('lelang.penawaran.modal.upload')
    @include('lelang.penawaran.modal.preview')
@endsection
@push('customScript')
    <script src="/assets/js/select2.min.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script> --}}
    <script>
        $(document).ready(function() {
            $('.gugur').on('click', function(e) {
                e.preventDefault();

                let penawaranId = $(this).data('id');

                $.ajax({
                    type: 'POST',
                    url: '/lelang/sts/' + penawaranId + '/gugur',
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

                $.post('/lelang/sts/' + penawaranId + '/update-date', {
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
                const page = document.getElementById('page' + i);
                if (page) {
                    page.style.display = 'none';
                }
            }

            const currentPage = document.getElementById('page' + pageNumber);
            if (currentPage) {
                currentPage.style.display = 'block';
            }
        }
    </script>
    <script>
        $('#modal-upload').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            $('#id_penawaran').val(id);
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#uploadForm').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                formData.append('id_penawaran', $('#id_penawaran').val());

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log(response);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>
    <script>
        var detailStatus = {};
        $('.toggle-details').click(function() {
            var targetId = $(this).data('target');
            var listPenawaranId = targetId.split('-')[1];

            for (var id in detailStatus) {
                if (id != listPenawaranId && detailStatus[id] === true) {
                    $('#details-' + id).toggle();
                    $('.toggle-details[data-target="#details-' + id + '"] i')
                        .toggleClass('fa-chevron-down fa-chevron-up');
                    detailStatus[id] = false;
                }
            }

            $(targetId).toggle();
            $(this).find('i').toggleClass('fa-chevron-down fa-chevron-up');
            detailStatus[listPenawaranId] = $(targetId).is(':visible');
        });
    </script>
    <script>
        $('.preview-btn').on('click', function() {
            var key = $(this).data('key');
            var listPenawaran = JSON.parse($(this).attr('data-penawaran'));
            $('#previewFileModal .modal-title').text('Preview File ' + key);
            if (listPenawaran.surat_tanda_setor.endsWith('.pdf')) {
                $('#previewFileModal .modal-body').html('<iframe src="' + listPenawaran.suratUrl +
                    '" width="100%" height="500px" frameborder="0"></iframe>');
            } else {
                $('#previewFileModal .modal-body').html('<img src="' + listPenawaran.suratUrl +
                    '" alt="Surat" style="max-width: 100%; height: auto;">');
            }
            $('#previewFileModal').modal('show');
        });
    </script>
@endpush

@push('customStyle')
    <link rel="stylesheet" href="/assets/css/select2.min.css">
@endpush
