<ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('dashboard') ?>">
        <div class="sidebar-brand-icon">
            <i class="fas fa-building"></i>
        </div>
        <div class="sidebar-brand-text mx-3">CV. GUNATECH COMPUTINDO</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?= url_is('dashboard') ? 'active' : null; ?>">
        <a class="nav-link" href="<?= base_url('dashboard') ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <?php if(in_groups(['admin', 'seller'])): ?>
    <!-- Heading -->
    <div class="sidebar-heading">
        Data Management
    </div>

    <?php if(in_groups(['admin'])): ?>
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item <?= url_is('dashboard/categories*') ? 'active' : null; ?>">
        <a class="nav-link <?= url_is('dashboard/categories*') ? null : 'collapsed'; ?>" href="#" data-toggle="collapse" data-target="#collapseCategories"
            aria-expanded="<?= url_is('dashboard/categories*') ? 'true' : 'false'; ?>" aria-controls="collapseCategories">
            <i class="fas fa-fw fa-folder"></i>
            <span>Categories</span>
        </a>
        <div id="collapseCategories" class="collapse <?= url_is('dashboard/categories*') ? 'show' : null; ?>" aria-labelledby="headingCategories" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Categories Management:</h6>
                <a class="collapse-item <?= url_is('dashboard/categories/product*') ? 'active' : null; ?>" href="<?= base_url('dashboard/categories/product') ?>">Products</a>
                <a class="collapse-item <?= url_is('dashboard/categories/service*') ? 'active' : null; ?>" href="<?= base_url('dashboard/categories/service') ?>">Services</a>
            </div>
        </div>
    </li>
    <?php endif; ?>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item <?= url_is('dashboard/data*') ? 'active' : null; ?>">
        <a class="nav-link <?= url_is('dashboard/data*') ? null : 'collapsed'; ?>" href="#" data-toggle="collapse" data-target="#collapseData"
            aria-expanded="<?= url_is('dashboard/data*') ? 'true' : 'false'; ?>" aria-controls="collapseData">
            <i class="fas fa-fw fa-folder"></i>
            <span>Data</span>
        </a>
        <div id="collapseData" class="collapse <?= url_is('dashboard/data*') ? 'show' : null; ?>" aria-labelledby="headingData" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Data Management:</h6>
                <a class="collapse-item <?= url_is('dashboard/data/product*') ? 'active' : null; ?>" href="<?= base_url('dashboard/data/product') ?>">Products</a>
                <a class="collapse-item <?= url_is('dashboard/data/service*') ? 'active' : null; ?>" href="<?= base_url('dashboard/data/service') ?>">Services</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
    <?php endif; ?>

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?= (url_is('dashboard/order*') || url_is('dashboard/orders*')) ? 'active' : null; ?>">
        <a class="nav-link <?= (url_is('dashboard/order*') || url_is('dashboard/orders*')) ? null : 'collapsed'; ?>" href="#" data-toggle="collapse" data-target="#collapseOrder"
            aria-expanded="<?= (url_is('dashboard/order*') || url_is('dashboard/orders*')) ? 'true' : 'false'; ?>" aria-controls="collapseOrder">
            <i class="fas fa-fw fa-shopping-cart"></i>
            <span>Order</span>
        </a>
        <div id="collapseOrder" class="collapse <?= (url_is('dashboard/order*') || url_is('dashboard/orders*')) ? 'show' : null; ?>" aria-labelledby="headingOrder" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Order Management:</h6>
                <a class="collapse-item <?= url_is('dashboard/order/product*') ? 'active' : null; ?>" href="<?= base_url('dashboard/order/product') ?>">Products</a>
                <a class="collapse-item <?= url_is('dashboard/order/service*') ? 'active' : null; ?>" href="<?= base_url('dashboard/order/service') ?>">Services</a>
                <a class="collapse-item <?= url_is('dashboard/orders*') ? 'active' : null; ?>" href="<?= base_url('dashboard/orders') ?>">Completed</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <?php if(in_groups(['admin'])): ?>
    <!-- Heading -->
    <div class="sidebar-heading">
        Settings Management
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item <?= (url_is('dashboard/reports*') || url_is('dashboard/users*')) ? 'active' : null; ?>">
        <a class="nav-link <?= (url_is('dashboard/reports*') || url_is('dashboard/users*')) ? null : 'collapsed'; ?>" href="#" data-toggle="collapse" data-target="#collapseSettings"
            aria-expanded="<?= (url_is('dashboard/reports*') || url_is('dashboard/users*')) ? 'true' : 'false'; ?>" aria-controls="collapseSettings">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Settings</span>
        </a>
        <div id="collapseSettings" class="collapse <?= (url_is('dashboard/reports*') || url_is('dashboard/users*')) ? 'show' : null; ?>" aria-labelledby="headingSettings" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Settings Management:</h6>
                <a class="collapse-item <?= url_is('dashboard/users*') ? 'active' : null; ?>" href="<?= base_url('dashboard/users') ?>">Users</a>
                <a class="collapse-item <?= url_is('dashboard/reports*') ? 'active' : null; ?>" href="<?= base_url('dashboard/reports') ?>">Reports</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
    <?php endif; ?>

    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('logout'); ?>">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <span>Logout</span></a>
    </li>

</ul>