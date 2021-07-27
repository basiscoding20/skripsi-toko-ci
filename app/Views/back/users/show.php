<?= $this->extend('template/admin/layout'); ?>
<?= $this->section('content'); ?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= isset($title)?$title:'Detail'; ?></h1>

    <!-- DataTales Example -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="row no-gutters">
                    <?= view('Myth\Auth\Views\_message_block') ?>
                    <div class="col-lg-4">
                        <img src="<?= ($users->photo && file_exists('upload/users/'.$users->photo))?base_url('upload/users/'.$users->photo):base_url('back/img/undraw_profile.svg'); ?>" class="card-img-top card-img" alt="<?= $users->name; ?>">
                    </div>
                    <div class="col-lg-8">
                        <div class="card-body">
                            <?= ($users->active==1)?'<span class="badge badge-success float-right">Active</span>':'<span class="badge badge-danger float-right">Inactive</span>'; ?>
                            <span class="badge badge-<?= ($users->rolename=='admin')?'primary':(($users->rolename=='seller')?'success':(($users->rolename=='user')?'info':'dark')); ?> float-right"><?= $users->rolename; ?></span>
                            <h5 class="card-title"><?= $users->name; ?></h5>
                            <p class="card-text"><?= $users->address; ?></p>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">NIK : <?= $users->nik; ?></li>
                            <li class="list-group-item">Email : <?= $users->email; ?></li>
                            <li class="list-group-item">Phone : <?= $users->phone; ?></li>
                        </ul>
                    </div>
                </div>
                <div class="card-footer">
                    <?php if(in_groups(['admin'])): ?>
                    <a href="<?= base_url('dashboard/users'); ?>" class="card-link float-left btn btn-sm btn-danger">Back</a>
                    <?php endif; ?>
                    <a href="<?= base_url('dashboard/users/'.$users->id.'/edit'); ?>" class="card-link float-right btn btn-sm btn-warning">Edit</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
<?= $this->endSection(); ?>