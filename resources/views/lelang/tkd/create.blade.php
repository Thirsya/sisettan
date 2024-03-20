@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Table</h1>
        </div>
        <div class="section-body">
            <h2 class="section-title">Tambah Harga Dasar</h2>
            <div class="card">
                <div class="card-header">
                    <h4>Validasi Tambah Data</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('tkd.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label>Kelurahan<span class="text-danger">*</span></label>
                            <select class="form-control select2 @error('id_kelurahan') is-invalid @enderror"
                                name="id_kelurahan_disabled" data-id="select-kelurahan" id="id_kelurahan" disabled>
                                <option value="">Piih Kelurahan</option>
                                @foreach ($kelurahans as $kelurahan)
                                    <option @selected($kelurahan->id == $kelurahanIdFromDaerah) value="{{ $kelurahan->id }}">
                                        {{ $kelurahan->kelurahan }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="id_kelurahan" value="{{ $kelurahanIdFromDaerah }}" />
                            @error('id_kelurahan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Letak<span class="text-danger">*</span></label>
                            <input type="text" id="letak" name="letak"
                                class="form-control @error('letak') is-invalid @enderror" placeholder="Masukan Letak"
                                autocomplete="off">
                            @error('letak')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Bidang<span class="text-danger">*</span></label>
                            <input type="text" id="bidang" name="bidang"
                                class="form-control @error('bidang') is-invalid @enderror" placeholder="Masukan Bidang"
                                autocomplete="off">
                            @error('bidang')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Bukti<span class="text-danger">*</span></label>
                            <input type="text" id="bukti" name="bukti"
                                class="form-control @error('bukti') is-invalid @enderror" placeholder="Masukan Bukti"
                                autocomplete="off">
                            @error('bukti')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Luas<span class="text-danger">*</span></label>
                            <input type="text" id="luas" name="luas"
                                class="form-control @error('luas') is-invalid @enderror" placeholder="Masukan Luas"
                                autocomplete="off">
                            @error('luas')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Harga Dasar<span class="text-danger">*</span></label>
                            <input type="text" id="harga_dasar" name="harga_dasar"
                                class="form-control @error('harga_dasar') is-invalid @enderror"
                                placeholder="Masukan Harga Dasar" autocomplete="off">
                            @error('harga_dasar')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Keterangan<span class="text-danger">*</span></label>
                            <textarea id="keterangan" name="keterangan" class="form-control @error('keterangan') is-invalid @enderror"
                                placeholder="Masukkan Keterangan" autocomplete="off" rows="4"></textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Nop</label>
                            <input type="text" id="nop" name="nop"
                                class="form-control @error('nop') is-invalid @enderror" placeholder="Masukan Nop"
                                autocomplete="off">
                            @error('nop')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Map Location<span class="text-danger">*</span></label>
                            <div id="map" style="height: 400px;"></div>
                        </div>
                        <div class="row">
                            <div class="col md-6">
                                <div class="form-group ">
                                    <label>Longitude<span class="text-danger">*</span></label>
                                    <input type="text" id="longitude" name="longitude"
                                        class="form-control @error('longitude') is-invalid @enderror"
                                        placeholder="Masukan Longitude" autocomplete="off">
                                    @error('longitude')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col md-6">
                                <div class="form-group">
                                    <label>Latitude<span class="text-danger">*</span></label>
                                    <input type="text" id="latitude" name="latitude"
                                        class="form-control @error('latitude') is-invalid @enderror"
                                        placeholder="Masukan Latitude" autocomplete="off">
                                    @error('latitude')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>


                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary">Submit</button>
                    <a class="btn btn-secondary" href="{{ route('tkd.index') }}">Cancel</a>
                </div>
                </form>
            </div>
        </div>
    </section>
@endsection
@push('customStyle')
    <link rel="stylesheet" href="/assets/css/select2.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Leaflet.EasyButton/2.4.0/easy-button.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-geosearch/dist/geosearch.css" />
@endpush

@push('customScript')
    <script src="/assets/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Leaflet.EasyButton/2.4.0/easy-button.min.js"></script>
    <script src="https://unpkg.com/leaflet-geosearch/dist/geosearch.umd.js"></script>

    <script type="text/javascript">
        $('#harga_dasar').mask('000,000,000,000,000', {
            reverse: true
        });
        $('form').on('submit', function() {
            var harga_dasar = $('#harga_dasar').val().replace(/,/g, '');
            $('#harga_dasar').val(harga_dasar);
        });
    </script>
    </script>
    <script>
        $(document).ready(function() {
            var map = L.map('map').fitWorld();
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 18,
            }).addTo(map);

            map.locate({
                setView: true,
                maxZoom: 16
            });

            var marker;

            function placeMarker(lat, lng) {
                var newLatLng = new L.LatLng(lat, lng);
                if (marker) {
                    map.removeLayer(marker);
                }
                marker = new L.Marker(newLatLng).addTo(map);
                map.setView(newLatLng, 16);
            }

            map.on('click', function(e) {
                $('#latitude').val(e.latlng.lat);
                $('#longitude').val(e.latlng.lng);
                placeMarker(e.latlng.lat, e.latlng.lng);
            });

            $('#latitude, #longitude').on('change', function() {
                var lat = $('#latitude').val();
                var lng = $('#longitude').val();
                if (lat && lng) {
                    placeMarker(lat, lng);
                }
            });

            const provider = new GeoSearch.OpenStreetMapProvider();

            const searchControl = new GeoSearch.GeoSearchControl({
                provider: provider,
                showMarker: false,
                autoClose: true,
            });

            map.addControl(searchControl);

            map.on('geosearch/showlocation', function(e) {
                placeMarker(e.location.y, e.location.x);
                $('#latitude').val(e.location.y);
                $('#longitude').val(e.location.x);
            });

            L.easyButton('fas fa-location-arrow', function(btn, map) {
                map.locate({
                    setView: true,
                    maxZoom: 16,
                    enableHighAccuracy: true
                }).on('locationfound', function(e) {
                    placeMarker(e.latitude, e.longitude);
                    $('#latitude').val(e.latitude);
                    $('#longitude').val(e.longitude);
                });
            }, 'Get Current Location').addTo(map);
        });
    </script>
@endpush
