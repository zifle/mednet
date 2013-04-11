<div class="articles">
	<?php if (isset($articles[0])): ?>
		<div class="row">
			<div class="span9 article article_big">
				<a href="<?php echo site_url('nyhed/vis/'.$articles[0]->articles_id); ?>" class="fill"></a>
				<div class="info">
					<h3 class="title"><?php echo $articles[0]->title; ?></h3>
					<p class="teaser"><?php echo $articles[0]->teaser ? $articles[0]->teaser : firstline_or_numwords(strip_tags($articles[0]->content), 100); ?></p>
				</div>
				<img src="<?php echo site_url('nyhed/image/'.$articles[0]->articles_id.'/700/200') ?>" alt="Nyhedsbillede">
			</div>
		</div>
	<?php ENDIF; ?>
	<div class="row">
		<?php if (isset($articles[1])): ?>
			<div class="span5 article article_medium">
				<a href="<?php echo site_url('nyhed/vis/'.$articles[1]->articles_id); ?>" class="fill"></a>
				<div class="info">
					<h4 class="title"><?php echo $articles[1]->title; ?></h4>
				</div>
				<img src="<?php echo site_url('nyhed/image/'.$articles[1]->articles_id.'/380/150') ?>" alt="Nyhedsbillede">
			</div>
		<?php ENDIF; ?>
		<?php if (isset($articles[2])): ?>
			<div class="span4 article article_medium">
				<a href="<?php echo site_url('nyhed/vis/'.$articles[2]->articles_id); ?>" class="fill"></a>
				<div class="info">
					<h4 class="title"><?php echo $articles[2]->title; ?></h4>
				</div>
				<img src="<?php echo site_url('nyhed/image/'.$articles[2]->articles_id.'/300/150') ?>" alt="Nyhedsbillede">
			</div>
		<?php ENDIF; ?>
	</div>
	<div class="row">
		<?php if (isset($articles[3])): ?>
			<div class="span3 article article_small">
				<a href="<?php echo site_url('nyhed/vis/'.$articles[3]->articles_id); ?>" class="fill"></a>
				<div class="info">
					<h5 class="title"><?php echo $articles[3]->title; ?></h5>
				</div>
				<img src="<?php echo site_url('nyhed/image/'.$articles[3]->articles_id.'/220/125') ?>" alt="Nyhedsbillede">
			</div>
		<?php ENDIF; ?>
		<?php if (isset($articles[4])): ?>
			<div class="span3 article article_small">
				<a href="<?php echo site_url('nyhed/vis/'.$articles[4]->articles_id); ?>" class="fill"></a>
				<div class="info">
					<h5 class="title"><?php echo $articles[4]->title; ?></h5>
				</div>
				<img src="<?php echo site_url('nyhed/image/'.$articles[4]->articles_id.'/220/125') ?>" alt="Nyhedsbillede">
			</div>
		<?php ENDIF; ?>
		<?php if (isset($articles[5])): ?>
			<div class="span3 article article_small">
				<a href="<?php echo site_url('nyhed/vis/'.$articles[5]->articles_id); ?>" class="fill"></a>
				<div class="info">
					<h5 class="title"><?php echo $articles[5]->title; ?></h5>
				</div>
				<img src="<?php echo site_url('nyhed/image/'.$articles[5]->articles_id.'/220/125') ?>" alt="Nyhedsbillede">
			</div>
		<?php ENDIF; ?>
	</div>
</div>