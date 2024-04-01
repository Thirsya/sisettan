@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Tabel Harga Dasar</h1>
        </div>
        <div class="section-body">
            <h2 class="section-title">Ubah Harga Dasar</h2>
            <div class="card">
                <div class="card-header">
                    <h4>Ubah Data</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('tkd.update', $tkd) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Kelurahan</label>
                            <select class="form-control select2 @error('id_kelurahan') is-invalid @enderror"
                                id="id_kelurahan" name="id_kelurahan_disabled" data-id="select-id_kelurahan" disabled>
                                <option value="">Pilih Kelurahan</option>
                                @foreach ($kelurahans as $kelurahan)
                                    <option @selected($kelurahan->id == $tkd->id_kelurahan) value="{{ $kelurahan->id }}">
                                        {{ $kelurahan->kelurahan }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_kelurahan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <input type="hidden" name="id_kelurahan" value="{{ $tkd->id_kelurahan }}">
                        </div>
                        <div class="form-group">
                            <label>Letak</label>
                            <input type="text" id="letak" name="letak"
                                class="form-control @error('tkd') is-invalid @enderror " placeholder="Masukan Letak"
                                value="{{ old('tkd', $tkd->letak) }}" data-id="input_letak" autocomplete="off">
                            @error('tkd')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Bidang</label>
                            <input type="text" id="bidang" name="bidang"
                                class="form-control @error('tkd') is-invalid @enderror " placeholder="Masukan Bidang"
                                value="{{ old('tkd', $tkd->bidang) }}" data-id="input_bidang" autocomplete="off">
                            @error('tkd')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Bukti</label>
                            <input type="text" id="bukti" name="bukti"
                                class="form-control @error('tkd') is-invalid @enderror " placeholder="Masukan Bukti"
                                value="{{ old('tkd', $tkd->bukti) }}" data-id="input_bukti" autocomplete="off">
                            @error('tkd')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Luas</label>
                            <input type="text" id="luas" name="luas"
                                class="form-control @error('tkd') is-invalid @enderror " placeholder="Masukan Luas"
                                value="{{ old('tkd', $tkd->luas) }}" data-id="input_luas" autocomplete="off">
                            @error('tkd')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Harga Dasar</label>
                            <input type="text" id="harga_dasar" name="harga_dasar"
                                class="form-control @error('tkd') is-invalid @enderror " placeholder="Masukan Harga Dasar"
                                value="{{ old('tkd', $tkd->harga_dasar) }}" data-id="input_harga_dasar" autocomplete="off">
                            @error('tkd')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Keterangan</label>
                            <input type="text" id="keterangan" name="keterangan"
                                class="form-control @error('keterangan') is-invalid @enderror "
                                placeholder="Masukan Keterangan" value="{{ old('keterangan', $tkd->keterangan) }}"
                                data-id="input_keterangan" autocomplete="off">
                            @error('keterangan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Nop</label>
                            <input type="text" id="nop" name="nop"
                                class="form-control @error('nop') is-invalid @enderror " placeholder="Masukan Nop"
                                value="{{ old('nop', $tkd->nop) }}" data-id="input_nop" autocomplete="off">
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
                                        placeholder="Masukan Longitude" autocomplete="off"
                                        value="{{ old('longitude', $tkd->longitude) }}">
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
                                        placeholder="Masukan Latitude" autocomplete="off"
                                        value="{{ old('latitude', $tkd->latitude) }}">
                                    @error('latitude')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Foto</label>
                            <input type="file" id="foto" name="foto"
                                class="form-control @error('foto') is-invalid @enderror" onchange="previewImage();">
                            @error('foto')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <img id="image-preview" src="{{ asset('storage/' . $tkd->foto) }}" alt="your image"
                                width="200" />
                        </div>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary">Kirim</button>
                    <a class="btn btn-secondary" href="{{ route('tkd.index') }}">Batal</a>
                </div>
                </form>
            </div>
        </div>
    </section>
@endsection
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
    <script>
        $(document).ready(function() {
            var map = L.map('map').setView([{{ $tkd->latitude }}, {{ $tkd->longitude }}], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
            }).addTo(map);

            var marker = L.marker([{{ $tkd->latitude }}, {{ $tkd->longitude }}]).addTo(map);

            function placeMarker(lat, lng) {
                var newLatLng = new L.LatLng(lat, lng);
                if (marker) {
                    map.removeLayer(marker);
                }
                marker = new L.Marker(newLatLng).addTo(map);
                map.setView(newLatLng, 16);
            }

            map.on('click', function(e) {
                marker.setLatLng(e.latlng);
                $('#latitude').val(e.latlng.lat);
                $('#longitude').val(e.latlng.lng);
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

@push('customStyle')
    <style>
        #image-preview {
            display: block;
            max-width: 200px;
            margin: 20px auto;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            border-radius: 5px;
        }
    </style>
    <link rel="stylesheet" href="/assets/css/select2.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Leaflet.EasyButton/2.4.0/easy-button.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-geosearch/dist/geosearch.css" />
@endpush
