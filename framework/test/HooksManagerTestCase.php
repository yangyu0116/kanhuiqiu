<?php
	
	class HooksManagerTestCase extends PHPUnit_Framework_TestCase {
	
		private $hooksManager;

		protected function setUp() {
			$this->hooksManager = HooksManager::getInstance();			
		}

		public function testIsValidHook() {
			$ret = HooksManager::isValidHook(123);
			$this->assertFalse($ret);

			$ret = HooksManager::isValidHook(new Error(1, 'message'));
			$this->assertTrue($ret);
		
			$ret = HooksManager::isValidHook("jj");
			$this->assertTrue($ret);

			$ret = HooksManager::isValidHook(array());
			$this->assertFalse($ret);
	
			$ret = HooksManager::isValidHook(array(new Error(1, 'message')));
			$this->assertTrue($ret);

			$ret = HooksManager::isValidHook(array(1));
			$this->assertFalse($ret);

			$ret = HooksManager::isValidHook(array("hook"));
			$this->assertTrue($ret);
		}

		public function testAddEventHook() {
			/*
			$hooksManager = HooksManager::getInstance();			
			$ret = $this->hooksManager->addEventHook(null, null);	
			$this->assertFalse($ret);
			*/

			$hook = 'hookmethod';
			$event = new Event('', 'source', 'object');
			$ret = $this->hooksManager->addEventHook($event, $hook);
			$this->assertFalse($ret);

			$hook = 'hookmethod';
			$event = new Event('eventName', 'source', 'object');
			$ret = $this->hooksManager->addEventHook($event, $hook);
			$this->assertTrue($ret);

			$hook = '';
			$event = new Event('eventName', 'source', 'object');
			$ret = $this->hooksManager->addEventHook($event, $hook);
			$this->assertFalse($ret);
	
			$hook = 123;
			$event = new Event('eventName', 'source', 'object');
			$ret = $this->hooksManager->addEventHook($event, $hook);
			$this->assertFalse($ret);
		}
		
		public function testFireEvent() {
			$ret = $this->hooksManager->fireEvent(null);
			$this->assertFalse($ret);

			$event = new Event('12312313123123123123', 'source', 'object');
			$ret = $this->hooksManager->fireEvent($event);	
			$this->assertFalse($ret);
		}

	}

?>
