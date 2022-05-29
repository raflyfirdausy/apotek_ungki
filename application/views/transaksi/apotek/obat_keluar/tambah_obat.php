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

            <form method="POST" action="<?= base_url("transaksi/apotek/obat-keluar/tambah_proses") ?>" id="form_add" enctype='multipart/form-data'>
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <a href="<?= back() ?>" type="button" class="btn btn-primary float-left"><i class="fas fa-chevron-left"></i> Kembali</a>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="recipient-name" class="control-label">No Faktur</label>
                                    <input type="text" name="no_faktur" id="no_faktur" class="form-control" value="<?= $no_faktur ?>" readonly>
                                </div>
                                <div class="col-md-8">
                                    <label for="recipient-name" class="control-label">Catatan</label>
                                    <textarea type="text" class="form-control" name="catatan" rows="1" id="catatan"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-outline card-dark">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-10">
                                <h5 class="m-0 text-dark text-bold" id="titleGrafik">Detail obat keluar</h5>
                            </div>
                            <div class="col-md-2">
                                <button id="btnReset" type="button" class="btn btn-md btn-danger float-right">RESET</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="sectionAwal">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="recipient-name" class="control-label">Nama Obat</label>
                                </div>
                                <div class="col-md-2">
                                    <label for="recipient-name" class="control-label">Quantity</label>
                                </div>
                                <div class="col-md-5">
                                    <label for="recipient-name" class="control-label">Keterangan</label>
                                </div>
                                <div class="col-md-1">

                                </div>
                                <div class="col-md-4">
                                    <select class="form-control select2bs4 id_obat" id="id_obat_1" name="id_obat[]" style="width: 100%;" required>
                                        <option value="">-- PILIH OBAT --</option>
                                        <?php foreach ($obat as $o) : ?>
                                            <option value="<?= $o["id"] ?>"><?= $o["nama"] . " (Max " . $o["stok"] . " " . $o["nama_satuan"] . ")" ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" step="any" class="form-control quantity_obat" id="quantity_obat_1" name="quantity_obat[]" placeholder="Quantity obat" required>
                                </div>
                                <div class="col-md-5">
                                    <input type="text" class="form-control" id="catatan_detail_1" name="catatan_detail[]" placeholder="Catatan">
                                </div>
                                <div class="col-md-1">
                                    <input class="btn btn-primary" type="button" id="btn_tambah_form" value="Tambah" />
                                </div>
                            </div>
                        </div>
                        <div id="sectionInput">

                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12">
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

    const resetObat = () => {
        $(".id_obat").empty().trigger('change')
        $(".quantity_obat").val("")
    }

    const remove = id => {
        $('#row_' + id).remove();
    }

    const reset = () => {
        $("#sectionInput").html("")
        reset()
        currentForm = 1
    }

    $("#btnReset").click(() => {
        reset()
    })

    $("#btn_tambah_form").click(() => {
        currentForm++

        let section = /*html */ `
            <div id="row_${currentForm}" class="row mt-2">
                <div class="col-md-4">
                    <select class="form-control select2bs4 id_obat" id="id_obat_${currentForm}" name="id_obat[]" style="width: 100%;" required>
                        <option value="">-- PILIH OBAT --</option>
                        <?php foreach ($obat as $o) : ?>
                            <option value="<?= $o["id"] ?>"><?= $o["nama"] . " (Max " . $o["stok"] . " " . $o["nama_satuan"] . ")" ?></option>
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
    })

    $("#form_add").submit(e => {
        e.preventDefault()
        $.ajax({
            type: "POST",
            url: "<?= base_url('transaksi/apotek/obat-keluar/tambah_proses') ?>",
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
                            window.location.href = "<?= base_url('transaksi/apotek/obat-keluar') ?>";
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