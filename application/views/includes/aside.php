<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4" style="overflow-y: scroll;">
  <!-- Brand Logo -->
  <a href="<?php echo site_url('') ?>" class="brand-link text-center">
    <!-- <span class="brand-text font-weight-light"><?php echo $this->session->userdata('toko')->nama ?></span> -->
    <!-- <img src="<?php echo base_url().'assets/image/logo-sahabat-sembako-putih.png' ?>" style="max-width: 200px;" /> -->
    <img src="<?php echo base_url() ?>/assets/image/logo-sahabat-sembako-putih.png" style="max-width: 200px;" />
  </a>
  <?php $uri = $this->uri->segment(1) ?>
  <?php $role = $this->session->userdata('role'); ?>

  <!-- Sidebar -->
  <div class="sidebar">

    <!-- Sidebar Menu -->
    <?php if($role == 'sales') : ?>

      <?php include_once('aside-sales.php') ?>

    <?php elseif($role == 'admin') : ?>

      <?php include_once('aside-admin.php') ?>

    <?php elseif($role == 'kasir') : ?>

      <?php include_once('aside-kasir.php') ?>

    <?php elseif($role == 'asisten bos') : ?>

      <?php include_once('aside-asisten-bos.php') ?>

    <?php else: ?>

      <?php include_once('aside-bos.php') ?>

    <?php endif ?>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>