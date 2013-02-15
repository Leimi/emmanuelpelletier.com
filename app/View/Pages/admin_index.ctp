<div class="pages index">
	<h2><?php echo __('Pages');?></h2>
	
	<table class="zebra-striped">
		<tr>
			<th>Nom</th>
			<th>Actions</th>
		</tr>
	<?php
	$lastType = null;
	foreach ($pages as $page): 
	if ($page['Page']['type'] == 'article') {
		$commentsCount = 0;
		foreach ($page['Comment'] as $comment) if (!$comment['active']) $commentsCount++;
	}
	if ($lastType != $page['Page']['type']): ?>
		<tr>
			<th><?php echo Inflector::pluralize(ucfirst($page['Page']['type'])); ?></th>
		</tr>
	<?php endif ?>
		<tr>
			<td><?php echo $page['Page']['name']; ?></td>
			<td class="actions">
			<?php echo $this->Html->link(__('Voir'), array('action' => 'view', 'slug' => $page['Page']['slug'], 'admin' => false)); ?>
			<?php $editAction = $page['Page']['type'] == 'article' ? 'edit_textile' : 'edit_html';
			echo $this->Html->link(__('Modifier'), array('action' => $editAction, $page['Page']['id'])); ?>
			<?php echo $this->Form->postLink(__('Supprimer'), array('action' => 'delete', $page['Page']['id']), null, __('Are you sure you want to delete # %s?', $page['Page']['id'])); ?>
			<?php if ($page['Page']['type'] == 'article'): ?>
			&nbsp;&nbsp;<?php echo $this->Html->link(__('Commentaires '.($commentsCount > 0 ? '('.$this->Text->pluralize($commentsCount, 'inactif').')' : '')), array('action' => 'view', $page['Page']['id'], 'admin' => true)); ?>
			<?php endif ?>
			</td>
		</tr>
<?php 
	$lastType = $page['Page']['type'];
	endforeach; ?>
	</table>
	
</div>

<div class="projects index">
	<h2><?php echo __('Projects');?></h2>
	<table cellpadding="0" cellspacing="0">
	<?php
	foreach ($projects as $project): ?>
	<tr>
		<td><?php echo h($project['Project']['title']); ?>&nbsp;</td>
		<td><?php echo h($project['Project']['order']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Voir'), array('controller' => 'projects', 'action' => 'view', $project['Project']['id'])); ?>
			<?php echo $this->Html->link(__('Modifier'), array('controller' => 'projects', 'action' => 'edit', $project['Project']['id'])); ?>
			<?php echo $this->Form->postLink(__('Supprimer'), array('controller' => 'projects', 'action' => 'delete', $project['Project']['id']), null, __('Are you sure you want to delete # %s?', $project['Project']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
</div>

