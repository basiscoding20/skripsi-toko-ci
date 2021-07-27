<?= $this->extend('template/layout'); ?>
<?= $this->section('content'); ?>
<!-- About-->
<section class="page-section" id="products">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 row">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <a href="<?= base_url('cart/clear'); ?>" class="btn btn-sm btn-warning float-right">Clear Cart</a>
                        <form action="<?= base_url('checkout') ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                            <button type="submit" class="card-link btn btn-sm btn-success float-right">Checkout</button>
                        </form>
                        <h6 class="m-0 font-weight-bold text-primary"><?= isset($title)?$title:'Cart'; ?> <?= $total." Item"; ?></h6>
                    </div>
                    <form action="<?= base_url('cart/update') ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="card-body">
                        <?php if(@count($cart)>0): ?>
                        <div class="table-responsive">
                            <table class="table table-stripped table-hopper" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Photo</th>
                                        <th width="200">Name</th>
                                        <th>Type</th>
                                        <th>Price</th>
                                        <th width="200">Order</th>
                                        <th>Sub Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $i = 1;
                                    if(@count($cart)>0): foreach($cart as $row): ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><img src="<?= ($row['options']['photo'] && file_exists('upload/products/'.$row['options']['photo']))?base_url('upload/products/'.$row['options']['photo']):base_url('back/img/no-image.png'); ?>" width="50px"></td>
                                        <td><?= $row['name']; ?></td>
                                        <td><?= $row['options']['type']; ?></td>
                                        <td><?=  "Rp".number_format($row['price'],0,",","."); ?></td>
                                        <td>
                                            <input type="hidden" name="id<?= $row['rowid']; ?>" value="<?= $row['id']; ?>" required />
                                            <?php if($row['options']['type'] == 'product'): ?>
                                            <div class="form-group">
                                                <input type="number" class="form-control <?php if(session('errors.qty')) : ?>is-invalid<?php endif ?>"
                                                       name="qty<?= $row['rowid']; ?>" placeholder="Quantity" value="<?= $row['qty']; ?>" id="qty" min="1" required>
                                                <?php if(session('errors.qty')): ?>
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong><?= session('errors.qty'); ?></strong>
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <?php elseif($row['options']['type'] == 'service'): ?>
                                            <input type="hidden" name="qty<?= $row['rowid']; ?>" value="1" required />
                                            <div class="row">
                                                <div class="form-group">
                                                    <label for="date">Date</label>
                                                    <input type="date" class="form-control <?php if(session('errors.date')) : ?>is-invalid<?php endif ?>"
                                                           name="date<?= $row['rowid']; ?>" placeholder="Date" value="<?= $row['options']['date']?$row['options']['date']:date('Y-m-d'); ?>" id="date" min="<?= date('Y-m-d'); ?>" required>
                                                    <?php if(session('errors.date')): ?>
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong><?= session('errors.date'); ?></strong>
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="form-group">
                                                    <label for="time">Time</label>
                                                    <input type="time" class="form-control <?php if(session('errors.time')) : ?>is-invalid<?php endif ?>"
                                                           name="time<?= $row['rowid']; ?>" placeholder="Time" value="<?= $row['options']['time']?$row['options']['time']:date('H:i'); ?>" id="time" required>
                                                    <?php if(session('errors.time')): ?>
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong><?= session('errors.time'); ?></strong>
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= "Rp".number_format($row['subtotal'],0,",","."); ?></td>
                                        <td>
                                            <a href="<?= base_url('cart/'.$row['rowid'].'/delete'); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; endif; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="6">Total</th>
                                        <th colspan="2"><?= "Rp".number_format($carts->total(),0,",","."); ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <?php else: ?>
                        <div class="alert alert-success">No product in cart</div>
                        <?php endif; ?>
                    </div>
                    <div class="card-footer">
                        <?php if(@count($cart)>0): ?>
                        <button type="submit" class="card-link float-left btn btn-sm btn-info">Update</button>
                        <a href="<?= base_url('/'); ?>" class="btn btn-sm btn-danger float-right">Back</a>
                        <?php else: ?>
                        <a href="<?= base_url('/'); ?>" class="btn btn-sm btn-danger float-right">Back</a>
                        <?php endif; ?>
                        <br>
                        <br>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>