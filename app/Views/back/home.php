<?= $this->extend('template/admin/layout'); ?>
<?= $this->section('content'); ?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <?php if(in_groups(['admin'])): ?>
        <a href="<?= base_url('dashboard/reports') ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Report</a>
        <?php endif; ?>
    </div>

    <!-- Content Row -->
    <?= view('Myth\Auth\Views\_message_block') ?>
    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <?php $or = orderreport('order'); ?>
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Orders (order)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $or['total']; ?></div>
                            <h4 class="small font-weight-bold"><?= $or['count']; ?> Order</h4>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <?php $or = orderreport('completed'); ?>
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Orders (completed)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $or['total']; ?></div>
                            <h4 class="small font-weight-bold"><?= $or['count']; ?> Order</h4>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <?php $or = orderreport('rejected'); ?>
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Orders (rejected)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $or['total']; ?></div>
                            <h4 class="small font-weight-bold"><?= $or['count']; ?> Order</h4>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <?php $or = orderreport('paid'); ?>
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Orders (paid)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $or['total']; ?></div>
                            <h4 class="small font-weight-bold"><?= $or['count']; ?> Order</h4>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
<?= $this->endSection(); ?>