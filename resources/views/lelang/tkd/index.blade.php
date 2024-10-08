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
                                <a class="btn btn-icon icon-left btn-primary" href="{{ route('tkd.create') }}">
                                    <i class="far fa-file"></i>
                                    Create Harga Dasar</a>
                                <a class="btn btn-info btn-warning active import bg-warning">
                                    <i class="fa fa-download" aria-hidden="true"></i>
                                    Import Harga Dasar</a>
                                <a class="btn btn-info btn-dark active bg-dark" href="{{ route('tkd.export') }}"
                                    data-id="export">
                                    <i class="fa fa-upload" aria-hidden="true"></i>
                                    Export Harga Dasar</a>
                                <a class="btn btn-info btn-info active search bg-info">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                    Search SHP</a>
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
                                    <form action="{{ route('tkd.import') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('POST')
                                        <label
                                            class="custom-file-label @error('import-file', 'ImportTkdRequest') is-invalid @enderror"
                                            for="file-upload">Choose File</label>
                                        <input type="file" id="file-upload" class="custom-file-input" name="import-file"
                                            data-id="send-import">
                                        <br /><br />
                                        <a href="{{ route('tkd.download-template') }}" class="text">Unduh Template</a>
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
                                            <label for="role">Bukti (SHP)</label>
                                            <input type="text" name="bukti" class="form-control" id="bukti"
                                                placeholder="SHP">
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
                                            <th>No.</th>
                                            <th style="width: 120px">Letak</th>
                                            <th>Bidang</th>
                                            <th>Kelurahan</th>
                                            <th style="width: 100px">Bukti</th>
                                            <th style="width: 100px">Luas</th>
                                            <th style="width: 120px">Harga Dasar</th>
                                            <th style="width: 300px">Keterangan</th>
                                            <th>Nop</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                        @foreach ($tkds as $key => $tkd)
                                            <tr data-id="{{ $tkd->id }}" data-lat="{{ $tkd->latitude }}"
                                                data-lng="{{ $tkd->longitude }}">
                                                <td>{{ ($tkds->currentPage() - 1) * $tkds->perPage() + $key + 1 }}</td>
                                                <td>{{ $tkd->letak }}</td>
                                                <td>{{ $tkd->bidang }}</td>
                                                <td>{{ $tkd->kelurahan }}</td>
                                                <td>{{ $tkd->bukti }}</td>
                                                <td>{{ number_format($tkd->luas, 0, ',', '.') }} m<sup>2</sup></td>
                                                <td>Rp {{ number_format($tkd->harga_dasar, 0, ',', '.') }}</td>
                                                <td>{{ $tkd->keterangan }}</td>
                                                <td>{{ $tkd->nop }}</td>
                                                <td class="text-right">
                                                    <div class="d-flex justify-content-end">
                                                        <a href="{{ route('tkd.edit', $tkd->id) }}"
                                                            class="btn btn-sm btn-info btn-icon"><i class="fas fa-edit"></i>
                                                            Edit</a>
                                                        <form action="{{ route('tkd.destroy', $tkd->id) }}" method="POST"
                                                            class="ml-2">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-sm btn-danger btn-icon confirm-delete">
                                                                <i class="fas fa-times"></i> Delete </button>
                                                        </form>
                                                        <button
                                                            class="btn btn-sm btn-secondary btn-icon toggle-details ml-2">
                                                            <i class="fas fa-chevron-down"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="details-row" style="display:none">
                                                <td colspan="20">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h5>Detail Maps</h5>
                                                            <table class="table">
                                                                <tr>
                                                                    <td style="font-weight: bold">Longitude</td>
                                                                    <td style="font-weight: bold">Latitude</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>{{ $tkd->longitude }}</td>
                                                                    <td>{{ $tkd->latitude }}</td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        @if ($tkd->longitude && $tkd->latitude)
                                                            <div id="map-{{ $tkd->id }}" style="height: 300px;">
                                                            </div>
                                                        @else
                                                            <p class="text-center">Belum ada maps</p>
                                                        @endif
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
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

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

            $('.toggle-details').click(function() {
                var icon = $(this).find('i');
                var row = $(this).closest('tr').next('.details-row');
                row.toggle();
                icon.toggleClass('fa-chevron-down fa-chevron-up');

                if (row.is(':visible')) {
                    var mapId = 'map-' + $(this).closest('tr').data('id');
                    if ($('#' + mapId).length && !$('#' + mapId).hasClass('leaflet-container')) {
                        var lat = $(this).closest('tr').data('lat');
                        var lng = $(this).closest('tr').data('lng');
                        var map = L.map(mapId).setView([lat, lng], 13);
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                        }).addTo(map);
                        L.marker([lat, lng]).addTo(map)
                            .bindPopup('Latitude: ' + lat + '<br>Longitude: ' + lng)
                            .openPopup();
                    }
                }
            });
        });
    </script>
@endpush

@push('customStyle')
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
@endpush
