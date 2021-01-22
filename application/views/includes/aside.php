<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="<?php echo site_url('') ?>" class="brand-link text-center">
    <!-- <span class="brand-text font-weight-light"><?php echo $this->session->userdata('toko')->nama ?></span> -->
    <!-- <img src="<?php echo base_url().'assets/image/logo-sahabat-sembako-putih.png' ?>" style="max-width: 200px;" /> -->
    <img src="https://officialsancu.com/appsembako/assets/image/logo-sahabat-sembako-putih.png" style="max-width: 200px;" />
  </a>
  <?php $uri = $this->uri->segment(1) ?>
  <?php $role = $this->session->userdata('role'); ?>

  <!-- Sidebar -->
  <div class="sidebar">

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="<?php echo site_url('dashboard') ?>" class="nav-link <?php echo $uri == 'dashboard' || $uri == '' ? 'active' : 'no' ?>">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        <li class="nav-item" style="display: <?php echo $role == 'bos' ? 'none' : 'block' ?>">
          <a href="<?php echo site_url('supplier') ?>" class="nav-link <?php echo $uri == 'supplier' ? 'active' : 'no' ?>">
            <i class="nav-icon fas fa-truck"></i>
            <p>
              Supplier
            </p>
          </a>
        </li>
        <li class="nav-item" style="display: <?php echo $role == 'bos' ? 'none' : 'block' ?>">
          <a href="<?php echo site_url('pelanggan') ?>" class="nav-link <?php echo $uri == 'pelanggan' ? 'active' : 'no' ?>">
            <i class="nav-icon fas fa-address-book"></i>
            <p>
              Pelanggan
            </p>
          </a>
        </li>
        <li style="display: <?php echo $role == 'bos' ? 'none' : 'block' ?>" class="nav-item has-treeview <?php echo $uri == 'produk' || $uri == 'kategori_produk' || $uri == 'satuan_produk' ? 'menu-open' : 'no' ?>">
          <a href="#" class="nav-link <?php echo $uri == 'produk' || $uri == 'kategori_produk' || $uri == 'satuan_produk' ? 'active' : 'no' ?>">
            <i class="nav-icon fas fa-box"></i>
            <p>
              Produk
            </p>
            <i class="right fas fa-angle-right"></i>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?php echo site_url('kategori_produk') ?>" class="nav-link <?php echo $uri == 'kategori_produk' ? 'active' : 'no' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>
                  Kategori Produk
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo site_url('satuan_produk') ?>" class="nav-link <?php echo $uri == 'satuan_produk' ? 'active' : 'no' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>
                  Satuan Produk
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo site_url('produk') ?>" class="nav-link <?php echo $uri == 'produk' ? 'active' : 'no' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>
                  Produk
                </p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item has-treeview <?php echo $uri == 'stok_masuk' 
        || $uri == 'stok_keluar'
        || $uri == 'transaksi'
        || $uri == 'invoice' ? 'menu-open' : 'no' ?>" style="display: <?php echo $role == 'bos' ? 'none' : 'block' ?>">
          <a href="#" class="nav-link <?php echo $uri == 'stok_masuk' 
          || $uri == 'stok_keluar'
          || $uri == 'transaksi'
          || $uri == 'invoice' ? 'active' : 'no' ?>">
            <i class="fas fa-money-bill nav-icon"></i>
            <p>Transaksi</p>
            <i class="right fas fa-angle-right"></i>
          </a>
          <ul class="nav-treeview">
            <li class="nav-item">
              <a href="<?php echo site_url('stok_masuk') ?>" class="nav-link <?php echo $uri == 'stok_masuk' ? 'active' : 'no' ?>">
                <i class="far fa-circle nav-icon"></i>
                <!-- <p>Stok Masuk</p> -->
                <p>Pembelian</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo site_url('transaksi') ?>" class="nav-link <?php echo $uri == 'transaksi' ? 'active' : 'no' ?>">
                <i class="far fa-circle nav-icon"></i>
                <!-- <p>Transaksi</p> -->
                <p>Penjualan</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo site_url('invoice') ?>" class="nav-link <?php echo $uri == 'invoice' ? 'active' : 'no' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Invoice</p>
              </a>
            </li>
            <!-- <li class="nav-item">
              <a href="<?php echo site_url('stok_keluar') ?>" class="nav-link <?php echo $uri == 'stok_keluar' ? 'active' : 'no' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Stok Keluar</p>
              </a>
            </li> -->
          </ul>
        </li>
       
        
        <li class="nav-item has-treeview 
        <?php echo $uri == 'laporan_penjualan' 
        || $uri == 'laporan_stok_masuk' 
        || $uri == 'laporan_stok_keluar' 
        || $uri == 'laporan_keuangan' 
        || $uri == 'laporan_kartu_stok' ? 'menu-open' : 'no' ?>">
          <a href="<?php echo site_url('laporan') ?>" class="nav-link 
          <?php echo $uri == 'laporan_penjualan' 
          || $uri == 'laporan_stok_masuk' 
          || $uri == 'laporan_stok_keluar' 
          || $uri == 'laporan_keuangan'
          || $uri == 'laporan_kartu_stok' ? 'active' : 'no' ?>">
            <i class="fas fa-book nav-icon"></i>
            <p>Laporan</p>
            <i class="right fas fa-angle-right"></i>
          </a>
          <ul class="nav-treeview">
            <li class="nav-item">
              <a href="<?php echo site_url('laporan_penjualan') ?>" class="nav-link <?php echo $uri == 'laporan_penjualan' ? 'active' : 'no' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Laporan Penjualan</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo site_url('laporan_stok_masuk') ?>" class="nav-link <?php echo $uri == 'laporan_stok_masuk' ? 'active' : 'no' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Laporan Pembelian</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo site_url('laporan_keuangan') ?>" class="nav-link <?php echo $uri == 'laporan_keuangan' ? 'active' : 'no' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Laporan Keuangan</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo site_url('laporan_kartu_stok') ?>" class="nav-link <?php echo $uri == 'laporan_kartu_stok' ? 'active' : 'no' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Laporan Kartu Stok</p>
              </a>
            </li>
            <!-- <li class="nav-item">
              <a href="<?php echo site_url('laporan_stok_keluar') ?>" class="nav-link <?php echo $uri == 'laporan_stok_keluar' ? 'active' : 'no' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Laporan Stok Keluar</p>
              </a>
            </li> -->
          </ul>
        </li>
        <?php if ($role === 'admin'): ?>
          <li class="nav-item">
            <a href="<?php echo site_url('pengaturan') ?>" class="nav-link <?php echo $uri == 'pengaturan' ? 'active' : 'no' ?>">
              <i class="fas fa-cog nav-icon"></i>
              <p>Pengaturan</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo site_url('pengguna') ?>" class="nav-link <?php echo $uri == 'pengguna' ? 'active' : 'no' ?>">
              <i class="fas fa-user nav-icon"></i>
              <p>Pengguna</p>
            </a>
          </li>
        <?php endif ?>
       
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>