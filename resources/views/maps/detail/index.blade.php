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

                                <section class="section">
                                    <div class="col-12 col-lg-12 col-md-6 d-flex justify-content">
                                        <div class="row" style="width: 1200px">
                                            <div class="col-12 col-md-12 col-lg-5">
                                                <div class="card-header letak">
                                                    <h4>Letak : </h4>
                                                </div>
                                                <div class="card-header kecamatan">
                                                    <h4>Kecamatan : </h4>
                                                </div>
                                                <div class="card-header kelurahan">
                                                    <h4>Kelurahan : </h4>
                                                </div>
                                                <div class="card-header luas">
                                                    <h4>Luas : </h4>
                                                </div>
                                                <div class="card-header harga">
                                                    <h4>Harga: </h4>
                                                </div>
                                                <div class="card-header nop">
                                                    <h4>NOP : </h4>
                                                </div>
                                                <div class="card-header keterangan">
                                                    <h4>Keterangan : </h4>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </section>
                                <div class="d-flex justify-content-center">
                                    {{-- {{ $tkds->withQueryString()->links() }} --}}
                                </div>
                            </div>
                            <div id="map" style="height: 400px;"></div>
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
            var map = L.map('map').setView([0, 0], 13); // Initialize map with arbitrary values
            var marker = L.marker([0, 0]).addTo(map); // Initialize marker with arbitrary values

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
            }).addTo(map);

            $('#dropdown-item').change(function() {
                var selectedOption = $(this).find('option:selected');
                var selectedValue = selectedOption.val();
                console.log(selectedValue);

                $.ajax({
                    url: '/maps/detail-data/' + selectedValue,
                    type: 'GET',
                    success: function(response) {
                        console.log(response);

                        var newPosition = [response.latitude, response.longitude];
                        map.setView(newPosition, 13);
                        marker.setLatLng(newPosition).bindPopup(response.letak).openPopup();

                        $('.letak').html('<h4>Letak : ' + response.letak + '</h4>');
                        $('.kelurahan').html('<h4>Kelurahan : ' + response.kelurahan + '</h4>');
                        $('.kecamatan').html('<h4>Kecamatan : ' + response.kecamatan + '</h4>');
                        $('.luas').html('<h4>Luas : ' + response.luas + '</h4>');
                        $('.harga').html('<h4>Harga : ' + response.harga_dasar + '</h4>');
                        $('.nop').html('<h4>NOP : ' + response.nop + '</h4>');
                        $('.keterangan').html('<h4>Keterangan : ' + response.keterangan +
                            '</h4>');
                    }
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
@endpush
