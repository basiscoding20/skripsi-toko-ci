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
                        <img src="<?= ($categories->photo && file_exists('upload/categories/'.$categories->photo))?base_url('upload/categories/'.$categories->photo):base_url('back/img/undraw_profile.svg'); ?>" class="card-img-top card-img" alt="<?= $categories->title; ?>">
                    </div>
                    <div class="col-lg-8">
                        <div class="card-body">
                            <?= ($categories->status=="active")?'<span class="badge badge-success float-right">'.$categories->status.'</span>':'<span class="badge badge-danger float-right">'.$categories->status.'</span>'; ?>
                            <span class="badge badge-dark float-right">
                                <?= $categories->type; ?>
                            </span>
                            <h5 class="card-title"><?= $categories->title; ?></h5>
                            <p class="card-text"><?= $categories->description; ?></p>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <?php if(in_groups(['admin'])): ?>
                    <a href="<?= base_url('dashboard/categories/'.$categories->type); ?>" class="card-link float-left btn btn-sm btn-danger">Back</a>
                    <?php endif; ?>
                    <a href="<?= base_url('dashboard/categories/'.$categories->id.'/edit/'.$categories->type); ?>" class="card-link float-right btn btn-sm btn-warning">Edit</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
<?= $this->endSection(); ?>