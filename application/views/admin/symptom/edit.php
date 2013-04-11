<h3 class="page-title"><?php echo empty($symptom->symptoms_id) ? 'Opret symptom' : 'Rediger symptom ('.$symptom->title.')'; ?></h3>
<?php echo form_open(); ?>
<label class="row">
	<div class="span2">Titel</div>
	<?php echo form_input('title', set_value('title', $symptom->title)); ?>
</label>
<label class="row">
	<div class="span2">Beskrivelse</div>
	<?php echo form_input('description', set_value('description', $symptom->description), 'class="span3"'); ?>
</label>
<label class="row">
	<div class="span2">Type</div>
	<?php echo form_dropdown('type', $symptom_types, set_value('type', $symptom->type_id), 'data-placeholder="Vælg symptom type" class="chzn-select"'); ?>
</label>
<div class="row">
	<div class="span2"></div>
	<?php echo form_submit('submit', 'Gem', 'class="btn"'); ?>
</div>
<?php echo form_close(); ?>
<script>
	$(function(){
		$('.chzn-select').chosen();
	});
</script>