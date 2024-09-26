<!-- Modal -->
<div class="modal fade" id="data_siswa_edit" data-backdrop="static" data-keyword="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                                <label for="nama">Nama</label>
                                <input type="text" name="nama" id="nama_edit" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="tanggal_lahir">TTL</label>
                                <input type="text" name="tanggal_lahir" id="tanggal_lahir_edit" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="jenis_kelamin">Jenis Kelamin</label>
                                <select name="jenis_kelamin" id="jenis_kelamin_edit" class="form-control">
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="pendidikan_terakhir">Pendidikan Terakhir</label>
                                <input type="text" name="pendidikan_terakhir" id="pendidikan_terakhir_edit" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="nama_ayah">Nama Ayah</label>
                                <input type="text" name="nama_ayah" id="nama_ayah_edit" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="nama_ibu">Nama Ibu</label>
                                <input type="text" name="nama_ibu" id="nama_ibu_edit" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="pekerjaan_orangtua">Pekerjaan Orangtua</label>
                                <input type="text" name="pekerjaan_orangtua" id="pekerjaan_orangtua_edit" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <input type="text" name="alamat" id="alamat_edit" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="tanggal_masuk">Tanggal Masuk</label>
                                <input type="date" name="tanggal_masuk" id="tanggal_masuk_edit" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="tanggal_keluar">Tanggal Keluar</label>
                                <input type="date" name="tanggal_keluar" id="tanggal_keluar_edit" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <input type="text" name="status" id="status_edit" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="keterangan">keterangan</label>
                                <input type="text" name="keterangan" id="keterangan_edit" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="foto_edit">Foto</label>
                                <div id="foto_edit"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="foto">Tambahkan Foto</label>
                                <input type="file" name="foto" id="foto" class="form-control">
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
                url: "{{ asset('data_siswa/update/'. $data->id) }}",
data: idata,
processData: false,
contentType: false,
cache: false,
beforeSend: function() {
in_load();
},
success: function(data) {
toastr.success(''+data.status+'', ''+data.messages+'', 'success');
window.location.href= "{{ asset('data_siswa') }}"
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