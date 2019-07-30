<!--<div class="img_bebets_container">
    <img src="images/left.png" class="img_bebets_left">
    <img src="images/right.png" class="img_bebets_right">
</div>-->
<?php
	$header_banner = $db->getReklamaById(1);
?>

<div class="row">
	<div class="col-md-12">
		<div class="hidden-xs hidden-sm centered">
			<?=$header_banner->getKod()?>
		</div>
		<div class="hidden-lg hidden-md centered">
			<?=$header_banner->getKodMob()?>
		</div>
	</div>
</div>