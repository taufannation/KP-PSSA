<script type="text/javascript">
    $(document).ready(function() {
        $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": "{{ asset('data_pengajar') }}",
                "type": "get",
            },
            columns: [{
                    data: 'DT_RowIndex',
                    sClass: 'text-center',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'foto',
                    render: function(data, type, full, meta) {
                        var imageUrl = "{{ asset('fotopengajar') }}" + '/' + data;
                        console.log(imageUrl);
                        return '<img src="' + imageUrl + '" class="img-thumbnail" alt="Foto" style="width:50px;height:50px;">';
                    },
                    sClass: 'text-center'


                },
                {
                    sClass: 'text-center',
                    data: 'no_ktp',
                    sClass: 'text-center'
                },
                {

                    data: 'nama',
                    sClass: 'text-center'
                },
                {
                    data: 'jenis_kelamin',
                    sClass: 'text-center'
                },
                {
                    data: 'usia',
                    sClass: 'text-center'
                },
                {
                    data: 'alamat',
                    sClass: 'text-center'
                },
                {
                    data: 'jabatan',
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
        var idata = new FormData($('#data_form')[0]);
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{ asset('data_pengajar/store') }}",
            data: idata,
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                in_load();
            },
            success: function(data) {
                toastr.success('' + data.status + '', '' + data.messages + '', 'success');
                window.location.href = "{{ asset('data_pengajar') }}";
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
            url: "{{ asset('data_pengajar/edit') }}/" + id,
            data: {
                id: id,
                _token: token
            },
            beforeSend: function() {
                in_load();
            },
            success: function(data) {
                $("#no_ktp_edit").val(data.data.no_ktp);
                $("#nama_edit").val(data.data.nama);
                $("#jenis_kelamin_edit").val(data.data.jenis_kelamin);
                $("#usia_edit").val(data.data.usia);
                $("#alamat_edit").val(data.data.alamat);
                $("#jabatan_edit").val(data.data.jabatan);
            },
            error: function(error) {
                error_detail(error);
                out_load();
            }
        });

        // Update Data
        $('#swal-update-button').click(function(e) {
            e.preventDefault();
            var id = $('#swal-update-button').attr('data-id');
            var token = $("input[name=_token]").val();
            $.ajax({
                type: "PUT",
                dataType: "json",
                url: "{{ asset('data_pengajar/update') }}/" + id,
                data: {
                    _token: token,
                    no_ktp: $('#no_ktp_edit').val(),
                    nama: $('#nama_edit').val(),
                    jenis_kelamin: $('#jenis_kelamin_edit').val(),
                    usia: $('#usia_edit').val(),
                    alamat: $('#alamat_edit').val(),
                    jabatan: $('#jabatan_edit').val()
                },
                cache: false,
                beforeSend: function() {
                    in_load();
                },
                success: function(data) {
                    toastr.success('' + data.status + '', '' + data.messages + '', 'success');
                    window.location.href = "{{ asset('data_pengajar') }}";
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
            url: "{{ asset('data_pengajar/show') }}/" + id,
            data: "_method=SHOW&_token=" + tokenCSRF,
            beforeSend: function() {
                in_load();
            },
            success: function(data) {
                console.log(data.data);
                $('#modalLabel').html("Show Data");
                $("#no_ktp_show").html(data.data.no_ktp);
                $("#nama_show").html(data.data.nama);
                var jenisKelaminText = (data.data.jenis_kelamin === 'L') ? 'Laki-laki' : 'Perempuan';
                $("#jenis_kelamin_show").html(jenisKelaminText);
                $("#usia_show").html(data.data.usia);
                $("#alamat_show").html(data.data.alamat);
                $("#jabatan_show").html(data.data.jabatan);
                $('#data_pengajar_show').modal('show');
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
                    url: "{{ url('/data_pengajar/destroy') }}/" + id, // Ganti dengan URL yang sesuai
                    data: "_method=DELETE&_token=" + tokenCSRF,
                    beforeSend: function() {
                        in_load();
                    },
                    success: function(data) {
                        toastr.success('' + data.status + '', '' + data.messages + '', 'success');
                        window.location.href = "{{ asset('data_pengajar') }}"; // Ganti dengan route yang sesuai untuk index
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