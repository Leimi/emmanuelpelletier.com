<!DOCTYPE html>
<?php echo $this->Plate->html(); ?>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?> 
	</title>
	
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<meta name="description" content="<?php if (!empty($description_for_layout)) echo $description_for_layout; ?>">
	<meta name="author" content="Emmanuel Pelletier">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<?php echo $this->Html->meta('favicon.ico', '/favicon.ico', array('type' => 'icon', 'rel' => 'shortcut icon')); ?> 
	<?php echo $this->Html->meta('favicon.ico', '/favicon.ico', array('type' => 'icon', 'rel' => 'apple-touch-icon-precomposed')); ?> 
	<?php
		echo $this->Html->css(array('style.css', '/js/markitup/skins/simple/style', '/js/markitup/sets/textile/style'));
		#!# echo $this->AssetCompress->css('style.css');
		#!# echo $this->AssetCompress->includeCss();
		echo $this->Html->script('modernizr.custom');
	?>
</head>
<body>
	<div id="container">
		<div id="content">
			<?php echo $this->Session->flash(); ?>
			<?php echo $this->Session->flash('auth'); ?>

			<?php echo $content_for_layout; ?>
			
			<?php echo $this->element('admin_actions'); ?>
		</div>
	</div>
	<?php
	echo $this->Plate->lib('jquery', array('compressed' => true, 'fallback' => 'jquery-1.7.0.min'));
	echo $this->AssetCompress->script('admin.js', array('raw' => Configure::read('debug') > 0));

	#!# echo $this->AssetCompress->script('script');
	
	#!# echo $this->AssetCompress->includeJs();
	?>
	<?php echo $scripts_for_layout; ?>
	<?php
	echo $this->Plate->analytics();
	echo $this->Plate->chrome();
	?>
</body>
</html>
