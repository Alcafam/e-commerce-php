<div class="wrapper">
	<!-- Sidebar  -->
	<nav id="sidebar" style="padding-top:80px">
		<ul class="list-unstyled components">
			<li <?=(uri_string() == 'catalog')?'class="active"':''?>>
				<a href="<?= base_url('catalog')?>">Catalogs</a>
			</li>
		</ul>
		<ul class="list-unstyled components">
			<li <?=(uri_string() == 'profile')?'class="active"':''?>>
				<a href="<?= base_url('profile')?>"><i class="fa-solid fa-user fa-2xl pe-3"></i>Profile</a>
			</li>
			<li class="<?=(uri_string() == 'cart')?'active':''?> mt-3">
				<a href="<?= base_url('cart')?>"><i class="fa-solid fa-cart-shopping fa-2xl pe-3"></i>Cart (<?= $cart_num ?>)</a>
			</li>
		</ul>
	</nav>

	<!-- Page Content  -->
	<div id="content">
		<nav class="navbar mt-5">
			<button type="button" id="sidebarCollapse" class="rounded-end-3">
			&#9776;
			</button>
		</nav>
		<div id="main" class="py-0 text-black">

		<!-- </div>
	</div>
</div> -->