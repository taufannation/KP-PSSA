<script type="text/javascript">
    $(document).ready(function() {
        $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": "{{ asset('realisasianggaran') }}",
                "type": "get",
            },
            columns: [{
                    data: 'DT_RowIndex',
                    sClass: 'text-center',
                    orderable: false,
                    searchable: false
                },
                {

                    data: 'tanggal_transaksi',
                    sClass: 'text-center',
                    render: DataTable.render.datetime('D MMMM YYYY')
                },
                {
                    data: 'kode',
                    sClass: 'text-center'
                },
                {
                    data: 'deskripsi',
                    sClass: 'text-center'
                },
                {
                    data: 'anggaran',
                    sClass: 'text-center',
                    render: function(data) {
                        return formatRupiah(data);
                    }
                },
                {
                    data: 'realisasi',
                    sClass: 'text-center',
                    render: function(data) {
                        return formatRupiah(data);
                    }
                },
                {
                    data: 'selisih',
                    sClass: 'text-center',
                    render: function(data) {
                        return formatRupiah(data);
                    }
                },
                {
                    data: 'persentase',
                    sClass: 'text-center',
                    render: function(data) {
                        return formatRupiah(data);

                    }
                },
                {
                    data: 'act',
                    sClass: 'text-center',
                    orderable: false,
                    searchable: false
                },

            ],
            order: []
        });
    });

    // TANGGAL TRANSAKSI FORM CREATE
    $('#tanggal_transaksi').daterangepicker({
        locale: {
            format: 'DD-MM-YYYY'
        },
        singleDatePicker: true,
        showDropdowns: true,
    });

    // Create Data
    $('#data_form').on('submit', function(e) {
        e.preventDefault();
        var idata = new FormData($('#data_form')[0]);
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{ asset('realisasianggaran/store') }}",
            data: idata,
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                in_load();
            },
            success: function(data) {
                toastr.success('' + data.status + '', '' + data.messages + '', 'success');
                window.location.href = "{{ asset('realisasianggaran') }}";
                out_load();
            },
            error: function(error) {
                error_detail(error);
                out_load();
            }
        });
    });

    //  Edit Data
    function edit_data(id) {
        var token = $("input[name=_token]").val();
        $('#swal-update-button').attr('data-id', id);
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "{{ asset('realisasianggaran/edit') }}/" + id,
            data: {
                id: id,
                _token: token
            },
            beforeSend: function() {
                in_load();
            },
            success: function(data) {
                $('#tanggal_transaksi_edit').val(formatTanggal(data.data.tanggal_transaksi));
                $('#kode_edit').val(data.data.kode);
                $('#deskripsi_edit').val(data.data.deskripsi);
                $('#anggaran_edit').val(formatRupiah(data.data.anggaran));
                $('#realisasi_edit').val(formatRupiah(data.data.realisasi));
                $('#persentase_edit').val(formatRupiah(data.data.persentase));

            },
            error: function(error) {
                error_detail(error);
                out_load();
            }
        });
        $('#tanggal_transaksi_edit').daterangepicker({
            locale: {
                format: 'DD-MM-YYYY'
            },
            singleDatePicker: true,
            showDropdowns: true,
        });

        // Update Data
        $('#swal-update-button').click(function(e) {
            e.preventDefault();
            var id = $('#swal-update-button').attr('data-id');
            var token = $("input[name=_token]").val();
            $.ajax({
                type: "PUT",
                dataType: "json",
                url: "{{ asset('realisasianggaran/update') }}/" + id,
                data: {
                    _token: token,
                    tanggal_transaksi: $('#tanggal_transaksi_edit').val(),
                    kode: $('#kode_edit').val(),
                    deskripsi: $('#deskripsi_edit').val(),
                    anggaran: $('#anggaran_edit').val(),
                    realisasi: $('#realisasi_edit').val(),
                    persentase: $('#persentase_edit').val(),



                },
                cache: false,
                beforeSend: function() {
                    in_load();
                },
                success: function(data) {
                    toastr.success('' + data.status + '', '' + data.messages + '', 'success');
                    window.location.href = "{{ asset('realisasianggaran') }}";
                    out_load();
                },
                error: function(error) {
                    error_detail(error);
                    out_load();
                }
            });
        });
    }

    //show data
    function show_data(id) {
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "{{ asset('realisasianggaran/show') }}/" + id,
            data: "_method=SHOW&_token=" + tokenCSRF,
            beforeSend: function() {
                in_load();
            },
            success: function(data) {
                console.log(data.data);
                $('#modalLabel').html("Show Data");
                $('#tanggal_transaksi_show').html(formatTanggal(data.data.tanggal_transaksi));
                $('#kode_show').html(data.data.kode);
                $('#deskripsi_show').html(data.data.deskripsi);
                $('#anggaran_show').html(formatRupiah(data.data.anggaran));
                $('#realisasi_show').html(formatRupiah(data.data.realisasi));
                $('#selisih_show').html(formatRupiah(data.data.selisih));
                $('#persentase_show').html(formatRupiah(data.data.persentase));
                $('#realisasianggaran_show').modal('show');
                out_load();
            },
            error: function(error) {
                error_detail(error);
                out_load();
            }
        });
    }


    // Delete Data
    function delete_data(id) {
        swal({
            title: "Konfirmasi Hapus !",
            text: "Apakah anda yakin ingin menghapus Data ?",
            icon: "warning",
            buttons: {
                cancel: "Batal",
                confirm: "Ya, Hapus !",
            },
            dangerMode: true
        }).then((deleteFile) => {
            if (deleteFile) {
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ url('/realisasianggaran/destroy') }}/" + id,
                    data: "_method=DELETE&_token=" + tokenCSRF,
                    beforeSend: function() {
                        in_load();
                    },
                    success: function(data) {
                        toastr.success('' + data.status + '', '' + data.messages + '', 'success');
                        window.location.href = "{{ asset('realisasianggaran') }}";
                        out_load();
                    },
                    error: function(error) {
                        error_detail(error);
                        out_load();
                    }
                });
            }
        });
    }
    var tanpa_rupiah = document.getElementById('anggaran_rupiah');
    tanpa_rupiah.addEventListener('keyup', function(e) {
        tanpa_rupiah.value = formatRupiah(this.value);
    });
    var realisasi_input = document.getElementById('realisasi_rupiah');
    realisasi_input.addEventListener('keyup', function(e) {
        realisasi_input.value = formatRupiah(this.value);

    });

    /* Fungsi */
    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }
</script>

































































<!-- <script type="text/javascript">
    $(document).ready(function() {
        $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            language: {
                "Processing": "Processing...Please wait"
            },
            ajax: {
                type: "GET",
                url: "{{ asset('kaskecil') }}" // Menggunakan url() untuk menghasilkan URL lengkap
            },
            columns: [{
                    data: 'DT_RowIndex',
                    sClass: 'text-center',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'tanggal_transaksi',
                    sClass: 'text-center'
                },
                {
                    data: 'no_transaksi',
                    sClass: 'text-center'
                },
                {
                    data: 'nama_transaksi',
                    sClass: 'text-center'
                },
                {
                    data: 'debet',
                    sClass: 'text-center'
                },
                {
                    data: 'kredit',
                    sClass: 'text-center'
                },
                {
                    data: 'saldo',
                    sClass: 'text-center'
                },
                {
                    data: 'act',
                    sClass: 'text-center',
                    orderable: false,
                    searchable: false
                }
            ],
            order: []
        });

        // Create Data
        $('#data_form').on('submit', function(e) {
            e.preventDefault();
            idata = new FormData($('#data_form')[0]);
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ asset('kaskecil/store') }}", // Menggunakan url() untuk menghasilkan URL lengkap
                data: idata,
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function() {
                    in_load();
                },
                success: function(data) {
                    toastr.success('' + data.status + '', '' + data.messages + '', 'success');
                    window.location.href = "{{ asset('kaskecil') }}"; // Menggunakan url() untuk menghasilkan URL lengkap
                    out_load();
                },
                error: function(error) {
                    error_detail(error);
                    out_load();
                }
            });
        });

        // Edit Data
        function edit_data(id) {
            let token = $('input[name=_token]').val();
            $('#swal-update-button').attr('data-id', id);
            $.ajax({
                type: "GET",
                url: "{{ asset('kaskecil/edit') }}/" + id,
                data: {
                    id: id,
                    _token: token
                },
                beforeSend: function() {
                    in_load();
                },
                success: function(data) {
                    console.log(data.data);
                    $('#tanggal_transaksi_edit').val(data.data.tanggal_transaksi);
                    $('#no_transaksi_edit').val(data.data.no_transaksi);
                    $('#nama_transaksi_edit').val(data.data.nama_transaksi);
                    $('#debet_edit').val(data.data.debet);
                    $('#kredit_edit').val(data.data.kredit);
                    $('#saldo_edit').val(data.data.saldo);
                    $('#keterangan_edit').val(data.data.keterangan);
                },
                error: function(error) {
                    error_detail(error);
                    out_load();
                }
            });

            // Update Data
            // Update Data
            $('#form_edit').on('submit', function(e) {
                e.preventDefault();
                let id = $('#swal-update-button').attr('data-id');
                let token = $('input[name=_token]').val();
                $.ajax({
                    type: "PUT",
                    dataType: "json",
                    url: "{{ asset('kaskecil/update') }}/" + id,
                    data: {
                        _token: token,
                        tanggal_transaksi: $('#tanggal_transaksi_edit').val(),
                        no_transaksi: $('#no_transaksi_edit').val(),
                        nama_transaksi: $('#nama_transaksi_edit').val(),
                        debet: $('#debet_edit').val(),
                        kredit: $('#kredit_edit').val(),
                        saldo: $('#saldo_edit').val(),
                        keterangan: $('#keterangan_edit').val(),
                    },
                    cache: false,
                    beforeSend: function() {
                        in_load();
                    },
                    success: function(data) {
                        toastr.success('' + data.status + '', '' + data.messages + '', 'success');
                        window.location.href = "{{ asset('kaskecil') }}"
                        out_load();
                    },
                    error: function(error) {
                        error_detail(error);
                        out_load();
                    }
                });
            });
        }

        function show_data(id) {
            $.ajax({
                type: "GET",
                dataType: "json",
                url: "{{ asset('/kaskecil/show') }}/" + id,
                data: "_method=SHOW&_token=" + tokenCSRF,
                beforeSend: function() {
                    in_load();
                },
                success: function(data) {
                    console.log(data.data);
                    $('#modalLabel').html("Show Data");
                    $('#tanggal_transaksi_show').val(data.data.tanggal_transaksi);
                    $('#no_transaksi_show').html(data.data.no_transaksi);
                    $('#nama_transaksi_show').html(data.data.nama_transaksi);
                    $('#debet_show').val(data.data.debet);
                    $('#kredit_show').val(data.data.kredit);
                    $('#saldo_show').val(data.data.saldo);
                    $('#keterangan_show').html(data.data.keterangan);
                },
                error: function(error) {
                    error_detail(error);
                    out_load();
                }
            });
        }

        // Delete Data
        function delete_data(id) {
            swal({
                title: "Konfirmasi Hapus !",
                text: "Apakah anda yakin ingin menghapus Data ?",
                icon: "warning",
                buttons: {
                    cancel: "Batal",
                    confirm: "Ya, Hapus !",
                },
                dangerMode: true
            }).then((deleteFile) => {
                if (deleteFile) {
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "{{ asset('kaskecil/destroy') }}/" + id,
                        data: "_method=DELETE&_token=" + tokenCSRF,
                        beforeSend: function() {
                            in_load();
                        },
                        success: function(data) {
                            toastr.success('' + data.status + '', '' + data.messages + '', 'success');
                            window.location.href = "{{ asset('kaskecil') }}"; // Menggunakan url() untuk menghasilkan URL lengkap
                            out_load();
                        },
                        error: function(error) {
                            error_detail(error);
                            out_load();
                        }
                    });
                }
            });
        }
    });
</script> -->