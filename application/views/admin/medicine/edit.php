<script>
	window.pricehtml = '<?php
		echo '<div class="row margin5"><div class="span2">Priser</div>';
			echo form_input('price_doses[]', '', 'class="span6" placeholder="Disponeringsform - styrke"');
			echo '<div class="row">';
				echo '<div class="span2"></div><div class="span6 nomargin">';
					echo form_input('price_price[]', '', 'class="span2" placeholder="Pris"').' ';
					echo form_input('price_quantity[]', '', 'class="span1" placeholder="Antal"').' ';
					echo form_input('price_quantity_type[]', '', 'class="span1" placeholder="Antal type"').' ';
					echo form_checkbox('price_receipt_required[]', '1', TRUE);
					echo form_hidden('price_receipt_required[]', '0').' ';
					echo 'Recept';
				echo '</div>';
				echo ' <a href="#" class="icon-minus-sign removeRow" data-parents="2"></a>';
				echo ' <a href="#" class="icon-plus-sign addRow" data-html="pricehtml" data-parents="2"></a>';
			echo '</div>';
		echo '</div>';?>';
	window.doseshtml = '<?php
		echo '<label class="row">';
			echo '<div class="span2">Dosering</div>';
			echo form_input('doses[]', '', 'class="span6"');
			echo ' <a href="#" class="icon-minus-sign removeRow" data-parents="1"></a>';
			echo ' <a href="#" class="icon-plus-sign addRow" data-html="doseshtml" data-parents="1"></a>';
		echo '</label>';
		?>';
</script>
<h3 class="page-title"><?php echo empty($medicine->medicine_id) ? 'Opret medicin' : 'Rediger medicin ('.$medicine->title.')'; ?></h3>
<?php echo form_open(); ?>
<label class="row">
	<div class="span2">Navn</div>
	<?php echo form_input('title', set_value('title', $medicine->title)); ?>
</label>
<label class="row">
	<div class="span2">Anvendelse</div>
	<?php echo form_input('usage', set_value('usage', $medicine->usage), 'class="span6"'); ?>
</label>
<?php 

if (isset($_POST['doses[]']) && is_array($_POST['doses[]'])) $doses = $_POST['doses[]'];
else $doses = $medicine->doses;
if (isset($doses[0]) && is_object($doses[0])) {
	foreach ($doses as &$dose) {
		$dose = $dose->text;
	}
	unset($dose); // This needs to be done, or the next foreach will overwrite it, along with the last entry in doses. =/
}

?>
<?php $ds = 0; foreach ($doses as $dose): $ds++; ?>
	<label class="row">
		<div class="span2">Dosering</div>
		<?php echo form_input('doses[]', $dose, 'class="span6"'); ?>
		<?php if ($ds): ?><a href="#" class="icon-minus-sign removeRow" data-parents="1"></a><?php ENDIF; ?>
		<a href="#" class="icon-plus-sign addRow" data-html="doseshtml" data-parents="1"></a>
	</label>	
<?php ENDFOREACH; ?>
<?php if (!$ds): ?>
	<label class="row">
		<div class="span2">Dosering</div>
		<?php echo form_input('doses[]', '', 'class="span6"'); ?>
		<a href="#" class="icon-plus-sign addRow" data-html="doseshtml" data-parents="1"></a>
	</label>
<?php ENDIF; ?>
<?php foreach ($symptom_types as $type): ?>
	<label class="row">
		<div class="span2"><?php echo $type->title ?></div>
		<?php echo form_multiselect('symptoms[]', $symptoms[$type->symptom_types_id], set_value('symptoms', $medicine->symptoms), 'class="span6 chzn-select" data-placeholder="Vælg relaterede symptomer"'); ?>
	</label>
<?php ENDFOREACH; ?>
	<?php 

	if (isset($_POST['price_doses']) && is_array($_POST['price_doses'])) {
		$prices = $_POST['price_doses'];
		foreach ($prices as $k => &$price) {
			$dose = $price;
			$price = (object) array();
			$price->doses = $dose;
			$price->price = $_POST['price_price'][$k];
			$price->quantity = $_POST['price_quantity'][$k];
			$price->quantity_type = $_POST['price_quantity_type'][$k];
			$price->receipt_required = isset($_POST['price_receipt_required'][$k]) ? $_POST['price_receipt_required'][$k] : FALSE;
		}
		unset($price); // This needs to be done, or the next foreach will overwrite it, along with last entry in $prices D:
	}
	else $prices = $medicine->prices;

	?>
	<?php $pc = 0; foreach ($prices as $price): $pc++; ?>
	<div class="row margin5">
		<div class="span2">Priser</div>
		<?php echo form_input('price_doses[]', $price->doses, 'class="span6" placeholder="Disponeringsform - styrke"'); ?>
		<div class="row">
			<div class="span2"></div>
			<div class="span6 nomargin">
				<?php echo form_input('price_price[]', $price->price, 'class="span2" placeholder="Pris"'); ?>
				<?php echo form_input('price_quantity[]', $price->quantity, 'class="span1" placeholder="Antal"'); ?>
				<?php echo form_input('price_quantity_type[]', $price->quantity_type, 'class="span1" placeholder="Antal type"'); ?>
				<?php echo form_checkbox('price_receipt_required[]', '1', $price->receipt_required).form_hidden('price_receipt_required[]', '0'); ?> Recept
			</div>
			<?php if ($pc > 1): ?><a href="#" class="icon-minus-sign removeRow" data-parents="2"></a><?php ENDIF; ?>
			<a href="#" class="icon-plus-sign addRow" data-html="pricehtml" data-parents="2"></a>
		</div>
	</div>
	<?php ENDFOREACH; ?>
	<?php if (!$pc): ?>
	<div class="row margin5">
		<div class="span2">Priser</div>
		<?php echo form_input('price_doses[]', '', 'class="span6" placeholder="Disponeringsform - styrke"'); ?>
		<div class="row">
			<div class="span2"></div>
			<div class="span6 nomargin">
				<?php echo form_input('price_price[]', '', 'class="span2" placeholder="Pris"'); ?>
				<?php echo form_input('price_quantity[]', '', 'class="span1" placeholder="Antal"'); ?>
				<?php echo form_input('price_quantity_type[]', '', 'class="span1" placeholder="Antal type"'); ?>
				<?php echo form_checkbox('price_receipt_required[]', '1', TRUE).form_hidden('price_receipt_required[]', '0'); ?> Recept
			</div>
			<a href="#" class="icon-plus-sign addRow" data-html="pricehtml" data-parents="2"></a>
		</div>
	</div>
	<?php ENDIF; ?>
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