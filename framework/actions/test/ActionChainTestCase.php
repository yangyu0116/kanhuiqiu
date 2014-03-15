<?php

	class ActionChainTestCase extends PHPUnit_Framework_TestCase {
		
		private $actionChain;
		private $context;

		protected function setUp() {
			$this->actionChain = new ActionChain();
			$this->actionChain->setActionID('chain');
				
			$this->context  = Context::getInstance();	
		}
	
		public function testAddAction() {
			$ret = $this->actionChain->addAction(null, null, null);
			$this->assertFalse($ret);
	
			$ret = $this->actionChain->addAction("abc", null, null);
			$this->assertTrue($ret);
		}

		public function testRemoveActionByIndex() {
			$ret = $this->actionChain->removeActionByIndex("123");
			$this->assertFalse($ret);

			$ret = $this->actionChain->removeActionByIndex(1213);
			$this->assertTrue($ret);
	
			$ret = $this->actionChain->setActions(null);
			$this->assertTrue($ret);

			$ret = $this->actionChain->removeActionByIndex(1213);
			$this->assertTrue($ret);
		}
		
		public function testSetActions() {
			$ret = $this->actionChain->setActions(null);
			$this->assertTrue($ret);
	
			$ret = $this->actionChain->setActions($this);
			$this->assertFalse($ret);

			$actions = array('a', 'b', 123);
			$ret = $this->actionChain->setActions($actions);
			$this->assertTrue($ret);

			$actions = array('a', 'b');
			$ret = $this->actionChain->setActions($actions);
			$this->assertTrue($ret);
		}

		public function testExecute() {
			
			$ret = $this->actionChain->setActions(null);
			$this->assertTrue($ret);

			$ret = $this->actionChain->execute($this->context, null);
			$this->assertFalse($ret);	
		}
	}	

?>
