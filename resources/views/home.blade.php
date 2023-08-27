@extends('layouts.app')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Components</a></div>
            </div>
        </div>
        <section class="section">
            <div class="col-12 col-lg-12 col-md-6 d-flex justify-content-center">
                <div class="row" style="width: 1200px">
                    <div class="col-12 col-md-4 col-lg-7">
                        <div class="pricing pricing-highlight">
                            <div class="pricing-title">
                                Filter
                            </div>
                            <div class="pricing-padding" style="font-size: 15px; height: 335px">
                                <div class="pricing-price">
                                    <div style="font-size: 30px">Filter Data</div>
                                    <div>Silahkan pilih tahun lelang terlebih dahulu !</div>
                                </div>
                                <div class="form-group">
                                    <select class="form-control select2" name="tahun_lelang" id="dropdown-item">
                                        <option value="">Tahun Lelang</option>
                                        @foreach ($tahun as $item)
                                            <option @selected($tahunSelected == $item->id) value="{{ $item->id }}"
                                                data-tahun="{{ $item->tahun }}">
                                                {{ $item->tahun }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('jenis_kelamin')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group" id="dropdownKelurahan">
                                    <select class="form-control select2" @error('kelurahan') is-invalid @enderror
                                        name="kelurahan">
                                        <option value="">Pilih Kelurahan</option>
                                    </select>
                                    @error('kelurahan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="col-lg-12 col-md-6 col-sm-6 col-12">
                            <div class="card card-statistic-2">
                                <div class="card-icon bg-danger">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="card-wrap">
                                    <div class="card-header">
                                        <h4>Total Pendaftar</h4>
                                    </div>
                                    <div class="card-body" id="totalPendaftar">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-6 col-sm-6 col-12">
                            <div class="card card-statistic-2">
                                <div class="card-icon bg-success">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="card-wrap">
                                    <div class="card-header">
                                        <h4>Total TKD</h4>
                                    </div>
                                    <div class="card-body" id="totalTkd">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-6 col-sm-6 col-12">
                            <div class="card card-statistic-2">
                                <div class="card-icon bg-warning">
                                    <i class="fas fa-file"></i>
                                </div>
                                <div class="card-wrap">
                                    <div class="card-header">
                                        <h4>Total Penawaran</h4>
                                    </div>
                                    <div class="card-body" id="totalPenawaran">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
@endsection

@push('customScript')
    <script src="/assets/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            var selectedYearId = {{ $tahunSelected ?? 'null' }};
            var selectedDaerahId = {{ $daerahSelected ?? 'null' }};
            if (selectedDaerahId) {
                console.log('selected Daerah :' + selectedDaerahId);
            }

            function populateKelurahanDropdown(data) {
                var selectedDaerahId = {{ $daerahSelected ?? 'null' }};
                var kelurahanDropdown = $('[name="kelurahan"]');
                kelurahanDropdown.empty();
                kelurahanDropdown.append('<option value="">Pilih Kelurahan</option>');

                var kecamatanGroups = {};

                data.forEach(function(daerah) {
                    if (!kecamatanGroups[daerah.kecamatan]) {
                        kecamatanGroups[daerah.kecamatan] = [];
                    }
                    kecamatanGroups[daerah.kecamatan].push(daerah);
                });

                for (var kecamatan in kecamatanGroups) {
                    var optgroup = $('<optgroup>').attr('label', 'Kec.' + kecamatan);
                    kecamatanGroups[kecamatan].forEach(function(daerah) {
                        var optionText = '[Kel.' + daerah.kelurahan + '] - tgl:' + daerah.tanggal_lelang;
                        var option = $('<option>').attr('value', daerah.id)
                            .attr('data-id', daerah.id)
                            .text(optionText);
                        console.log(daerah.id);
                        console.log(selectedDaerahId);
                        console.log(daerah.id === parseInt(selectedDaerahId));
                        if (daerah.id === parseInt(selectedDaerahId)) {
                            option.attr('selected', 'selected');
                        }

                        optgroup.append(option);
                    });
                    kelurahanDropdown.append(optgroup);
                }
            }

            if (selectedYearId) {
                $.ajax({
                    url: '{{ route('requestAjaxLogin') }}',
                    type: 'GET',
                    data: {
                        'tahun_id': selectedYearId
                    },
                    success: function(data) {
                        populateKelurahanDropdown(data);
                        $('#dropdownKelurahan').show();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error("AJAX error: ", textStatus, errorThrown);
                    }
                });
            }

            // Handle year selection
            $('#dropdown-item').on('change', function() {
                selectedYearId = $(this).find(':selected').val();
                console.log("Selected Year ID: " + selectedYearId);

                selectedDaerahId = null;
                $('#dropdownKelurahan').hide();
                if (selectedYearId) {
                    $.ajax({
                        url: '{{ route('requestAjaxLogin') }}',
                        type: 'GET',
                        data: {
                            'tahun_id': selectedYearId
                        },
                        success: function(data) {
                            populateKelurahanDropdown(data);

                            $('#dropdownKelurahan').show();
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.error("AJAX error: ", textStatus, errorThrown);
                        }
                    });
                }
            });

            $('#dropdownKelurahan').on('change', function() {
                selectedDaerahId = $(this).find(':selected').val();
                if (selectedYearId) {
                    $.ajax({
                        url: '{{ route('storeSelectedValues') }}',
                        type: 'POST',
                        data: {
                            'tahun_id': selectedYearId,
                            'kelurahan_id': selectedDaerahId,
                        },
                        success: function(data) {
                            console.log("Selected values stored.");
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.error("AJAX error: ", textStatus, errorThrown);
                        }
                    });
                }
            });

            if (selectedYearId) {
                $('#dropdown-item').val(selectedYearId).trigger('change');
                if (selectedDaerahId) {
                    $('#dropdownKelurahan').val(selectedDaerahId);
                }
            }
        });
    </script>
    <script>
        function updateStatistics() {
            fetch('/total-pendaftar')
                .then(response => response.json())
                .then(data => {
                    const totalPendaftarElement = document.getElementById('totalPendaftar');
                    totalPendaftarElement.textContent = data.totalPendaftar || '--';
                });
            fetch('/total-tkd')
                .then(response => response.json())
                .then(data => {
                    const totalTkdElement = document.getElementById('totalTkd');
                    totalTkdElement.textContent = data.totalTkd || '--';
                });
            fetch('/total-penawaran')
                .then(response => response.json())
                .then(data => {
                    const totalPenawaranElement = document.getElementById('totalPenawaran');
                    totalPenawaranElement.textContent = data.totalPenawaran || '--';
                });
        }

        // Update every 10 seconds
        setInterval(updateStatistics, 1000);

        // Update immediately on page load
        updateStatistics();
    </script>
@endpush

@push('customStyle')
    <link rel="stylesheet" href="/assets/css/select2.min.css">
@endpush
