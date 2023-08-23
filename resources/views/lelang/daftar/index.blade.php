@extends('layouts.app')

@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Pendaftar Lelang List</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Components</a></div>
                <div class="breadcrumb-item">Table</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Pendaftar Lelang Management</h2>

            <div class="row">
                <div class="col-12">
                    @include('layouts.alert')
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Pendaftar Lelang List</h4>
                            <div class="card-header-action">
                                <a class="btn btn-icon icon-left btn-primary" href="{{ route('daftar.create') }}">Create New
                                    Pendaftar Lelang</a>
                                <a class="btn btn-info btn-primary active import">
                                    <i class="fa fa-download" aria-hidden="true"></i>
                                    Import Pendaftar Lelang</a>
                                <a class="btn btn-info btn-primary active" href="{{ route('daftar.export') }}" data-id="export">
                                    <i class="fa fa-upload" aria-hidden="true"></i>
                                    Export Pendaftar Lelang</a>
                                <a class="btn btn-info btn-primary active search">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                    Search Pendaftar Lelang</a>
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
                                    <form action="{{ route('daftar.import') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('POST')
                                        <label
                                            class="custom-file-label @error('import-file', 'ImportDaftarRequest') is-invalid @enderror"
                                            for="file-upload">Choose File</label>
                                        <input type="file" id="file-upload" class="custom-file-input" name="import-file"
                                            data-id="send-import">
                                        <br/><br />
                                            <a href="{{ route('daftar.download-template') }}" class="text">Unduh Template</a>
                                        <br /> <br />
                                        <div class="footer text-right">
                                            <button class="btn btn-primary" data-id="submit-import">Import File</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="show-search mb-3" style="display: none">
                                <form id="search" method="GET" action="{{ route('daftar.index') }}">
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="role">Pendaftar</label>
                                            <input type="text" name="daftar" class="form-control" id="daftar"
                                                placeholder="Group daftar">
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button class="btn btn-primary mr-1" type="submit">Submit</button>
                                        <a class="btn btn-secondary" href="{{ route('daftar.index') }}">Reset</a>
                                    </div>
                                </form>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-md">
                                    <tbody>
                                        <tr>
                                            {{-- <th>No</th> --}}
                                            <th>Nomor Urut</th>
                                            <th>Nama</th>
                                            <th>Kelurahan</th>
                                            <th>Alamat</th>
                                            <th>Nomor KK</th>
                                            <th>Tanggal Perjanjian</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                        @foreach ($daftars as $key => $daftar)
                                            <tr>
                                                {{-- <td>{{ ($daftars->currentPage() - 1) * $daftars->perPage() + $key + 1 }}</td> --}}
                                                <td>{{ $daftar->no_urut}}</td>
                                                <td>{{ $daftar->nama}}</td>
                                                <td>{{ $daftar->kelurahan}}</td>
                                                <td>{{ $daftar->alamat}}</td>
                                                <td>{{ $daftar->no_kk}}</td>
                                                <td>{{ $daftar->tgl_perjanjian}}</td>
                                                <td class="text-right">
                                                    <div class="d-flex justify-content-end">
                                                        <a href="{{ route('daftar.edit', $daftar->id) }}"
                                                            class="btn btn-sm btn-info btn-icon "><i
                                                                class="fas fa-edit"></i>
                                                            Edit</a>
                                                        <form action="{{ route('daftar.destroy', $daftar->id) }}"
                                                            method="POST" class="ml-2">
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <input type="hidden" name="_token"
                                                                value="{{ csrf_token() }}">
                                                            <button class="btn btn-sm btn-danger btn-icon confirm-delete">
                                                                <i class="fas fa-times"></i> Delete </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center">
                                    {{ $daftars->withQueryString()->links() }}
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
    <script>
        $(document).ready(function() {
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
@endpush

@push('customStyle')
@endpush
