<?php 
if ($this->Session->check('Auth.User.id')) {
	$editAction = $page['Page']['type'] == 'article' ? 'edit_textile' : 'edit_html';
	echo $this->Html->link('Modifier', array('controller' => 'pages', 'action' => $editAction, $page['Page']['id'], 'admin' => true));
} ?>
<div class="clearfix">
<?php echo $page['Page']['html']; ?>
</div>
<br><br>
<div class="last-projects">
	<h2>Mes derniers projets. De la mort. Qui tue.</h2>
	<?php foreach ($projects as $project): ?>
		<?php echo $this->element('project', array('project' => $project)); ?>
	<?php endforeach ?>
</div>

<br><br>
<div class="lft halfwidth">
	<h2><?php echo $this->Html->link('Derniers tweets', array('controller' => 'tweets', 'action' => 'index', 'type' => 'user_timeline')); ?></h2>
	<ul class="notes-list">
	<?php echo $this->element('notesListLoop', array('model' => 'Tweet', 'notes' => $tweets)); ?>
	</ul>
</div>
<div class="rght halfwidth">
	<h2><?php echo $this->Html->link('Derniers liens', array('controller' => 'pocketlinks', 'action' => 'index')); ?></h2>
	<ul class="notes-list">
	<?php echo $this->element('notesListLoop', array('model' => 'Pocketlink', 'notes' => $links, 'type' => 'link')); ?>
	</ul>
</div>