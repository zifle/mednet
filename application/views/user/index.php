<h3 class="page-title">Min side</h3>
<h4>Min medicin</h4>
<?php foreach ($user_medicine as $medicine): ?>
	- <a href="<?php echo site_url('medicin/vis/'.$medicine->medicine_id); ?>"><?php echo $medicine->title; ?></a><br>
<?php ENDFOREACH; ?>
<?php if (!count($user_medicine)): ?>
	<i>Du har ikke tilføjet medicin endnu.</i>
<?php ENDIF; ?>
<h4>Mine sygdomme</h4>
<?php foreach ($user_illness as $illness): ?>
	- <a href="<?php echo site_url('sygdom/vis/'.$illness->illnesses_id); ?>"><?php echo $illness->title; ?> (<?php echo $illness->latin_name; ?>)</a><br>
<?php ENDFOREACH; ?>
<?php if (!count($user_illness)): ?>
	<i>Du har ikke tilføjet sygdom(me) endnu.</i>
<?php ENDIF; ?>