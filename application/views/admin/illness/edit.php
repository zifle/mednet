<h3 class="page-title"><?php echo empty($illness->illnesses_id) ? 'Opret sygdom' : 'Rediger sygdom ('.$illness->latin_name.' - '.$illness->title.')'; ?></h3>
<?php echo form_open(); ?>
<label class="row">
	<div class="span2">Latinske navn</div>
	<?php echo form_input('latin_name', set_value('latin_name', $illness->latin_name)); ?>
</label>
<label class="row">
	<div class="span2">Navn</div>
	<?php echo form_input('title', set_value('title', $illness->title)); ?>
</label>
<label class="row">
	<div class="span2">Beskrivelse</div>
	<?php echo form_input('description', set_value('description', $illness->description), 'class="span7"'); ?>
</label>
<label class="row">
	<div class="span2">Symptomer</div>
	<?php echo form_multiselect('symptoms[]', $symptoms, set_value('symptoms', $illness->symptoms), 'class="chzn-select" data-placeholder="Vælg relaterede symptomer"'); ?>
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