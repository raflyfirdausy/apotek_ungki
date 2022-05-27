<?php if ($this->userData->level == "KARYAWAN" || $this->userData->level == "KEPALA_APOTEK") : ?>
    <li class="nav-header">Master Data Apotek</li>
    <li class="nav-item">
        <a href="<?= base_url("master/apotek/identitas") ?>" class="nav-link">
            <i class="nav-icon fas fa-users-cog"></i>
            <p>Identitas Apotek</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="<?= base_url("master/apotek/suplier") ?>" class="nav-link">
            <i class="nav-icon fas fa-users-cog"></i>
            <p>Data Suplier</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-chart-pie"></i>
            <p>
                Pengguna
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="<?= base_url("master/apotek/pengguna/kepala-apotek") ?>" class="nav-link">
                    <p>Kepala Apotek</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url("master/apotek/pengguna/karyawan") ?>" class="nav-link">
                    <p>Karyawan</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url("master/apotek/pengguna/suplier") ?>" class="nav-link">
                    <p>Suplier</p>
                </a>
            </li>
        </ul>
    </li>


    <li class="nav-item">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-chart-pie"></i>
            <p>
                Obat
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="<?= base_url("master/apotek/obat/golongan") ?>" class="nav-link">
                    <p>Golongan Obat</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url("master/apotek/obat/kategori") ?>" class="nav-link">
                    <p>Kategori Obat</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url("master/apotek/obat/satuan") ?>" class="nav-link">
                    <p>Satuan Obat</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url("master/apotek/obat/data") ?>" class="nav-link">
                    <p>Master Data obat</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url("master/apotek/obat/stok") ?>" class="nav-link">
                    <p>Master Data Stok obat</p>
                </a>
            </li>
        </ul>
    </li>

    <li class="nav-header">Transaksi Apotek</li>

    <li class="nav-item">
        <a href="<?= base_url("transaksi/apotek/pemesanan") ?>" class="nav-link">
            <i class="nav-icon fas fa-users-cog"></i>
            <p>Pemesanan Obat</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?= base_url("transaksi/apotek/verifikasi-obat") ?>" class="nav-link">
            <i class="nav-icon fas fa-users-cog"></i>
            <p>Verifikasi Pemesanan Obat</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?= base_url("transaksi/apotek/obat-keluar") ?>" class="nav-link">
            <i class="nav-icon fas fa-users-cog"></i>
            <p>Obat Keluar</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?= base_url("transaksi/apotek/stock-opname") ?>" class="nav-link">
            <i class="nav-icon fas fa-users-cog"></i>
            <p>Stock Opname</p>
        </a>
    </li>

    <li class="nav-header">Laporan Apotek</li>

    <li class="nav-item">
        <a href="<?= base_url("laporan/apotek/data-obat") ?>" class="nav-link">
            <i class="nav-icon fas fa-file-alt"></i>
            <p>Data obat</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?= base_url("laporan/apotek/obat-kadaluarsa") ?>" class="nav-link">
            <i class="nav-icon fas fa-file-alt"></i>
            <p>Obat Kadaluarsa</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?= base_url("laporan/apotek/mutasi-obat") ?>" class="nav-link">
            <i class="nav-icon fas fa-file-alt"></i>
            <p>Mutasi Obat</p>
        </a>
    </li>
<?php endif ?>