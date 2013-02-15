<div class="projects form">
<?php echo $this->Form->create('Project');?>
	<fieldset>
		<legend><?php echo __('Admin Edit Project'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('title');
		echo $this->Form->input('order');
		echo $this->Form->input('class');
		echo $this->Form->input('url');
		echo $this->Form->input('content');
		echo $this->Form->input('images');
		echo $this->Form->input('tags');
		echo $this->Form->input('playstore');
		echo $this->Form->input('qrcode');
		echo $this->Form->input('github');
		echo $this->Form->input('highlight');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Project.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Project.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Projects'), array('action' => 'index'));?></li>
	</ul>
</div>
