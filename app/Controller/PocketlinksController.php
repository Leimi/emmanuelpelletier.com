<?php
App::uses('AppController', 'Controller');
class PocketlinksController extends AppController {
	public function index() {
		$this->paginate = array();
		$paginate = array(
			'links',
			'conditions' => array(),
			'limit' => $this->paginateLimit,
			'page' => 1
		);
		//can't figure out how to get the page named param to work properly with Cake 2.0 :(. Sadpanda. Had to add some code
		if (!empty($this->params['page']) && is_numeric($this->params['page'])) {
			$paginate['page'] = $this->params['page'];
		}
		$this->paginate = $paginate;
		$this->set('links', $this->paginate());

		$this->set('title_for_layout', 'Liens partagés via Pocket - Emmanuel Pelletier');
	}
}
