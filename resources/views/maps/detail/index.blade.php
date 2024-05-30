@extends('layouts.app')

@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Detail Lahan Tanah Pertanian</h1>
        </div>
        <div class="section-body">
            <h2 class="section-title">Lahan Tanah Pertanian</h2>

            <div class="row">
                <div class="col-12">
                    @include('layouts.alert')
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Lahan Tanah Pertanian</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <select class="form-control select2" name="bukti" id="dropdown-item">
                                    <option value="">Pilih SHP</option>
                                    @foreach ($tkd as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->bukti }} bidang {{ $item->bidang }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="show-search mb-3">
                            </div>
                            <div class="col-12 d-flex justify-content-center">
                                <h1>MAPS</h1>
                            </div>
                            <div class="table-responsive">
                            </div>
                            <div id="map" style="height: 600px;"></div>
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
    <script>
        $(document).ready(function() {
            var map = L.map('map').setView([0, 0], 13);
            var marker = L.marker([0, 0]).addTo(map);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
            }).addTo(map);

            $('#dropdown-item').change(function() {
                var selectedValue = $(this).val();
                console.log(selectedValue);

                $.ajax({
                    url: '/maps/detail-data/' + selectedValue,
                    type: 'GET',
                    success: function(response) {
                        var newPosition = [response.latitude, response.longitude];
                        map.setView(newPosition, 18);
                        marker.setLatLng(newPosition);

                        var popupContent = `
    <section class="popup-content">
        <header><h4>Detail Lokasi</h4></header>
        <div><strong>Letak:</strong> ${response.letak}</div>
        <div><strong>Kelurahan:</strong> ${response.kelurahan}</div>
        <div><strong>Kecamatan:</strong> ${response.kecamatan}</div>
        <div><strong>Luas:</strong> ${response.luas}</div>
        <div><strong>Harga:</strong> ${response.harga_dasar}</div>
        <div><strong>NOP:</strong> ${response.nop}</div>
        <div><strong>Keterangan:</strong> ${response.keterangan}</div>
        <figure>
            ${
                response.foto ?
                `<img src="/storage/${response.foto}" alt="Foto" class="popup-image">
                                <figcaption>Foto Lokasi</figcaption>` :
                `<div class="no-photo">Tidak Ada Foto</div>`
            }
        </figure>
    </section>`;


                        marker.bindPopup(popupContent).openPopup();
                    }
                });
            });

            marker.on('popupopen', function() {
                // Sesuaikan nilai x dan y berdasarkan kebutuhan
                // Nilai y negatif untuk menggeser map ke atas
                map.panBy([0, -200], {
                    animate: true
                });
            });
        });
    </script>
    <script src="/assets/js/select2.min.js"></script>
@endpush
@push('customStyle')
    <link rel="stylesheet" href="/assets/css/select2.min.css">
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
@endpush

@push('customStyle')
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        .popup-content {
            width: 200px;
            font-family: Arial, sans-serif;
        }

        .popup-content header {
            margin-bottom: 10px;
        }

        .popup-content div,
        .popup-content figure {
            margin-bottom: 5px;
        }

        .popup-image {
            width: 100%;
            height: auto;
            margin-top: 10px;
        }

        figcaption {
            text-align: center;
            font-style: italic;
            margin-top: 5px;
        }

        .no-photo {
            padding: 10px;
            text-align: center;
            color: #666;
        }
    </style>
@endpush
