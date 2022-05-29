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
                <form id="form_edit" action="<?= base_url("master/apotek/obat/data/edit") ?>" method="post" enctype="multipart/form-data">
                    <div class="card-header">
                        <a href="<?= back() ?>" type="button" class="btn btn-primary float-left"><i class="fas fa-chevron-left"></i> Kembali</a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label text-right">Kode Obat <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input required type="text" disabled name="kode" class="form-control" placeholder="Kode Obat" value="<?= $obat["kode_obat"] ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label text-right">Nama Obat <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input required type="text" name="nama" class="form-control" placeholder="Nama Obat" value="<?= $obat["nama"] ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label text-right">Golongan Obat <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <select required class="form-control select2bs4" name="id_golongan">
                                            <option value="">-- Pilih Golongan Obat --</option>
                                            <?php foreach ($golongan as $g) : ?>
                                                <option <?= $obat["id_golongan"] == $g["id"] ? "selected" : "" ?> value="<?= $g["id"] ?>"><?= $g["nama"] ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label text-right">Kategori Obat <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <select required class="form-control select2bs4" name="id_kategori">
                                            <option value="">-- Pilih Kategori Obat --</option>
                                            <?php foreach ($kategori as $k) : ?>
                                                <option <?= $obat["id_kategori"] == $k["id"] ? "selected" : "" ?> value="<?= $k["id"] ?>"><?= $k["nama"] ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label text-right">Satuan Obat <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <select required class="form-control select2bs4" name="id_satuan">
                                            <option value="">-- Pilih Kategori Obat --</option>
                                            <?php foreach ($satuan as $s) : ?>
                                                <option <?= $obat["id_satuan"] == $s["id"] ? "selected" : "" ?> value="<?= $s["id"] ?>"><?= $s["nama"] ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>                               
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label text-right">Minimal Stok <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input required type="number" name="min_stok" class="form-control" placeholder="Minimal Stock Obat" value="<?= $obat["min_stok"] ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label text-right">Deskripsi Obat</label>
                                    <div class="col-sm-9">
                                        <textarea name="deskripsi" rows="2" class="form-control" placeholder="Deskripsi Obat"><?= $obat["deskripsi"] ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label text-right">Indikasi Obat</label>
                                    <div class="col-sm-9">
                                        <textarea name="indikasi" rows="2" class="form-control" placeholder="Indikasi Obat"><?= $obat["indikasi"] ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label text-right">Kandungan Obat</label>
                                    <div class="col-sm-9">
                                        <textarea name="kandungan" rows="2" class="form-control" placeholder="Kandungan Obat"><?= $obat["kandungan"] ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label text-right">Dosis Obat</label>
                                    <div class="col-sm-9">
                                        <textarea name="dosis" rows="2" class="form-control" placeholder="Dosis Obat"><?= $obat["dosis"] ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label text-right">Bentuk / Kemasan Obat</label>
                                    <div class="col-sm-9">
                                        <textarea name="kemasan" rows="2" class="form-control" placeholder="Bentuk / Kemasan Obat"><?= $obat["kemasan"] ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label text-right">Efek Samping</label>
                                    <div class="col-sm-9">
                                        <textarea name="efek_samping" rows="2" class="form-control" placeholder="Efek Samping"><?= $obat["efek_samping"] ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <input type="hidden" name="id_data" value="<?= $obat["id"] ?>">
                        <button type="submit" class="btn btn-primary add_btn">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

    </section>
</div>

<script>
    $("#form_edit").submit(e => {
        e.preventDefault()
        var formData = new FormData($("#form_edit")[0])

        $(".add_btn").prop('disabled', true)
        $(".add_btn").text("Sedang menyimpan data...")

        $.ajax({
            type: "POST",
            url: "<?= base_url("master/apotek/obat/data/edit") ?>",
            data: formData,
            dataType: 'JSON',
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            success: function(result) {
                $(".add_btn").prop('disabled', false)
                $(".add_btn").text("Simpan")
                if (result.code == 200) {
                    Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: `${result["message"]}`,
                            confirmButtonText: 'Oke!',
                        })
                        .then((result) => {
                            window.location.href = "<?= base_url('master/apotek/obat/data') ?>";
                        })
                } else {
                    Swal.fire(
                        'Gagal',
                        `${result.message}`,
                        'error'
                    )
                }
            },
            error: function() {
                $(".add_btn").prop('disabled', false)
                $(".add_btn").text("Simpan")
                alert(xhr.responseText)
            }
        })
    })
</script>