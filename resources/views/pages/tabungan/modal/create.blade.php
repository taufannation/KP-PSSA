<div class="modal fade" id="tabungan_create" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="data_form">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="tanggal_transaksi">Tanggal Transaksi</label>
                                <input type="text" name="tanggal_transaksi" id="tanggal_transaksi" class="form-control tanggal" autocomplete="off" onkeydown="return false;" onkeyup="return false;">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="kategori_tabungan_id">Jenis Tabungan</label>
                                <select id="kategori_tabungan_id_add_combo" class="form-control" disabled>
                                    @foreach($kategori_tabungans as $kategori_tabungan)
                                    <option value="{{ $kategori_tabungan->id }}">{{ '[' . $kategori_tabungan->nama . '] - ' . $kategori_tabungan->kode  }}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="kategori_tabungan_id" id="kategori_tabungan_id_add_hidden">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="jenis_transaksitabungan_id">Jenis Transaksi</label>
                                <select name="jenis_transaksitabungan_id" id="jenis_transaksitabungan_id" class="form-control">
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
                                <input type="text" name="keterangan" id="keterangan" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="debet">Debet</label>
                                <input type="text" name="debet" id="debet" class="form-control" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="kredit">Kredit</label>
                                <input type="text" name="kredit" id="kredit" class="form-control" autocomplete="off">

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