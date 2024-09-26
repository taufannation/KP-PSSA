<!-- Modal -->
<div class="modal fade" id="kaskecil_show" data-backdrop="static" data-keyword="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Show Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <table class="table">
                        <tr>
                            <td style="width: 145px;">
                                <b>Tanggal Transaksi</b>
                            </td>
                            <td style="width: 20px;">:</td>
                            <td id="tanggal_transaksi_show" name="tanggal_transaksi" style="font-weight:900"></td>
                        </tr>
                        <tr>
                            <td>
                                <b>Kode</b>
                            </td>
                            <td>:</td>
                            <td id="kode_dan_mata_anggaran_show"></td>
                        </tr>
                        <tr>
                            <td>
                                <b>Keterangan</b>
                            </td>
                            <td>:</td>
                            <td id="nama_transaksi_show" name="nama_transaksi"></td>
                        </tr>
                        <tr>
                            <td>
                                <b>Debet</b>
                            </td>
                            <td>:</td>
                            <td id="debet_show" name="debet"></td>
                        </tr>
                        <tr>
                            <td>
                                <b>Kredit</b>
                            </td>
                            <td>:</td>
                            <td id="kredit_show" name="kredit"></td>
                        </tr>
                        <tr>
                            <td>
                                <b>Saldo</b>
                            </td>
                            <td>:</td>
                            <td id="saldo_show" name="saldo"></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
            </div>
        </div>
    </div>
</div>