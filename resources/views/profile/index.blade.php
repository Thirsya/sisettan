@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Ubah Profile</h1>
        </div>

        <div class="section-body">
            <h2 class="section-title">Hai, {{ Auth::user()->name }}!</h2>
            <div class="row">
                <div class="col-12">
                    @include('layouts.alert')
                </div>
            </div>
            <p class="section-lead">
                Ubah informasi tentang diri Anda di halaman ini.
            </p>
            <div class="row mt-sm-4">
                <div class="col-12 col-md-12 col-lg-5">
                    <div class="card profile-widget">
                        <div class="profile-widget-header">
                            <img alt="image"
                                src="{{ Auth::user()->profile ? Storage::url(Auth::user()->profile->foto) : '' }}"
                                class="rounded-circle profile-widget-picture img-fluid"
                                style="width: 150px; height: 150px;">

                            <!-- <div class="profile-widget-items">
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">Unggahan</div>
                                    <div class="profile-widget-item-value">187</div>
                                </div>
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">Pengikut</div>
                                    <div class="profile-widget-item-value">6,8K</div>
                                </div>
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">Mengikuti</div>
                                    <div class="profile-widget-item-value">2,1K</div>
                                </div>
                            </div> -->
                        </div>
                        <div class="profile-widget-description">
                            <div class="profile-widget-name">{{ Auth::user()->name }}</div>

                            {{ Auth::user()->bio }}
                        </div>
                        <!-- <div class="card-footer text-center">
                            <div class="font-weight-bold mb-2">Ikuti {{ Auth::user()->name }} Aktif</div>
                            <a href="#" class="btn btn-social-icon btn-facebook mr-1">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="btn btn-social-icon btn-twitter mr-1">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="btn btn-social-icon btn-github mr-1">
                                <i class="fab fa-github"></i>
                            </a>
                            <a href="#" class="btn btn-social-icon btn-instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </div> -->
                    </div>
                    <div class="card">
                        <form method="POST" action="{{ route('user-password.update') }}" class="needs-validation"
                            novalidate="">
                            @csrf
                            @method('PUT')
                            <div class="card-header">
                                <h4>Ubah Kata Sandi</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-6 col-12">
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
                                    <div class="form-group col-md-6 col-12">
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
                                    <div class="form-group col-md-6 col-12">
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
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary" type="submit">Ubah Kata Sandi</button>
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
                                        <label>Nama</label>
                                        <input name="name" type="name"
                                            class="form-control @error('name', 'updateProfileInformation')
                                    is-invalid
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
                                    <div class="form-group col-md-6 col-12">
                                        <label>NIK</label>
                                        <input name="nik" type="text"
                                            class="form-control @error('nik') is-invalid @enderror"
                                            value="{{ Auth::user()->profile ? Auth::user()->profile->nik : '' }}">
                                        @error('nik')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6 col-12">
                                        <label>Tanggal Lahir</label>
                                        <input name="tanggal_lahir" type="date"
                                            class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                            value="{{ Auth::user()->profile ? Auth::user()->profile->tanggal_lahir : '' }}">
                                        @error('tanggal_lahir')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12 col-12">
                                        <label>Alamat</label>
                                        <input name="alamat" type="text"
                                            class="form-control @error('alamat') is-invalid @enderror"
                                            value="{{ Auth::user()->profile ? Auth::user()->profile->alamat : '' }}">
                                        @error('alamat')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 col-12">
                                        <label for="jenis_kelamin">Jenis Kelamin</label>
                                        <select class="form-control select2 @error('jenis_kelamin') is-invalid @enderror"
                                            name="jenis_kelamin" id="jenis_kelamin">
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="L"
                                                {{ Auth::user()->profile && Auth::user()->profile->jenis_kelamin === 'L' ? 'selected' : '' }}>
                                                Laki-Laki</option>
                                            <option value="P"
                                                {{ Auth::user()->profile && Auth::user()->profile->jenis_kelamin === 'P' ? 'selected' : '' }}>
                                                Perempuan</option>
                                        </select>
                                        @error('jenis_kelamin')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6 col-12">
                                        <label>No HP</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-phone"></i>
                                                </div>
                                            </div>
                                            <input name="no_hp" type="text"
                                                class="form-control phone-number @error('no_hp') is-invalid @enderror"
                                                value="{{ Auth::user()->profile ? Auth::user()->profile->no_hp : '' }}">
                                        </div>
                                        @error('no_hp')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="show_foto"
                                                id="show_foto">
                                            <label class="form-check-label" for="show_foto">
                                                Perbarui Foto
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="show_ktp"
                                                id="show_ktp">
                                            <label class="form-check-label" for="show_ktp">
                                                Perbarui KTP
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12 col-12" id="foto_upload_form"
                                        style="{{ old('show_foto') ? '' : 'display: none' }}">
                                        <div class="form-group">
                                            <label>Unggah Foto</label>
                                            <input name="foto" type="file"
                                                class="form-control @error('foto') is-invalid @enderror">
                                        </div>
                                        @error('foto')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-12 col-12" id="ktp_upload_form"
                                        style="{{ old('show_ktp') ? '' : 'display: none' }}">
                                        <div class="form-group">
                                            <label>Unggah KTP</label>
                                            <input name="ktp" type="file"
                                                class="form-control @error('ktp') is-invalid @enderror">
                                        </div>
                                        @error('ktp')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
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
