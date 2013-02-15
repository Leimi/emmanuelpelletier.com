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

<div id="developpeur-applications" class="clearfix">
	<h2>Applications et sites web</h2>

	<?php foreach ($projects as $project): ?>
	<?php echo $this->element('project', array('project' => $project)); ?>
	<?php endforeach ?>
</div>