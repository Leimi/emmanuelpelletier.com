<?php
class RandomImage {
	var $tumblrs = array(
		'http://bonjourmadame.fr',
		'http://bonjourlesgeeks.com',
		'http://bonjourhamster.fr',
		'http://bonjourlechat.fr',
		'http://dailybunny.org'
	);
	var $from = '';
	var $src = '';

	function __construct() {
		$this->from = $this->tumblrs[mt_rand(0, count($this->tumblrs)-1)];
		$limit = mt_rand(0, 49);
		$xml = simplexml_load_file($this->from.'/api/read?start='.$limit.'&num=50&type=photo');
		$postNumber = mt_rand(0, 49);
		$img = $xml->posts->post[$postNumber]->{'photo-url'}[1];
		$this->src = $img;
	}
}