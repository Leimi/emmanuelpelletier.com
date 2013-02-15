<?php if (empty($model)) $model = 'Note'; ?>
<div class="notes index">
	<?php
	if (empty($type)) $type = !empty($this->request->params['type']) ? $this->request->params['type'] : ($model == 'Page' ? 'article' : false);
	switch ($type) {
		case 'user_timeline': $title = 'Tweets'; break;
		case 'favorites': $title = 'Favoris'; break;
		case 'article': $title = 'Articles'; break;
		case 'link': $title = 'Liens à voir, via Pocket'; break;
		default: $title = 'Notes'; break;
	}
	?>
	<h2><?php echo $title; ?></h2>
	<p>Dans cette liste, il y a 
	<?php if (!$type || $type == 'user_timeline'): ?>
		mes <?php echo $this->Html->link('<span class="small i">(re)</span>tweets', array('controller' => 'tweets', 'action' => 'index', 'type' => 'user_timeline'), array('class' => 'tweet', 'escape' => false)); ?> (<a href="http://twitter.com/@Leimina" target="_blank">&#8599;</a>)<?php echo !$type ? ',' : '.'  ?>
	<?php endif ?>
	<?php if (!$type || $type == 'favorites'): ?>
		mes <?php echo $this->Html->link('tweets favoris', array('controller' => 'tweets', 'action' => 'index', 'type' => 'favorites'), array('class' => 'favorite')); ?> (<a href="http://twitter.com/@Leimina/favorites" target="_blank">&#8599;</a>)<?php echo !$type ? ' et' : '.'  ?>
	<?php endif ?>
	<?php if ($type == 'article'): ?>
	mes <?php echo $this->Html->link('articles de blog', array('controller' => 'pages', 'action' => 'index'), array('class' => 'article')); if ($type) echo '.' ?>
	<?php endif ?>
	<?php if (!$type || $type == 'link'): ?>
	mes <?php echo $this->Html->link('liens à voir', array('controller' => 'pocketlinks', 'action' => 'index'), array('class' => 'article')); if ($type) echo '.' ?>
	<?php endif ?>
	<?php if (!$type): ?>
	récents.
	<?php else: ?>
	&nbsp;<?php echo $this->Html->link('Voir toutes les dernières notes', array('controller' => 'notes', 'action' => 'index')); ?>
	<?php endif ?>
	</p>
	<?php echo $this->element('notesPagination'); ?>
	<?php if (empty($notes)): ?>
		<p>Hmm, y'a pas encore de trucs ici en fait.</p>
	<?php endif ?>
	<ul class="notes-list">
	<?php echo $this->element('notesListLoop', array('notes' => $notes, 'model' => $model)); ?>
	</ul>
	<?php echo $this->element('notesPagination'); ?>
	<ul class="more">
		<?php if ($model == 'Note'): ?>
		<li><?php echo $this->Html->link('Voir plus de tweets', array('controller' => 'tweets', 'action' => 'index', 'type' => 'user_timeline', 'page' => 2), array('class' => 'tweet')); ?> (<a href="http://twitter.com/@Leimina" target="_blank">&#8599;</a>)</li>
		<li><?php echo $this->Html->link('Voir plus de favoris', array('controller' => 'tweets', 'action' => 'index', 'type' => 'favorites', 'page' => 2), array('class' => 'favorite')); ?> (<a href="http://twitter.com/@Leimina/favorites" target="_blank">&#8599;</a>)</li>
		<!--<li><?php //echo $this->Html->link("Voir plus d'articles", array('controller' => 'pages', 'action' => 'index', 'page' => 2), array('class' => 'article')); ?></li>-->
		<li><?php echo $this->Html->link("Voir plus de liens", array('controller' => 'pocketlinks', 'action' => 'index', 'page' => 2), array('class' => 'article')); ?></li>
		<?php else: ?>
		<li><?php echo $this->Html->link('Voir toutes les dernières notes', array('controller' => 'notes', 'action' => 'index')); ?></li>
		<?php endif ?>
	</ul>
</div>