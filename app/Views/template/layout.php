<!DOCTYPE html>
<html lang="en">
<head>
	<?= $this->include('template/header'); ?>

	<?= $this->renderSection('css'); ?>
</head>
<body id="page-top">
	<?= $this->include('template/menu'); ?>
	<?php $uri = current_url(true); $uris = $uri->getSegment(1) ?>

	<!-- Masthead-->
	<header class="masthead" <?= ($uris) ? 'style="background-color:#212529 !important; background-image:url() !important; padding-top:0;padding-bottom:6rem;"' : ''; ?> >
		<?php if($uris == null): ?>
	    <div class="container">
	        <div class="masthead-subheading">Welcome To</div>
	        <div class="masthead-heading text-uppercase">CV. GUNATECH COMPUTINDO</div>
	        <a class="btn btn-primary btn-xl text-uppercase" href="#services">Tell Me More</a>
	    </div>
		<?php endif; ?>
	</header>

    <?= view('Myth\Auth\Views\_message_block') ?>
	<?= $this->renderSection('content'); ?>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="<?= base_url('logout'); ?>">Logout</a>
                </div>
            </div>
        </div>
    </div>

	<?= $this->include('template/footer'); ?>

	<?= $this->renderSection('js'); ?>
</body>
</html>