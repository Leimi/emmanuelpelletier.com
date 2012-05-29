<div class="actions-list" class="actions">
	<ul class="well">
		<li><?php echo $this->Html->link(__('Nouvelle page'), array('action' => 'edit_html'), array('class' => 'btn add')); ?></li>
		<li><?php echo $this->Html->link(__('Nouvel article'), array('action' => 'edit_textile'), array('class' => 'btn add')); ?></li>
		<li><?php echo $this->Html->link(__('Voir les pages et articles'), array('controller' => 'pages', 'action' => 'index'), array('class' => 'btn next'));?></li>
		<?php if (!empty($this->request->data['Page']['id'])): ?>
		<li><?php echo $this->Html->link(__('Voir la page'), array('controller' => 'pages', 'action' => 'view', $this->Form->value('Page.slug')), array('class' => 'btn view')); ?></li>
		<li><?php echo $this->Form->postLink(__('Supprimer la page'), array('controller' => 'pages', 'action' => 'delete', $this->Form->value('Page.id')), array('class' => 'btn delete'), 'Es-tu sûr de vouloir supprimer cette page ?'); ?></li>
		<?php endif ?>
		<li><?php echo $this->Html->link('Voir le site', '/', array('class' => 'btn next')); ?></li>		
	</ul>
</div>