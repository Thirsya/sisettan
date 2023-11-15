@extends('layouts.app')

@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Penawaran List</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Components</a></div>
                <div class="breadcrumb-item">Table</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Penawaran Management</h2>

            <div class="row">
                <div class="col-12">
                    @include('layouts.alert')
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Penawaran List</h4>
                            <div class="card-header-action">
                                <a class="btn btn-icon icon-left btn-primary create active">
                                    <i class="far fa-file" aria-hidden="true"></i>
                                    Create Penawaran</a>
                                <a class="btn btn-info btn-dark active bg-dark" href="{{ route('penawaran.export') }}"
                                    data-id="export">
                                    <i class="fa fa-upload" aria-hidden="true"></i>
                                    Export Penawaran</a>
                                <a class="btn btn-success btn-success active bg-success" href="{{ route('sts') }}">
                                    <i class="far fa-file"></i>
                                    STS & Perjanjian</a>
                                <a class="btn btn-danger btn-danger active cetak bg-danger">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                    Cetak Data</a>
                                <a class="btn btn-warning btn-warning active import-button bg-warning">
                                    <i class="fa fa-download" aria-hidden="true"></i>
                                    Import Data</a>
                                <a class="btn btn-info btn-info active search bg-info">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                    Search SHP</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="show-create mb-3" style="display: none">
                                <form id="create" method="POST" action="{{ route('penawaran.handleForm') }}">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="penawaran">Pendaftar</label>
                                            <select
                                                class="form-control select2
                                                    @error('penawaran') is-invalid @enderror"
                                                name="penawaran">
                                                <option value="">Pilih Pendaftar</option>
                                                @foreach ($daftarList as $daftarListNoUrut)
                                                    <option value="{{ $daftarListNoUrut->id }}">
                                                        {{ $daftarListNoUrut->no_urut }} - {{ $daftarListNoUrut->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('penawaran')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="text-right" style="padding-top: 29px">
                                            <button class="btn btn-primary mr-1" type="submit">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="show-import mb-4" style="display: none">
                                @error('import-file')
                                    <div class="invalid-feedback d-flex mb-10" role="alert">
                                        <div class="alert_alert-dange_mt-1_mb-1">
                                            {{ $message }}
                                        </div>
                                    </div>
                                @enderror
                                <div class="custom-file">
                                    <form action="{{ route('penawaran.import') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('POST')
                                        <label
                                            class="custom-file-label @error('import-file', 'ImportPenawaranRequest') is-invalid @enderror"
                                            for="file-upload">Choose File</label>
                                        <input type="file" id="file-upload" class="custom-file-input" name="import-file"
                                            data-id="send-import">
                                        <br /><br />
                                        <a href="{{ route('penawaran.download-template') }}" class="text">Unduh
                                            Template</a>
                                        <br /> <br />
                                        <div class="footer text-right">
                                            <button class="btn btn-primary" data-id="submit-import">Import File</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="show-import-ba mb-4" style="display: none">
                                @error('import-file')
                                    <div class="invalid-feedback d-flex mb-10" role="alert">
                                        <div class="alert_alert-dange_mt-1_mb-1">
                                            {{ $message }}
                                        </div>
                                    </div>
                                @enderror
                                <div class="custom-file">
                                    <form action="{{ route('daerahs.upload') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <label
                                            class="custom-file-label @error('import-file', 'ImportBaRequest') is-invalid @enderror"
                                            for="file-upload1">Choose File</label>
                                        <input type="file" id="file-upload1" class="custom-file-input" name="import-file"
                                            data-id="send-import">
                                        <br /><br />
                                        <div class="footer text-right">
                                            <button class="btn btn-primary" data-id="submit-import">Upload File</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="show-import-shp mb-4" style="display: none">
                                @error('import-file')
                                    <div class="invalid-feedback d-flex mb-10" role="alert">
                                        <div class="alert_alert-dange_mt-1_mb-1">
                                            {{ $message }}
                                        </div>
                                    </div>
                                @enderror
                                <div class="custom-file">
                                    <form action="{{ route('daerahs.upload.shp') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('POST')
                                        <label
                                            class="custom-file-label @error('import-file', 'ImportPenawaranRequest') is-invalid @enderror"
                                            for="file-upload2">Choose File</label>
                                        <input type="file" id="file-upload2" class="custom-file-input"
                                            name="import-file" data-id="send-import">
                                        <br /><br />
                                        <div class="footer text-right">
                                            <button class="btn btn-primary" data-id="submit-import">Upload File</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="show-cetak mb-3" style="display: none">
                                <a class="btn btn-info btn-success active bg-success" href="{{ route('hektar') }}">
                                    <i class="fas fa-check"></i>
                                    Luas Lebih dari 2 Hektar</a>
                                <a class="btn btn-info btn-danger active bg-danger" target="_blank"
                                    href="{{ route('penawaran.cetaktidaklaku') }}">
                                    <i class="fas fa-times"></i>
                                    Bidang/SHP Tidak Laku</a>
                                {{-- <a class="btn btn-info btn-info active bg-info" href="{{ route('sts') }}">
                                    <i class="far fa-file"></i>
                                    STS & Perjanjian</a> --}}
                                <a class="btn btn-info btn-primary active bg-primary" target="_blank"
                                    href="{{ route('penawaran.cetakba') }}">
                                    <i class="far fa-file"></i>
                                    Lampiran BA</a>
                                <a class="btn btn-info btn-primary active bg-primary" target="_blank"
                                    href="{{ route('penawaran.cetaksekota') }}">
                                    <i class="far fa-file"></i>
                                    Rekap Se-kota</a>
                            </div>
                            <div class="show-import-button mb-3" style="display: none">
                                <a class="btn btn-info btn-warning active import bg-warning">
                                    <i class="fa fa-download" aria-hidden="true"></i>
                                    Import Penawaran</a>
                                <a class="btn btn-info btn-warning active import-ba bg-warning">
                                    <i class="fa fa-download" aria-hidden="true"></i>
                                    Upload BA</a>
                                <a class="btn btn-info btn-warning active import-shp bg-warning">
                                    <i class="fa fa-download" aria-hidden="true"></i>
                                    Upload SHP Tidak Laku</a>
                            </div>
                            <div class="show-search mb-3" style="display: none">
                                <form id="search" method="GET" action="{{ route('penawaran.index') }}">
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="role">Bukti Hak (SHP)</label>
                                            <input type="text" name="bukti" class="form-control" id="bukti"
                                                placeholder="Bukti Hak">
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button class="btn btn-primary mr-1" type="submit">Submit</button>
                                        <a class="btn btn-secondary" href="{{ route('penawaran.index') }}">Reset</a>
                                    </div>
                                </form>
                            </div>
                            {{-- <div class="d-flex justify-content-end">
                                <a href="#" data-toggle="dropdown"
                                    class="nav-link dropdown-toggle nav-link-lg nav-link-user"></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="#" class="dropdown-item has-icon">
                                        Upload BA
                                    </a>
                                    <a href="#" class="dropdown-item has-icon">
                                        Upload SHP Tidak Laku
                                    </a>
                                </div>
                                <form action="{{ route('delete.all') }}" method="POST" class="ml-2">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <button class="btn btn-sm btn-danger btn-icon confirm-delete"></i>Delete All</button>
                                </form>
                            </div> --}}
                            <div class="table-responsive">
                                <table class="table table-bordered table-md">
                                    <tbody>
                                        <tr>
                                            <th>No</th>
                                            <th>Total Luas</th>
                                            <th>Pendaftar</th>
                                            <th>Bukti Hak</th>
                                            <th>Luas Bidang</th>
                                            <th>Harga Dasar</th>
                                            <th>Harga Penawaran</th>
                                            <th class="text-right" style="width: 230px">Action</th>
                                        </tr>
                                        @foreach ($penawarans as $key => $penawaran)
                                            <tr>
                                                <td>{{ ($penawarans->currentPage() - 1) * $penawarans->perPage() + $key + 1 }}
                                                </td>
                                                <td>{{ $penawaran->total_luas }} m<sup>2</sup></td>
                                                <td>{{ $penawaran->nama }}</td>
                                                <td>{{ $penawaran->bukti }} bidang {{ $penawaran->bidang }}</td>
                                                <td>{{ number_format($penawaran->luas, 0, ',', '.') }} m<sup>2</sup></td>
                                                <td>Rp {{ number_format($penawaran->harga_dasar, 0, ',', '.') }}</td>
                                                <td>Rp {{ number_format($penawaran->nilai_penawaran, 0, ',', '.') }}</td>
                                                <td class="text-right">
                                                    <div class="d-flex justify-content-end">
                                                        <a href="#" data-toggle="dropdown"
                                                            class="nav-link dropdown-toggle nav-link-lg nav-link-user"></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a href="#" class="dropdown-item has-icon">
                                                                Pemenang II
                                                            </a>
                                                            <div class="dropdown-divider"></div>
                                                            @if ($penawaran->gugur == false)
                                                                <a href="{{ route('penawaran.toggle-gugur', $penawaran->id) }}"
                                                                    class="dropdown-item has-icon text-danger">
                                                                    Digugurkan
                                                                </a>
                                                            @else
                                                                <a href="{{ route('penawaran.toggle-gugur', $penawaran->id) }}"
                                                                    class="dropdown-item has-icon text-danger">
                                                                    Kembali Ke Panitia
                                                                </a>
                                                            @endif

                                                        </div>
                                                        <a href="{{ route('penawaran.edit', $penawaran->id) }}"
                                                            class="btn btn-sm btn-info btn-icon " style="padding-top: 7px"><i
                                                                class="fas fa-edit"></i>Edit</a>
                                                        <form action="{{ route('penawaran.destroy', $penawaran->id) }}"
                                                            method="POST" class="ml-2">
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <input type="hidden" name="_token"
                                                                value="{{ csrf_token() }}">
                                                            <button class="btn btn-sm btn-danger btn-icon confirm-delete"
                                                                type="submit" style="height: 40px">
                                                                <i class="fas fa-times"></i> Delete </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center">
                                    {{ $penawarans->withQueryString()->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('customScript')
    <script src="/assets/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.import').click(function(event) {
                event.stopPropagation();
                $(".show-import").slideToggle("fast");
                $(".show-create").hide();
                $(".show-import-button").hide();
                $(".show-cetak").hide();
                $(".show-search").hide();
                $(".show-import-shp").hide();
                $(".show-import-ba").hide();
            });
            $('.search').click(function(event) {
                event.stopPropagation();
                $(".show-search").slideToggle("fast");
                $(".show-import").hide();
                $(".show-create").hide();
                $(".show-import-button").hide();
                $(".show-cetak").hide();
                $(".show-import-shp").hide();
                $(".show-import-ba").hide();
            });
            $('.create').click(function(event) {
                event.stopPropagation();
                $(".show-create").slideToggle("fast");
                $(".show-import").hide();
                $(".show-import-button").hide();
                $(".show-cetak").hide();
                $(".show-import-shp").hide();
                $(".show-import-ba").hide();
            });
            $('.cetak').click(function(event) {
                event.stopPropagation();
                $(".show-cetak").slideToggle("fast");
                $(".show-import").hide();
                $(".show-create").hide();
                $(".show-import-button").hide();
                $(".show-import-shp").hide();
                $(".show-import-ba").hide();
            });

            $('.import-button').click(function(event) {
                event.stopPropagation();
                $(".show-import-button").slideToggle("fast");
                $(".show-import").hide();
                $(".show-create").hide();
                $(".show-cetak").hide();
                $(".show-import-shp").hide();
                $(".show-import-ba").hide();
            });

            $('.import-shp').click(function(event) {
                event.stopPropagation();
                $(".show-import-shp").slideToggle("fast");
                $(".show-import").hide();
                $(".show-create").hide();
                $(".show-cetak").hide();
                $(".show-import-button").hide();

            });
            $('.import-ba').click(function(event) {
                event.stopPropagation();
                $(".show-import-ba").slideToggle("fast");
                $(".show-import").hide();
                $(".show-create").hide();
                $(".show-cetak").hide();
                $(".show-import-shp").hide();
                $(".show-import-button").hide();
            });

            $('#file-upload').change(function() {
                var i = $(this).prev('label').clone();
                var file = $('#file-upload')[0].files[0].name;
                $(this).prev('label').text(file);
            });
            $('#file-upload1').change(function() {
                var i = $(this).prev('label').clone();
                var file = $('#file-upload1')[0].files[0].name;
                $(this).prev('label').text(file);
            });
            $('#file-upload2').change(function() {
                var i = $(this).prev('label').clone();
                var file = $('#file-upload2')[0].files[0].name;
                $(this).prev('label').text(file);
            });
        });
    </script>
@endpush

@push('customStyle')
    <link rel="stylesheet" href="/assets/css/select2.min.css">
@endpush
