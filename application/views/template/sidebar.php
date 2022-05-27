<style>
    .centerr {
        display: block;
        margin-left: auto;
        margin-right: auto;
        margin-top: 20px;
        margin-bottom: 20px;
        width: 50%;
    }
</style>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="<?= base_url("dashboard") ?>" class="brand-link">
        <img src="<?= asset("apotek/img/" . $_identitas->logo) ?>" alt="AdminLTE Logo" class="brand-image " style="opacity: .8">
        <span class="brand-text font-weight-light"><?= ce($app_name) ?></span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-header">Dashboard</li>
                <li class="nav-item">
                    <a href="<?= base_url("dashboard") ?>" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Dashboard Utama</p>
                    </a>
                </li>

                <?php $this->load->view("template/sidebar_admin") ?>
                <?php $this->load->view("template/sidebar_suplier") ?>

            </ul>
        </nav>
    </div>
</aside>