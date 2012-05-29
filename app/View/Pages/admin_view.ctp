<h1><?php echo $this->Html->link($page['Page']['name'], array('action' => 'view', 'slug' => $page['Page']['slug'], 'admin' => false)); ?></h1>

<table class="zebra-striped">
	<tr>
		<th>Date</th>
		<th>Auteur</th>
		<th>Commentaire</th>
		<th>Actions</th>
	</tr>
	<?php foreach ($page['Comment'] as $comment): ?>
	<tr class="<?php echo $comment['active'] ? 'active' : 'inactive' ?>">
		<td><?php echo date('d/m/Y - H:i', strtotime($comment['created'])) ?></td>
		<td>
			<a href="<?php echo $comment['link'] ?>" target="_blank"><?php echo $comment['user']; ?></a>
		</td>
		<td><?php echo $comment['name']; ?></td>
		<td class="actions">
		<?php 
		$toggleString = $comment['active'] ? 'Désactiver' : 'Activer';
		echo $this->Html->link(__($toggleString), array('controller' => 'comments', 'action' => 'invert_field', $comment['id'])); ?>
		<?php echo $this->Form->postLink(__('Supprimer'), array('controller' => 'comments', 'action' => 'delete', $comment['id']), null, __('Are you sure you want to delete # %s?', $comment['id'])); ?>
		</td>
	</tr>
	<?php endforeach; ?>
</table>