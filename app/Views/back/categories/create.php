<?= $this->extend('template/admin/layout'); ?>
<?= $this->section('content'); ?>
<?php $store = $list?'dashboard/categories/'.$list.'/store':'dashboard/categories/store'; ?>
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
                        <img src="<?= base_url('back/img/no-image.png'); ?>" alt="categories image" class="card-img-top card-img">
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
                            <div class="form-group col-lg-6">
                                <label for="title">Name</label>
                                <input type="text" class="form-control <?php if(session('errors.title')) : ?>is-invalid<?php endif ?>"
                                       name="title" placeholder="Name" value="<?= old('title'); ?>" id="title" required>
                                <?php if(session('errors.title')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?= session('errors.title'); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="form-group col-lg-6">
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

                            <div class="form-group col-lg-12">
                                <label for="description">Description</label>
                                <textarea class="form-control <?php if(session('errors.description')) : ?>is-invalid<?php endif ?>" id="description" name="description" placeholder="Description" required><?= old('description'); ?></textarea>
                                <?php if(session('errors.description')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?= session('errors.description'); ?></strong>
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
                        <?php if(in_groups(['admin'])): ?>
                        <a href="<?= base_url('dashboard/categories/'.$list); ?>" class="card-link float-left btn btn-sm btn-danger">Back</a>
                        <?php endif; ?>
                        <button type="submit" class="btn btn-primary btn-sm float-right">Save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- /.container-fluid -->
<?= $this->endSection(); ?>