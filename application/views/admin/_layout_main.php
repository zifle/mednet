<?php $this->load->view('admin/components/page_head'); ?>
<body>
	<div class="navbar navbar-static-top navbar-inverse">
		<div class="navbar-inner">
			<a href="<?php echo site_url('admin/dashboard'); ?>" class="brand"><?php echo $meta_title; ?></a>
			<ul class="nav">
				<li class="active"><a href="<?php echo site_url('admin/dashboard'); ?>">Dashboard</a></li>
				<li class="active"><?php echo anchor('admin/page', 'Pages'); ?></li>
				<li class="active"><?php echo anchor('admin/page/order', 'Order pages'); ?></li>
				<li class="active"><?php echo anchor('admin/article', 'News articles'); ?></li>
				<li class="active"><?php echo anchor('admin/user', 'Users'); ?></li>
			</ul>
		</div>
	</div>
	
	<div class="container">
		<div class="row">
			<!-- Main column -->
			<div class="span9">
				<?php $this->load->view($subview); ?>
			</div>
			<!-- Sidebar -->
			<div class="span3">
				<section>
					<?php echo mailto('zifle@hotmail.com', '<i class="icon-user"></i> zifle@hotmail.com'); ?><br>
					<?php echo anchor('admin/user/logout', '<i class="icon-off"></i> Log out'); ?><br>
				</section>
			</div>
		</div>
	</div>
<?php $this->load->view('admin/components/page_tail'); ?>