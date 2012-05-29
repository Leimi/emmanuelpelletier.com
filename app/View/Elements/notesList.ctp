<?php if (empty($model)) $model = 'Note'; ?>
<div class="notes index">
	<?php
	$type = !empty($this->request->params['type']) ? $this->request->params['type'] : ($model == 'Page' ? 'article' : false);
	switch ($type) {
		case 'user_timeline': $title = 'Tweets'; break;
		case 'favorites': $title = 'Favoris'; break;
		case 'article': $title = 'Articles'; break;
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
	<?php if (!$type || $type == 'article'): ?>
	mes <?php echo $this->Html->link('articles de blog', array('controller' => 'pages', 'action' => 'index'), array('class' => 'article')); if ($type) echo '.' ?>
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
	<?php foreach ($notes as $note): 
		$noteDate = strtotime($note[$model]['created']);
		$isTweet = in_array($note[$model]['type'], array_keys(Configure::read('Tweet.types')));
		switch ($note[$model]['type']) {
			case 'user_timeline': $icon = 'twitter';break;
			case 'favorites': $icon = 'star';break;
			case 'page':default: $icon = 'newspaper';break;
		}
		?>
		<li>
			<?php if ($isTweet): ?>
				<a href="http://twitter.com/<?php echo $note[$model]['user'].'/status/'.$note[$model]['id'] ?>" target="_blank" title="Le <?php echo date('d/m/Y à H\hi') ?>, cliquer pour voir le tweet en détails">
			<?php else: ?>
				<a href="<?php echo $this->Html->url(array('controller' => 'pages', 'action' => 'view', 'slug' => $note[$model]['slug'])); ?>" title="Le <?php echo date('d/m/Y à H\hi') ?>, cliquer pour voir l'article en détails">
			<?php endif; ?>
				<span class="day"><?php echo date('d', $noteDate); ?></span>
				<span class="month"><?php echo $this->Fr->month(date('n', $noteDate), true); ?></span>
				<?php if (date('Y', $noteDate) != date('Y')): ?><span class="year"><?php echo date('y', $noteDate); ?></span><?php endif ?>
				<span class="icon common-<?php echo $icon ?>"></span>
			</a>
			<p><?php 
				if ($isTweet) {
					if (strcmp($note[$model]['user'], 'Leimina') !== 0)
						echo '<span class="user">'.$this->Text->autoLink('@'.$note[$model]['user'], array('target' => '_blank')).' a dit...</span>';
					echo $this->Text->autoLink($note[$model]['name'], array('target' => '_blank'));
				} else {
					// echo '<strong>'.$note[$model]['name'].'</strong>';
					echo '&nbsp;'.$this->Html->link($note[$model]['name'], array('controller' => 'pages', 'action' => 'view', 'slug' => $note[$model]['slug']));	
				}
			?></p>
		</li>
	<?php endforeach; ?>
	</ul>
	<?php echo $this->element('notesPagination'); ?>
	<ul class="more">
		<?php if ($model == 'Note'): ?>
		<li><?php echo $this->Html->link('Voir plus de tweets', array('controller' => 'tweets', 'action' => 'index', 'type' => 'user_timeline', 'page' => 2), array('class' => 'tweet')); ?> (<a href="http://twitter.com/@Leimina" target="_blank">&#8599;</a>)</li>
		<li><?php echo $this->Html->link('Voir plus de favoris', array('controller' => 'tweets', 'action' => 'index', 'type' => 'favorites', 'page' => 2), array('class' => 'favorite')); ?> (<a href="http://twitter.com/@Leimina/favorites" target="_blank">&#8599;</a>)</li>
		<li><?php echo $this->Html->link("Voir plus d'articles", array('controller' => 'pages', 'action' => 'index', 'page' => 2), array('class' => 'article')); ?></li>
		<?php else: ?>
		<li><?php echo $this->Html->link('Voir toutes les dernières notes', array('controller' => 'notes', 'action' => 'index')); ?></li>
		<?php endif ?>
	</ul>
</div>