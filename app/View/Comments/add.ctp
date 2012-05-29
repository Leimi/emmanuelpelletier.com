<div class="comments form">
<?php echo $this->Form->create('Comment');?>
	<fieldset>
		<legend><?php echo __('Add Comment'); ?></legend>
	<?php
		echo $this->Form->input('user', array('label' => 'Nom'));
		echo $this->Form->input('link', array('label' => 'Site web'));
		echo $this->Form->input('anchor', array('label' => 'Ancre de lien'));
		echo $this->Form->input('mail', array('label' => 'Adresse e-mail'));
		echo $this->Form->input('name', array('label' => 'Commentaire'));
		echo $this->Form->input('page_id', array('value' => $pageId));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Comments'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Pages'), array('controller' => 'pages', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Page'), array('controller' => 'pages', 'action' => 'add')); ?> </li>
	</ul>
</div>
