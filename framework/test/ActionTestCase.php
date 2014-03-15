<?php
	
	class ActionTestCase extends PHPUnit_Framework_TestCase {
	
		protected function setUp() {
			
		}

		public function testIsValidActionID() {
			$ret = Action::isValidActionID(null);
			$this->assertFalse($ret);

			$ret = Action::isValidActionID(12);
			$this->assertFalse($ret);
	
			$ret = Action::isValidActionID(array());
			$this->assertFalse($ret);

			$ret = Action::isValidActionID(Context::getInstance());
			$this->assertFalse($ret);
			
			$ret = Action::isValidActionID("");
			$this->assertFalse($ret);
		
			$ret = Action::isValidActionID("12");
			$this->assertTrue($ret);	
		}

		public function testSetActionID() {
			$ret = Action::setActionID(null);
			$this->assertFalse($ret);

			$ret = Action::setActionID(12);
			$this->assertFalse($ret);
	
			$ret = Action::setActionID(array());
			$this->assertFalse($ret);

			$ret = Action::setActionID(Context::getInstance());
			$this->assertFalse($ret);
			
			$ret = Action::setActionID("");
			$this->assertFalse($ret);
		
			$ret = Action::setActionID("12");
			$this->assertTrue($ret);	

		}


		public function testGetAction() {
			$action = Action::getAction(null, null);
			$this->assertNull($action);

			$action = Action::getAction('test', null, null);
			$this->assertNull($action);

			$action = Action::getAction('test', 'abc', null);
			$this->assertNull($action);

			$action = Action::getAction('test', '/abc', null);
			$this->assertNull($action);

			$action = Action::getAction('test', 
								'/home/liubin/bingo/framework/Context',
								null
			);
			$this->assertNull($action);

			$action = Action::getAction('test', 
								'/home/liubin/bingo/framework/Event',
								null
			);
			$this->assertNull($action);

			$action = Action::getAction('test', 
						'/home/liubin/bingo/framework/actions/ActionController', 
						null
			);
			if (!($action instanceof Action)) {
				$this->fail();
			}
		}
	}

?>
