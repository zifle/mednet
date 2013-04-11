<h3 class="page-title">
	<?php echo $pharmacy->title; ?> (<?php echo $pharmacy->zipcode; ?>)
</h3>
<?php if($pharmacy->latitude && $pharmacy->longitude): ?>
	<div class="maps">
		<iframe width="700" height="500" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.dk/?ie=UTF8&amp;ll=<?php echo $pharmacy->longitude; ?>,<?php echo $pharmacy->latitude; ?>&amp;spn=0.001122,0.002301&amp;t=h&amp;z=19&amp;iwloc=lyrftr:h,12571680706524639713,<?php echo $pharmacy->longitude; ?>,<?php echo $pharmacy->latitude; ?>&amp;output=embed"></iframe><br /><small><a href="https://maps.google.dk/?ie=UTF8&amp;ll=<?php echo $pharmacy->longitude; ?>,<?php echo $pharmacy->latitude; ?>&amp;spn=0.001122,0.002301&amp;t=h&amp;z=19&amp;iwloc=lyrftr:h,12571680706524639713,<?php echo $pharmacy->longitude; ?>,<?php echo $pharmacy->latitude; ?>&amp;source=embed" style="color:#0000FF;text-align:left" target="_blank">Vis større kort</a></small>
	</div>
<?php else: ?>
	<i>Der er ikke angivet lokation for dette apotek</i>
<?php ENDIF; ?>