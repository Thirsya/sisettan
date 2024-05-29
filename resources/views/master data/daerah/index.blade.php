@extends('layouts.app')

@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Periode List</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Components</a></div>
                <div class="breadcrumb-item">Table</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Periode Management</h2>

            <div class="row">
                <div class="col-12">
                    @include('layouts.alert')
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Periode List</h4>
                            <div class="card-header-action">
                                <a class="btn btn-icon icon-left btn-primary" href="#" data-toggle="modal"
                                    data-target="#modal-sewa">
                                    <i class="far fa-file"></i>
                                    Masa Sewa</a>
                                <a class="btn btn-info btn-warning active import bg-warning">
                                    <i class="fa fa-download" aria-hidden="true"></i>
                                    Import Periode</a>
                                <a class="btn btn-info btn-dark active bg-dark" href="{{ route('daerah.export') }}"
                                    data-id="export">
                                    <i class="fa fa-upload" aria-hidden="true"></i>
                                    Export Periode</a>
                                <a class="btn btn-info btn-info active search bg-info">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                    Search Periode</a>
                                {{-- <a class="btn btn-info btn-primary active" href="{{ route('daerah.download-template') }}">
                                    <i class="fa fa-upload" aria-hidden="true"></i>
                                    Daerah Template</a> --}}
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="show-import mb-4" style="display: none">
                                @error('import-file')
                                    <div class="invalid-feedback d-flex mb-10" role="alert">
                                        <div class="alert_alert-dange_mt-1_mb-1">
                                            {{ $message }}
                                        </div>
                                    </div>
                                @enderror
                                <div class="custom-file">
                                    <form action="{{ route('daerah.import') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('POST')
                                        <label
                                            class="custom-file-label @error('import-file', 'ImportDaerahRequest') is-invalid @enderror"
                                            for="file-upload">Choose File</label>
                                        <input type="file" id="file-upload" class="custom-file-input" name="import-file"
                                            data-id="send-import">
                                        <br /><br />
                                        <a href="{{ route('daerah.download-template') }}" class="text">Unduh Template</a>
                                        <br /> <br />
                                        <div class="footer text-right">
                                            <button class="btn btn-primary" data-id="submit-import">Import File</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                            <div class="show-search mb-3" style="display: none">
                                <form id="search" method="GET" action="{{ route('daerah.index') }}">
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="role">Kecamatan</label>
                                            <select class="form-control select2" name="kecamatan" data-id="select-Kecamatan"
                                                id="kecamatan">
                                                <option value="" readonly>Pilih Kecamatan </option>
                                                @foreach ($kecamatan as $kecamat)
                                                    <option value="{{ $kecamat->id }}" @selected($kecamat->id == $kecamatanSelected)>
                                                        {{ $kecamat->kecamatan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="role">Kelurahan</label>
                                            <select class="form-control select2 kelurahan" name="kelurahan"
                                                data-id="select-kelurahan" id="kelurahan">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button class="btn btn-primary mr-1" type="submit">Submit</button>
                                        <a class="btn btn-secondary" href="{{ route('daerah.index') }}">Reset</a>
                                    </div>
                                </form>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-md">
                                    <tbody>
                                        <tr>
                                            <th>No</th>
                                            <th>Kecamatan</th>
                                            <th>Kelurahan</th>
                                            <th>Noba</th>
                                            <th>Periode</th>
                                            <th>Tahun Sts</th>
                                            <th>Tanggal</th>
                                            {{-- <th class="text-right" style="width: 150px">Preview BA</th>
                                            <th class="text-right" style="width: 150px">Preview Tidak Laku</th> --}}
                                            <th class="text-right">Action</th>
                                        </tr>
                                        @foreach ($daerahs as $key => $daerah)
                                            <tr>
                                                <td>{{ ($daerahs->currentPage() - 1) * $daerahs->perPage() + $key + 1 }}
                                                </td>
                                                <td>{{ $daerah->kecamatan }}</td>
                                                <td>{{ $daerah->kelurahan }}</td>
                                                <td>{{ $daerah->noba }}</td>
                                                <td>{{ $daerah->periode }}</td>
                                                <td>{{ $daerah->tahun }}</td>
                                                <td>{{ $daerah->tanggal_lelang }}</td>

                                                <td class="text-right">
                                                    <div class="d-flex justify-content-end">
                                                        <a href="{{ route('daerah.edit', $daerah->id) }}"
                                                            class="btn btn-sm btn-info btn-icon">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>
                                                        <form action="{{ route('daerah.destroy', $daerah->id) }}"
                                                            method="POST" class="ml-2">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn btn-sm btn-danger btn-icon confirm-delete">
                                                                <i class="fas fa-times"></i> Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center">
                                    {{ $daerahs->withQueryString()->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
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
    <div class="modal fade" id="previewFileModal2" tabindex="-1" aria-labelledby="previewFileModalLabel"
        aria-hidden="true" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Preview BA</h5>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="modal fade" id="modal-sewa" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Penguumuman Masa Sewa</h5>
                        {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Kecamatan<span class="text-danger">*</span></label>
                            <select class="form-control select2" name="id_kecamatan" data-id="select-kecamatan"
                                id="id_kecamatan">
                                <option value="">Piih Kecamatan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kelurahan<span class="text-danger">*</span></label>
                            <select class="form-control select2" name="id_kelurahan" data-id="select-kelurahan"
                                id="id_kelurahan">
                                <option value="">Piih Kelurahan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>No Berita Acara</label>
                            <input type="text" id="noba" name="noba" class="form-control"
                                placeholder="Masukan Noba" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Periode<span class="text-danger">*</span></label>
                            <input type="text" id="periode" name="periode" class="form-control "
                                placeholder="Masukan Periode" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Tahun<span class="text-danger">*</span></label>
                            <select class="form-control select2" name="id_tahun" data-id="select-tahun" id="id_tahun">
                                <option value="">Piih Tahun</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Lelang<span class="text-danger">*</span></label>
                            <input type="date" id="tanggal_lelang" name="tanggal_lelang" class="form-control"
                                placeholder="Masukan Tanggal Lelang" autocomplete="off">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>
@endsection

@push('customScript')
    <script src="/assets/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // $('.modal').modal();
            $('.import').click(function(event) {
                event.stopPropagation();
                $(".show-import").slideToggle("fast");
                $(".show-search").hide();
            });
            $('.search').click(function(event) {
                event.stopPropagation();
                $(".show-search").slideToggle("fast");
                $(".show-import").hide();
            });
            //ganti label berdasarkan nama file
            $('#file-upload').change(function() {
                var i = $(this).prev('label').clone();
                var file = $('#file-upload')[0].files[0].name;
                $(this).prev('label').text(file);
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#modal-sewa').on('shown.bs.modal', function() {
                $.ajax({
                    url: '/master-data/getDaerahJquery',
                    type: 'GET',
                    success: function(data) {
                        console.log(data);
                        $('#id_kelurahan').empty();
                        $('#id_kecamatan').empty();
                        $('#id_tahun').empty();
                        $('#noba').empty();
                        $('#periode').empty();
                        $.each(data, function(key, daerah) {
                            console.log(data)
                            $('#id_kelurahan').append('<option value="' + daerah
                                .id_kelurahan +
                                '">' + daerah.kelurahan + '</option>');
                            $('#id_kecamatan').append('<option value="' + daerah
                                .id_kecamatan + '">' + daerah.kecamatan +
                                '</option>');
                            $('#id_tahun').append('<option value="' + daerah
                                .thn_sts + '">' +
                                daerah.tahun + '</option>');
                            $('#noba').val(daerah.noba);
                            $('#tanggal_lelang').val(daerah.tanggal_lelang);
                            $('#periode').val(daerah.periode);
                        });
                    }
                });
            });
        });
    </script>
    <script>
        $('.preview-btn').on('click', function() {
            var key = $(this).data('key');
            var daerah = JSON.parse($(this).attr('data-daerah'));
            $('#previewFileModal .modal-title').text('Preview File ' + key);
            if (daerah.surat.endsWith('.pdf')) {
                $('#previewFileModal .modal-body').html('<iframe src="' + daerah.suratUrl +
                    '" width="100%" height="500px" frameborder="0"></iframe>');
            } else {
                $('#previewFileModal .modal-body').html('<img src="' + daerah.suratUrl +
                    '" alt="Surat" style="max-width: 100%; height: auto;">');
            }
            $('#previewFileModal').modal('show');
        });
    </script>
    <script>
        $('.preview-btn-shp').on('click', function() {
            var key = $(this).data('key');
            var daerah = JSON.parse($(this).attr('data-daerah-shp'));
            $('#previewFileModal2 .modal-title').text('Preview File ' + key);
            if (daerah.surat_shp.endsWith('.pdf')) {
                $('#previewFileModal2 .modal-body').html('<iframe src="' + daerah.suratUrlSHP +
                    '" width="100%" height="500px" frameborder="0"></iframe>');
            } else {
                $('#previewFileModal2 .modal-body').html('<img src="' + daerah.suratUrlSHP +
                    '" alt="Surat" style="max-width: 100%; height: auto;">');
            }
            $('#previewFileModal2').modal('show');
        });
    </script>
    <script src="/assets/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            var detailStatus = {};
            $('.form-control select2 kelurahan').select2();
            $('#kecamatan').change(function() {
                var kecamatanIds = $('#kecamatan').val();
                $.ajax({
                    url: '{{ route('kelurahan.filter.survey') }}',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        id_kecamatan: kecamatanIds,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        $('#kelurahan').html(
                            '<option value="" readonly>Pilih Nama Kelurahan</option>');
                        $.each(response['Kelurahan'], function(index, val) {
                            $('#kelurahan').append('<option value="' + val.id +
                                '"> ' + val.kelurahan + ' </option>')
                        });
                    }
                });
            });
            var selectkecResponden = "{{ $kecamatanSelected }}";
            var oldKelurahanId = "{{ $kelurahanSelected }}";
            var selectkelSelect = "{{ $kelurahan }}";
            var dataKelurahan = JSON.parse(selectkelSelect.replace(/&quot;/g, '"'));
            $('#kelurahan').empty();
            $.ajax({
                url: '{{ route('load.filter') }}',
                type: 'GET',
                dataType: 'json',
                data: {
                    id_kecamatan: selectkecResponden,

                },
                success: function(response, items) {
                    $.each(dataKelurahan, function(index, val) {
                        if (val.id_kecamatan == selectkecResponden) {
                            console.log(val.id);
                            $('#kelurahan').html(
                                '<option value="" readonly>Pilih Nama Kelurahan</option>');
                            $('#kelurahan').append('<option value="' + val.id + '" >' +
                                val.kelurahan + '</option>')
                            $("#kelurahan option[value='" + oldKelurahanId + "']").attr(
                                "selected", "selected");
                        }
                    });
                }
            });
        });
    </script>
@endpush

@push('customStyle')
    <link rel="stylesheet" href="/assets/css/select2.min.css">
@endpush
