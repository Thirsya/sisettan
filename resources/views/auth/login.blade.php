<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>{{ config('app.name') }} - Login</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="../node_modules/bootstrap-social/bootstrap-social.css">
    @stack('customStyle')
    <!-- Template CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/components.css">
</head>

<body>
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="row">
                    <div
                        class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                        <div class="login-brand">
                            <H1>Lelang Sewaaa</H1>
                        </div>
                        <div class="card card-primary">
                            <div class="card-header">
                                <p style="font-family: 'Roboto', sans-serif; font-size: 14px; font-weight: bold;">
                                    Silahkan masukkan username dan password terlebih dahulu !</p>
                            </div>
                            <div class="card-body">
                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif
                                <form action="{{ route('login') }}" method="POST" class="needs-validation"
                                    novalidate="">
                                    @csrf
                                    {{-- <div class="form-group">
                                        <select class="form-control select2" @error('tahun_lelang') is-invalid @enderror
                                            name="tahun_lelang" id="dropdown-item">
                                            <option value="">Tahun Lelang</option>
                                            @foreach ($tahun as $item)
                                                <option value="{{ $item->id }}" data-tahun="{{ $item->tahun }}">
                                                    {{ $item->tahun }}</option>
                                            @endforeach
                                        </select>
                                        @error('tahun')
                                            <div class="invalid-feedback">
                                                {{ $message }}

                                            </div>
                                        @enderror
                                    </div> --}}
                                    <div class="form-group">
                                        <input type="username" name="username" value="{{ old('username') }}"
                                            class="form-control @error('username') is-invalid @enderror"
                                            placeholder="Username" id="username" style="display: block   ;">
                                        @error('username')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            placeholder="Password" id="password" style="display: block;">
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group" id="dropdownKelurahan" style="display: none;">
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
                                    <div class="form-group">
                                        <button id="masuk" type="submit" class="btn btn-primary btn-lg btn-block"
                                            tabindex="4" style="display: block;">
                                            Masuk
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="simple-footer">
                            Copyright &copy; Stisla 2018
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- General JS Scripts -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="../assets/js/stisla.js"></script>

    <!-- JS Libraies -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- Template JS File -->
    <script src="../assets/js/scripts.js"></script>
    <script src="../assets/js/custom.js"></script>


    <script>
        $(document).ready(function() {
            $('#dropdown-item').on('change', function() {
                var username = document.getElementById('username');
                var password = document.getElementById('password');
                var dropdownKelurahan = document.getElementById('dropdownKelurahan');
                var masuk = document.getElementById('masuk');
                username.style.display = 'none';
                password.style.display = 'none';
                dropdownKelurahan.style.display = 'block';
                masuk.style.display = 'block';
            });
        });
        // });
    </script>
    <script>
        $(document).ready(function() {
            $('#dropdown-item').on('change', function() {
                var selectedYearId = $(this).find(':selected').data('tahun');
                $('#dropdownKelurahan').on('change', function() {
                    var selectedKelurahanId = $(this).find(':selected').data('id');
                    console.log(selectedKelurahanId);
                });
                if (selectedYearId) {

                    $.ajax({
                        url: '{{ route('requestAjaxLogin') }}',
                        type: 'GET',
                        data: {
                            'tahun_id': selectedYearId
                        },
                        success: function(data) {
                            // console.log(data);
                            var kelurahanDropdown = $('[name="kelurahan"]');
                            kelurahanDropdown.empty();
                            kelurahanDropdown.append(
                                '<option value="">Pilih Kelurahan</option>');

                            var kecamatanGroups = {};

                            data.forEach(function(daerah) {
                                if (!kecamatanGroups[daerah.kecamatan]) {
                                    kecamatanGroups[daerah.kecamatan] = [];
                                }
                                kecamatanGroups[daerah.kecamatan].push(daerah);
                            });

                            for (var kecamatan in kecamatanGroups) {
                                var optgroup = $('<optgroup>').attr('label', 'Kec.' +
                                    kecamatan);
                                kecamatanGroups[kecamatan].forEach(function(daerah) {
                                    var optionText = '[Kel.' + daerah.kelurahan +
                                        '] - tgl:' + daerah.tanggal_lelang;
                                    var option = $('<option>').attr('value', daerah.id)
                                        .attr('data-id', daerah.id_kelurahan)
                                        .text(optionText);
                                    optgroup.append(option);
                                });
                                kelurahanDropdown.append(optgroup);
                            }

                            $('#dropdownKelurahan').show();
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.error("AJAX error: ", textStatus, errorThrown);
                        }
                    });
                }
            });
        });
    </script>
    {{-- <script>
        $(document).ready(function() {
            $('#masuk').on('click', function(e) {
                e.preventDefault();

                var selectedYearId = $('#dropdown-item').find(':selected').data('tahun');
                var selectedKelurahanId = $('#dropdownKelurahan').find(':selected').data('id');

                var usernameValue = $('#username').val();
                var passwordValue = $('#password').val();
                if (selectedYearId) {
                    $.ajax({
                        url: '{{ route('login') }}',
                        type: 'POST',
                        data: {
                            '_token': '{{ csrf_token() }}',
                            'username': usernameValue,
                            'password': passwordValue,
                        },
                        success: function(response) {

                            $.ajax({
                                url: '{{ route('setSessionTahun') }}',
                                type: 'POST',
                                data: {
                                    '_token': '{{ csrf_token() }}',
                                    'tahun_id': selectedYearId,
                                    'kelurahan_id': selectedKelurahanId,

                                },
                                success: function(response) {
                                    console.log('Tahun disimpan dalam session:',
                                        selectedYearId);
                                    $('#masuk').unbind('click')
                                        .click();
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    console.error("AJAX error: ", textStatus,
                                        errorThrown);
                                }
                            });
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.error("AJAX error: ", textStatus, errorThrown);
                        }
                    });
                }
            });
        });
    </script> --}}
    @stack('customScript')
</body>

</html>
