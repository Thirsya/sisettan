<form action="" method="post" enctype="multipart/form-data">
    <div class="modal fade" id="modal-upload" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload Dokumen</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <form >
                            <label style="display: inline-block; margin-right: 20px;"><input type="radio" name="jenis" value="STS"> STS </label>
                            <label style="display: inline-block; margin-right: 20px;"> <input type="radio" name="jenis" value="Pernyataan"> Pernyataan </label>
                            <label style="display: inline-block; margin-right: 20px;"> <input type="radio" name="jenis" value="Perjanjian"> Perjanjian </label>
                        </form>
                    </div>
                    {{-- <div class="form-group">
                        <label class="custom-file-label @error('import-file', 'ImportDaerahRequest') is-invalid @enderror" for="file-upload">Choose File</label>
                        <input type="file" id="file-upload" class="custom-file-input" name="import-file" data-id="send-import">
                    </div> --}}
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" data-id="submit-import">Import File</button>
                 </div>
            </div>
        </div>
    </div>

</form>
