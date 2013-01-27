<?php
/**
 * get a random image coming from a tumblr present in a list
 *
 * usage:
 * <?php 
 *     $image = new RandomTumblrImage(); //choose an image from the default list
 *     //or
 *     $image = new RandomTumblrImage(array('http://dailybunny.org', 'http://yourtumblrwebsite.com')); //choose from the passed list
 * ?>
 * <p>The image <img src="<?php echo $image->src ?>" alt=""> comes from <?php echo $image->from ?>.</p>
 *
 */
class RandomTumblrImage {
	var $tumblrs = array(
		'http://www.bonjourmadame.fr',
		'http://bonjourlesgeeks.com',
		'http://bonjourhamster.fr',
		'http://bonjourlechat.fr',
		'http://bonjourhumour.tumblr.com'
	);
	var $from = '';
	var $src = '';
	var $tries = 0;

	function __construct($list = array()) {
		if (!empty($list)) $this->tumblrs = $list;
		libxml_use_internal_errors(true);
		$this->rand();
	}

	public function rand() {
		if ($this->tries > 5) return;
		// $this->tries++;
		// $this->from = $this->tumblrs[mt_rand(0, count($this->tumblrs)-1)];
		// $xml = simplexml_load_file($this->from.'/api/read?start='.mt_rand(0, 49).'&num=50&type=photo');
		// if (!$xml) {
		// 	foreach (libxml_get_errors() as $error) {
		//         var_dump($error);
		//     }
		// }
		// $img = $xml->posts->post[mt_rand(0, 49)]->{'photo-url'}[1];
		// $this->src = $img;
		$max = 300;
		$num = 50;
		$this->from = $this->tumblrs[mt_rand(0, count($this->tumblrs)-1)];
		$checkMax = @simplexml_load_file($this->from.'/api/read?num=1');
		if ($checkMax) $max = $checkMax->posts['total']; 
		$pages = floor($max/$num);
		$xml = @simplexml_load_file($this->from.'/api/read?start='.((mt_rand(0, $pages-1))*50).'&num='.$num.'&type=photo'); //CRADOOOOO OUUUHHH
		if ($xml) {
			$this->tries = 0;
			$img = $xml->posts->post[mt_rand(0, 49)]->{'photo-url'}[1];
			$this->src = $img;
		} else {
			$this->tries++;
			$this->rand();
		}
	}
}