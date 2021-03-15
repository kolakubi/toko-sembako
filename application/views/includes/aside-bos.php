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
       
      </ul>
    </nav>