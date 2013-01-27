<?php
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
				$id = $this->Comment->id;
				$post = $this->Comment->Page->find('first', array('conditions' => array('id' => $this->request->data['Comment']['page_id'])));
				App::uses('CakeEmail', 'Network/Email');
				$email = new CakeEmail();
				$message = 'Commentaire sur l\'article <a href="http://emmanuelpelletier.com/'.$post['Page']['slug'].'"><strong>'.$post['Page']['name'].'</strong></a> posté le '.date("d/m/Y à H:i").".<br>";
				foreach ($this->request->data['Comment'] as $key => $value) {
					if (in_array($key, array('user', 'link', 'name'))) {
						$message .= $value."<br>";
					}
				}
				$message .= '<a href="http://emmanuelpelletier.com/admin/comments/invert_field/'.$id.'">Activer ce commentaire</a>';
				$message .= ' - <a href="http://emmanuelpelletier.com/admin/comments/delete/'.$id.'">Supprimer ce commentaire</a>';
				$email->from(array('site@emmanuelpelletier.com' => 'Bot emmanuelpelletier.com'))
					->emailFormat('html')
					->to('emmanuel@emmanuelpelletier.com')
					->subject('Nouveau commentaire sur le site')
					->send($message);
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
		$this->Comment->id = $id;
		if (!$this->Comment->exists()) {
			throw new NotFoundException(__('Commentaire introuvable.'));
		}
		if ($this->Comment->delete()) {
			$this->Session->setFlash(__('Commentaire supprimé.'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Commentaire impossible à supprimer.'));
		$this->redirect($this->referer());
	}
}
