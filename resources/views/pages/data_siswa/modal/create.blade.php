<!-- Modal -->
<div class="modal fade" id="data_siswa_create" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Increased modal width -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="data_form" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <!-- Left column -->
                            <div class="form-group">
                                <label for="nama">Nama Siswa</label>
                                <input type="text" name="nama" id="nama" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="tempat_lahir">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="tanggal_lahir">TTL</label>
                                <input type="text" name="tanggal_lahir" id="tanggal_lahir" class="form-control tanggal" autocomplete="off" onkeydown="return false;" onkeyup="return false;">
                            </div>
                            <div class="form-group">
                                <label for="jenis_kelamin">Jenis Kelamin</label>
                                <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="pendidikan_terakhir">Pendidikan Terakhir</label>
                                <input type="text" name="pendidikan_terakhir" id="pendidikan_terakhir" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="nama_ayah">Nama Ayah</label>
                                <input type="text" name="nama_ayah" id="nama_ayah" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="nama_ibu">Nama Ibu</label>
                                <input type="text" name="nama_ibu" id="nama_ibu" class="form-control">
                            </div>
                        </div>
                        <!-- Right column -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pekerjaan_orangtua">Pekerjaan Orangtua</label>
                                <input type="text" name="pekerjaan_orangtua" id="pekerjaan_orangtua" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <input type="text" name="alamat" id="alamat" class="form-control" style="width: 100%;"> <!-- Full width -->
                            </div>
                            <div class="form-group">
                                <label for="tanggal_masuk">Tanggal Masuk</label>
                                <input type="text" name="tanggal_masuk" id="tanggal_masuk" class="form-control tanggal" autocomplete="off" onkeydown="return false;" onkeyup="return false;">

                            </div>
                            <div class="form-group">
                                <label for="tanggal_keluar">Tanggal Keluar</label>
                                <input type="text" name="tanggal_keluar" id="tanggal_keluar" class="form-control tanggal" autocomplete="off" onkeydown="return false;" onkeyup="return false;">
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <input type="text" name="status" id="status" class="form-control" style="width: 100%;"> <!-- Full width -->
                            </div>
                            <div class="form-group">
                                <label for="keterangan">Keterangan</label>
                                <input type="text" name="keterangan" id="keterangan" class="form-control" style="width: 100%;"> <!-- Full width -->
                            </div>
                            <div class="form-group">
                                <label for="foto">Tambahkan Foto</label>
                                <input type="file" name="foto" id="foto" class="form-control">
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                <button type="submit" class="btn btn-primary"><i class="fa fa-check-square"></i> Save</button>
            </div>
            </form>
        </div>
    </div>
</div>
</div>