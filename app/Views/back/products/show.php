<?= $this->extend('template/admin/layout'); ?>
<?= $this->section('content'); ?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= isset($title)?$title:'Detail'; ?></h1>

    <!-- DataTales Example -->
    <div class="row">
        <?php $percent = round((($products->price - $products->price_sale)*100) /$products->price); ?>
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="row no-gutters">
                    <?= view('Myth\Auth\Views\_message_block') ?>
                    <div class="col-lg-4">
                        <div style="position: absolute;">
                            <span class="badge badge-danger">
                                <?= $percent."% OFF"; ?>
                            </span>
                        </div>
                        <img src="<?= ($products->photo && file_exists('upload/products/'.$products->photo))?base_url('upload/products/'.$products->photo):base_url('back/img/undraw_profile.svg'); ?>" class="card-img-top card-img" alt="<?= $products->title; ?>">
                    </div>
                    <div class="col-lg-8">
                        <div class="card-body">
                            <?= ($products->status=="published")?'<span class="badge badge-success float-right">'.$products->status.'</span>':'<span class="badge badge-danger float-right">'.$products->status.'</span>'; ?>
                            <span class="badge badge-dark float-right">
                                <?= $products->type; ?>
                            </span>
                            <h5 class="card-title"><?= $products->title; ?></h5>
                            <span class="badge badge-primary">
                                <?= $products->seller; ?>
                            </span>
                            <span class="badge badge-info">
                                <?= $products->category; ?>
                            </span>
                            <p class="card-text"><?= mb_substr(strip_tags($products->description),0, 300)."..."; ?></p>
                            <p class="card-text">
                                <span class="float-left"><?=  "Rp".number_format($products->price_sale,0,",","."); ?> <s class="text-danger"><?= "Rp".number_format($products->price,0,",","."); ?></s></span>
                                <span class="float-right">Stock : <?= $products->quantity; ?></span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <?php if(in_groups(['admin'])): ?>
                    <a href="<?= base_url('dashboard/data/'.$products->type); ?>" class="card-link float-left btn btn-sm btn-danger">Back</a>
                    <?php endif; ?>
                    <a href="<?= base_url('dashboard/data/'.$products->id.'/edit/'.$products->type); ?>" class="card-link float-right btn btn-sm btn-warning">Edit</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
<?= $this->endSection(); ?>