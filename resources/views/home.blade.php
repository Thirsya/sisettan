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
            <div class="row">
              <div class="col-12 col-md-4 col-lg-3">
                <div class="pricing pricing-highlight">
                  <div class="pricing-title">
                    Filter
                  </div>
                  <div class="pricing-padding" style="font-size: 15px">
                    <div class="pricing-price">
                      <div style="font-size: 30px">Filter Data</div>
                      <div>Silahkan pilih tahun lelang terlebih dahulu !</div>
                    </div>
                    <div class="form-group" >
                      <select class="form-control select2" @error('tahun_lelang') is-invalid @enderror
                          name="tahun_lelang" id="dropdown-item">
                          <option value="">Tahun Lelang</option>
                          @foreach ($tahun as $item)
                              <option value="{{ $item->id }}" data-tahun="{{ $item->tahun }}">
                                  {{ $item->tahun }}</option>
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
                  <div class="pricing-cta">
                    <a href="#">Kirim <i class="fas fa-arrow-right"></i></a>
                  </div>
                </div>
              </div>
            </div>
              <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                  <div class="card-icon bg-danger">
                    <i class="fas fa-user"></i>
                  </div>
                  <div class="card-wrap">
                    <div class="card-header">
                      <h4>Total Pendaftar</h4>
                    </div>
                    <div class="card-body">
                      47
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                  <div class="card-icon bg-success">
                    <i class="fas fa-newspaper"></i>
                  </div>
                  <div class="card-wrap">
                    <div class="card-header">
                      <h4>Total TKD</h4>
                    </div>
                    <div class="card-body">
                      47
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                  <div class="card-icon bg-warning">
                    <i class="fas fa-file"></i>
                  </div>
                  <div class="card-wrap">
                    <div class="card-header">
                      <h4>Total Penawaran</h4>
                    </div>
                    <div class="card-body">
                      47
                    </div>
                  </div>
                </div>
              </div>
            </div>
            </div>

        </section>
    </section>
@endsection
