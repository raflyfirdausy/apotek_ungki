<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= isset($title) ? $title . " | " : "" ?><?= $app_complete_name ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?= lte("plugins/fontawesome-free/css/all.min.css") ?>">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="<?= lte("plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css") ?>">
    <link rel="stylesheet" href="<?= lte("plugins/icheck-bootstrap/icheck-bootstrap.min.css") ?>">
    <link rel="stylesheet" href="<?= lte("plugins/jqvmap/jqvmap.min.css") ?>">
    <link rel="stylesheet" href="<?= lte("dist/css/adminlte.min.css") ?>">
    <link rel="stylesheet" href="<?= lte("plugins/overlayScrollbars/css/OverlayScrollbars.min.css") ?>">
    <link rel="stylesheet" href="<?= lte("plugins/daterangepicker/daterangepicker.css") ?>">
    <link rel="stylesheet" href="<?= lte("plugins/summernote/summernote-bs4.css") ?>">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="shortcut icon" type="image/x-icon" href="<?= asset("apotek/img/" . $_identitas->logo) ?>">
    <link rel="stylesheet" href="<?= lte("plugins/datatables-bs4/css/dataTables.bootstrap4.min.css") ?>">
    <link rel="stylesheet" href="<?= lte("plugins/datatables-responsive/css/responsive.bootstrap4.min.css") ?>">
    <link rel="stylesheet" href="<?= lte("plugins/datatables-buttons/css/buttons.bootstrap4.min.css") ?>">
    <link rel="stylesheet" href="<?= lte("plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css") ?>">
    <script src="<?= lte("plugins/jquery/jquery.min.js") ?>"></script>
    <script src="<?= lte("plugins/datatables/jquery.dataTables.min.js") ?>"></script>
    <script src="<?= lte("plugins/datatables-bs4/js/dataTables.bootstrap4.min.js") ?>"></script>
    <script src="<?= lte("plugins/datatables-responsive/js/dataTables.responsive.min.js") ?>"></script>
    <script src="<?= lte("plugins/datatables-responsive/js/responsive.bootstrap4.min.js") ?>"></script>
    <script src="<?= lte("plugins/datatables-buttons/js/dataTables.buttons.min.js") ?>"></script>
    <script src="<?= lte("plugins/datatables-buttons/js/buttons.bootstrap4.min.js") ?>"></script>
    <script src="<?= lte("plugins/jszip/jszip.min.js") ?>"></script>
    <script src="<?= lte("plugins/pdfmake/pdfmake.min.js") ?>"></script>
    <script src="<?= lte("plugins/pdfmake/vfs_fonts.js") ?>"></script>
    <script src="<?= lte("plugins/datatables-buttons/js/buttons.html5.min.js") ?>"></script>
    <script src="<?= lte("plugins/datatables-buttons/js/buttons.print.min.js") ?>"></script>
    <script src="<?= lte("plugins/datatables-buttons/js/buttons.colVis.min.js") ?>"></script>
    <script src="<?= asset("helper/js/utility.js") ?>"></script>

    <link rel="stylesheet" href="<?= lte("plugins/select2/css/select2.min.css") ?>">
    <link rel="stylesheet" href="<?= lte("plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css") ?>">
    <script>
        var BASE_URL = "<?= base_url() ?>"
    </script>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="<?= base_url() ?>" target="_blank" class="nav-link">Halaman Form Input <?= $app_name ?></a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-user"></i> <?= $this->userData->nama ?> (<?= str_replace('_', " ", $this->userData->level) ?>)
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <div class="dropdown-divider"></div>
                        <a href="<?= base_url("master/apotek/profile") ?>" class="dropdown-item">
                            <i class="fas fa-user mr-2"></i> Profile
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="<?= base_url("auth/logout") ?>" class="dropdown-item">
                            <i class="fas fa-power-off mr-2"></i> Keluar
                        </a>
                </li>
            </ul>
        </nav>