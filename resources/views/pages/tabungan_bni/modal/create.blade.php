<div class="modal fade" id="tabungan_bni_create" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                                <label for="kode_bni_id">Kode</label>
                                <select name="kode_bni_id" id="kode_bni_id" class="form-control">
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
                                <input type="text" name="nama_transaksi" id="nama_transaksi" class="form-control" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="debet">Debet</label>
                                <input type="text" name="debet" id="tanpa_rupiah" class="form-control" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="kredit">Kredit</label>
                                <input type="text" name="kredit" id="kredit" class="form-control" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="saldo">Saldo</label>
                                <input type="text" name="saldo" id="saldo" class="form-control" placeholder="Hanya diisi di pengisian pertama" autocomplete="off">

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