<?php
//simple baking as of now
App::uses('AppController', 'Controller');
/**
 * Comments Controller
 *
 * @property Comment $Comment
 */
class CommentsController extends AppController {

	public function add() {
		if ($this->request->is('post')) {
			$this->Comment->create();
			$this->request->data['Comment']['active'] = 0;
			if ($this->Comment->save($this->request->data)) {
				$this->Session->setFlash(__('Commentaire ajouté avec succès et maintenant en attente de modération.'));
				$this->redirect($this->referer());
			} else {
				$this->Session->setFlash(__("Le commentaire n'a pas pu être ajouté, réessayez plus tard. P'tete."));
			}
		}
		$pages = $this->Comment->Page->find('list');
		$this->set(compact('pages'));
	}

	public function admin_edit($id = null) {
		$this->Comment->id = $id;
		if (!$this->Comment->exists()) {
			throw new NotFoundException(__('Commentaire introuvable'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Comment->save($this->request->data)) {
				$this->Session->setFlash(__('Commentaire ajouté.'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Commentaire impossible à ajouter.'));
			}
		} else {
			$this->request->data = $this->Comment->read(null, $id);
		}
		$pages = $this->Comment->Page->find('list');
		$this->set(compact('pages'));
	}

	public function admin_delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Comment->id = $id;
		if (!$this->Comment->exists()) {
			throw new NotFoundException(__('Commentaire introuvable.'));
		}
		if ($this->Comment->delete()) {
			$this->Session->setFlash(__('Commentaire supprimé.'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Commentaire impossible à supprimer.'));
		$this->redirect(array('action' => 'index'));
	}
}
