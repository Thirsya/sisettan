@extends('layouts.app')

@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Tahun List</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Components</a></div>
                <div class="breadcrumb-item">Table</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Tahun Management</h2>

            <div class="row">
                <div class="col-12">
                    @include('layouts.alert')
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Tahun List</h4>
                            <div class="card-header-action">
                                <a class="btn btn-icon icon-left btn-primary" href="{{ route('tahun.create') }}">
                                    <i class="far fa-file"></i>
                                    Create Tahun</a>
                                <a class="btn btn-info btn-warning active import bg-warning">
                                    <i class="fa fa-download" aria-hidden="true"></i>
                                    Import Tahun</a>
                                <a class="btn btn-info btn-dark active bg-dark" href="{{ route('tahun.export') }}"
                                    data-id="export">
                                    <i class="fa fa-upload" aria-hidden="true"></i>
                                    Export Tahun</a>
                                <a class="btn btn-info btn-info active search bg-info">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                    Search Tahun</a>
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
                                    <form action="{{ route('tahun.import') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('POST')
                                        <label
                                            class="custom-file-label @error('import-file', 'ImportTahunRequest') is-invalid @enderror"
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
                                <form id="search" method="GET" action="{{ route('tahun.index') }}">
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="role">Tahun</label>
                                            <input type="text" name="tahun" class="form-control" id="tahun"
                                                placeholder="Tahun">
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button class="btn btn-primary mr-1" type="submit">Submit</button>
                                        <a class="btn btn-secondary" href="{{ route('tahun.index') }}">Reset</a>
                                    </div>
                                </form>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-md">
                                    <tbody>
                                        <tr>
                                            <th>No</th>
                                            <th>Tahun</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                        @foreach ($tahuns as $key => $tahun)
                                            <tr>
                                                <td>{{ ($tahuns->currentPage() - 1) * $tahuns->perPage() + $key + 1 }}</td>
                                                <td>{{ $tahun->tahun }}</td>
                                                <td class="text-right">
                                                    <div class="d-flex justify-content-end">
                                                        <a href="{{ route('tahun.edit', $tahun->id) }}"
                                                            class="btn btn-sm btn-info btn-icon "><i
                                                                class="fas fa-edit"></i>
                                                            Edit</a>
                                                        <form action="{{ route('tahun.destroy', $tahun->id) }}"
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
                                    {{ $tahuns->withQueryString()->links() }}
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
