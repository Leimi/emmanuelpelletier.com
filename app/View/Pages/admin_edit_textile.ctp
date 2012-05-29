<?php echo $this->element('page_edit_top'); ?>
<?php echo $this->Form->input('textile', array('class' => 'markItUp')); ?>
<?php echo $this->element('page_edit_bottom'); ?>
<?php 
echo $this->Html->script(array('markitup/jquery.markitup', 'markitup/sets/textile/set'), array('inline' => false));
echo $this->Html->scriptBlock(
	"$(document).ready(function() {
      $('.markItUp').markItUp(mySettings);
   	});",
   	array('inline' => false)
); ?>

