<?= $this->extend('template/layout'); ?>
<?= $this->section('content'); ?>
<!-- Services-->
<section class="page-section" id="services">
    <div class="container">
        <div class="text-left">
            <a href="<?= base_url('data/product'); ?>" class="btn btn-sm btn-info float-right">Selengkapnya</a>
            <h5 class="section-heading text-uppercase">Products</h5>
            <hr>
        </div>
        <div class="row">
            <?php if(@count($products)>0): foreach($products as $row): 
                $percent = round((($row->price - $row->price_sale)*100) /$row->price); 
            ?>
            <div class="col-md-3">
                <div class="card shadow mb-4">
                    <div class="no-gutters">
                        <div class="col-lg-12">
                            <div style="position: absolute;">
                                <span class="badge badge-danger">
                                    <?= $percent."% OFF"; ?>
                                </span>
                            </div>
                            <div class="float-center">
                                <a href="<?= base_url('data/'.$row->type.'/'.$row->categoryslug.'/'.$row->slug); ?>" class="nounderline float-center">
                                    <img src="<?= ($row->photo && file_exists('upload/products/'.$row->photo))?base_url('upload/products/'.$row->photo):base_url('back/img/undraw_profile.svg'); ?>" class="card-img-top card-img mx-auto photo float-center" alt="<?= $row->title; ?>">
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="card-body">
                                <a href="<?= base_url('data/'.$row->type.'/'.$row->categoryslug.'/'.$row->slug); ?>" class="nounderline">
                                    <h6 class="card-title text-left text-dark"><?= $row->title; ?></h6>
                                </a>
                                <span class="badge badge-dark">
                                    <?= $row->seller; ?>
                                </span>
                                <a href="<?= base_url('data/'.$row->type.'/'.$row->categoryslug); ?>" class="badge badge-primary nounderline">
                                    <?= $row->category; ?>
                                </a><br>
                                <s class="text-danger" style="font-size: 12px;"><?= "Rp".number_format($row->price,0,",","."); ?></s>
                                <p class="card-text">
                                    <span class="float-left"><?= "Rp".number_format($row->price_sale,0,",","."); ?></span>
                                    <span class="badge badge-<?= ($row->quantity<=10)?'danger':'success'; ?> float-right">Stock : <?= ($row->quantity<=10)?'Terbatas':'Available'; ?></span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="<?= base_url('data/'.$row->type.'/'.$row->categoryslug.'/'.$row->slug); ?>" class="card-link float-left btn btn-sm btn-info">Detail</a>

                        <form action="<?= base_url('cart/store') ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id" value="<?= $row->id; ?>" required />
                            <input type="hidden" name="qty" value="1" required />
                            <button type="submit" class="card-link float-right btn btn-sm btn-success">Add to Cart</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach; endif;?>
        </div>
    </div>

    <div class="container">
        <div class="text-left">
            <a href="<?= base_url('data/service'); ?>" class="btn btn-sm btn-info float-right">Selengkapnya</a>
            <h5 class="section-heading text-uppercase">Services</h5>
            <hr>
        </div>
        <div class="row">
            <?php if(@count($services)>0): foreach($services as $row): 
                $percent = round((($row->price - $row->price_sale)*100) /$row->price); 
            ?>
            <div class="col-md-3">
                <div class="card shadow mb-4">
                    <div class="no-gutters">
                        <div class="col-lg-12">
                            <div style="position: absolute;">
                                <span class="badge badge-danger">
                                    <?= $percent."% OFF"; ?>
                                </span>
                            </div>
                            <a href="<?= base_url('data/'.$row->type.'/'.$row->categoryslug.'/'.$row->slug); ?>" class="nounderline">
                                <img src="<?= ($row->photo && file_exists('upload/products/'.$row->photo))?base_url('upload/products/'.$row->photo):base_url('back/img/undraw_profile.svg'); ?>" class="card-img-top card-img mx-auto photo" alt="<?= $row->title; ?>">
                            </a>
                        </div>
                        <div class="col-lg-12">
                            <div class="card-body">
                                <a href="<?= base_url('data/'.$row->type.'/'.$row->categoryslug.'/'.$row->slug); ?>" class="nounderline">
                                    <h6 class="card-title text-left text-dark"><?= $row->title; ?></h6>
                                </a>
                                <span class="badge badge-dark">
                                    <?= $row->seller; ?>
                                </span>
                                <a href="<?= base_url('data/'.$row->type.'/'.$row->categoryslug); ?>" class="badge badge-primary nounderline">
                                    <?= $row->category; ?>
                                </a><br>
                                <s class="text-danger" style="font-size: 12px;"><?= "Rp".number_format($row->price,0,",","."); ?></s>
                                <p class="card-text">
                                    <span class="float-left"><?= "Rp".number_format($row->price_sale,0,",","."); ?></span>
                                    <span class="badge badge-<?= ($row->quantity<=10)?'danger':'success'; ?> float-right">Stock : <?= ($row->quantity<=10)?'Terbatas':'Available'; ?></span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="<?= base_url('data/'.$row->type.'/'.$row->categoryslug.'/'.$row->slug); ?>" class="card-link float-right btn btn-sm btn-info">Detail</a>
                    </div>
                </div>
            </div>
            <?php endforeach; endif;?>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>