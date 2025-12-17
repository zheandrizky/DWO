<?php
function nav_active($key, $current)
{
  return $key === $current ? 'active' : '';
}
?>
<aside class="left-sidebar">
  <div>
    <div class="brand-logo d-flex align-items-center justify-content-between">
      <a href="<?= base_url('?page=profile') ?>" class="text-nowrap logo-img">
        <img src="<?= base_url('assets/images/logos/dark-logo.svg') ?>" width="180" alt="" />
      </a>
      <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
        <i class="ti ti-x fs-8"></i>
      </div>
    </div>

    <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
      <ul id="sidebarnav">
        <li class="nav-small-cap" style="margin-top: 0px;">
          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
          <span class="hide-menu">Home</span>
        </li>

        <li class="sidebar-item <?= nav_active('profile', $page) ?>">
          <a class="sidebar-link <?= nav_active('profile', $page) ?>" href="<?= base_url('?page=profile') ?>" aria-expanded="false">
            <span><i class="ti ti-layout-dashboard"></i></span>
            <span class="hide-menu">Profil Kelompok</span>
          </a>
        </li>

        <li class="nav-small-cap">
          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
          <span class="hide-menu">DATA VISUALIZATION</span>
        </li>

        <li class="sidebar-item <?= nav_active('annual-revenue', $page) ?>">
          <a class="sidebar-link <?= nav_active('annual-revenue', $page) ?>" href="<?= base_url('?page=annual-revenue') ?>" aria-expanded="false">
            <span><i class="ti ti-chart-pie"></i></span>
            <span class="hide-menu">Annual Revenue</span>
          </a>
        </li>

        <li class="sidebar-item <?= nav_active('yearly-growth', $page) ?>">
          <a class="sidebar-link <?= nav_active('yearly-growth', $page) ?>" href="<?= base_url('?page=yearly-growth') ?>" aria-expanded="false">
            <span><i class="ti ti-arrow-up-right"></i></span>
            <span class="hide-menu">Yearly Growth</span>
          </a>
        </li>

        <li class="sidebar-item <?= nav_active('category-sales', $page) ?>">
          <a class="sidebar-link <?= nav_active('category-sales', $page) ?>" href="<?= base_url('?page=category-sales') ?>" aria-expanded="false">
            <span><i class="ti ti-folder"></i></span>
            <span class="hide-menu">Category Sales</span>
          </a>
        </li>

        <li class="sidebar-item <?= nav_active('top-bottom-products', $page) ?>">
          <a class="sidebar-link <?= nav_active('top-bottom-products', $page) ?>" href="<?= base_url('?page=top-bottom-products') ?>" aria-expanded="false">
            <span><i class="ti ti-list"></i></span>
            <span class="hide-menu">Top & Bottom Products</span>
          </a>
        </li>

        <li class="sidebar-item <?= nav_active('branch-sales', $page) ?>">
          <a class="sidebar-link <?= nav_active('branch-sales', $page) ?>" href="<?= base_url('?page=branch-sales') ?>" aria-expanded="false">
            <span><i class="ti ti-building"></i></span>
            <span class="hide-menu">Branch Sales</span>
          </a>
        </li>

        <li class="nav-small-cap">
          <span class="hide-menu">ANALYSIS</span>
        </li>

        <li class="sidebar-item">
          <a class="sidebar-link" href="http://localhost:8080/mondrian/">
            <span><i class="ti ti-chart-dots"></i></span>
            <span class="hide-menu">OLAP Analysis</span>
          </a>
        </li>

      </ul>
    </nav>
  </div>
</aside>