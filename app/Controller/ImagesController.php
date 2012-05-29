<?php
App::uses('AppController', 'Controller');
class ImagesController extends AppController {
	var $uses = null;
	public function random() {
		App::uses('RandomImage', 'Vendor');
		$img = new RandomImage();
		echo '{ "src" : "'.$img->src.'", "from" : "'.$img->from.'" }';

		if (!empty($this->request->params['konami'])) {
		/*App::uses('CakeEmail', 'Network/Email');
		$email = new CakeEmail();
		$message = "Un type a déclenché le konami code le ".date("d/m/Y à H:i")."!\n".
		"Il a eu cette image : <img src='".$img->src."'>\n";
		$email->from(array('site@emmanuelpelletier.com' => 'Bot emmanuelpelletier.com'))
			->emailFormat('html')
			->to('emmanuel@emmanuelpelletier.com')
			->subject('Konami code déclenché !!§§§§')
			->send($message);*/
		}
		die();
	}
}
