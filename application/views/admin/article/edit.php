<h3 class="page-title"><?php echo empty($article->articles_id) ? 'Opret nyhed' : 'Rediger nyhed ('.$article->title.')'; ?></h3>
<?php echo form_open_multipart(); ?>
<label class="row">
	<div class="span2">Titel</div>
	<?php echo form_input('title', set_value('title', $article->title)); ?>
</label>
<label class="row">
	<div class="span2">Udgivelses dato</div>
	<?php echo form_input('publish', set_value('publish', date('Y-m-d', strtotime($article->publish))), 'class="datepicker"'); ?>
</label>
<label class="row">
	<div class="span2">Teaser</div>
	<?php echo form_input('teaser', set_value('teaser', $article->teaser), 'class="span6"'); ?>
</label>
<label class="row">
	<div class="span2">Billede</div>
	<?php echo form_upload('image', set_value('image', $article->image), 'accept="image/jpeg,image/png"'); ?>
</label>
<label class="row">
	<div class="span2">Relaterede symptomer</div>
	<?php echo form_dropdown('symptom', $symptoms, set_value('symptom', $article->symptom), 'class="chzn-select"'); ?>
</label>
<label class="row">
	<div class="span2">Relateret medicin</div>
	<?php echo form_dropdown('medicine', $medicines, set_value('medicine', $article->medicine), 'class="chzn-select"'); ?>
</label>
<label class="row">
	<div class="span2">Relaterede apoteker</div>
	<?php echo form_dropdown('pharmacy', $pharmacies, set_value('pharmacy', $article->pharmacy), 'class="chzn-select"'); ?>
</label>
<label class="row">
	<div class="span2">Relaterede sygdomme</div>
	<?php echo form_dropdown('illness', $illnesses, set_value('illness', $article->illness), 'class="chzn-select"'); ?>
</label>
<label class="row">
	<div class="span2">Nyhed</div>
	<?php echo form_textarea('content', set_value('content', $article->content), 'class="span6"'); ?>
</label>
<div class="row">
	<div class="span2"></div>
	<?php echo form_submit('submit', 'Gem', 'class="btn"'); ?>
</div>
<?php echo form_close(); ?>
<script>
	$(function(){
		$('.chzn-select').chosen();
		$('.datepicker').datepicker({ format : 'yyyy-mm-dd'});
	});
</script>