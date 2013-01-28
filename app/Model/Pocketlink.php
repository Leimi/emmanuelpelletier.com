<?php
App::uses('AppModel', 'Model');
class Pocketlink extends AppModel {
	public $displayField = 'name';
	public $useTable = 'pocket_links';
	public $validate = array(
		'from_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'isUnique' => array(
				'rule' => array('isUnique')
			)
		),
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'url' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		)
	);
	
	public $findMethods = array('links' => true);
	
	//didn't find a more ambigous naming for this
	protected function _findLinks($state, $query, $results = array()) {
		if ($state == 'before') {
			$defaultQuery = array();
			$defaultQuery['fields'] = array('from_id as id', 'from_created as created', 'name', 'url');
			$defaultQuery['order'] = 'from_created DESC';
			$query = array_merge($query, $defaultQuery);
			return $query;
		}
		if ($state == 'after') {
			foreach ($results as $key => $value) {
				$results[$key]['Pocketlink']['type'] = 'link';
			}
		}
		return $results;
	}

	/**
	 * connects to the pocket API to fill the database with new links for a given user/password
	 * see http://getpocket.com/api/docs/#get_since for more info about the API
	 * @param  string $login      user
	 * @param  string $password   password
	 * @param  int    $count      number of tweets to get, default to 50
	 * @return boolean true on save succes, false otherwise
	 */
	function refresh($login = 'leimina', $password = '', $count = 50) {
		$lastLink = $this->find('first', array(
			'order' => 'from_id DESC'
		));
		//we build the API url for the given parameters
		$links = "https://readitlaterlist.com/v2/get?apikey=5c9A5c25dbsUpI4b8ap0Gz1jX4T0Baf1&state=0&tags=1";
		$links .= "&username=".$login;
		$links .= '&password='.$password;
		$links .= '&count='.$count;
		if (!empty($lastLink['Pocketlink']['id']))
			$links .= "&since=".strtotime($lastLink['Pocketlink']['from_created']);
		$links = $this->getJsonFromUrl($links);
		if (empty($links['list']))
			return false;
		$data = array();
		$i = 0;
		foreach ($links['list'] as $link) {
			if (!empty($link['tags']) && strpos($link['tags'], 'public') !== false && $this->isUnique(array('Pocketlink.from_id'=> $link['item_id']))) {
				if (empty($link['title'])) $link['title'] = $link['url'];
				$data[$i]['Pocketlink'] = array(
					'from_id' => $link['item_id'],
					'from_created' => date('Y-m-d H:i:s', $link['time_added']),
					'name' => $link['title'],
					'url' => $link['url']
				);
				$i++;
			}
		}
		if (!empty($data)) {
			if (!$this->saveAll($data)) {
				return false;
			}
		}
		$Configuration = ClassRegistry::init('Configuration');
		$Configuration->id = $Configuration->field('id', array('name' => 'pocketLinksUpdateDate'));
		if (empty($Configuration->id)) {
			$Configuration->save(array(
				'name' => 'pocketLinksUpdateDate',
				'value' => date('Y-m-d H:i:s')
			));
		} else {
			$Configuration->saveField('value', date('Y-m-d H:i:s'));				
		}
		return true;
	}
}
