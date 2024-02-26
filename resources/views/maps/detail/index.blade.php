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
                                    {{-- @foreach ($bukti as $item)
                                        <option @selected($buktiSelected == $item->id) value="{{ $item->id }}"
                                            data-bukti="{{ $item->bukti }}">
                                            {{ $item->bukti }}
                                        </option>
                                    @endforeach --}}
                                </select>
                                @error('bukti')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="show-search mb-3">
                                <section class="section">
                                    <div class="col-12 col-lg-12 col-md-6 d-flex justify-content-center">
                                        <div class="row" style="width: 1200px">
                                            <div class="col-12 col-md-12 col-lg-5">
                                                <div class="card-header">
                                                    <h4>Letak : </h4>
                                                </div>
                                                <div class="card-header">
                                                    <h4>Kelurahan :  </h4>
                                                </div>
                                                <div class="card-header">
                                                    <h4>Kecamatan :  </h4>
                                                </div>
                                                <div class="card-header">
                                                    <h4>Luas :  </h4>
                                                </div>
                                                <div class="card-header">
                                                    <h4>Harga:  </h4>
                                                </div>
                                                <div class="card-header">
                                                    <h4>NOP : </h4>
                                                </div>
                                                <div class="card-header">
                                                    <h4>Keterangan :  </h4>
                                                </div>
                                            </div>
                                            <div class="col-5">
                                                <h1>MAPS</h1>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                {{--
                                letak
                                kelurahan
                                kecamatan
                                luas
                                harga
                                nop
                                keterangan --}}
                            </div>
                            <div class="table-responsive">

                                <div class="d-flex justify-content-center">
                                    {{-- {{ $tkds->withQueryString()->links() }} --}}
                                </div>
                            </div>
                        </div></div>
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
@endpush

@push('customStyle')
@endpush
