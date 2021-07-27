<?php $uri = current_url(true); $uris = $uri->getSegment(1) ?>
<nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="<?= base_url('/'); ?>">
        	<!-- <img src="/front/assets/img/navbar-logo.svg" alt="..." /> -->
        	CV. GUNATECH COMPUTINDO
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fas fa-bars ms-1"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">
	      		<li class="nav-item <?= ($uris == null) ? 'active' : null; ?>">
	        		<a class="nav-link small" href="<?= base_url('/'); ?>">Home <span class="sr-only">(current)</span></a>
	      		</li>
	      		<li class="nav-item <?= url_is('data/product*') ? 'active' : null; ?>">
	        		<a class="nav-link small" href="<?= base_url('data/product'); ?>">Product</a>
	      		</li>
	      		<li class="nav-item <?= url_is('data/service*') ? 'active' : null; ?>">
	        		<a class="nav-link small" href="<?= base_url('data/service'); ?>">Service</a>
	      		</li>
	      		<li class="nav-item <?= url_is('about*') ? 'active' : null; ?>">
	        		<a class="nav-link small" href="<?= base_url('about'); ?>">About</a>
	      		</li>
	      		<li class="nav-item <?= url_is('contact*') ? 'active' : null; ?>">
	        		<a class="nav-link small" href="<?= base_url('contact'); ?>">Contact</a>
	      		</li>
	      		<?php if(!url_is('login*')): if(!empty(user())): ?>
		        <li class="nav-item dropdown no-arrow <?= url_is('dashboard*') ? 'active' : null; ?>">
		            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
		                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		                <span class="mr-2 d-lg-inline small"><?= user()->name; ?></span>
		                <img class="img-profile rounded-circle"
		                    src="<?= (user()->photo && file_exists('upload/users/'.user()->photo))?base_url('upload/users/'.user()->photo):base_url('back/img/undraw_profile.svg'); ?>" width="20">
		            </a>
		            <!-- Dropdown - User Information -->
		            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
		                aria-labelledby="userDropdown">
		                <a class="dropdown-item" href="<?= base_url('dashboard'); ?>">
		                    <i class="fas fa-tachometer-alt fa-sm fa-fw mr-2 text-gray-400"></i>
		                    Dashboard
		                </a>
		                <a class="dropdown-item" href="<?= base_url('dashboard/profile'); ?>">
		                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
		                    Profile
		                </a>
		                <a class="dropdown-item" href="<?= base_url('cart'); ?>">
		                    <i class="fas fa-shopping-cart fa-sm fa-fw mr-2 text-gray-400"></i>
		                    <span class="badge badge-danger navbar-badge float-right"><?= $carts->totalItems(); ?></span>
		                    Cart
		                </a>
		                <div class="dropdown-divider"></div>
		                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
		                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
		                    Logout
		                </a>
		            </div>
		        </li>
	            <?php else: ?>
                <li class="nav-item <?= url_is('login*') ? 'active' : null; ?>">
                    <a class="nav-link" href="<?= base_url('login'); ?>">Login</a>
                </li>
	            <?php endif; endif; ?>
            </ul>
        </div>
    </div>
</nav>