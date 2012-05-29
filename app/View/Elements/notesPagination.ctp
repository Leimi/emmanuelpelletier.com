<?php if (isset($this->Paginator) && $this->Paginator->hasPage(null, 2)) {
	echo '<ul class="pagination">';
	if (!empty($this->request->params['type']))
		$this->Paginator->options(array('url' => array('type' => $this->request->params['type'])));
	echo '<li>'.$this->Paginator->prev(' &larr; ' . __('Après'), array('escape' => false), null, array('escape' => false, 'class' => 'prev disabled')).'</li>';
	echo '<li>'.$this->Paginator->next(__('Avant') . ' &rarr; ', array('escape' => false), null, array('escape' => false, 'class' => 'prev disabled')).'</li>';
	echo '</ul>';
} ?>