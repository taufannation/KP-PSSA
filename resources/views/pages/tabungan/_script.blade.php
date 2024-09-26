<script type="text/javascript">
    var oTable;
    $(document).ready(function() {
        oTable = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": "{{ asset('tabungan') }}",
                "type": "get",
                "data": function(data) {
                    data.start_date = $("#startDate").val();
                    data.end_date = $("#endDate").val();
                    data.kategori_tabungan_id = $("#filter_kategori_tabungan_id").val();
                    data.enable_filter = $("[name=enable_filter]:checked").val();
                },
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
                    render: DataTable.render.datetime('D MMMM YYYY'),
                    width: '100'
                },
                {
                    data: 'nama_kategori_tabungan',
                    sClass: 'text-center',
                    width: '100'
                },
                {
                    data: 'nama_jenis_transaksi_tabungan',
                    sClass: 'text-center'
                },
                {
                    data: 'keterangan',
                    sClass: 'text-center'
                },
                {
                    data: 'debet',
                    sClass: 'text-right',
                    render: function(data) {
                        return formatRupiah(data);
                    },
                    width: '70'
                },
                {
                    data: 'kredit',
                    sClass: 'text-right',
                    render: function(data) {
                        return formatRupiah(data);
                    },
                    width: '70'
                },
                {
                    data: 'saldo',
                    sClass: 'text-right',
                    render: function(data) {
                        return formatRupiah(data);
                    },
                    width: '70'

                },
                {
                    data: 'act',
                    sClass: 'text-center',
                    orderable: false,
                    searchable: false,
                    width: '100'
                },
            ],
            order: []
        });
    });


    document.getElementById('filter_kategori_tabungan_id').addEventListener('change', function() {
        oTable.ajax.reload();

        var kategori_tabungan = document.getElementById('filter_kategori_tabungan_id').value;
        document.getElementById('kategori_tabungan_id_add_combo').value = kategori_tabungan;
        document.getElementById('kategori_tabungan_id_add_hidden').value = kategori_tabungan;
    });

    var kategori_tabungan = document.getElementById('filter_kategori_tabungan_id').value;
    document.getElementById('kategori_tabungan_id_add_combo').value = kategori_tabungan;
    document.getElementById('kategori_tabungan_id_add_hidden').value = kategori_tabungan;

    /* FILTER CHECBOX */
    document.getElementById('enableFilter').addEventListener('change', function() {
        var startDateInput = document.getElementById('startDate');
        var endDateInput = document.getElementById('endDate');

        if (this.checked) {
            // Jika checkbox dicentang, aktifkan input tanggal
            startDateInput.removeAttribute('disabled');
            endDateInput.removeAttribute('disabled');
        } else {
            // Jika checkbox tidak dicentang, nonaktifkan input tanggal
            startDateInput.setAttribute('disabled', true);
            endDateInput.setAttribute('disabled', true);
        }

        oTable.ajax.reload();
    });

    /* FILTER TANGGAL */
    $('.tanggal-filter').daterangepicker({
        locale: {
            format: 'DD-MM-YYYY'
        },
        singleDatePicker: true,
        showDropdowns: true
    });

    /* FILTER TANGGAL SAAT DIPILIH */
    $('.tanggal-filter').on('apply.daterangepicker', function(ev, picker) {
        oTable.ajax.reload();
    });

    $('.btn-filter-action').on('click', function() {
        var dataUrl = $(this).data('url');
        $('#form_filter').attr('action', dataUrl).submit();
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
            url: "{{ asset('tabungan/store') }}",
            data: idata,
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                in_load();
            },
            success: function(data) {
                toastr.success('' + data.status + '', '' + data.messages + '', 'success');
                window.location.href = "{{ asset('tabungan') }}";
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
            url: "{{ asset('tabungan/edit') }}/" + id,
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
                $('#kategori_tabungan_id_edit_hidden').val(data.data.kategori_tabungan_id);
                $('#kategori_tabungan_id_edit_combo').val(data.data.kategori_tabungan_id);
                $('#jenis_transaksitabungan_id_edit').val(data.data.jenis_transaksitabungan_id);
                $('#keterangan_edit').val(data.data.keterangan);
                $('#debet_edit').val(formatRupiah(data.data.debet));
                $('#kredit_edit').val(formatRupiah(data.data.kredit));
                $('#saldo_edit').val(formatRupiah(data.data.saldo));
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
                url: "{{ asset('tabungan/update') }}/" + id,
                data: {
                    _token: token,
                    tanggal_transaksi: $('#tanggal_transaksi_edit').val(),
                    kategori_tabungan_id: $('#kategori_tabungan_id_edit_hidden').val(),
                    jenis_transaksitabungan_id: $('#jenis_transaksitabungan_id_edit').val(),
                    keterangan: $('#keterangan_edit').val(),
                    debet: $('#debet_edit').val(),
                    kredit: $('#kredit_edit').val(),
                    saldo: $('#saldo_edit').val()

                },
                cache: false,
                beforeSend: function() {
                    in_load();
                },
                success: function(data) {
                    toastr.success('' + data.status + '', '' + data.messages + '', 'success');
                    window.location.href = "{{ asset('tabungan') }}";
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
            url: "{{ asset('tabungan/show') }}/" + id,
            data: "_method=SHOW&_token=" + tokenCSRF,
            beforeSend: function() {
                in_load();
            },
            success: function(data) {
                var kode_dan_kategori_tabungan = '';
                var data_kategori_tabungan = data.data.kategori_tabungan;

                if (data_kategori_tabungan.hasOwnProperty('kode')) {
                    kode_dan_kategori_tabungan = data_kategori_tabungan['nama'] + ' - [' + data_kategori_tabungan['kode'] + ']';
                }

                var kode_dan_jenis_transaksi_tabungan = '';
                var data_jenis_transaksi_tabungan = data.data.jenis_transaksi_tabungan;

                if (data_jenis_transaksi_tabungan.hasOwnProperty('kode')) {
                    kode_dan_jenis_transaksi_tabungan = data_jenis_transaksi_tabungan['nama'] + ' - [' + data_jenis_transaksi_tabungan['kode'] + ']';
                }

                $('#modalLabel').html("Show Data");
                $('#tanggal_transaksi_show').html(formatTanggal(data.data.tanggal_transaksi));
                $('#kode_show').html(data.data.kode);
                $('#kode_dan_kategori_tabungan_show').html(kode_dan_kategori_tabungan);
                $('#kode_dan_jenis_transaksi_tabungan_show').html(kode_dan_jenis_transaksi_tabungan);
                $('#keterangan_show').html(data.data.keterangan);
                $('#debet_show').html(formatRupiah(data.data.debet));
                $('#kredit_show').html(formatRupiah(data.data.kredit));
                $('#saldo_show').html(formatRupiah(data.data.saldo));
                $('#tabungan_show').modal('show');
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
                    url: "{{ url('/tabungan/destroy') }}/" + id,
                    data: "_method=DELETE&_token=" + tokenCSRF,
                    beforeSend: function() {
                        in_load();
                    },
                    success: function(data) {
                        toastr.success('' + data.status + '', '' + data.messages + '', 'success');
                        window.location.href = "{{ asset('tabungan') }}";
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


    var tanpa_rupiah = document.getElementById('debet');
    tanpa_rupiah.addEventListener('keyup', function(e) {
        tanpa_rupiah.value = formatRupiah(this.value);
    });
    var kredit_input = document.getElementById('kredit');
    kredit_input.addEventListener('keyup', function(e) {
        kredit_input.value = formatRupiah(this.value);
    });
    var saldo_input = document.getElementById('saldo');
    saldo_input.addEventListener('keyup', function(e) {
        saldo_input.value = formatRupiah(this.value);
    });

    /* FORM EDIT */
    var debet_edit = document.getElementById('debet_edit');
    debet_edit.addEventListener('keyup', function(e) {
        debet_edit.value = formatRupiah(this.value);
    });
    var kredit_edit = document.getElementById('kredit_edit');
    kredit_edit.addEventListener('keyup', function(e) {
        kredit_edit.value = formatRupiah(this.value);
    });
    var saldo_edit = document.getElementById('saldo_edit');
    saldo_edit.addEventListener('keyup', function(e) {
        saldo_edit.value = formatRupiah(this.value);
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

    function formatTanggal(tanggal) {
        if (tanggal.length) {
            var tanggalFormat = tanggal.split('-');
            tanggal = tanggalFormat[2] + '-' + tanggalFormat[1] + '-' + tanggalFormat[0];
        }
        return tanggal;
    }
</script>