

<div id="developpeur-applications" class="clearfix">
	<h2>Applications et sites web</h2>

	<?php foreach ($projects as $project): ?>
	<?php echo $this->element('project', array('project' => $project)); ?>
	<?php endforeach ?>
</div>