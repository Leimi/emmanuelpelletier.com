<div class="users form">
<?php echo $this->Session->flash('auth'); ?>
<?php echo $this->Form->create('User', array('inputDefaults' => array('label' => false), 'class' => 'form-stacked'));?>
    <fieldset class="group">
    <?php
        echo $this->Form->input('username', array('placeholder' => 'Login'));
        echo $this->Form->input('password', array('placeholder' => 'Mot de passe'));
    ?>
    </fieldset>
<?php echo $this->Form->submit('Valider', array('div' => array('class' => 'input submit')));?>
<?php echo $this->Form->end();?>
</div>