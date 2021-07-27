<?= $this->extend('template/admin/layout'); ?>
<?= $this->section('content'); ?>
<?php $store = $list?'dashboard/data/'.$list.'/store':'dashboard/data/store'; ?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= isset($title)?$title:'Create'; ?></h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><?= isset($title)?$title:'Create'; ?></h6>
        </div>
        <form action="<?= base_url($store) ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="card-body">
                <?= view('Myth\Auth\Views\_message_block') ?>
                <div class="row">
                    <div class="col-lg-4">
                        <img src="<?= base_url('back/img/no-image.png'); ?>" alt="data image" class="card-img-top card-img">
                        <div class="form-group">
                            <label for="photo">Photo</label>
                            <input type="file" name="photo" accept="image/*" class="form-control <?php if(session('errors.photo')) : ?>is-invalid<?php endif ?>" id="photo" required />
                            <?php if(session('errors.photo')): ?>
                                <span class="invalid-feedback" role="alert">
                                    <strong><?= session('errors.photo'); ?></strong>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label for="title">Name</label>
                                <input type="text" class="form-control <?php if(session('errors.title')) : ?>is-invalid<?php endif ?>"
                                       name="title" placeholder="Name" value="<?= old('title'); ?>" id="title" required>
                                <?php if(session('errors.title')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?= session('errors.title'); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="form-group col-lg-4">
                                <label for="type">Type</label>
                                <select class="form-control <?php if(session('errors.type')) : ?>is-invalid<?php endif ?>" id="type" name="type" required>
                                    <?php if(@count($lists)>1): ?>
                                    <option value="">Choice</option>
                                    <?php endif; ?>
                                    <?php if(@count($lists)>0): foreach ($lists as $row): ?>
                                    <option value="<?= $row; ?>" <?= (old('type')==$row)?'selected':''; ?> ><?= $row; ?></option>
                                    <?php endforeach; endif; ?>
                                </select>
                                <?php if(session('errors.type')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?= session('errors.type'); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="form-group col-lg-4">
                                <label for="seller_id">Seller</label>
                                <select class="form-control <?php if(session('errors.seller_id')) : ?>is-invalid<?php endif ?>" id="seller_id" name="seller_id" required>
                                    <?php if(@count($users)>1): ?>
                                    <option value="">Choice</option>
                                    <?php endif; ?>
                                    <?php if(@count($users)>0): foreach ($users as $row): ?>
                                    <option value="<?= $row->id; ?>" <?= (old('seller_id')==$row->id)?'selected':''; ?> ><?= $row->name; ?></option>
                                    <?php endforeach; endif; ?>
                                </select>
                                <?php if(session('errors.seller_id')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?= session('errors.seller_id'); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="form-group col-lg-4">
                                <label for="category_id">Categories</label>
                                <select class="form-control <?php if(session('errors.category_id')) : ?>is-invalid<?php endif ?>" id="category_id" name="category_id" required>
                                    <?php if(@count($categories)>1): ?>
                                    <option value="">Choice</option>
                                    <?php endif; ?>
                                    <?php if(@count($categories)>0): foreach ($categories as $row): ?>
                                    <option value="<?= $row->id; ?>" <?= (old('category_id')==$row->id)?'selected':''; ?> ><?= $row->title; ?></option>
                                    <?php endforeach; endif; ?>
                                </select>
                                <?php if(session('errors.category_id')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?= session('errors.category_id'); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="form-group col-lg-12">
                                <label for="description">Description</label>
                                <textarea class="form-control <?php if(session('errors.description')) : ?>is-invalid<?php endif ?>" id="description" name="description" placeholder="Description" required><?= old('description'); ?></textarea>
                                <?php if(session('errors.description')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?= session('errors.description'); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="form-group col-lg-4">
                                <label for="price">Price</label>
                                <input type="number" class="form-control <?php if(session('errors.price')) : ?>is-invalid<?php endif ?>"
                                       name="price" placeholder="Price" value="<?= old('price'); ?>" id="price" required>
                                <?php if(session('errors.price')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?= session('errors.price'); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="form-group col-lg-4">
                                <label for="price_sale">Sale Price</label>
                                <input type="number" class="form-control <?php if(session('errors.price_sale')) : ?>is-invalid<?php endif ?>"
                                       name="price_sale" placeholder="Sale Price" value="<?= old('price_sale'); ?>" id="price_sale" required>
                                <?php if(session('errors.price_sale')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?= session('errors.price_sale'); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="form-group col-lg-4">
                                <label for="quantity">Stock</label>
                                <input type="number" class="form-control <?php if(session('errors.quantity')) : ?>is-invalid<?php endif ?>"
                                       name="quantity" placeholder="Stock" value="<?= old('quantity'); ?>" id="quantity" required>
                                <?php if(session('errors.quantity')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?= session('errors.quantity'); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="form-group col-lg-12">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="customSwitch1" name="status" <?= old('status')?'checked':''; ?> >
                                    <label class="custom-control-label" for="customSwitch1">Activated</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-lg-12">
                        <a href="<?= base_url('dashboard/data/'.$list); ?>" class="card-link float-left btn btn-sm btn-danger">Back</a>
                        <button type="submit" class="btn btn-primary btn-sm float-right">Save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- /.container-fluid -->
<?= $this->endSection(); ?>