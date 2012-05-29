<div class="comments form">
	<h2>Commenter</h2>
	<?php echo $this->Form->create('Comment', array('action' => 'add', 'class'=>'form-stacked'));?>
	<fieldset>
		<div class="input">
			<?php
			echo $this->Form->input('user', array('div' => false, 'required', 'label' => 'Nom (requis)', 'placeholder' => 'Nom (requis)'));
			echo $this->Form->input('link', array('div' => false, 'label' => 'Site web', 'placeholder' => 'Site web', 'type' => 'url'));
			?>
		</div>
		<?php
		echo $this->Form->input('name', array('required', 'label' => 'Commentaire (requis)', 'placeholder' => 'Commentaire (requis)'));
		echo $this->Form->input('page_id', array('type' => 'hidden', 'value' => $pageId));
		?>
	</fieldset>
	<?php echo $this->Form->end(__('Valider'));?>
</div>