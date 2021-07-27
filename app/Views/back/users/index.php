<?= $this->extend('template/admin/layout'); ?>
<?= $this->section('content'); ?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= isset($title)?$title:'Datatable'; ?></h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="<?= base_url('dashboard/users/create'); ?>" class="btn btn-sm btn-success float-right">Create</a>
            <h6 class="m-0 font-weight-bold text-primary"><?= isset($title)?$title:'Datatable'; ?></h6>
        </div>
        <div class="card-body">
            <?= view('Myth\Auth\Views\_message_block') ?>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Photo</th>
                            <th>NIK</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Username</th>
                            <th>Status</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Photo</th>
                            <th>NIK</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Username</th>
                            <th>Status</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                    <?php $i = 1;
                        if(@count($users)>0): foreach($users as $row): ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><img src="<?= ($row->photo && file_exists('upload/users/'.$row->photo))?base_url('upload/users/'.$row->photo):base_url('back/img/undraw_profile.svg'); ?>" width="50px"></td>
                            <td><?= $row->nik; ?></td>
                            <td><?= $row->name; ?></td>
                            <td><?= $row->address.'<br>Phone : '.$row->phone.'<br>Email : '.$row->email; ?></td>
                            <td><?= $row->username; ?></td>
                            <td><?= ($row->active==1)?'<span class="badge badge-success">Active</span>':'<span class="badge badge-danger">Inactive</span>'; ?></td>
                            <td><span class="badge badge-<?= ($row->rolename=='admin')?'primary':(($row->rolename=='seller')?'success':(($row->rolename=='user')?'info':'dark')); ?>"><?= $row->rolename; ?></span></td>
                            <td>
                                <a href="<?= base_url('dashboard/users/'.$row->id.'/show'); ?>" class="btn btn-sm btn-success">Show</a>
                                <a href="<?= base_url('dashboard/users/'.$row->id.'/edit'); ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="<?= base_url('dashboard/users/'.$row->id.'/delete'); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
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