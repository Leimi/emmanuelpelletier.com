<?php
App::uses('AppController', 'Controller');
class NotesController extends AppController {
	//notes, posts, you name it: these represent the combination of all timed content data like, for now, tweets and blog articles
	var $uses = array('Tweet', 'Page');
	public function index() {
		$this->paginate = array();
		//we get all the tweets and articles and put it together in a single array sorted by date
		$data = array();
		foreach (array_keys(Configure::read('Tweet.types')) as $type) {
			$tweets = $this->Tweet->find('tweets' , array(
				'conditions' => array('type' => $type),
				'limit' => $this->paginateLimit
			));
			foreach ($tweets as $key => $value) {
				$data[]['Note'] = $value['Tweet'];
			}
		}
		$articles = $this->Page->find('articles', array(
			'limit' => $this->paginateLimit
		));
		foreach ($articles as $key => $value) 
			$data[]['Note'] = $value['Page'];
		if (!empty($data)) 
			$data = Set::sort($data, '{n}.Note.created', 'desc');
		$this->set('notes', $data);
	}
}
