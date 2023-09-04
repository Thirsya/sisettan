@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Ubah Profile</h1>
        </div>
        <div class="section-body">
            <h2 class="section-title">Ubah informasi tentang diri Anda di halaman ini.</h2>
            <div class="row">
                <div class="col-12">
                    @include('layouts.alert')
                </div>
            </div>
            <div class="row mt-sm-4">
                <div class="col-12 col-md-12 col-lg-5">
                    <div class="card">
                        <div class="card-header">
                            <h4>
                                <div class="profile-widget-name"> Hi, {{ Auth::user()->name }} !</div>
                                {{ Auth::user()->bio }}
                            </h4>
                        </div>
                    </div>
                    <div class="card" style="height: 470px">
                        <form method="POST" action="{{ route('user-password.update') }}" class="needs-validation"
                            novalidate="">
                            @csrf
                            @method('PUT')
                            <div class="card-header">
                                <h4>Ubah Kata Sandi</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-12 col-12">
                                        <label for="current_password">Kata Sandi Saat Ini</label>
                                        <input id="current_password" type="password"
                                            class="form-control select @error('current_password', 'updatePassword') is-invalid @enderror"
                                            data-indicator="pwindicator" name="current_password" tabindex="2">
                                        @error('current_password', 'updatePassword')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        <div id="pwindicator" class="pwindicator">
                                            <div class="bar"></div>
                                            <div class="label"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12 col-12">
                                        <label for="password">Kata Sandi Baru</label>
                                        <input id="password" type="password"
                                            class="form-control select @error('password', 'updatePassword') is-invalid @enderror"
                                            data-indicator="pwindicator" name="password" tabindex="2">
                                        @error('password', 'updatePassword')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        <div id="pwindicator" class="pwindicator">
                                            <div class="bar"></div>
                                            <div class="label"></div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12 col-12">
                                        <label for="password_confirmation">Konfirmasi Kata Sandi</label>
                                        <input id="password_confirmation" type="password"
                                            class="form-control select @error('password_confirmation') is-invalid @enderror"
                                            data-indicator="pwindicator" name="password_confirmation" tabindex="2">
                                        @error('password_confirmation')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        <div id="pwindicator" class="pwindicator">
                                            <div class="bar"></div>
                                            <div class="label"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right" style="padding-top: 5px">
                                    <button class="btn btn-primary" type="submit">Ubah Kata Sandi</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-7">
                    <div class="card">
                        <form method="POST" action="{{ route('profile.user.update') }}" class="needs-validation"
                            novalidate="" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-header">
                                <h4>Ubah Data Diri</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-6 col-12">
                                        <label>Username</label>
                                        <input name="username" type="text"
                                            class="form-control @error('username', 'updateProfileInformation') is-invalid
                                    @enderror"
                                            value="{{ Auth::user()->username }}">
                                        @error('username', 'updateProfileInformation')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 col-12">
                                        <label>Nama</label>
                                        <input name="name" type="name"
                                            class="form-control @error('name', 'updateProfileInformation') is-invalid
                                    @enderror"
                                            value="{{ Auth::user()->name }}">
                                        @error('name', 'updateProfileInformation')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6 col-12">
                                        <label for="id_pejabat">Pilih Nama Pejabat</label>
                                        <select id="id_pejabat" class="form-control select2" name="id_pejabat">
                                            <option value="">Pilih Jabatan</option>
                                            @foreach ($pejabat as $listPejabat)
                                                <option value="{{ $listPejabat->id }}"
                                                    data-nip="{{ $listPejabat->nip_pejabat }}"
                                                    data-opd="{{ $listPejabat->id_opd }}"
                                                    data-jabatan="{{ $listPejabat->jabatan }}"
                                                    data-no_sk="{{ $listPejabat->no_sk }}"
                                                    {{ old('id_pejabat', $currentIdPejabat) == $listPejabat->id ? 'selected' : '' }}>
                                                    {{ $listPejabat->nama_pejabat }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('jabatan')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4 col-12">
                                        <label>NIP</label>
                                        <input id="nip_pejabat" name="nip_pejabat" type="text"
                                            class="form-control @error('nip_pejabat') is-invalid @enderror" value=""
                                            readonly>
                                        @error('nip_pejabat')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4 col-12">
                                        <label>Nomor SK</label>
                                        <input name="no_sk" type="no_sk"
                                            class="form-control @error('no_sk', 'updateProfileInformation') is-invalid
                                        @enderror"
                                            value="" readonly>
                                        @error('no_sk', 'updateProfileInformation')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4 col-12">
                                        <label>HK</label>
                                        <input name="hk" type="text"
                                            class="form-control @error('hk', 'updateProfileInformation') is-invalid @enderror"
                                            value="{{ old('hk', $currentProfile->hk ?? '') }}">
                                        @error('hk', 'updateProfileInformation')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4 col-12">
                                        <label>Jabatan</label>
                                        <input name="jabatan" type="jabatan"
                                            class="form-control @error('jabatan', 'updateProfileInformation') is-invalid
                                        @enderror"
                                            value="" readonly>
                                        @error('jabatan', 'updateProfileInformation')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4 col-12">
                                        <label>Opd</label>
                                        <input name="opd" type="opd"
                                            class="form-control @error('opd', 'updateProfileInformation') is-invalid
                                        @enderror"
                                            value="" readonly>
                                        @error('opd', 'updateProfileInformation')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button class="btn btn-primary" type="submit">Perbarui Data Diri</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('customScript')
    <script src="/assets/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            function populateFields() {
                const selectedOption = $('#id_pejabat').find('option:selected');
                const nip = selectedOption.data('nip');
                const opd = selectedOption.data('opd');
                const jabatan = selectedOption.data('jabatan');
                const no_sk = selectedOption.data('no_sk');

                $('#nip_pejabat').val(nip);
                $('[name="opd"]').val(opd);
                $('[name="jabatan"]').val(jabatan);
                $('[name="no_sk"]').val(no_sk);
            }
            populateFields();
            $('#id_pejabat').on('change', function() {
                populateFields();
            });
        });
    </script>
@endpush

@push('customStyle')
    <link rel="stylesheet" href="/assets/css/select2.min.css">
@endpush
