<?= $this->extend('template/admin/layout'); ?>
<?= $this->section('content'); ?>
<?php $create = $list?'dashboard/categories/'.$list.'/create':'dashboard/categories/create'; ?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= isset($title)?$title:'Categories'; ?></h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="<?= base_url($create); ?>" class="btn btn-sm btn-success float-right">Create</a>
            <h6 class="m-0 font-weight-bold text-primary"><?= isset($title)?$title:'Categories'; ?></h6>
        </div>
        <div class="card-body">
            <?= view('Myth\Auth\Views\_message_block') ?>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                    <?php $i = 1;
                        if(@count($categories)>0): foreach($categories as $row): ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><img src="<?= ($row->photo && file_exists('upload/categories/'.$row->photo))?base_url('upload/categories/'.$row->photo):base_url('back/img/no-image.png'); ?>" width="50px"></td>
                            <td><?= $row->title; ?></td>
                            <td><?= $row->type; ?></td>
                            <td><?= ($row->status=='active')?'<span class="badge badge-success">'.$row->status.'</span>':'<span class="badge badge-danger">'.$row->status.'</span>'; ?></td>
                            <td>
                                <a href="<?= base_url('dashboard/categories/'.$row->id.'/show/'.$row->type); ?>" class="btn btn-sm btn-success">Show</a>
                                <a href="<?= base_url('dashboard/categories/'.$row->id.'/edit/'.$row->type); ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="<?= base_url('dashboard/categories/'.$row->id.'/delete/'.$row->type); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
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