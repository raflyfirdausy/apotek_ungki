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
                                    <th>Nama Obat</th>
                                    <th>Stok</th>
                                    <th>Satuan</th>
                                    <th>Tanggal Expired</th>
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
            <form method="POST" id="form_add" enctype='multipart/form-data' action="<?= base_url("master/apotek/obat/stok/add") ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="recipient-name" class="control-label">Stok <span class="text-danger">*</span></label>
                                <input type="number" min="0" class="form-control" name="stok" id="stok" required>
                            </div>
                            <div class="col-md-6">
                                <label for="recipient-name" class="control-label">Tanggal Expired </label>
                                <input type="date" class="form-control" name="tgl_expired" id="tgl_expired" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <input type="hidden" name="id_obat" value="<?= $obat["id"] ?>">
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
        ],
        "ajax": {
            "url": "<?= base_url("master/apotek/obat/stok/get_data_detail/" . $obat["id"] ) ?>",
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
                "data": "nama_obat",
            },
            {
                "data": "stok",
            },
            {
                "data": "nama_satuan",
            },
            {
                "data": "tgl_expired",
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
            url: "<?= base_url("master/apotek/obat/stok/add") ?>",
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
                        confirmButtonText: 'Oke!'
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
                        confirmButtonText: 'Oke!'
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
</script>