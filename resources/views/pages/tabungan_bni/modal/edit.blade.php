<!-- Modal -->
<div class="modal fade" id="tabungan_bni_edit" data-backdrop="static" data-keyword="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                                <label for="kode_bni_id">Kode</label>
                                <select name="kode_bni_id" id="kode_bni_id_edit" class="form-control">
                                    <option value="">- Pilih Kode Transaksi -</option>
                                    @foreach($kode_bnis as $kode_bni)
                                    <option value="{{ $kode_bni->id }}">{{ '[' . $kode_bni->kode . '] - ' . $kode_bni->nama  }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="nama_transaksi">Keterangan</label>
                                <input type="text" name="nama_transaksi" id="nama_transaksi_edit" class="form-control">
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
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="saldo">Saldo</label>
                                <input type="text" name="saldo" id="saldo_edit" class="form-control" autocomplete="off">
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
                url: "{{ asset('tabungan_bni/update/'. $data->id) }}",
data: idata,
processData: false,
contentType: false,
cache: false,
beforeSend: function() {
in_load();
},
success: function(data) {
toastr.success(''+data.status+'', ''+data.messages+'', 'success');
window.location.href= "{{ asset('tabungan_bni') }}"
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