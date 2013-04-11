<h3 class="page-title">
	<?php echo $medicine->title; ?>
	<?php if($this->user_m->loggedin() && !$this->medicine_m->is_users_medicine($medicine->medicine_id, $this->user_m->user->users_id)): ?>
	<?php echo form_open('medicin/add/'.$medicine->medicine_id); ?>
	 <input type="submit" value="Tilføj til min medicin" class="btn">
	<?php echo form_close(); ?>
	<?php elseif ($this->user_m->loggedin()): ?>
	<?php echo form_open('medicin/remove/'.$medicine->medicine_id); ?>
	 <input type="submit" value="Fjern fra min medicin" class="btn">
	<?php echo form_close(); ?>
	<?php ENDIF; ?>
</h3>
<div class="row">
	<div class="span7">
		<h4 class="title">Anvendelse</h4>
		<p><?php echo $medicine->usage; ?></p>
	</div>
</div>
<div class="row">
	<div class="span7">
		<h4 class="title">Dosering</h4>
		<?php foreach ($medicine->doses as $dose): ?>
			<p><?php echo $dose->text; ?></p>
		<?php ENDFOREACH; ?>
	</div>
</div>
<?php foreach ($medicine->symptom_types as $title => $entries): ?>
	<?php if (!empty($entries)): ?>
		<div class="row">
			<div class="span7">
				<h4 class="title"><?php echo $title; ?></h4>
				<?php foreach ($entries as $entry): ?>
					<div class="row">
						<p class="span<?php echo empty($entry->description) ? '6' : '2'; ?>"><?php echo $entry->title; ?></p>
						<?php if (!empty($entry->description)): ?>
							<p class="span4"><?php echo $entry->description; ?></p>
						<?php ENDIF; ?>
					</div>
				<?php ENDFOREACH; ?>
			</div>
		</div>
	<?php ENDIF; ?>
<?php ENDFOREACH; ?>
<div class="row">
	<div class="span7">
		<h4 class="title">Priser</h4>
		<table class="table table-striped">
			<thead>
				<th>Udlevering</th>
				<th>Dispenseringsform / styrke</th>
				<th>Pakning</th>
				<th>Pris</th>
			</thead>
			<tbody>
				<?php foreach ($medicine->prices as $price): ?>
					<tr>
						<td><?php echo $price->receipt_required?'Recept':'Håndkøb'; ?></td>
						<td><?php echo $price->doses; ?></td>
						<td><?php echo $price->quantity; ?> <?php echo $price->quantity_type; ?></td>
						<td><?php echo number_format($price->price, 2, ',', '.'); ?></td>
					</tr>
				<?php ENDFOREACH; ?>
			</tbody>
		</table>
	</div>
</div>