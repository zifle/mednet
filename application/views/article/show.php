<img src="<?php echo site_url('nyhed/image/'.$article->articles_id.'/700/200') ?>" alt="Nyhedsbillede" class="banner">
<h3 class="page-title"><?php echo $article->title; ?></h3>
<date class="published"><?php echo date('j. M - Y', strtotime($article->publish)); ?></date>
<section class="content">
	<?php echo $article->content; ?>
</section>
