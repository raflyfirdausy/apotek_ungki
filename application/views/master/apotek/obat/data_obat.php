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
                    <a href="<?= base_url("master/apotek/obat/data/tambah") ?>" type="button" class="btn btn-success float-right"><i class="fas fa-plus"></i> Tambah Data <?= $title ?></a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table_data" class="table table-sm nowrap table-bordered table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 3%">No.</th>
                                    <th style="width: 8%">Aksi</th>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Golongan</th>
                                    <th>Kategori</th>
                                    <th>Satuan</th>
                                    <th>Stok Gudang</th>
                                    <th>Minimal Stok</th>
                                    <th>Waktu Ditambahkan</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>

<script>
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
            {
                "targets": [8],
                "orderable": false
            },
        ],
        "ajax": {
            "url": "<?= base_url("master/apotek/obat/data/get_data") ?>",
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
                    tombol += `<a href="<?= base_url("master/apotek/obat/data/ubah/") ?>${row.kode_obat}" type="button" title="Edit" onclick="modal_edit('${data}')" class="btn btn-sm btn-info waves-effect waves-light" type="button"><span class="btn-label text-white"><i class="fas fa-edit"></i></span></a>&nbsp;`
                    tombol += `<button type="button" title="Hapus" onclick="hapus('${data}')" class="btn btn-sm btn-danger waves-effect waves-light" type="button"><span class="btn-label text-white"><i class="fas fa-trash"></i></span></button>&nbsp;`
                    return tombol;
                }
            },
            {
                "data": "kode_obat",
            },
            {
                "data": "nama",
            },
            {
                "data": "nama_golongan",
            },
            {
                "data": "nama_kategori",
            },
            {
                "data": "nama_satuan",
            },
            {
                "data": "stok",
            },
            {
                "data": "min_stok",
            },
            {
                "data": "created_at",
            },
        ]
    })

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
                    url: "<?= base_url('master/apotek/obat/data/delete') ?>",
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