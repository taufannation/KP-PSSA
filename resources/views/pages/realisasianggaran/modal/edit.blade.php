<!-- Modal -->
<div class="modal fade" id="realisasianggaran_edit" data-backdrop="static" data-keyword="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                                <label for="kode">Kode</label>
                                <input type="number" name="kode" id="kode_edit" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="bulan">Bulan</label>
                                <select class="form-control" name="bulan" id="bulan_edit">
                                    @for ($i = 1; $i <= 12; $i++) <option value="{{ $i }}">{{ \Carbon\Carbon::create()->month($i)->format('F') }}</option>
                                        @endfor
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="tahun">Tahun</label>
                                @php
                                $currentYear = date('Y');
                                $yearRange = range($currentYear, $currentYear + 2); // Adjust the range as needed
                                @endphp

                                <select class="form-control" name="tahun" id="tahun_edit">
                                    @foreach ($yearRange as $year)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="deskripsi">Deskripsi</label>
                                <input type="text" name="deskripsi" id="deskripsi_edit" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="anggaran">Anggaran</label>
                                <input type="number" name="anggaran" id="anggaran_edit" class="form-control">
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="realisasi">Realisasi</label>
                                <input type="number" name="realisasi" id="realisasi_edit" class="form-control">
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
                url: "{{ asset('realisasianggaran/update/'. $data->id) }}",
data: idata,
processData: false,
contentType: false,
cache: false,
beforeSend: function() {
in_load();
},
success: function(data) {
toastr.success(''+data.status+'', ''+data.messages+'', 'success');
window.location.href= "{{ asset('realisasianggaran') }}"
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