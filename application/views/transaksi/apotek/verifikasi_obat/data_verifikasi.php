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
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table_data" class="table table-sm nowrap table-bordered table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 3%">No.</th>
                                    <th style="width: 8%">Aksi</th>
                                    <th>No Faktur</th>
                                    <th>Tanggal</th>
                                    <th>Total Obat</th>
                                    <th>Status</th>
                                    <th>Waktu Dibuat</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade myModal" id="modal_lihat">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail pemesanan obat <b>(<span id="no_faktur"></span>)</b></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <table style="width: 100%" class="table table-sm table-bordered table-hover" id="table_detail">
                            <thead>
                                <th width="5%">No.</th>
                                <th>Nama Obat</th>
                                <th>Quantity Permintaan</th>
                                <th>Catatan</th>
                                <th>Quantity Diterima</th>
                                <th>Tanggal Expired</th>
                            </thead>
                            <tbody id="table_body_detail"></tbody>
                            <tfoot id="table_foot_detail"></tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-success" id="btn_proses">Terima (Obat akan masuk dalam stok)</button>

            </div>
        </div>
    </div>
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
        ],
        "ajax": {
            "url": "<?= base_url("transaksi/apotek/verifikasi-obat/get_data") ?>",
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
                    let disabled = ''
                    if (row.status_suplier != 'MENUNGGU') {
                        disabled = 'disabled'
                    }
                    tombol += `<a type="button" title="Lihat" onclick="modal_lihat('${row.no_faktur}')" class="btn btn-sm btn-success waves-effect waves-light" type="button"><span class="btn-label text-white"><i class="fas fa-edit"> Proses</i></span></a>&nbsp;`
                    return tombol;
                }
            },
            {
                "data": "no_faktur",
            },
            {
                "data": "tgl_faktur",
            },
            {
                "data": "total_obat",
            },
            {
                "data": "status_apotek",
            },
            {
                "data": "created_at",
            },

        ]
    })

    let noFaktur = ""

    const modal_lihat = (no_faktur) => {
        noFaktur = no_faktur
        $("#modal_lihat").modal("show")
        $("#no_faktur").text(no_faktur)
        $.ajax({
            url: "<?= base_url('transaksi/apotek/verifikasi-obat/get/') ?>" + no_faktur,
            type: "GET",
            dataType: "JSON",
            contentType: "application/json; charset=utf-8",
            success: function(response) {
                $('#table_body_detail').html('');
                $('#table_foot_detail').html('');
                $('#footer_modal').html('');
                if (response.code == 200) {
                    let result = response.data
                    var z = 1;
                    for (var i in result) {
                        var r = result[i];
                        $('#table_body_detail').append(
                            /*html*/
                            `<tr>
                            <td class="text-center">${z++}</td>
                            <td><span>${r.nama_obat}</span></td>
                            <td><span>${r.qty}</span></td>
                            <td><span>${r.catatan}</span></td>                        
                            <td><span>${r.qty_acc}</span></td>                        
                            <td><span>${r.tgl_expired}</span></td>                        
                        </tr>`
                        );
                    }

                }
                $("#table_detail").DataTable();
            }
        });
    }

    $("#btn_proses").click(() => {
        swal.fire({
            title: 'Proses pemesanan obat ini ?',
            text: "Pastikan suppier sudah mengirimkan obat ke apotek !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#27a844',
            cancelButtonText: 'Batal',
            confirmButtonText: 'Proses'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "<?= base_url('transaksi/apotek/verifikasi-obat/proses') ?>",
                    data: {
                        "no_faktur": noFaktur
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.code == 200) {
                            $("#modal_lihat").modal("hide")
                            Swal.fire(
                                'Berhasil',
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
    })
</script>