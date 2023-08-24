@extends('layouts.app')

@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Harga Dasar List</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Components</a></div>
                <div class="breadcrumb-item">Table</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Harga Dasar Management</h2>

            <div class="row">
                <div class="col-12">
                    @include('layouts.alert')
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Harga Dasar List</h4>
                            <div class="card-header-action">
                                <a class="btn btn-icon icon-left btn-primary" href="{{ route('tkd.create') }}">Create New
                                    Harga Dasar</a>
                                <a class="btn btn-info btn-primary active import">
                                    <i class="fa fa-download" aria-hidden="true"></i>
                                    Import Harga Dasar</a>
                                <a class="btn btn-info btn-primary active" href="{{ route('tkd.export') }}" data-id="export">
                                    <i class="fa fa-upload" aria-hidden="true"></i>
                                    Export Harga Dasar</a>
                                <a class="btn btn-info btn-primary active search">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                    Search Harga Dasar</a>
                                <a class="btn btn-info btn-primary active" href="{{ route('tkd.download-template') }}">
                                    <i class="fa fa-upload" aria-hidden="true"></i>
                                    Harga Dasar Template</a>
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
                                    <form action="{{ route('tkd.import') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('POST')
                                        <label
                                            class="custom-file-label @error('import-file', 'ImportTkdRequest') is-invalid @enderror"
                                            for="file-upload">Choose File</label>
                                        <input type="file" id="file-upload" class="custom-file-input" name="import-file"
                                            data-id="send-import">
                                        <br /> <br />
                                        <div class="footer text-right">
                                            <button class="btn btn-primary" data-id="submit-import">Import File</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                            <div class="show-search mb-3" style="display: none">
                                <form id="search" method="GET" action="{{ route('tkd.index') }}">
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="role">Harga Dasar</label>
                                            <input type="text" name="tkd" class="form-control" id="tkd"
                                                placeholder="Group tkd">
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button class="btn btn-primary mr-1" type="submit">Submit</button>
                                        <a class="btn btn-secondary" href="{{ route('tkd.index') }}">Reset</a>
                                    </div>
                                </form>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-md">
                                    <tbody>
                                        <tr>
                                            <th>No</th>
                                            <th>Letak</th>
                                            <th>Bidang</th>
                                            <th>Kelurahan</th>
                                            <th>Bukti</th>
                                            <th>Luas</th>
                                            <th>Harga Dasar</th>
                                            <th>Keterangan</th>
                                            <th>Nop</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                        @foreach ($tkds as $key => $tkd)
                                            <tr>
                                                {{-- <td>{{ ($tkds->currentPage() - 1) * $tkds->perPage() + $key + 1 }}</td> --}}
                                                <td>{{ $tkd->id}}</td>
                                                <td>{{ $tkd->letak}}</td>
                                                <td>{{ $tkd->bidang}}</td>
                                                <td>{{ $tkd->kelurahan}}</td>
                                                <td>{{ $tkd->bukti}}</td>
                                                <td>{{ $tkd->luas}} m<sup>2</sup></td>
                                                <td>{{ 'Rp ' . number_format($tkd->harga_dasar, 0, ',', '.') }}</td>
                                                <td>{{ $tkd->keterangan}}</td>
                                                <td>{{ $tkd->nop}}</td>
                                                <td class="text-right">
                                                    <div class="d-flex justify-content-end">
                                                        <a href="{{ route('tkd.edit', $tkd->id) }}"
                                                            class="btn btn-sm btn-info btn-icon "><i
                                                                class="fas fa-edit"></i>
                                                            Edit</a>
                                                        <form action="{{ route('tkd.destroy', $tkd->id) }}"
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
                                    {{ $tkds->withQueryString()->links() }}
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
