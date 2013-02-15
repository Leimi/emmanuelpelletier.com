<?php
App::uses('AppController', 'Controller');
class TweetsController extends AppController {
	public function index() {
		$this->paginate = array();
		$paginate = array(
			'tweets',
			'conditions' => array(),
			'limit' => $this->paginateLimit,
			'page' => 1
		);
		//if a tweet type is given, we paginate the results for the given type
		if (!empty($this->params['type']) && in_array($this->params['type'], array_keys(Configure::read('Tweet.types')))) {
			$paginate['conditions']['type'] = $this->params['type'];
		}
		//can't figure out how to get the page named param to work properly with Cake 2.0 :(. Sadpanda. Had to add some code
		if (!empty($this->params['page']) && is_numeric($this->params['page'])) {
			$paginate['page'] = $this->params['page'];
		}
		$this->paginate = $paginate;
		$this->set('tweets', $this->paginate());
	}
	
	public function admin_update() {
		$this->Tweet->refreshAll();
		$this->redirect($this->referer());
	}
}
