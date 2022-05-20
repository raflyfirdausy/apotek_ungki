<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0 text-dark"><b><?= $title ?></b> | <?= $app_name ?></h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">

        <?php if ($this->session->flashdata("gagal")) : ?>
            <div class="alert bg-danger alert-dismissible fade show" role="alert">
                <strong>Gagal !</strong> <?= $this->session->flashdata("gagal") ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php unset($_SESSION["gagal"]);
        endif; ?>

        <?php if ($this->session->flashdata("sukses")) : ?>
            <div class="alert bg-success alert-dismissible fade show" role="alert">
                <strong>Sukses !</strong> <?= $this->session->flashdata("sukses") ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php unset($_SESSION["sukses"]);
        endif; ?>


        <div class="container-fluid">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <a href="<?= back() ?>" type="button" class="btn btn-primary float-left"><i class="fas fa-chevron-left"></i> Kembali</a>
                    <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#modal_tambah"><i class="fas fa-plus"></i> Tambah Data <?= $title ?></button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table_data" class="table table-sm nowrap table-bordered table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 3%">No.</th>
                                    <th style="width: 8%">Aksi</th>
                                    <th>Nama Suplier</th>
                                    <th>Alamat</th>
                                    <th>Kota</th>
                                    <th>No Telp</th>
                                    <th>No Rekening</th>
                                    <th>Nama Bank</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade myModal" id="modal_tambah">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Form Tambah <?= $title ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="form_add" action="<?= base_url("master/apotek/suplier/add") ?>" enctype='multipart/form-data'>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="recipient-name" class="control-label">Nama Suplier <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama" id="nama" required>
                            </div>
                            <div class="col-md-6">
                                <label for="recipient-name" class="control-label">Alamat <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="alamat" id="alamat" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="recipient-name" class="control-label">Kota <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="kota" id="kota" required>
                            </div>
                            <div class="col-md-6">
                                <label for="recipient-name" class="control-label">No Telp <span class="text-danger">*</span></label>
                                <input type="text" onkeyup="validate(this)" class="form-control" name="no_telp" id="no_telp">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="recipient-name" class="control-label">Nomor Rekening <span class="text-danger">*</span></label>
                                <input type="text" onkeyup="validate(this)" class="form-control" name="no_rek" id="no_rek">
                            </div>
                            <div class="col-md-6">
                                <label for="recipient-name" class="control-label">Nama Bank <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama_bank" id="nama_bank">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary add_btn">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade myModal" id="modal_edit">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Form Edit <?= $title ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="<?= base_url("master/apotek/suplier/edit") ?>" id="form_edit" enctype='multipart/form-data'>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="recipient-name" class="control-label">Nama Suplier <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama" id="nama_edit" autocomplete="off" required>
                            </div>
                            <div class="col-md-6">
                                <label for="recipient-name" class="control-label">Alamat <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="alamat" id="alamat_edit" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="recipient-name" class="control-label">Kota <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="kota" id="kota_edit" required>
                            </div>
                            <div class="col-md-6">
                                <label for="recipient-name" class="control-label">No Telp <span class="text-danger">*</span></label>
                                <input type="text" onkeyup="validate(this)" class="form-control" name="no_telp" id="no_telp_edit">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="recipient-name" class="control-label">Nomor Rekening <span class="text-danger">*</span></label>
                                <input type="text" onkeyup="validate(this)" class="form-control" name="no_rek" id="no_rek_edit">
                            </div>
                            <div class="col-md-6">
                                <label for="recipient-name" class="control-label">Nama Bank <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama_bank" id="nama_bank_edit">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <input type="hidden" name="id_data" id="id_data">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary add_btn">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    var table = $("#table_data").DataTable({
        "pagingType": "full_numbers",
        "language": {
            "lengthMenu": "Tampilkan _MENU_ data per halaman",
            "zeroRecords": "Data Tidak Ditemukan",
            "info": "Menampilkan Halaman _PAGE_ dari _PAGES_",
            "infoEmpty": "Oops, data tidak ditemukan",
            "infoFiltered": "(di filter dari _MAX_ total data)",
            "loadingRecords": "Loading...",
            "processing": "Sedang memuat data...",
            "paginate": {
                "first": "First",
                "last": "Last",
                "next": "Next",
                "previous": "Previous"
            },
        },
        "processing": true,
        "serverSide": true,
        "searching": true,
        "order": [],
        "columnDefs": [{
                "targets": [0],
                "orderable": false
            },
            {
                "targets": [1],
                "orderable": false
            }, {
                "targets": [2],
                "orderable": false
            },
            {
                "targets": [3],
                "orderable": false
            },
            {
                "targets": [4],
                "orderable": false
            },
            {
                "targets": [5],
                "orderable": false
            },
            {
                "targets": [6],
                "orderable": false
            },
            {
                "targets": [7],
                "orderable": false
            },
        ],
        "ajax": {
            "url": "<?= base_url("master/apotek/suplier/get_data") ?>",
            "type": "POST"
        },
        "columns": [{
                "data": null,
                "sortable": false,
                className: "text-center align-middle",
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                "data": "id",
                "sortable": false,
                className: "text-center align-middle",
                render: function(data, type, row, meta) {
                    let tombol = ''
                    tombol += `<button type="button" title="Edit" onclick="modal_edit('${data}')" class="btn btn-sm btn-info waves-effect waves-light" type="button"><span class="btn-label text-white"><i class="fas fa-edit"></i></span></button>&nbsp;`
                    tombol += `<button type="button" title="Hapus" onclick="hapus('${data}')" class="btn btn-sm btn-danger waves-effect waves-light" type="button"><span class="btn-label text-white"><i class="fas fa-trash"></i></span></button>&nbsp;`
                    return tombol;
                }
            },
            {
                "data": "nama",
            },
            {
                "data": "alamat",
            },
            {
                "data": "kota",
            },
            {
                "data": "no_telp",
            },
            {
                "data": "no_rek",
            },
            {
                "data": "nama_bank",
            },
        ]
    })

    $(document).ready(function() {
        $('#table_data thead tr').clone(true).appendTo('#table_data thead');
        $('#table_data thead tr:eq(1) th').each(function(i) {
            var title = $(this).text();
            if (i == 0 || i == 1) {
                $(this).html('');
            } else {
                $(this).html(`<input class="form-control" style="width: 100%" type="text" placeholder="Cari ${title}" />`);
            }

            $('input', this).on('keyup change', function(e) {
                if (e.keyCode == 13) {
                    if (table.column(i).search() !== this.value) {
                        console.log("asd")
                        table.column(i).search(this.value).draw();
                    }
                }
            })
        })
    })

    $("#form_add").submit(e => {
        e.preventDefault()
        var form = $('#form_add')[0]
        var data = new FormData(form)

        $(".add_btn").prop('disabled', true)
        $(".add_btn").text("Sedang menyimpan data...")

        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "<?= base_url("master/apotek/suplier/add") ?>",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            success: function(result) {
                console.log(result)
                $(".add_btn").prop('disabled', false)
                $(".add_btn").text("Simpan")
                if (result.code == 200) {
                    Swal.fire({
                        title: 'Sukses',
                        text: result.message,
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Oke Siap !'
                    }).then((result) => {
                        $('#form_add').trigger("reset");
                        $("#modal_tambah").modal("hide")
                        table.ajax.reload(null, false)
                    })
                } else {
                    Swal.fire({
                        title: 'Gagal',
                        text: result.message,
                        icon: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Oke Siap !'
                    })
                }

            },
            error: function(xhr, ajaxOptions, thrownError) {
                $(".add_btn").prop('disabled', false)
                $(".add_btn").text("Simpan")
                Swal.fire("Oops", xhr.responseText, "error")
            }
        })
    })

    $("#form_edit").submit(e => {
        e.preventDefault()
        var form = $('#form_edit')[0]
        var data = new FormData(form)

        $(".add_btn").prop('disabled', true)
        $(".add_btn").text("Sedang menyimpan data...")

        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "<?= base_url("master/apotek/suplier/edit") ?>",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            success: function(result) {
                console.log(result)
                $(".add_btn").prop('disabled', false)
                $(".add_btn").text("Simpan")
                if (result.code == 200) {
                    Swal.fire({
                        title: 'Sukses',
                        text: result.message,
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Oke Siap !'
                    }).then((result) => {
                        $('#form_edit').trigger("reset");
                        $("#modal_edit").modal("hide")
                        table.ajax.reload(null, false)
                    })
                } else {
                    Swal.fire({
                        title: 'Gagal',
                        text: result.message,
                        icon: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Oke Siap !'
                    })
                }

            },
            error: function(xhr, ajaxOptions, thrownError) {
                $(".add_btn").prop('disabled', false)
                $(".add_btn").text("Simpan")
                Swal.fire("Oops", xhr.responseText, "error")
            }
        })
    })

    const modal_edit = (id) => {
        $("#modal_edit").modal("show")
        $.ajax({
            url: "<?= base_url('master/apotek/suplier/get/') ?>" + id,
            type: "GET",
            dataType: "JSON",
            contentType: "application/json; charset=utf-8",
            success: function(result) {
                if (result.code == 200) {
                    let data = result.data
                    $("#nama_edit").val(data.nama)
                    $("#alamat_edit").val(data.alamat)
                    $("#kota_edit").val(data.kota)
                    $("#no_telp_edit").val(data.no_telp)
                    $("#nama_bank_edit").val(data.nama_bank)
                    $("#no_rek_edit").val(data.no_rek)
                    $("#id_data").val(data.id)
                } else {
                    Swal.fire({
                        title: 'Gagal',
                        text: result.message,
                        icon: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Oke Siap !'
                    })
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                $(".add_btn").prop('disabled', false)
                $(".add_btn").text("Simpan")
                Swal.fire("Oops", xhr.responseText, "error")
            }
        });
    }

    const hapus = (id) => {
        swal.fire({
            title: 'Hapus Data ?',
            text: "Data akan terhapus secara permanent",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonText: 'Batal',
            confirmButtonText: 'Hapus'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "<?= base_url('master/apotek/suplier/delete') ?>",
                    data: {
                        "id_data": id
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.code == 200) {
                            Swal.fire(
                                'Terhapus',
                                data.message,
                                'success'
                            ).then((result) => {
                                table.ajax.reload(null, false)
                            })
                        } else {
                            Swal.close();
                            Swal.fire("Oops", data.message, "error");
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        Swal.fire("Oops", xhr.responseText, "error");
                    }
                })
            }
        });
    }
</script>