<?= $this->extend('template/admin/layout'); ?>
<?= $this->section('content'); ?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= isset($title)?$title:'Edit'; ?></h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><?= isset($title)?$title:'Edit'; ?></h6>
        </div>
        <form action="<?= base_url('dashboard/profile/update') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="card-body">
                <?= view('Myth\Auth\Views\_message_block') ?>
                <div class="row">
                    <div class="col-lg-4">
                        <img src="<?= ($users->photo && file_exists('upload/users/'.$users->photo))? base_url('upload/users/'.$users->photo): base_url('back/img/undraw_profile.svg'); ?>" alt="<?= $users->name; ?>" class="card-img-top card-img">
                        <div class="form-group">
                            <label for="photo">Photo</label>
                            <input type="file" name="photo" accept="image/*" class="form-control <?php if(session('errors.photo')) : ?>is-invalid<?php endif ?>" id="photo" <?= ($users->photo && file_exists('upload/users/'.$users->photo))? '': 'required'; ?> />
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
                                <label for="nik">NIK</label>
                                <input type="number" class="form-control <?php if(session('errors.nik')) : ?>is-invalid<?php endif ?>"
                                       name="nik" placeholder="NIK" value="<?= old('nik')?old('nik'):$users->nik; ?>" id="nik" required>
                                <?php if(session('errors.nik')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?= session('errors.nik'); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="form-group col-lg-6">
                                <label for="name">Name</label>
                                <input type="text" class="form-control <?php if(session('errors.name')) : ?>is-invalid<?php endif ?>"
                                       name="name" placeholder="Name" value="<?= old('name')?old('name'):$users->name; ?>" id="name" required>
                                <?php if(session('errors.name')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?= session('errors.name'); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="form-group col-lg-6">
                                <label for="email"><?=lang('Auth.email')?></label>
                                <input type="email" class="form-control <?php if(session('errors.email')) : ?>is-invalid<?php endif ?>"
                                       name="email" aria-describedby="emailHelp" placeholder="<?=lang('Auth.email')?>" value="<?= old('email')?old('email'):$users->email; ?>" id="email" required>
                                <small id="emailHelp" class="form-text text-muted"><?=lang('Auth.weNeverShare')?></small>
                                <?php if(session('errors.email')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?= session('errors.email'); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="form-group col-lg-6">
                                <label for="phone">Phone</label>
                                <input type="number" class="form-control <?php if(session('errors.phone')) : ?>is-invalid<?php endif ?>"
                                       name="phone" placeholder="Phone" value="<?= old('phone')?old('phone'):$users->phone; ?>" id="phone" required>
                                <?php if(session('errors.phone')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?= session('errors.phone'); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="form-group col-lg-12">
                                <label for="address">address</label>
                                <textarea class="form-control <?php if(session('errors.address')) : ?>is-invalid<?php endif ?>" id="address" name="address" placeholder="Address" required><?= old('address')?old('address'):$users->address; ?></textarea>
                                <?php if(session('errors.address')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?= session('errors.address'); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="form-group col-lg-6">
                                <label for="username"><?=lang('Auth.username')?></label>
                                <input type="text" class="form-control <?php if(session('errors.username')) : ?>is-invalid<?php endif ?>" name="username" placeholder="<?=lang('Auth.username')?>" value="<?= old('username')?old('username'):$users->username; ?>" id="username" required>
                                <?php if(session('errors.username')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?= session('errors.username'); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="form-group col-lg-6">
                                <label for="password"><?=lang('Auth.password')?></label>
                                <input type="password" name="password" class="form-control <?php if(session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="<?=lang('Auth.password')?>" autocomplete="off" id="password">
                                <?php if(session('errors.password')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?= session('errors.password'); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-lg-12">
                        <a href="<?= base_url('dashboard/profile'); ?>" class="card-link float-left btn btn-sm btn-danger">Back</a>
                        <button type="submit" class="btn btn-primary btn-sm float-right">Save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- /.container-fluid -->
<?= $this->endSection(); ?>