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
                        {{-- <div class="profile-widget-header">
                            <img alt="image"
                                src="{{ Auth::user()->profile ? Storage::url(Auth::user()->profile->foto) : '' }}"
                                class="rounded-circle profile-widget-picture img-fluid"
                                style="width: 150px; height: 150px;">
                        </div> --}}
                        {{-- <div class="profile-widget-description">
                            <div class="profile-widget-name">{{ Auth::user()->name }}</div>
                            {{ Auth::user()->bio }}
                        </div> --}}
                        <div class="card-header">
                            <h4> <div class="profile-widget-name"> Hi, {{ Auth::user()->name }} !</div>
                                {{ Auth::user()->bio }}</h4>
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
                    {{-- <div class="card">
                        <form method="POST" action="{{ route('user-profile-information.update') }}"
                            class="needs-validation" novalidate="">
                            @csrf
                            @method('PUT')
                            <div class="card-header">
                                <h4>Ubah Informasi Login</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-6 col-12">
                                        <label>Username</label>
                                        <input name="username" type="text"
                                            class="form-control @error('username', 'updateProfileInformation')
                                    is-invalid
                                    @enderror"
                                            value="{{ Auth::user()->username }}">
                                        @error('username', 'updateProfileInformation')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6 col-12">
                                        <label>Email</label>
                                        <input name="email" type="email"
                                            class="form-control @error('email', 'updateProfileInformation')
                                    is-invalid
                                    @enderror"
                                            value="{{ Auth::user()->email }}">
                                        @error('email', 'updateProfileInformation')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary" type="submit">Ubah Profil</button>
                            </div>
                        </form>
                    </div> --}}
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
                                    <div class="form-group col-md-6 col-12">
                                        <label>Email</label>
                                        <input name="email" type="email"
                                            class="form-control @error('email', 'updateProfileInformation') is-invalid
                                    @enderror"
                                            value="{{ Auth::user()->email }}">
                                        @error('email', 'updateProfileInformation')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 col-12">
                                        <label>Nama Pejabat</label>
                                        <input name="nama_pejabat" type="text"
                                            class="form-control @error('nama_pejabat') is-invalid @enderror"
                                            value="{{ Auth::user()->profile ? Auth::user()->profile->nama_pejabat : '' }}">
                                        @error('nama_pejabat')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
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
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4 col-12">
                                        <label>NIP</label>
                                        <input name="nip_pejabat" type="text"
                                            class="form-control @error('nip_pejabat') is-invalid @enderror"
                                            value="{{ Auth::user()->profile ? Auth::user()->profile->nip_pejabat : '' }}">
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
                                                value="{{ Auth::user()->no_sk }}">
                                            @error('no_sk', 'updateProfileInformation')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4 col-12">
                                            <label>HK</label>
                                            <input name="hk" type="hk"
                                                class="form-control @error('hk', 'updateProfileInformation') is-invalid
                                        @enderror"
                                                value="{{ Auth::user()->hk }}">
                                            @error('hk', 'updateProfileInformation')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 col-12">
                                        <label for="jabatan">Jabatan</label>
                                        <select class="form-control select2" @error('jabatan') is-invalid @enderror name="jabatan">
                                        <option value="">Pilih Jabatan</option>
                                    </select>
                                    @error('jabatan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    </div>
                                    <div class="form-group col-md-6 col-12">
                                        <label for="opd">OPD</label>
                                        <select class="form-control select2" @error('opd') is-invalid @enderror name="opd">
                                        <option value="">Pilih OPD</option>
                                    </select>
                                    @error('opd')
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
        document.getElementById('show_foto').addEventListener('change', function() {
            var fotoUploadForm = document.getElementById('foto_upload_form');
            fotoUploadForm.style.display = this.checked ? 'block' : 'none';
        });

        document.getElementById('show_ktp').addEventListener('change', function() {
            var fotoUploadForm = document.getElementById('ktp_upload_form');
            fotoUploadForm.style.display = this.checked ? 'block' : 'none';
        });

        function submitDel(id) {
            $('#del-' + id).submit()
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var showFotoCheckbox = document.getElementById("show_foto");
            var showKtpCheckbox = document.getElementById("show_ktp");
            var fotoUploadForm = document.getElementById('foto_upload_form');
            var ktpUlploadForm = document.getElementById('ktp_upload_form');

            if ({{ Auth::user()->profile ? json_encode(Auth::user()->profile->foto) : 'null' }} === null) {
                showFotoCheckbox.checked = true;
                fotoUploadForm.style.display = 'block';
            }

            if ({{ Auth::user()->profile ? json_encode(Auth::user()->profile->ktp) : 'null' }} === null) {
                showKtpCheckbox.checked = true;
                ktpUlploadForm.style.display = 'block';
            }
        });
    </script>
@endpush

@push('customStyle')
    <link rel="stylesheet" href="/assets/css/select2.min.css">
@endpush
