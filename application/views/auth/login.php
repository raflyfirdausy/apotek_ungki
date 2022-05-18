<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $app_name ?> | <?= $app_complete_name ?></title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="<?= lte("plugins/fontawesome-free/css/all.min.css") ?>">
    <link rel="stylesheet" href="<?= lte("plugins/icheck-bootstrap/icheck-bootstrap.min.css") ?>">
    <link rel="stylesheet" href="<?= lte("dist/css/adminlte.min.css") ?>">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?= lte("plugins/select2/css/select2.min.css") ?>">
    <link rel="stylesheet" href="<?= lte("plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css") ?>">
</head>


<body class="hold-transition login-page" style="background-image: url(<?= asset("evans/img/bg-login.jpg") ?>); background-size: cover;">
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="<?= base_url() ?>" class="h1"><b><?= $app_name ?></b></a>

            </div>
            <div class="card-body">
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
                <p class="login-box-msg">Silahkan masuk menggunakan username dan password kamu</p>
                <form action="<?= base_url('auth/login_proses') ?>" method="POST">
                    <div class="input-group mb-3">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-at"></span>
                            </div>
                        </div>
                        <input type="text" class="form-control" name="username" placeholder="Username" required>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        <input type="password" class="form-control" name="password" placeholder="Password" required>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">LOGIN</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="<?= lte("plugins/jquery/jquery.min.js") ?>"></script>
    <script src="<?= lte("plugins/bootstrap/js/bootstrap.bundle.min.js") ?>"></script>
    <script src="<?= lte("dist/js/adminlte.min.js") ?>"></script>
    <script src="<?= lte("plugins/select2/js/select2.full.min.js") ?>"></script>
</body>

</html>