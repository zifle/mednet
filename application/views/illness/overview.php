<h3 class="page-title">Find sygdom ved at søge efter navn, eller symptomer:</h3>
<?php echo form_open('search/sygdom'); ?>
	<div class="input-append big">
		<input name="query" type="text" class="span7" placeholder="Søg efter sygdom">
		<input type="submit" class="span2 btn" value="Søg">
	</div>
<?php echo form_close(); ?>

<h3 class="page-title">Mest besøgte sygdomme</h3>
<?php foreach($most_visited as $item): ?>
	<div class="most-visited span3">
		<a href="<?php echo site_url(uri_string().'/vis/'.$item->$prim_key); ?>" class="fill title"><?php echo $item->title; ?></a>
	</div>
<?php ENDFOREACH; ?>