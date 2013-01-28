<!DOCTYPE html>
<?php echo $this->Plate->html(); ?>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo !empty($title_for_layout) ? $title_for_layout : Configure::read('Site.title'); ?>
	</title>

	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<meta name="description" content="<?php echo !empty($description_for_layout) ? $description_for_layout : Configure::read('Site.description'); ?>">
	<meta name="author" content="Emmanuel Pelletier">

	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<?php echo $this->Html->meta('favicon.ico', '/favicon.ico', array('type' => 'icon', 'rel' => 'shortcut icon')); ?>
	<?php echo $this->Html->meta('favicon.ico', '/favicon.ico', array('type' => 'icon', 'rel' => 'apple-touch-icon-precomposed')); ?>
	<?php 
		$rawAssets = !Configure::read('inProduction');
		echo $this->AssetCompress->css('style.css', array('raw' => $rawAssets)); 
	?>
	<?php echo $this->Html->script(array('modernizr.custom')); ?>
</head>
<body>
	<div id="header">
		<!-- you dirty, dirty header -->
		<div id="headerContainer">
			<div class="ir"><h1>Emmanuel Pelletier, développeur web Angers</h1></div>
			<div class="moving" data-offset=0></div>
			<div class="moving" data-offset=0></div>
			<div class="moving" data-offset=0></div>
			<div id="navContainer">
				<ul id="navigation">
					<li><?php echo $this->Html->smartLink('Accueil', '/'); ?></li>
					<li><?php echo $this->Html->smartLink('Applications', array('controller' => 'pages', 'action' => 'view', 'slug' => 'applications', 'admin' => false)); ?></li>
					<li><?php echo $this->Html->smartLink('CV', array('controller' => 'pages', 'action' => 'view', 'slug' => 'developpeur-web', 'admin' => false)); ?></li>
					<li><?php echo $this->Html->smartLink('Notes', array('controller' => 'notes', 'action' => 'index', 'admin' => false)); ?></li>
					<?php if ($this->Session->read('Auth.User.id')): ?>
					<li><?php echo $this->Html->smartLink('Admin', array('controller' => 'pages', 'action' => 'index', 'admin' => true)); ?></li>
					<?php endif ?>
				</ul>
			</div>
			<div class="moving" data-offset=0></div>
			<div class="moving" data-offset=0></div>
			<div class="moving" data-offset=0></div>
			<div class="moving" data-offset=0></div>
			<div class="moving" data-offset=0></div>
			<div class="moving" data-offset=0></div>
			<div class="moving" data-offset=0></div>
			<div class="moving" data-offset=0></div>
			<div class="moving" data-offset=0></div>
		</div>
	</div>
	<div class="only-mobile only-js" id="header-toggler" data-show="Afficher le " data-hide="Cacher le ">Menu</div>
	<div id="container">
		<div id="content-wrapper" class="clearfix">
			<div class="loading hidden"><span class="loading-content"><?php echo $this->Html->image('common/ajax-loader.gif', array('alt'=>'Chargement')); ?></span></div>
			<div id="content">
				<?php echo $this->Session->flash(); ?>

				<?php echo $this->Session->flash('auth'); ?>

				<?php echo $content_for_layout; ?>
			</div>
		</div>
		<p id="footer">
			<a title="Contactez-moi par mail" href="mailto:&#101;&#109;&#109;&#097;&#110;&#117;&#101;&#108;&#064;&#101;&#109;&#109;&#097;&#110;&#117;&#101;&#108;&#112;&#101;&#108;&#108;&#101;&#116;&#105;&#101;&#114;&#046;&#099;&#111;&#109;">e-mail</a> &mdash; <a class="tweet" target="_blank" href="https://twitter.com/intent/user?screen_name=Leimina">twitter</a> &mdash; <a class="github-icon" target="_blank" href="https://github.com/Leimi">github</a>
			<a href="https://plus.google.com/115995065387824929742?rel=author" class="hidden">google+</a>
		</p>
	</div>
	<?php echo $this->AssetCompress->script('scripts.js', array('raw' => $rawAssets)); ?>
	<div id="scripts">
	<?php echo $scripts_for_layout ?>
	</div>
	<script>
        var _gaq=[['_setAccount','UA-13184829-2'],['_trackPageview']];
        (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
        g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
        s.parentNode.insertBefore(g,s)}(document,'script'));
    </script>

	<div id='konamiiii' class='hidden'>
		<p style='text-align: center'>Bravo, tu as trouvé la cachette ultra secrète de ce site ! Ici se cache...</p>
		<div class="reward" style='text-align: center'>chargement</div>
		<audio preload="auto" class='hidden' id="discovered-sound"> 
			<source src="/files/OOT_Secret.wav">
		</audio>
		<audio preload="auto" class='hidden' id="discovered-sound-2"> 
			<source src="/files/OOT_Fanfare_Item.wav">
		</audio>
	</div>
</body>
</html>
