<!-- Modal -->
<div class="modal fade" id="tabungan_edit" data-backdrop="static" data-keyword="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statisBackdropLabel">Ubah Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_edit">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="tanggal_transaksi">Tanggal Transaksi</label>
                                <input type="text" name="tanggal_transaksi" id="tanggal_transaksi_edit" class="form-control tanggal" autocomplete="off" onkeydown="return false;" onkeyup="return false;">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="kategori_tabungan_id_edit">Jenis Tabungan</label>
                                <select id="kategori_tabungan_id_edit_combo" class="form-control" disabled>
                                    @foreach($kategori_tabungans as $kategori_tabungan)
                                    <option value="{{ $kategori_tabungan->id }}">{{ '[' . $kategori_tabungan->nama . '] - ' . $kategori_tabungan->kode  }}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="kategori_tabungan_id" id="kategori_tabungan_id_edit_hidden">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="jenis_transaksitabungan_id_edit">Jenis Transaksi</label>
                                <select name="jenis_transaksitabungan_id" id="jenis_transaksitabungan_id_edit" class="form-control">
                                    <option value="">- Pilih Jenis Transaksi -</option>
                                    @foreach($jenis_transaksitabungans as $jenis_transaksitabungan)
                                    <option value="{{ $jenis_transaksitabungan->id }}">{{ '[' . $jenis_transaksitabungan->nama . '] - ' . $jenis_transaksitabungan->kode  }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="keterangan">Keterangan</label>
                                <input type="text" name="keterangan" id="keterangan_edit" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="debet">Debet</label>
                                <input type="text" name="debet" id="debet_edit" class="form-control" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="kredit">Kredit</label>
                                <input type="text" name="kredit" id="kredit_edit" class="form-control" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                        <button type="submit" data-id="" id="swal-update-button" class="btn btn-primary"><i class="fa fa-check-square"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('js_internal')
{{-- <script type="text/javascript">
    
        $('#form_edit').on('submit', function(e) {
            e.preventDefault();
            idata = new FormData($('#form_edit')[0]);
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ asset('tabungan/update/'. $data->id) }}",
data: idata,
processData: false,
contentType: false,
cache: false,
beforeSend: function() {
in_load();
},
success: function(data) {
toastr.success(''+data.status+'', ''+data.messages+'', 'success');
window.location.href= "{{ asset('tabungan') }}"
out_load();
},
error: function(error) {
error_detail(error);
out_load();
}
});
});
</script> --}}
@endpush