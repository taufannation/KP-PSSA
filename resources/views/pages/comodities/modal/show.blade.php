<!-- Modal -->
<div class="modal fade" id="show_comodities" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Show Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <label for="item_code"><b>Kode Barang</b></label>
                        <input type="text" id="item_code_show" class="form-control" placeholder="" disabled>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <table class="table">
                        <tr>
                            <td style="width:145px;">
                                <b>Nama Barang</b>
                            </td>
                            <td style="width:20px">:</td>
                            <td id="name_show"></td>
                        </tr>
                        <tr>
                            <td>
                                <b>Lokasi</b>
                            </td>
                            <td>:</td>
                            <td id="comodity_locations_id_show"></td>
                        </tr>
                    </table>
                </div>
                <hr>
                <div class="row">
                    <div class="col-lg-4">
                        <label for="material"><b>Bahan</b></label>
                        <input type="text" id="material_show" class="form-control" placeholder="" disabled>
                    </div>
                    <div class="col-lg-4">
                        <label for="brand"><b>Merek</b></label>
                        <input type="text" id="brand_show" class="form-control" placeholder="" disabled>
                    </div>
                    <div class="col-lg-4">
                        <label for="date_of_purchase"><b>Tanggal Peroleh</b></label>
                        <input type="text" id="date_of_purchase_show" class="form-control" placeholder="" disabled>
                    </div>
                </div>
                <hr>
                <table>
                    <tr>
                        <td><b>Keterangan</b></td>
                        <td>:</td>
                        <td id="note_show"></td>
                    </tr>
                </table>
                <hr>
                <div class="row">
                    <div class="col-lg-4">
                        <label for="quantity"><b>Banyaknya</b></label>
                        <input type="text" id="quantity_show" class="form-control" placeholder="" disabled>
                    </div>
                    <div class="col-lg-4">
                        <label for="price"><b>Harga</b></label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Rp.</span>
                            </div>
                            <input type="text" id="price_show" class="form-control" placeholder="" disabled>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <label for="condition"><b>Kondisi Barang</b></label>
                        <input type="text" id="condition_show" class="form-control" placeholder="" disabled>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
            </div>
        </div>
    </div>
</div>