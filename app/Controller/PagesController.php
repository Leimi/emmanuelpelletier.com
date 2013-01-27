<?php
App::uses('AppController', 'Controller');
class PagesController extends AppController {
	public function index($type = null) {
		$paginate = array(
			'articles',
			'limit' => $this->paginateLimit
		);
		//can't figure out how to get the page named param to work properly with Cake 2.0 :(. Sad panda. Had to add some code
		if (!empty($this->params['page']) && is_numeric($this->params['page'])) {
			$paginate['page'] = $this->params['page'];
		}
		$this->paginate = $paginate;
		$this->set('articles', $this->paginate());
		$this->set('title_for_layout', 'Articles sur le développement web - Emmanuel Pelletier');
	}

	public function view($slug = null) {
		$page = Cache::read('Page.'.$slug);
		if (!$page) {
			$page = $this->Page->find('first', array(
				'conditions' => array(
					'slug' => $slug,
					'active' => 1
				),
				'contain' => array(
					'Comment' => array(
						'conditions' => array(
							'active' => 1
						),
						'order' => 'created ASC'
					)
				)
			));
			if (!empty($page['Page']['id']))
				Cache::write('Page.'.$slug, $page);
		}
		if (!$page) {
			$oldSlug = $slug;
			$slug = $this->Page->getCurrentSlugByOldSlug($slug, array('active' => 1));
			if ($slug) {
				Cache::delete('Page.'.$oldSlug);
				$this->redirect(array('controller' => 'pages', 'action' => 'view', 'slug' => $slug), 301);
			}
			throw new NotFoundException(__('Page introuvable'));
		}

		$this->set('page', $page);
		$this->set('title_for_layout', $page['Page']['title']);
		$this->set('description_for_layout',  $page['Page']['description']);
	}

	public function admin_index() {
		$data = $this->Page->find('all' , array(
			'order' => array('type', 'name')
		));
		
		$this->set('pages', $data);
	}

	public function admin_view($id = null) {
		$this->Page->id = $id;
		if (!$this->Page->exists()) {
			throw new NotFoundException(__('Page introuvable.'));
		}
		$page = $this->Page->find('first', array(
			'conditions' => array(
				'id' => $id
			),
			'contain' => array(
				'Comment' => array(
					'order' => 'created ASC'
				)
			)
		));
		$this->set('page', $page);
	}

	public function admin_edit_textile($id = null) {
		if (!is_null($id)) {
			$this->Page->id = $id;
			if (!$this->Page->exists()) {
				throw new NotFoundException(__('Page introuvable.'));
			}
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->request->data['Page']['type'] = 'article';
			if ($this->Page->save($this->request->data)) {
				$this->Session->setFlash(__('Page sauvegardée.'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Page impossible à sauvegarder.'));
			}
		} else {
			$this->request->data = $this->Page->read(null, $id);
		}
	}

	public function admin_edit_html($id = null) {
		if (!is_null($id)) {
			$this->Page->id = $id;
			if (!$this->Page->exists()) {
				throw new NotFoundException(__('Page introuvable.'));
			}
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->request->data['Page']['html'] = str_replace(array('&lt;', '&gt;'), array('<', '>'), $this->request->data['Page']['html']);
			$this->request->data['Page']['type'] = 'page';
			if ($this->Page->save($this->request->data)) {
				$this->Session->setFlash(__('Page sauvegardée.'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Page impossible à sauvegarder.'));
			}
		} else {
			$this->request->data = $this->Page->read(null, $id);
			$this->request->data['Page']['html'] = str_replace(array('<', '>'), array('&lt;', '&gt;'), $this->request->data['Page']['html']);
		}
	}

	public function admin_delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Page->id = $id;
		if (!$this->Page->exists()) {
			throw new NotFoundException(__('Page introuvable.'));
		}
		if ($this->Page->delete()) {
			$this->Session->setFlash(__('Page supprimée.'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Page impossible à supprimer.'));
		$this->redirect(array('action' => 'index'));
	}

	public function display() {
		$this->layout = false;
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			$this->redirect('/');
		}
		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
		$this->set(compact('page', 'subpage', 'title_for_layout'));
		$this->render(implode('/', $path));
	}
}
