<?php
App::uses('AppController', 'Controller');
class ImagesController extends AppController {
	var $uses = null;
	public function random() {
		App::uses('RandomTumblrImage', 'Vendor');
		$img = new RandomTumblrImage();
		echo '{ "src" : "'.$img->src.'", "from" : "'.$img->from.'" }';

		if (!empty($this->request->params['konami']) && Configure::read('inProduction')) {
			App::uses('CakeEmail', 'Network/Email');
			$email = new CakeEmail();
			$message = "Un type a déclenché le konami code le ".date("d/m/Y à H:i")."!\n".
			"Il a eu cette image venant de ".$img->from.": <img src='".$img->src."'>\n";
			$email->from(array('site@emmanuelpelletier.com' => 'Bot emmanuelpelletier.com'))
				->emailFormat('html')
				->to('emmanuel@emmanuelpelletier.com')
				->subject('Konami code déclenché !!§§§§')
				->send($message);
		}
		die();
	}
}
