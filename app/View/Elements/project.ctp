<?php 
	$tagClasses = array(
		'webapp' => 'web',
		'website' => 'web',
		'android' => 'android',
		'responsive' => 'mobile',
		'mobileweb' => 'mobile'
	);
	$tagStrings = array(
		'webapp' => 'Appli web',
		'website' => 'Site web',
		'android' => 'Appli Android',
		'responsive' => 'Adapté pour mobile',
		'mobileweb' => 'Orienté mobile'
	);
?>
<div class="project <?php echo $project['Project']['class'] ?>">
	<h3 class="project-title"><?php echo $project['Project']['title']; ?></h3>

	<div class="project-tags">
		<?php $tags = explode(', ', $project['Project']['tags']); 
		foreach ($tags as $tag): if (!empty($tagStrings[$tag]) && !empty($tagClasses[$tag])): ?>
			<span class="project-tag <?php echo $tagClasses[$tag] ?>"><?php echo $tagStrings[$tag] ?></span>
		<?php endif; endforeach; ?>
	</div>

	<div class="project-content">
		<div class="project-imgs">
			<?php $imgs = json_decode($project['Project']['images'], true);
			if ($imgs) { 
				foreach ($imgs as $img) { ?>
				<a class="cb" href="<?php echo $img ?>" data-rel="<?php echo $project['Project']['class'] ?>"><img src="<?php echo $img ?>" alt="Aperçu du projet <?php echo $project['Project']['title'] ?>"></a>
			<?php }
			} ?>
		</div>
		<?php echo $project['Project']['content'] ?>
	</div>

	

	<div class="project-links">
		<?php if ($project['Project']['url']): ?>
			<a class="cool-link web" href="<?php echo $project['Project']['url']; ?>" target="_blank">Aller sur le site</a>	
		<?php endif ?>
		<?php if ($project['Project']['playstore']): ?>
			<a class="cool-link market" href="<?php echo $project['Project']['playstore']; ?>" target="_blank">Télécharger sur le Play Store</a>	
		<?php endif ?>
		<?php if ($project['Project']['github']): ?>
			<a class="cool-link github" href="<?php echo $project['Project']['github']; ?>" target="_blank">Voir le code source</a>	
		<?php endif ?>
		<?php if ($project['Project']['qrcode']): ?>
			<img src="<?php echo $project['Project']['qrcode'] ?>" alt="QR Code pour télécharger <?php echo $project['Project']['title'] ?> sur le play store depuis votre téléphone" title="Scannez moi avec votre téléphone !" />
		<?php endif ?>
	</div>
</div>