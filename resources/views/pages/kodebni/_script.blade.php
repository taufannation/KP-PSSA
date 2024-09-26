<script type="text/javascript">
    $(document).ready(function() {
        $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": "{{ asset('kodebni') }}",
                "type": "get",
            },
            columns: [{
                    data: 'DT_RowIndex',
                    sClass: 'text-center',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'kode',
                    sClass: 'text-center'
                },
                {
                    data: 'nama',
                    sClass: 'text-center'

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


    // Create Data
    $('#data_form').on('submit', function(e) {
        e.preventDefault();
        idata = new FormData($('#data_form')[0]);
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{ asset('kodebni/store') }}",
            data: idata,
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                in_load();
            },
            success: function(data) {
                toastr.success('' + data.status + '', '' + data.messages + '', 'success');
                window.location.href = "{{ asset('kodebni') }}"
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
        let token = $("input[name=_token]").val();
        $('#swal-update-button').attr('data-id', id);
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "{{ asset('kodebni/edit') }}/" + id,
            data: {
                id: id,
                _token: token
            },
            beforeSend: function() {
                in_load();
            },
            success: function(data) {
                $("#kode_edit").val(data.data.kode);
                $("#nama_edit").val(data.data.nama);
            },
            error: function(error) {
                error_detail(error);
                out_load();
            }
        });

        // Update Data
        $('#swal-update-button').click(function(e) {
            e.preventDefault();
            let id = $('#swal-update-button').attr('data-id');
            let token = $("input[name=_token]").val();
            $.ajax({
                type: "PUT",
                dataType: "json",
                url: "{{ asset('kodebni/update') }}/" + id,
                data: {
                    _token: token,
                    kode: $('#kode_edit').val(),
                    nama: $('#nama_edit').val(),
                },
                cache: false,
                beforeSend: function() {
                    in_load();
                },
                success: function(data) {
                    toastr.success('' + data.status + '', '' + data.messages + '', 'success');
                    window.location.href = "{{ asset('kodebni') }}"
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
            url: "{{ asset('kodebni/show') }}/" + id,
            data: "_method=SHOW&_token=" + tokenCSRF,
            beforeSend: function() {
                in_load();
            },
            success: function(data) {
                console.log(data.data);
                $('#modalLabel').val(data.data.kode);
                $("#kode_show").html(data.data.kode);
                $("#nama_show").html(data.data.nama);
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
                    url: "{{ asset('/kodebni/destroy') }}/" + id,
                    data: "_method=DELETE&_token=" + tokenCSRF,
                    beforeSend: function() {
                        in_load();
                    },
                    success: function(data) {
                        toastr.success('' + data.status + '', '' + data.messages + '', 'success');
                        window.location.href = "{{ asset('kodebni') }}";
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
</script>