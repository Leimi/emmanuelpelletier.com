<div class="pages form">
<?php echo $this->Form->create('Page', array('class' => 'form-stacked'));?>
	<fieldset class="group">
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name', array('label' => 'Nom'));