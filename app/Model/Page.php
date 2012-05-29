<?php
App::uses('AppModel', 'Model');
/**
 * Page Model
 *
 */
class Page extends AppModel {
	//public $name = 'Page';
	public $displayField = 'name';

	public $actsAs = array(
		'Sluggable' => array(
			'label' => 'slug',
			'slug' => 'slug',
			'separator' => '-',
			'length' => 255,
			'update' => false
		)
	);
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter a valid name',
				//'allowEmpty' => true,
				//'required' => true,
				//'last' => true, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	public $hasMany = array(
		'Comment',
		'Slug' => array(
			'className'     => 'Slug',
			'foreignKey'    => 'model_id',
			'conditions'    => array('Slug.model' => 'Page')
		)
	);

	function beforeSave() {
		//we make sure to transform given textile in html if textile data is passed
		if (!empty($this->data['Page']['textile'])) {
			App::uses('Textile', 'Vendor');
			$Textile = new Textile();
			$this->data['Page']['textile'] = stripslashes($this->data['Page']['textile']);
			$this->data['Page']['html'] = $Textile->TextileThis($this->data['Page']['textile']);
		}

		$oldSlug = (!empty($this->data['Page']['id'])) ? $this->field('slug', array('Page.id' => $this->data['Page']['id'])) : '';
		//we save the old slug in DB if it changes
		if (!empty($oldSlug) && $oldSlug != $this->data['Page']['slug']) {
			$this->loadModel('Slug');
			$oldSlugEntry = array(
				'slug' => $oldSlug,
				'model' => 'Page',
				'model_id' => $this->data['Page']['id'],
				'created' => date('Y-m-d H:i:s')
			);
			$this->Slug->save($oldSlugEntry);
		}

		return true;
	}

	public $findMethods = array('articles' => true);

	/**
	 * custom find type 'Articles': we find all active "article" pages ordered by last created
	 */
	protected function _findArticles($state, $query, $results = array()) {
		if ($state == 'before') {
			$defaultQuery = array();
			$defaultQuery['fields'] = array('type', 'slug', 'created', 'name');
			$defaultQuery['order'] = 'created DESC';
			$defaultQuery['conditions'] = array('type' => 'article', 'active' => 1);
			$query = array_merge($query, $defaultQuery);
			return $query;
		}
		return $results;
	}

	/**
	 * pass a slug and return the new slug for the record or false if nothing is found
	 * 
	 * this is useful for CMS & SEO. For example when somebody wants to view a post that is accessed by the slug, you can check if the given slug is the current one or an old one in the controller with this method. If it's an old one you can easily redirect 301 to the new one.
	 * Old slugs are saved in the 'slugs' table in the beforeSave() method.
	 * 
	 * @param  string $oldSlug    the slug you wanna check
	 * @param  array $conditions additionnal conditions to retrieve the record
	 * @return the current slug of the record if found, false otherwise
	 */
	public function getCurrentSlugByOldSlug($oldSlug, $conditions) {
		$id = $this->Slug->field('model_id', array(
			'model' => $this->alias,
			'slug' => $oldSlug
		));
		if (!empty($id)) {
			$conditions = array_merge($conditions, array('id' => $id));
			$newSlug = $this->field('slug', $conditions);
			if (!empty($newSlug))
				return $newSlug;
		}
		return false;
	}
}