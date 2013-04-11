<h3 class="page-title">Find din medicin med oversigten, eller brug søgningen:</h3>
<?php echo form_open('search/medicin'); ?>
	<div class="input-append big">
		<input name="query" type="text" class="span7" placeholder="Søg efter medicin">
		<input type="submit" class="span2 btn" value="Søg">
	</div>
<?php echo form_close(); ?>

<h3 class="page-title">Mest besøgt medicin</h3>
<?php foreach($most_visited as $item): ?>
	<div class="most-visited span3">
		<a href="<?php echo site_url(uri_string().'/vis/'.$item->$prim_key); ?>" class="fill title"><?php echo $item->title; ?></a>
	</div>
<?php ENDFOREACH; ?>