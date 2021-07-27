<?= $this->extend('template/layout'); ?>
<?= $this->section('content'); ?>
<!-- About-->
<section class="page-section" id="products">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 row">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <a href="<?= base_url('/'); ?>" class="btn btn-sm btn-danger float-right">Back</a>
                        <h6 class="m-0 font-weight-bold text-primary"><?= isset($title)?$title:'Checkout'; ?></h6>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-success"><?= $messages; ?></div>
                    </div>
                    <div class="card-footer">
                        <a href="<?= base_url('/'); ?>" class="btn btn-sm btn-danger float-right">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>