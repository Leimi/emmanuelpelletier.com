<?php
App::uses('AppModel', 'Model');
/**
 * Slug Model
 *
 * @property Page $Page
 */
class Slug extends AppModel {

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Page' => array(
			'className' => 'Page',
			'foreignKey' => 'model_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
