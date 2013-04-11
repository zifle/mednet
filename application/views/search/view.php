<?php 
$medicine_count = count(@$search_results['medicine']);
$illness_count = count(@$search_results['illness']);
$pharmacy_count = count(@$search_results['pharmacy']);

$result_count = 0;
$result_count += $medicine_count;
$result_count += $illness_count;
$result_count += $pharmacy_count;
?>
<h3 class="page-title">Søgeresultater</h3>
<i>Din søgning efter "<?php echo $search_query; ?>" gav <?php echo $result_count; ?> resultater</i>
<?php if ($result_count > 0): ?>
	<p>Hop til:
		<?php echo $medicine_count ? anchor(current_url().'#medicin', 'Medicin ('.$medicine_count.')') :''; ?>
		<?php echo $illness_count ? anchor(current_url().'#sygdom', 'Sygdomme ('.$illness_count.')') :''; ?>
		<?php echo $pharmacy_count ? anchor(current_url().'#apotek', 'Apoteker ('.$pharmacy_count.')') :''; ?>
	</p>
<?php ENDIF; ?>
<?php if ($medicine_count): ?>
	<div class="results">
		<a name="medicin"></a><h4>Medicin (<?php echo $medicine_count; ?>)</h4>
		<?php foreach ($search_results['medicine'] as $medicine): ?>
			- <a href="<?php echo site_url('medicin/vis/'.$medicine->medicine_id); ?>"><?php echo $medicine->title; ?></a><br>
		<?php ENDFOREACH; ?>
	</div>
<?php ENDIF; ?>
<?php if ($illness_count): ?>
	<div class="results">
		<a name="sygdom"></a><h4>Sygdomme (<?php echo $illness_count; ?>)</h4>
		<?php foreach ($search_results['illness'] as $illness): ?>
			- <a href="<?php echo site_url('sygdom/vis/'.$illness->illnesses_id); ?>"><?php echo $illness->title; ?> (<?php echo $illness->latin_name; ?>)</a><br>
		<?php ENDFOREACH; ?>
	</div>
<?php ENDIF; ?>
<?php if ($pharmacy_count): ?>
	<div class="results">
		<a name="apotek"></a><h4>Apoteker (<?php echo $pharmacy_count; ?>)</h4>
		<?php foreach ($search_results['pharmacy'] as $pharmacy): ?>
			- <a href="<?php echo site_url('apotek/vis/'.$pharmacy->pharmacies_id); ?>"><?php echo $pharmacy->title; ?></a><br>
		<?php ENDFOREACH; ?>
	</div>
<?php ENDIF; ?>