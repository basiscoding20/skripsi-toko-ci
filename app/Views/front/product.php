<?= $this->extend('template/layout'); ?>
<?= $this->section('content'); ?>
<!-- About-->
<section class="page-section" id="products">
    <div class="container">
        <div class="row">
            <?php $percent = round((($products->price - $products->price_sale)*100) /$products->price); ?>
            <div class="col-lg-12 row">
                <div class="card shadow mb-4">
                    <div class="row no-gutters">
                        <div class="col-lg-4">
                            <div style="position: absolute;">
                                <span class="badge badge-danger">
                                    <?= $percent."% OFF"; ?>
                                </span>
                            </div>
                            <img src="<?= ($products->photo && file_exists('upload/products/'.$products->photo))?base_url('upload/products/'.$products->photo):base_url('back/img/undraw_profile.svg'); ?>" class="card-img-top card-img" alt="<?= $products->title; ?>">
                            <br>
                            <div class="col-lg-12" style="padding-top: 1rem;">
                                <form action="<?= base_url('cart/store') ?>" method="post" enctype="multipart/form-data">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="id" value="<?= $products->id; ?>" required />
                                    <?php if($products->type == 'product'): ?>
                                    <div class="form-group">
                                        <label for="qty">Stock : <?= $products->quantity; ?></label>
                                        <input type="number" class="form-control <?php if(session('errors.qty')) : ?>is-invalid<?php endif ?>"
                                               name="qty" placeholder="Quantity" value="<?= old('qty')?old('qty'):'1'; ?>" id="qty" min="1" required>
                                        <?php if(session('errors.qty')): ?>
                                            <span class="invalid-feedback" role="alert">
                                                <strong><?= session('errors.qty'); ?></strong>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    <?php elseif($products->type == 'service'): ?>
                                    <input type="hidden" name="qty" value="1" required />
                                    <div class="row">
                                        <div class="form-group col-md-7">
                                            <label for="date">Date</label>
                                            <input type="date" class="form-control <?php if(session('errors.date')) : ?>is-invalid<?php endif ?>"
                                                   name="date" placeholder="Date" value="<?= old('date')?old('date'):date('Y-m-d'); ?>" id="date" min="<?= date('Y-m-d'); ?>" required>
                                            <?php if(session('errors.date')): ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?= session('errors.date'); ?></strong>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="form-group col-md-5">
                                            <label for="time">Time</label>
                                            <input type="time" class="form-control <?php if(session('errors.time')) : ?>is-invalid<?php endif ?>"
                                                   name="time" placeholder="Time" value="<?= old('time')?old('time'):date('H:i'); ?>" id="time" required>
                                            <?php if(session('errors.time')): ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?= session('errors.time'); ?></strong>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <button type="submit" class="card-link float-right btn btn-sm btn-success">Add to Cart</button>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="card-body">
                                <a href="<?= base_url('data/'.$products->type.'/'.$products->categoryslug); ?>" class="badge badge-primary nounderline float-right">
                                    <?= $products->category; ?>
                                </a>
                                <span class="badge badge-dark float-right">
                                    <?= $products->seller; ?>
                                </span>
                                <h6 class="card-title"><?= $products->title; ?></h6>
                            
                                <span style="font-size: 30px;"><?= "Rp".number_format($products->price_sale,0,",","."); ?></span>
                                <p class="card-text" style="padding-bottom: 2rem;">
                                    <span class="badge badge-danger float-left">
                                        <?= $percent."% OFF"; ?>
                                    </span>
                                    <s class="text-danger float-left" style="font-size: 12px;"><?= "Rp".number_format($products->price,0,",","."); ?></s>
                                    <span class="badge badge-<?= ($products->quantity<=10)?'danger':'success'; ?> float-right">Stock : <?= ($products->quantity<=10)?'Terbatas':'Available'; ?></span>
                                </p>

                                <p class="card-text" style="font-size: 12px;"><?= nl2br($products->description); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>