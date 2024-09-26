<!-- Modal -->
<div class="modal fade" id="comodities_create" data-backdrop="static" data-keyword="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statisBackdropLabel">Add Data Asset</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="data_form">

                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="item_code">Kode Barang</label>
                                <input type="text" name="item_code" id="item_code" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="date_of_purchase">Tanggal Peroleh</label>
                                <input type="text" id="date_of_purchase" name="date_of_purchase" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="brand">Merek</label>
                                <input type="text" id="brand" name="brand" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="price">Harga</label>
                                <input type="text" id="price" name="price" class="form-control">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="name">Nama Barang</label>
                                <input type="text" id="name" name="name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="material">Bahan</label>
                                <input type="text" id="material" name="material" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Lokasi</label>
                                <select name="comodity_locations_id" id="comodity_locations_id" class="custom-select">
                                    <option>:: Pilih ::</option>
                                    @foreach ($comodity_locationss as $comodity_locations)
                                    <option value="{{ $comodity_locations->id }}">{{ $comodity_locations->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="condition">Kondisi Barang</label>
                                <select name="condition" id="condition" class="custom-select">
                                    <option>:: Pilih ::</option>
                                    <option value="1">Baru</option>
                                    <option value="2">Baik</option>
                                    <option value="3">Rusak</option>
                                    <option value="4">Hilang</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="quantity">Kuantitas</label>
                                <input type="number" name="quantity" id="quantity" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label for="note">Keterangan</label>
                                <textarea name="note" id="note" rows="5" class="form-control"></textarea>
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