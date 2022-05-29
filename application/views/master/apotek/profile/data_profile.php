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
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#profile" data-toggle="tab">Profile</a></li>
                        <li class="nav-item"><a class="nav-link" href="#password" data-toggle="tab">Password</a></li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="active tab-pane" id="profile">
                            <form id="form_profile" action="<?= base_url("master/apotek/profile/change_profile") ?>" method="post" enctype="multipart/form-data">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Username <span class="text-danger">*</span></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="username" class="form-control" value="<?= $admin->username ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="nama" class="form-control" value="<?= $admin->nama ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Nomor Telp <span class="text-danger">*</span></label>
                                    <div class="col-sm-10">
                                        <input type="telp" onkeyup="validate(this)" name="no_hp" class="form-control" value="<?= $admin->no_hp ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                    <div class="col-sm-10">
                                        <select class="form-control select2bs4" name="jenis_kelamin">
                                            <option value="LAKI-LAKI" <?= $admin->jenis_kelamin == "PEREMPUAN" ? "" : "selected" ?>>LAKI-LAKI</option>
                                            <option value="PEREMPUAN" <?= $admin->jenis_kelamin == "PEREMPUAN" ? "selected" : "" ?>>PEREMPUAN</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary add_btn">Simpan</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="password">
                            <form id="form_pass" action="<?= base_url("master/apotek/profile/change_password") ?>" method="post" enctype="multipart/form-data">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Password Lama <span class="text-danger">*</span></label>
                                    <div class="col-sm-10">
                                        <input type="password" name="password_lama" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Password Baru <span class="text-danger">*</span></label>
                                    <div class="col-sm-10">
                                        <input type="password" name="password_baru" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                                    <div class="col-sm-10">
                                        <input type="password" name="password_konfirmasi" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary add_btn">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


<script>
    $("#form_profile").submit(e => {
        e.preventDefault()
        var form = $('#form_profile')[0]
        var data = new FormData(form)

        $(".add_btn").prop('disabled', true)
        $(".add_btn").text("Sedang menyimpan data...")

        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "<?= base_url("master/apotek/profile/change_profile") ?>",
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
                        location.reload()
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

    $("#form_pass").submit(e => {
        e.preventDefault()
        var form = $('#form_pass')[0]
        var data = new FormData(form)

        $(".add_btn").prop('disabled', true)
        $(".add_btn").text("Sedang menyimpan data...")

        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "<?= base_url("master/apotek/profile/change_password") ?>",
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
                        location.reload()
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