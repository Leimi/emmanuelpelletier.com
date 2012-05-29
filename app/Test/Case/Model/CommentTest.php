<?php
/* Comment Test cases generated on: 2012-01-10 13:24:58 : 1326198298*/
App::uses('Comment', 'Model');

/**
 * Comment Test Case
 *
 */
class CommentTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.comment', 'app.page');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Comment = ClassRegistry::init('Comment');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Comment);

		parent::tearDown();
	}

}
