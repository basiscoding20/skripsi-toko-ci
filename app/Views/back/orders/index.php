<?= $this->extend('template/admin/layout'); ?>
<?= $this->section('content'); ?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= isset($title)?$title:'Orders'; ?></h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><?= isset($title)?$title:'Orders'; ?></h6>
        </div>
        <div class="card-body">
            <?= view('Myth\Auth\Views\_message_block') ?>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Order Code</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Order Code</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                    <?php $i = 1;
                        if(@count($orders)>0): foreach($orders as $row): ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= $row->code; ?></td>
                            <td><?= $row->customer; ?></td>
                            <td><?= "Rp".number_format($row->total,0,",","."); ?></td>
                            <td><span class="badge badge-info"><?= $row->status; ?></span></td>
                            <td>
                                <a href="<?= base_url('dashboard/order/'.$row->id.'/show/'.$list); ?>" class="btn btn-sm btn-success">Show</a>
                                <?php if(!in_groups(['admin'])): if(changeorder($row->status)): ?>
                                <a href="<?= base_url('dashboard/order/'.$row->id.'/edit/'.$list); ?>" class="btn btn-sm btn-warning">Edit</a>
                                <?php endif; endif; ?>
                                <?php if($row->photo && file_exists('upload/orders/'.$row->photo)): ?>
                                <a href="<?= base_url('upload/orders/'.$row->photo); ?>" target="_blank" class="btn btn-sm btn-primary">Bukti Pembayaran</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
<?= $this->endSection(); ?>