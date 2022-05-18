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
                <form id="form_add" action="<?= base_url("master/apotek/identitas/proses") ?>" method="post" enctype="multipart/form-data">
                    <div class="card-header">
                        <h3 class="text-center text-bold">Data Identitas Apotek</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Nama Aplikasi</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="nama_aplikasi" class="form-control" placeholder="Nama Aplikasi" value="<?= $identitas->nama_aplikasi ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Nama Apotek</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="nama_apotek" class="form-control" placeholder="Nama Apotek" value="<?= $identitas->nama_apotek ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Sia No</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="sia_no" class="form-control" placeholder="Sia No" value="<?= $identitas->sia_no ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Pemilik</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="pemilik" class="form-control" placeholder="Pemilik" value="<?= $identitas->pemilik ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">APA</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="apa" class="form-control" placeholder="APA" value="<?= $identitas->apa ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">SIPA No</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="sipa_no" class="form-control" placeholder="SIPA No" value="<?= $identitas->sipa_no ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Provinsi</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="provinsi" class="form-control" placeholder="Provinsi" value="<?= $identitas->prov ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Kabupaten</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="kabupaten" class="form-control" placeholder="Kabupaten" value="<?= $identitas->kab ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Kecamatan</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="kecamatan" class="form-control" placeholder="Kecamatan" value="<?= $identitas->kec ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Desa</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="kelurahan" class="form-control" placeholder="Desa" value="<?= $identitas->kel ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Alamat</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="alamat" class="form-control" placeholder="Alamat" value="<?= $identitas->alamat ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">No Telp</label>
                                    <div class="col-sm-9">
                                        <input type="telp" name="telp" class="form-control" placeholder="No Telp" value="<?= $identitas->telp ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">No Email</label>
                                    <div class="col-sm-9">
                                        <input type="email" name="email" class="form-control" placeholder="Email" value="<?= $identitas->email ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Website</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="website" class="form-control" placeholder="Website" value="<?= $identitas->website ?>">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Logo</label>
                                    <div class="col-sm-9">
                                        <div class="form-group">
                                            <img id="imgPreview" src="<?= $identitas->logo ? asset("apotek/img/" . $identitas->logo) :  asset("apotek/img/no-img.jpg") ?>" class="col-md-12" alt="">
                                            <div class="form-group">
                                                <label for="recipient-name" class="control-label">Pilih Gambar <span class="text-danger">*</span></label>
                                                <input accept="image/*" type="file" class="form-control-file imgUp" name="logo" id="imageUpload" data-id="">
                                                <small id="name1" class="text-info">Maximum Size : 5 Mb</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
    </section>
</div>

<script>
    const readURL = input => {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imgPreview').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#imageUpload").change(function() {
        readURL(this);
    })

    $("#form_add").submit(e => {
        e.preventDefault()
        var formData = new FormData($("#form_add")[0])
        $.ajax({
            type: "POST",
            url: "<?= base_url('master/apotek/identitas/proses') ?>",
            data: formData,
            dataType: 'JSON',
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            success: function(result) {
                if (result.code == 200) {
                    Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: `${result["message"]}`,
                            confirmButtonText: 'Okesiap !',
                        })
                        .then((result) => {
                            window.location.href = "<?= base_url('master/apotek/identitas') ?>";
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
                alert(xhr.responseText)
            }
        })
    })
</script>