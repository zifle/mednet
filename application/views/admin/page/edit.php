<h3 class="page-title"><?php echo empty($page->pages_id) ? 'Opret side' : 'Rediger side ('.$page->title.')'; ?></h3>
<?php echo form_open(); ?>
<label class="row">
	<div class="span2">Titel</div>
	<?php echo form_input('title', set_value('title', $page->title)); ?>
</label>
<label class="row">
	<div class="span2">Skabelon</div>
	<?php echo form_input('template', set_value('template', $page->template), 'class="span3"'); ?>
</label>
<label class="row">
	<div class="span2">Vises i footer</div>
	<?php echo form_dropdown('footer', array(0 => 'Nej', 1 => 'Ja'), set_value('footer', $page->footer), 'data-placeholder="Skal siden vises i footeren" class="chzn-select"'); ?>
</label>
<label class="row">
	<div class="span2">Indhold</div>
	<?php echo form_textarea('content', set_value('content', $page->content), 'class="content span6"'); ?>
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