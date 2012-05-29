<?php
App::uses('AppModel', 'Model');
class Tweet extends AppModel {
	public $displayField = 'name';
	public $validate = array(
		'type' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
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
	);
	
	public $findMethods = array('tweets' => true);
	
	//didn't find a more ambigous naming for this
	protected function _findTweets($state, $query, $results = array()) {
		if ($state == 'before') {
			$defaultQuery = array();
			$defaultQuery['fields'] = array('type', 'from_id as id', 'from_created as created', 'name', 'user');
			$defaultQuery['order'] = 'from_created DESC';
			$query = array_merge($query, $defaultQuery);
			return $query;
		}
		return $results;
	}

	/**
	 * fill the DB with all types of tweets for a given user
	 * @param  int    $count      number of tweets to get, default to 20
	 * @param  string $screenName twitter user to get the tweets from, default to "leimina" (that's me bro)
	 * @return boolean true on save success, false otherwise
	 */
	function refreshAll($count = 20, $screenName = 'leimina') {
		$success = true;
		foreach (array_keys(Configure::read('Tweet.types')) as $type) {
			if (!$this->refreshTweets($type)) {
				$success = false;
				break;
			}
		}
		if ($success) {
			$Configuration = ClassRegistry::init('Configuration');
			$Configuration->id = $Configuration->field('id', array('name' => 'tweetsUpdateDate'));
			if (empty($Configuration->id)) {
				$Configuration->save(array(
					'name' => 'tweetsUpdateDate',
					'value' => date('Y-m-d H:i:s')
				));
			} else {
				$Configuration->saveField('value', date('Y-m-d H:i:s'));				
			}
		}
		return $success;
	}

	/**
	 * connects to the twitter API to fill the database with new tweets of a given type for a given user
	 * see https://dev.twitter.com/docs/api for more info about the API
	 * @param  string $type       tweets's type, default to "user_timeline"
	 * @param  int    $count      number of tweets to get, default to 20
	 * @param  string $screenName twitter user to get the tweets from, default to "leimina"
	 * @return boolean true on save succes, false otherwise
	 */
	function refreshTweets($type = 'user_timeline', $count = 20, $screenName = 'leimina') {
		$lastTweet = $this->find('first', array(
			'conditions' => array(
				'type' => $type
			),
			'order' => 'from_id DESC'
		));
		//we build the API url for the given parameters
		$tweets = "http://api.twitter.com/1/";
		switch ($type) {
			case 'favorites': 
				$tweets .= 'favorites.json?include_entities=1&id=';break;
			case 'user_timeline':default:
				$tweets .= 'statuses/user_timeline.json?include_entities=1&include_rts=1&exclude_replies=1&screen_name=';
				break;
		}
		$tweets .= $screenName;
		$tweets .= '&count='.$count;
		if (!empty($lastTweet['Tweet']['id']))
			$tweets .= "&since_id=".$lastTweet['Tweet']['from_id'];
		$tweets = $this->getJsonFromUrl($tweets);
		if (!empty($tweets['error']))
			return false;
		$data = array();
		$i = 0;
		// $existingTweets = $this->find('list', array('fields' => 'from_id'));
		foreach ($tweets as $tweet) {
			if (!empty($tweet['retweeted_status']['text'])) {
				$tweet = $tweet['retweeted_status'];
			}
			if (!empty($tweet['entities']['urls'])) {
				foreach ($tweet['entities']['urls'] as $url)
					$tweet['text'] = str_replace($url['url'], $url['expanded_url'], $tweet['text']);
			}
			// if (!in_array($tweet['id_str'], $existingTweets)) {
			if ($this->isUnique(array('Tweet.from_id'=> $tweet['id_str']))) {
				$data[$i]['Tweet'] = array(
					'type' => $type,
					'from_id' => $tweet['id_str'],
					'from_created' => date('Y-m-d H:i:s', strtotime($tweet['created_at'])),
					'name' => $tweet['text'],
					'user' => $tweet['user']['screen_name']
				);
				$i++;
			}
		}
		if (!empty($data)) {
			if ($this->saveAll($data))
				return true;
			return false;
		}
		return true;
	}
}
