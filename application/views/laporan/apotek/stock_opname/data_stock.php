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

            <div class="card card-outline card-primary">
                <div class="card-header">
                    <a href="<?= back() ?>" type="button" class="btn btn-primary float-left"><i class="fas fa-chevron-left"></i> Kembali</a>
                </div>
                <form action="" method="get">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h5>Silahkan pilih range awal dan range akhir untuk melihat data laporan</h5>
                            </div>
                            <div class="col-md-6 mt-2">
                                <div class="row" id="rangeHari">
                                    <div class="col-md-6">
                                        <label for="">Range Awal (Tanggal)</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            <input autocomplete="off" type="text" class="form-control float-right" value="<?= $awal ?>" name="awal" id="awal_hari">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Range Akhir (Tanggal)</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            <input autocomplete="off" type="text" class="form-control float-right" value="<?= $akhir ?>" name="akhir" id="akhir_hari">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-md btn-success" style="margin-top: 10px; width:100%">
                                    LIHAT LAPORAN
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class=" card card-primary card-outline">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table_data" class="table table-sm nowrap table-bordered table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 3%">No.</th>                                    
                                    <th>Nama Obat</th>
                                    <th>Stok Awal</th>
                                    <th>Stok Akhir</th>
                                    <th>Selisih Stok</th>
                                    <th>Keterangan</th>
                                    <th>Jenis</th>
                                    <th>Ditambahkan Oleh</th>
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
            "url": "<?= base_url("laporan/apotek/stock-opname/get_data?awal=$awal&akhir=$akhir") ?>",
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
                "data": "stok_awal",
            },
            {
                "data": "stok_akhir",
            },
            {
                "data": "stok_akhir",
                render: function(data, type, row, meta) {
                    let selisih = row.stok_awal - row.stok_akhir
                    let warna = "success"
                    if(selisih < 0){
                        warna = "danger"
                    } else if(selisih == 0){
                        warna = "dark"
                    }

                    return `<span style="width:100%" class="badge badge-${warna}">${selisih}</span>`
                }
            },
            {
                "data": "keterangan",
            },
            {
                "data": "jenis",
            },
            {
                "data": "nama_admin",
            },
            {
                "data": "created_at",
            },

        ]
    })

    $(document).ready(function() {
        $('#table_data thead tr').clone(true).appendTo('#table_data thead');
        $('#table_data thead tr:eq(1) th').each(function(i) {
            var title = $(this).text();
            if (i == 0) {
                $(this).html('');
            } else {
                $(this).html(`<input class="form-control" style="width: 100%" type="text" placeholder="Cari ${title}" />`);
            }

            $('input', this).on('keyup change', function(e) {
                if (e.keyCode == 13) {
                    if (table.column(i).search() !== this.value) {
                        table.column(i).search(this.value).draw();
                    }
                }
            })
        })
    })
</script>

<script>
    $("#awal_hari").keypress(function(event) {
        event.preventDefault();
    });

    $("#akhir_hari").keypress(function(event) {
        event.preventDefault();
    });

    $('#awal_hari').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
    });

    $('#akhir_hari').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
    });
</script>