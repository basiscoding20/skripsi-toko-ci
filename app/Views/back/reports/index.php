<?= $this->extend('template/admin/layout'); ?>
<?= $this->section('css'); ?>
<link href="<?= base_url(); ?>/back/css/gijgo.min.css" rel="stylesheet">
<?= $this->endSection(); ?>
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
            <form action="<?= base_url('dashboard/reports') ?>" method="GET">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <select name="type" id="type" class="form-control type <?php if(session('errors.type')) : ?>is-invalid<?php endif ?>">
                                <option value="">Pilih Tipe</option>
                                <?php foreach($producttype as $row): ?>
                                <option value="<?= $row; ?>" <?= ($row==$type)?'selected':''; ?>><?= $row; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php if(session('errors.type')): ?>
                                <span class="invalid-feedback" role="alert">
                                    <strong><?= session('errors.type'); ?></strong>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <select name="status" id="status" class="form-control status <?php if(session('errors.status')) : ?>is-invalid<?php endif ?>">
                                <option value="">Pilih Status</option>
                                <?php foreach($orderstatus as $row): ?>
                                <option value="<?= $row; ?>" <?= ($row==$status)?'selected':''; ?>><?= $row; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php if(session('errors.status')): ?>
                                <span class="invalid-feedback" role="alert">
                                    <strong><?= session('errors.status'); ?></strong>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="startDate" name="from" value="<?= $from; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="endDate" name="to" value="<?= $to; ?>" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <button type="submit" class="btn btn-sm btn-success">Search</button>
                        <a href="<?= base_url('dashboard/reports/export?type='.$type.'&status='.$status.'&from='.$from.'&to='.$to) ?>" class="btn btn-sm btn-success" target="_blank">Export</a>
                    </div>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Photo</th>
                            <th width="200">Name</th>
                            <th>Type</th>
                            <th>Price</th>
                            <th width="200">Order</th>
                            <th>Sub Total</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Photo</th>
                            <th width="200">Name</th>
                            <th>Type</th>
                            <th>Price</th>
                            <th width="200">Order</th>
                            <th>Sub Total</th>
                        </tr>
                    </tfoot>
                    <tbody>
                    <?php $i = 1;
                        if(@count($orders)>0): foreach($orders as $row): ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><img src="<?= ($row->photo && file_exists('upload/products/'.$row->photo))?base_url('upload/products/'.$row->photo):base_url('back/img/no-image.png'); ?>" width="50px"></td>
                            <td><?= $row->title; ?></td>
                            <td><?= $row->type; ?></td>
                            <td><?=  "Rp".number_format($row->price,0,",","."); ?></td>
                            <td>
                                <?php if($row->type == 'product'): ?>
                                <?= $row->quantity; ?>
                                <?php elseif($row->type == 'service'): ?>
                                <?= $row->quantity; ?>

                                <?php //$row->datetime?date('d F Y H:i', strtotime($row->datetime)):date('d F Y H:i'); ?>

                                <?php endif; ?>
                            </td>
                            <td><?= "Rp".number_format(($row->quantity*$row->price),0,",","."); ?></td>
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
<?= $this->section('js'); ?>
<script src="<?= base_url(); ?>/back/js/gijgo.min.js"></script>
<script type="text/javascript">
    var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
    $('#startDate').datepicker({
        format: 'yyyy-mm-dd',
        uiLibrary: 'bootstrap4',
        iconsLibrary: 'fontawesome',
        maxDate: function () {
            return $('#endDate').val();
        }
    });
    $('#endDate').datepicker({
        format: 'yyyy-mm-dd',
        uiLibrary: 'bootstrap4',
        iconsLibrary: 'fontawesome',
        minDate: function () {
            return $('#startDate').val();
        }
    });
</script>
<?= $this->endSection(); ?>