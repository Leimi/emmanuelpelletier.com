<?php
App::uses('Controller', 'Controller');
class AppController extends Controller {
	
    public $helpers = array(
        'BakingPlate.Plate',
		'Html' => array('className' => 'MyHtmlPlus'),
		'Form' => array('className' => 'BakingPlate.FormPlus'),
        'Session',
        'Text' => array('className' => 'MyText'),
        'Fr',
        'AssetCompress.AssetCompress'
    );

	public $components = array(
		'BakingPlate.Plate',
		'Paginator',
		'Session',
		'Auth'
	);

	public $uses = array('Configuration.Configuration');

	/**
	 * Specifies if an action should be under SSL
	 *
	 * @var mixed set to true for all controller actions, set to an array of action names for specific ones
	 */
	public $secureActions = false;

	 /**
	  * $_GET keyword to force debug mode. Set to false or delete to disable.
	  */
	public $debugOverride = 'debug';

	protected $paginateLimit = 10;

	public function __construct($request = null, $response = null) {
		if (!empty($this->debugOverride) && !empty($request->query[$this->debugOverride])) {
			Configure::write('debug', 2);
		}
		if (Configure::read('debug') && $request->action != 'display') {
			//$this->components[] = 'DebugKit.Toolbar';
		}
		parent::__construct($request, $response);
	}

	public function beforeFilter() {
		$this->_setConfiguration();
		$this->_setAuth();

		//we fill the DB with new tweets if it's been more than 5 hours that we did last time
		$lastTweetsUpdate = strtotime(Configure::read('Site.tweetsUpdateDate'));
		$now = time();
		if ($now > $lastTweetsUpdate)
			$diff = ceil(($now - $lastTweetsUpdate)/3600);
		if (!empty($diff) && $diff > 5) {
			$this->loadModel('Tweet');
			$this->Tweet->refreshAll();
		}
		//we fill the DB with new links if it's been more than 5 hours that we did last time
		$lastLinksUpdate = strtotime(Configure::read('Site.pocketLinksUpdateDate'));
		$now = time();
		if ($now > $lastLinksUpdate)
			$diff = ceil(($now - $lastLinksUpdate)/3600);
		if (!empty($diff) && $diff > 5) {
			$this->loadModel('Pocketlink');
			$loginInfo = Configure::read('Pocket.credentials');
			$this->Pocketlink->refresh($loginInfo['login'], $loginInfo['password']);
		}
	}

	public function beforeRender() {
		if ($this->Plate->prefix('admin'))
			$this->layout = 'admin';
	}

	protected function _setConfiguration($prefix = 'Site') {
		if (isset($this->Configuration)) {
			$this->Configuration->load($prefix);
		}
	}

	protected function _setAuth() {
		$this->Auth->authError = __('Vous devez être connecté pour accéder à cette page');
		$this->Auth->loginError = __('Identifiants incorrects');
		$this->Auth->loginRedirect = array('controller' => 'pages', 'action' => 'index', 'admin' => true);
		$this->Auth->logoutRedirect = array('controller' => 'pages', 'action' => 'home');
		if (!$this->Plate->prefix('admin')) {
			$this->Auth->allow();
		}
	}

	/**
	 * useful actions for all controllers
	 */


	/**
	 * toggle a boolean field for a record and redirect to the referer
	 * @param  int $id    id of the record 
	 * @param  string $field field to toggle. Defaults to 'active'
	 */
	function admin_invert_field($id = null, $field = 'active') {
		$model =& $this->{$this->modelClass};

		if($id)
			$model->id = $id;
		if(!$model->id or !$model->hasField($field))
			$this->Session->setFlash("L'élément est introuvable.", 'message_error');
		else
		{
			if(!$model->saveField($field, !$model->field($field)))
				$this->Session->setFlash("Impossible de mettre à jour l'élément.", 'message_error');
			else
				$this->Session->setFlash("L'élément a été mis à jour.", 'message_ok');
		}
		$this->redirect($this->referer());
	}
}