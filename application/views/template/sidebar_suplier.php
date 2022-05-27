<?php if ($this->userData->level == "SUPLIER") : ?>
    <li class="nav-header">PO Obat Suplier</li>
    <li class="nav-item">
        <a href="<?= base_url("transaksi/suplier/pre-order/belum") ?>" class="nav-link">
            <i class="nav-icon fas fa-users-cog"></i>
            <p>Belum di proses</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?= base_url("transaksi/suplier/pre-order/sudah") ?>" class="nav-link">
            <i class="nav-icon fas fa-users-cog"></i>
            <p>PO Diterima</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?= base_url("transaksi/suplier/pre-order/tolak") ?>" class="nav-link">
            <i class="nav-icon fas fa-users-cog"></i>
            <p>Di Tolak</p>
        </a>
    </li>
<?php endif ?>