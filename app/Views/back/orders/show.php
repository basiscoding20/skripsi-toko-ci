<?= $this->extend('template/admin/layout'); ?>
<?= $this->section('content'); ?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= isset($title)?$title:'Orders'; ?></h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <?php if($orders->photo && file_exists('upload/orders/'.$orders->photo)): ?>
            <a href="<?= base_url('upload/orders/'.$orders->photo); ?>" target="_blank" class="btn btn-sm btn-primary float-right">Bukti Pembayaran</a>
            <?php endif; ?>
            <?php if(!in_groups(['admin'])): if(changeorder($orders->status)): ?>
            <a href="<?= base_url('dashboard/order/'.$id.'/edit/'.$list); ?>" class="btn btn-sm btn-warning float-right">Edit</a>
            <?php endif; endif; ?>
            <span class="btn btn-sm btn-success float-right" onclick="printDiv('#print-area');">Print</span>
            <a href="<?= base_url('dashboard/order/'.$list); ?>" class="btn btn-sm btn-danger float-right">Back</a>
            <h6 class="m-0 font-weight-bold text-primary"><?= isset($title)?$title:'Orders'; ?></h6>
        </div>
        <div class="card-body">
            <div class="table-responsive" id="print-area">
                <table class="table table-stripped table-hopper" width="100%" cellspacing="0">
                    <tbody>
                        <tr>
                            <th colspan="2" width="70%">Invoice</th>
                            <th width="30%"><?= $orders->code; ?></th>
                        </tr>
                        <tr>
                            <td width="30%">
                                <strong>Billed To:</strong><br>
                                <p>
                                    <?= $orders->customer; ?><br>
                                    <?= $orders->customer_address; ?><br>
                                    <?= $orders->customer_phone; ?>
                                </p>
                            </td>
                            <td width="40%">
                                <strong>Shipped To:</strong><br>
                                <p>
                                    <?= $orders->customer; ?><br>
                                    <?= $orders->customer_address; ?><br>
                                    <?= $orders->customer_phone; ?>
                                </p>
                            </td>
                            <td width="30%">
                                <strong>Seller:</strong><br>
                                <?php foreach($seller as $row): ?>
                                <p>
                                    <?= $row->name; ?><br>
                                    <?= $row->address; ?><br>
                                    <?= $row->phone; ?>
                                </p>
                            <?php endforeach; ?>
                            </td>
                        </tr>
                        <tr>
                            <th colspan="2" width="70%">
                                Status : <span class="badge badge-info"><?= $orders->status; ?></span>
                            </th>
                            <th width="30%">Date : <?= date('d F Y', strtotime($orders->created_at)); ?></th>
                        </tr>
                    </tbody>
                </table>
                <table class="table table-stripped table-hopper" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Photo</th>
                            <th width="200">Name</th>
                            <th>Type</th>
                            <th>Price</th>
                            <th width="200">Order</th>
                            <th>Sub Total</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1;
                        if(@count($orderDetails)>0): foreach($orderDetails as $row): ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><img src="<?= ($row->photo && file_exists('upload/products/'.$row->photo))?base_url('upload/products/'.$row->photo):base_url('back/img/no-image.png'); ?>" width="50px"></td>
                            <td><?= $row->title; ?></td>
                            <td><?= $row->type; ?></td>
                            <td><?=  "Rp".number_format($row->price,0,",","."); ?></td>
                            <td>
                                <?php if($row->type == 'product'): ?>
                                <?= $row->quantity; ?>
                                <?php elseif($row->type == 'service'): ?>
                                <?= $row->quantity; ?>
                                <?php //$row->datetime?date('d F Y H:i', strtotime($row->datetime)):date('d F Y H:i'); ?>
                                <?php endif; ?>
                            </td>
                            <td><?= "Rp".number_format(($row->quantity*$row->price),0,",","."); ?></td>
                        </tr>
                    <?php endforeach; endif; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="6">Total</th>
                            <th><?= "Rp".number_format($orders->total,0,",","."); ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
<?= $this->endSection(); ?>
<?= $this->section('js'); ?>
<script type="text/javascript">
    function printDiv(elem)
    {
       renderMe($('<div/>').append($(elem).clone()).html());
    }

    function renderMe(data) {
        var mywindow = window.open('', 'print-area', 'height=1000,width=1000');
        mywindow.document.write('<html><head><title>invoice-box</title>');
        mywindow.document.write('<link href="<?= base_url(); ?>/back/css/sb-admin-2.min.css" rel="stylesheet" type="text/css" />');
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');


        setTimeout(function () {
        mywindow.print();
        mywindow.close();
        }, 1000)
        return true;
    }
</script>
<?= $this->endSection(); ?>