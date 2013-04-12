<h3 class="page-title">
	<?php echo $pharmacy->title; ?> (<?php echo $pharmacy->zipcode; ?>)
</h3>
<?php if($pharmacy->address): ?>
	<div class="maps">
		<iframe width="700" height="500" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.dk/?ie=UTF8&amp;q=<?php echo urlencode($pharmacy->address.', '.$pharmacy->zipcode); ?>&amp;t=h&amp;z=19&amp;output=embed"></iframe>
	</div>
<?php else: ?>
	<i>Der er ikke angivet lokation for dette apotek</i>
<?php ENDIF; ?>