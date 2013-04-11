<?php $this->load->view('admin/components/page_head'); ?>
<body>
	<div class="container top">
		<div class="banner">
			<div class="logo">
				<a href="<?php echo site_url($is_admin ? 'admin/dashboard' : ''); ?>">
					<img src="<?php echo site_url('img/logo_banner.png'); ?>" alt="MEDNET logo">
				</a><?php if ($is_admin): ?><span class="metatitle">Content Management System</span><?php endif; ?>
			</div>
			<div class="utility-menu">
				<?php if (!$is_admin): ?>
					<?php if ($this->user_m->loggedin()): ?>
						<?php echo
									$this->user_m->user->name
								?
									$this->user_m->user->name . ' (' . $this->user_m->user->email . ')'
								:
									$this->user_m->user->email;
						?> - <a href="<?php echo site_url('user/logout'); ?>">Log ud</a>
					<?php else: ?>
						<a href="<?php echo site_url('user/login'); ?>">Log ind</a> - <a href="<?php echo site_url('user/register'); ?>">Registrer</a>
					<?php endif; ?>
				<?php elseif ($this->admin_user_m->loggedin()): ?>
					<a href="<?php echo site_url('admin/user/logout'); ?>">Log ud</a>
				<?php endif; ?>
			</div>
		</div>
		<div class="navbar">
			<div class="navbar-inner">
				<?php echo get_menu($menu); ?>
				<?php if (!$is_admin): ?>
				<?php echo form_open('search'); ?>
					<div class="input-append pull-right">
						<input name="query" type="text" class="span2" placeholder="Indtast søgning">
						<button class="btn" type="submit">Søg</button>
					</div>
				<?php echo form_close(); ?>
				<?php ENDIF; ?>
			</div>
		</div>
	</div>
	
	<div class="container">
		<div class="row">
			<?php if ($sidebar_side == 'left'): ?>
				<!-- Sidebar -->
				<div class="span3<?php if ($draw_sidebar) echo ' sidebar'; ?>">
					<?php echo get_sidebar($sidebar); ?>
				</div>
			<?php ENDIF; ?>
			<!-- Main column -->
			<div class="span9">
				<?php echo $this->statuses->show_statuses('bootstrap'); ?>
				<?php echo validation_errors('<div class="alert alert-error">', '</div>'); ?>
				<?php $this->load->view($subview); ?>
			</div>
			<?php if ($sidebar_side == 'right'): ?>
				<!-- Sidebar -->
				<div class="span3<?php if ($draw_sidebar) echo ' sidebar'; ?>">
					<?php echo get_sidebar($sidebar); ?>
				</div>
			<?php ENDIF; ?>
		</div>
	</div>

	<?php if (!$is_admin): ?>
	<div class="container footer">
		<div class="row">
			<?php foreach ($footer_articles as $info): ?>
			<div class="span3">
				<span class="title"><?php echo $info->title; ?></span>
				<?php foreach ($info->data as $article): ?>
					<a href="<?php echo site_url('nyhed/'.$article->articles_id); ?>"><?php echo $article->title; ?></a><br>
				<?php ENDFOREACH; ?>
				<?php if (!count($info->data)): ?>
					<i>Ingen nyheder fundet</i>
				<?php ENDIF; ?>
			</div>
			<?php ENDFOREACH; ?>
			<div class="span3">
				<?php foreach ($pages as $page): ?>
				<a href="<?php echo site_url('side/'.$page->pages_id); ?>" class="pagelink"><?php echo $page->title; ?></a><br>
				<?php ENDFOREACH; ?>
			</div>
		</div>
	</div>
	<?php ENDIF; ?>
<?php $this->load->view('admin/components/page_tail'); ?>