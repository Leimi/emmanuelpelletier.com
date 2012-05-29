<?php
	echo $this->Form->input('title', array('label' => 'Titre'));
	echo $this->Form->input('description', array('label' => 'Description'));
	echo $this->Form->input('slug', array('label' => 'Url'));
	echo $this->Form->label('active', 'Visible ?');
	echo $this->Form->input('active', array('label' => false, 'default' => 1));
?>
	</fieldset>
<?php echo $this->Form->end(__('Valider'));?>
</div>