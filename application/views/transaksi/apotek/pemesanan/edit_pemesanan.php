<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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
        <div class="container-fluid">
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

            <form method="POST" action="<?= base_url("transaksi/apotek/pemesanan/ubah_proses") ?>" id="form_add" enctype='multipart/form-data'>
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <a href="<?= back() ?>" type="button" class="btn btn-primary float-left"><i class="fas fa-chevron-left"></i> Kembali</a>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="recipient-name" class="control-label">Suplier</label>
                                    <input type="hidden" name="no_faktur" value="<?= $pemesanan_obat["no_faktur"] ?>">
                                    <select class="form-control select2bs4" id="suplier" name="suplier" style="width: 100%;" required>
                                        <option value="" selected>Pilih suplier</option>
                                        <?php foreach ($suplier as $s) : ?>
                                            <option <?= ($s["id"] == $pemesanan_obat["id_suplier"]) ? "selected" : "" ?> value="<?= $s["id"] ?>"><?= $s["nama"] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="col-md-8">
                                    <label for="recipient-name" class="control-label">Catatan</label>
                                    <textarea type="text" class="form-control" name="catatan" rows="1" id="catatan"><?= $pemesanan_obat["keterangan_pemesanan"] ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-outline card-dark">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-10">
                                <h5 class="m-0 text-dark text-bold" id="titleGrafik">Detail pembelian sampah</h5>
                            </div>
                            <div class="col-md-1">
                                <button id="btnTambah" type="button" class="btn btn-md btn-primary float-right">TAMBAH</a>
                            </div>
                            <div class="col-md-1">
                                <button id="btnReset" type="button" class="btn btn-md btn-danger float-right">RESET</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="sectionInput">
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="<?php back() ?>" id="btn_batal" class="btn btn-danger ml-1" style="width: 100%;">
                                    <i data-feather="close"></i>
                                    Batal
                                </a>
                            </div>
                            <div class="col-md-6">
                                <button id="btn_submit" type="submit" class="btn btn-success ml-1" style="width: 100%;">
                                    <i data-feather="save"></i>
                                    Simpan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>

<script>
    let currentForm = 1

    $(document).ready(() => {
        setupData()
    })

    const setupData = () => {
        $.ajax({
            url: '<?= base_url('transaksi/apotek/pemesanan/get/' . $pemesanan_obat["no_faktur"]) ?>',
            type: "GET",
            dataType: 'json',
            success: function(response) {
                if (response.code == 200) {
                    let data = response.data
                    for (let i = 0; i < data.length; i++) {
                        addData(data[i], i)
                    }
                } else {
                    Swal.fire(
                        'Gagal',
                        `${result.message}`,
                        'error'
                    )
                }
            }
        })
    }

    const addData = (data, index) => {
        let section = /*html */ `
            <div id="row_${currentForm}" class="row mt-2">
                <div class="col-md-4">                    
                    <input disabled type="text" value="${data.nama_obat}" class="form-control" required>
                    <input type="hidden" value="${data.id_obat}" class="form-control" id="id_obat${currentForm}" name="id_obat[]" required>
                </div>               
                <div class="col-md-2">
                    <input type="number" step="any" value="${data.qty}" class="form-control quantity_obat" id="quantity_obat_${currentForm}" name="quantity_obat[]" placeholder="Quantity Obat" required>
                </div>
                <div class="col-md-5">
                    <input type="text" value="${data.catatan}" class="form-control" id="catatan_detail_${currentForm}" name="catatan_detail[]" placeholder="Catatan">
                </div>
                <div class="col-md-1">
                    <input class="btn btn-danger" type="button" onclick="remove(${currentForm})" class="btn_hapus_form" style="width: 100%;" value="Hapus" />
                </div>
            </div>
        `
        $("#sectionInput").append(section)

        currentForm++
    }

    const resetSampah = () => {
        $(".sub_jenis_sampah").empty().trigger('change')
        $(".quantity_sampah").val("")
    }

    const remove = id => {
        $('#row_' + id).remove();
    }

    const reset = () => {
        $("#sectionInput").html("")
        resetSampah()
        currentForm = 1
    }

    const addRow = () => {
        currentForm++

        let section = /*html */ `
            <div id="row_${currentForm}" class="row mt-2">
                <div class="col-md-4">
                    <select class="form-control select2bs4 id_obat" id="id_obat_${currentForm}" name="id_obat[]" style="width: 100%;" required>
                        <option value="">-- PILIH OBAT --</option>
                        <?php foreach ($obat as $o) : ?>
                            <option value="<?= $o["id"] ?>"><?= $o["nama"] . " (" . $o["nama_satuan"] . ")" ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="number" step="any" class="form-control quantity_obat" id="quantity_obat_${currentForm}" name="quantity_obat[]" placeholder="Quantity obat" required>
                </div>
                <div class="col-md-5">
                    <input type="text" class="form-control" id="catatan_detail_${currentForm}" name="catatan_detail[]" placeholder="Catatan">
                </div>               
                <div class="col-md-1">
                    <input class="btn btn-danger" type="button" onclick="remove(${currentForm})" class="btn_hapus_form" style="width: 100%;" value="Hapus" />
                </div>
            </div>
        `
        $("#sectionInput").append(section)
    }

    $("#btnTambah").click(() => {
        addRow()
    })

    $("#btnReset").click(() => {
        reset()
    })

    $("#form_add").submit(e => {
        e.preventDefault()
        $.ajax({
            type: "POST",
            url: "<?= base_url('transaksi/apotek/pemesanan/ubah_proses') ?>",
            data: $('#form_add').serialize(),
            dataType: 'JSON',
            success: function(result) {
                if (result.code == 200) {
                    Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: `${result["message"]}`,
                            confirmButtonText: 'Okesiap !',
                        })
                        .then((result) => {
                            window.location.href = "<?= base_url('transaksi/apotek/pemesanan') ?>";
                        })
                } else {
                    Swal.fire(
                        'Gagal',
                        `${result.message}`,
                        'error'
                    )
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.responseText)
            }
        })
    })
</script>