<h3 class="page-title"><?php echo empty($pharmacy->pharmacies_id) ? 'Opret apotek' : 'Rediger apotek ('.$pharmacy->title.' - '.$pharmacy->zipcode.')'; ?></h3>
<?php echo form_open(); ?>
<label class="row">
	<div class="span2">Navn</div>
	<?php echo form_input('title', set_value('title', $pharmacy->title)); ?>
</label>
<label class="row">
	<div class="span2">Postnr</div>
	<?php echo form_input('zipcode', set_value('zipcode', $pharmacy->zipcode)); ?>
</label>
<label class="row">
	<div class="span2">Adresse</div>
	<?php echo form_input('address', set_value('address', $pharmacy->address)); ?>
</label>
<div class="row">
	<div class="span2"></div>
	<?php echo form_submit('submit', 'Gem', 'class="btn"'); ?>
</div>
<?php echo form_close(); ?>