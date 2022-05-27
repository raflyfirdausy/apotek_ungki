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

            <form method="POST" action="<?= base_url("transaksi/apotek/stock-opname/execute") ?>" id="form_add" enctype='multipart/form-data'>
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <a href="<?= back() ?>" type="button" class="btn btn-primary float-left"><i class="fas fa-chevron-left"></i> Kembali</a>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="recipient-name" class="control-label">Kode Obat</label>
                                    <input disabled class="form-control" type="text" value="<?= $obat["kode_obat"] ?>">
                                </div>
                                <div class="col-md-4">
                                    <label for="recipient-name" class="control-label">Nama Obat</label>
                                    <input disabled class="form-control" type="text" value="<?= $obat["nama"] ?>">
                                </div>
                                <div class="col-md-4">
                                    <label for="recipient-name" class="control-label">Satuan Obat</label>
                                    <input disabled class="form-control" type="text" value="<?= $obat["nama_satuan"] ?>">
                                    <input type="hidden" name="id_obat" value="<?= $obat["id"] ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-outline card-dark">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-10">
                                <h5 class="m-0 text-dark text-bold" id="titleGrafik">Detail stok obat</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php if ($stok) : ?>
                                <?php foreach ($stok as $s) : ?>
                                    <div class="col-md-4">
                                        <label for="recipient-name" class="control-label">Tanggal Expired</label>
                                        <input name="tgl_expired[]" disabled class="form-control" type="text" value="<?= $s["tgl_expired"] ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="recipient-name" class="control-label">Stok Gudang</label>
                                        <input name="stok_gudang[]" readonly class="form-control" type="text" value="<?= $s["stok"] ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="recipient-name" class="control-label">Stok Sebenarnya</label>
                                        <input required name="stok_sebenarnya[]" placeholder="Masukan stok sebenarnya" class="form-control" type="number">
                                    </div>
                                    <input type="hidden" name="id_stok[]" value="<?= $s["id"] ?>">
                                <?php endforeach ?>
                            <?php else : ?>
                                <div class="col-md-12">
                                    <h6 class="m-0 text-dark text-bold" id="titleGrafik">Data stok obat tidak ditemukan !!</h6>
                                </div>
                            <?php endif ?>

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