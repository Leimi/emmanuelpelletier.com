<?php 
if ($page['Page']['type'] != 'page') {
	echo '<h1>'.$page['Page']['name'].'</h1>';
	$date = strtotime($page['Page']['modified']);
	$date = ($page['Page']['created'] !== $page['Page']['modified'] ? 'Dernière mise à jour le ' : 'Le ').date('d', $date).' '.$this->Fr->month(date('n', $date)).' '.date('Y', $date);
	echo '<p class=article-date>'.$date.'</p>';
} 
if ($this->Session->check('Auth.User.id')) {
	$editAction = $page['Page']['type'] == 'article' ? 'edit_textile' : 'edit_html';
	echo $this->Html->link('Modifier', array('controller' => 'pages', 'action' => $editAction, $page['Page']['id'], 'admin' => true));
} 
echo $page['Page']['html'];
if ($page['Page']['type'] == 'article'): ?>
<div class="comments-wrapper">
<h2>Commentaires</h2>
<?php if (!empty($page['Comment'])): ?>
	
<ul class="notes-list comments">
	<?php foreach ($page['Comment'] as $comment): ?>
		<li>
			<span>
				<?php $postDate = strtotime($comment['created']); ?>
				<span class="day"><?php echo date('d', $postDate); ?></span>
				<span class="month"><?php echo strtolower(date('M', $postDate)); ?></span>
				<?php if (date('Y', $postDate) != date('Y')): ?><span class="year"><?php echo date('y', $postDate); ?></span><?php endif ?>
				</span>
			</span>
			<p><span class="user"><?php echo !empty($comment['link']) ? sprintf('<a href="%s" target="_blank">%s</a>', $comment['link'], $comment['user']) : $comment['user']; ?> a dit...</span><?php echo $comment['name']; ?></p>
		</li>
	<?php endforeach ?>
</ul>
<?php else: ?>
<p>Il y a environ zéro commentaire.</p>
<?php endif ?>
</div>
<?php echo $this->element('comment_add', array('pageId' => $page['Page']['id'])); ?>
<?php endif ?>

<?php echo $this->Html->scriptBlock($page['Page']['js'], array('inline' => false)); ?>
