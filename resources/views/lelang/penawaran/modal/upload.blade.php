<form action="" method="post" enctype="multipart/form-data">
    <div class="modal fade" id="modal-upload" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload Dokumen</h5>
                </div>
                <div class="col-md-12">
                {{-- STS --}}
                    <div class="form-group">
                        <label class="control-label col-md-12" id="label_sts">Surat Tanda Setor (STS)</label>
                        <div>
                            <div class="col-md-12" style="margin-bottom:5px">
                                <span class="btn green-meadow fileinput-button btn-sm">
                                    <span class="pull-left" style="margin-right:2px">Pilih File</span>
                                    <input type="file" name="fileSts" field="fileSts" class="flUpload" id="flUpload_fileSts" data-inc="fileSts" onchange="autoUpload(this, 5000000, '.pdf', 'fileSts', 'Sts.pdf')">
                                </span>
                            </div>
                        </div>
                    </div>
                {{-- Pernyataan --}}
                    <div class="form-group">
                        <label class="control-label col-md-12" id="label_pernyataan">Surat Pernyataan</label>
                        <div>
                            <div class="col-md-12" style="margin-bottom:5px">
                                <span class="btn green-meadow fileinput-button btn-sm">
                                    <span class="pull-left" style="margin-right:2px">Pilih File</span>
                                    <input type="file" name="filePernyataan" field="filePernyataan" class="flUpload" id="flUpload_filePernyataan" data-inc="filePernyataan" onchange="autoUpload(this, 5000000, '.pdf', 'filePernyataan', 'Pernyataan.pdf')">
                                </span>
                            </div>
                        </div>
                    </div>
                {{-- Perjanjian --}}
                    <div class="form-group">
                        <label class="control-label col-md-12" id="label_perjanjian">Surat Perjanjian</label>
                        <div>
                            <div class="col-md-12" style="margin-bottom:5px">
                                <span class="btn green-meadow fileinput-button btn-sm">
                                    <span class="pull-left" style="margin-right:2px">Pilih File</span>
                                    <input type="file" name="filePerjanjian" field="filePerjanjian" class="flUpload" id="flUpload_filePerjanjian" data-inc="filePerjanjian" onchange="autoUpload(this, 5000000, '.pdf', 'filePerjanjian', 'Perjanjian.pdf')">
                                </span>
                            </div>
                        </div>
                    </div>
                {{-- Berita Acara --}}
                    <div class="form-group">
                        <label class="control-label col-md-12" id="label_ba">Berita Acara</label>
                        <div>
                            <div class="col-md-12" style="margin-bottom:5px">
                                <span class="btn green-meadow fileinput-button btn-sm">
                                    <span class="pull-left" style="margin-right:2px">Pilih File</span>
                                    <input type="file" name="fileBa" field="fileBa" class="flUpload" id="flUpload_fileBa" data-inc="fileBa" onchange="autoUpload(this, 5000000, '.pdf', 'fileBa', 'Ba.pdf')">
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" data-id="submit-import">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</form>
