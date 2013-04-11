<h3 class="page-title">
	<?php echo $illness->title; echo $illness->latin_name ? ' ('.$illness->latin_name.')':''; ?>
	<?php if($this->user_m->loggedin() && !$this->illness_m->is_users_illness($illness->illnesses_id, $this->user_m->user->users_id)): ?>
		<?php echo form_open('sygdom/add/'.$illness->illnesses_id); ?>
			<input type="submit" value="Tilføj til mine sygdomme" class="btn">
		<?php echo form_close(); ?>
	<?php elseif ($this->user_m->loggedin()): ?>
		<?php echo form_open('sygdom/remove/'.$illness->illnesses_id); ?>
			<input type="submit" value="Fjern fra mine sygdomme" class="btn">
		<?php echo form_close(); ?>
	<?php ENDIF; ?>
</h3>
<div class="row">
	<div class="span7">
		<h4 class="title">Beskrivelse</h4>
		<p><?php echo $illness->description; ?></p>
	</div>
</div>
<?php foreach ($illness->symptom_types as $title => $entries): ?>
	<?php if (empty($entries)) continue; ?>
	<div class="row">
		<div class="span7">
			<h4 class="title"><?php echo $title == 'bivirkninger' ? 'Symptomer' : $title; ?></h4>
			<?php foreach ($entries as $entry): ?>
				<div class="row">
					<p class="span2"><?php echo $entry->title; ?></p>
					<?php if (!empty($entry->description)): ?>
						<p class="span4"><?php echo $entry->description; ?></p>
					<?php ENDIF; ?>
				</div>
			<?php ENDFOREACH; ?>
		</div>
	</div>
<?php ENDFOREACH; ?>