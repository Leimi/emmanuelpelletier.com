<?php foreach ($notes as $note): 
	$noteDate = strtotime($note[$model]['created']);
	$isTweet = in_array($note[$model]['type'], array_keys(Configure::read('Tweet.types')));
	$isLink = $note[$model]['type'] == 'link';
	switch ($note[$model]['type']) {
		case 'user_timeline': $icon = 'twitter';break;
		case 'favorites': $icon = 'star';break;
		case 'page':default: $icon = 'newspaper';break;
	}
	?>
	<li>
		<?php if ($isTweet): ?>
			<a href="http://twitter.com/<?php echo $note[$model]['user'].'/status/'.$note[$model]['id'] ?>" target="_blank" title="Le <?php echo date('d/m/Y à H\hi', $noteDate) ?>, cliquer pour voir le tweet en détails">
		<?php elseif ($isLink): ?>
			<a href="<?php echo $note[$model]['url']; ?>" target="_blank" title="Ajouté à ma liste de lecture le <?php echo date('d/m/Y à H\hi', $noteDate) ?>, cliquer pour voir l'article">
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
			} elseif ($isLink) {
				echo '<a href="'.$note[$model]['url'].'" target="_blank">'.$note[$model]['name'].'</a>';
			} else {
				echo '&nbsp;'.$this->Html->link($note[$model]['name'], array('controller' => 'pages', 'action' => 'view', 'slug' => $note[$model]['slug']));	
			}
		?></p>
	</li>
<?php endforeach; ?>