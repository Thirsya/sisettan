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
    <form action="{{ route('storeJquery') }}" method="POST" enctype="multipart/form-data">
        <div class="modal fade" id="modal-sewa" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Pengumuman Masa Sewa</h5>
                    </div>
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Kecamatan<span class="text-danger">*</span></label>
                            <select class="form-control select2 @error('id_kecamatan') is-invalid @enderror"
                                name="id_kecamatan" data-id="select-kecamatan" id="id_kecamatan">
                                <option value="">Piih Kecamatan</option>
                            </select>
                            @error('id_kecamatan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Kelurahan<span class="text-danger">*</span></label>
                            <select class="form-control select2 @error('id_kelurahan') is-invalid @enderror"
                                name="id_kelurahan" data-id="select-kelurahan" id="id_kelurahan">
                                <option value="">Piih Kelurahan</option>
                            </select>
                            @error('id_kelurahan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>No Berita Acara</label>
                            <input type="text" id="noba" name="noba"
                                class="form-control @error('noba') is-invalid @enderror" placeholder="Masukan Noba"
                                autocomplete="off">
                            @error('noba')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Periode<span class="text-danger">*</span></label>
                            <input type="text" id="periode" name="periode"
                                class="form-control @error('periode') is-invalid @enderror" placeholder="Masukan Periode"
                                autocomplete="off">
                            @error('periode')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Tahun<span class="text-danger">*</span></label>
                            <select class="form-control select2 @error('thn_sts') is-invalid @enderror" name="thn_sts"
                                data-id="select-tahun" id="thn_sts">
                                <option value="">Piih Tahun</option>
                            </select>
                            @error('thn_sts')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Tanggal Lelang<span class="text-danger">*</span></label>
                            <input type="date" id="tanggal_lelang" name="tanggal_lelang"
                                class="form-control @error('tanggal_lelang') is-invalid @enderror"
                                placeholder="Masukan Tanggal Lelang" autocomplete="off">
                            @error('tanggal_lelang')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button id="saveChanges" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
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
                        if (daerah.tanggal_lelang == null) {
                            var optionText = daerah.kelurahan;
                        } else {
                            var optionText = '[' + daerah.kelurahan + '] - tgl: ' + daerah
                                .tanggal_lelang;
                        }
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
                        console.log("Data Request Ajax Login: ", data);
                        populateKelurahanDropdown(data);
                        $('#dropdownKelurahan').show();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error("AJAX error: ", textStatus, errorThrown);
                    }
                });
            }

            $('#dropdown-item').on('change', function() {
                selectedYearId = $(this).find(':selected').val();
                console.log("Selected Year ID: " + selectedYearId);

                selectedDaerahId = null;
                $('#dropdownKelurahan').hide();
                console.log('pilih tahun', selectedYearId);
                if (selectedYearId) {
                    $.ajax({
                        url: '{{ route('requestAjaxLogin') }}',
                        type: 'GET',
                        data: {
                            'tahun_id': selectedYearId
                        },
                        success: function(data) {
                            console.log('Data Request Ajax Selected Year: ', data);
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
                if (selectedYearId !== null) {
                    $.ajax({
                        url: '{{ route('storeSelectedValues') }}',
                        type: 'POST',
                        data: {
                            'tahun_id': selectedYearId,
                            'kelurahan_id': selectedDaerahId,
                        },
                        success: function(data) {
                            console.log("Milih data di kecamatan dan kelurahan berhasil!");

                            $.ajax({
                                url: '{{ route('getTotalDaerah') }}',
                                type: 'GET',
                                success: function(data) {
                                    console.log(selectedDaerahId);
                                    console.log("Tampil Data");
                                    console.log(data);
                                    if (data.totalDaerah == 0) {
                                        $('#modal-sewa').modal('show');

                                    }
                                }
                            });

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
            $('#modal-sewa').on('shown.bs.modal', function() {
                $.ajax({
                    url: '/getKelurahansDashboard',
                    type: 'GET',
                    success: function(data) {
                        console.log(data);
                        $('#id_kelurahan').empty();
                        $('#id_kecamatan').empty();
                        $('#thn_sts').empty();
                        $.each(data, function(key, kelurahan) {
                            console.log(data.tahunSelected)
                            $('#id_kelurahan').append('<option value="' + kelurahan.id +
                                '">' + kelurahan.kelurahan + '</option>');
                            $('#id_kecamatan').append('<option value="' + kelurahan
                                .id_kecamatan + '">' + kelurahan.kecamatan +
                                '</option>');
                        });
                        $('#thn_sts').append('<option value="' + data.tahunSelected.id + '">' +
                            data.tahunSelected.tahun + '</option>');
                    }
                });

            });

            $('#id_kecamatan').change(function() {
                $('#hidden_id_kecamatan').val($(this).val());
            });

            $('#id_kelurahan').change(function() {
                $('#hidden_id_kelurahan').val($(this).val());
            });

            $("#saveChanges").on('click', function(e) {
                e.preventDefault();

                console.log("Button clicked!");

                var kecamatanId = $('#id_kecamatan').val();
                var kelurahanId = $('#id_kelurahan').val();
                var noba = $('#noba').val();
                var periode = $('#periode').val();
                var thn_sts = $('#thn_sts').val();
                var tanggal_lelang = $('#tanggal_lelang').val();

                var formData = {
                    'id_kecamatan': kecamatanId,
                    'id_kelurahan': kelurahanId,
                    'noba': noba,
                    'periode': periode,
                    'thn_sts': thn_sts,
                    'tanggal_lelang': tanggal_lelang
                };

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{ route('storeJquery') }}',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            $('#modal-sewa').modal('hide');
                            window.location.assign('/dashboard');
                        } else {
                            alert('Terjadi kesalahan saat menyimpan.');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error("AJAX error: ", textStatus, errorThrown);
                        alert('Terjadi kesalahan saat menyimpan.');
                    }
                });
            });

        });
    </script>
    <script>
        $(document).ready(function() {
            function updateStatistics() {
                $.getJSON('/total-pendaftar', function(data) {
                    $('#totalPendaftar').text(data.totalPendaftar || '--');
                });
                $.getJSON('/total-tkd', function(data) {
                    $('#totalTkd').text(data.totalTkd || '--');
                });
                $.getJSON('/total-penawaran', function(data) {
                    $('#totalPenawaran').text(data.totalPenawaran || '--');
                });
            }

            setInterval(updateStatistics, 1000);
            updateStatistics();
        });
    </script>
@endpush

@push('customStyle')
    <link rel="stylesheet" href="/assets/css/select2.min.css">
@endpush
