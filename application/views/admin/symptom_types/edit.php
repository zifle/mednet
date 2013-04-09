<h3 class="page-title"><?php echo empty($symptom_type->symptom_types_id) ? 'Opret symptom type' : 'Rediger symptom type ('.$symptom_type->title.')'; ?></h3>
<?php echo form_open(); ?>
<label class="row">
	<div class="span2">Type</div>
	<?php echo form_input('title', set_value('title', $symptom_type->title)); ?>
</label>
<div class="row">
	<div class="span2"></div>
	<?php echo form_submit('submit', 'Gem', 'class="btn"'); ?>
</div>
<?php echo form_close(); ?>