<?php

	class ErrorTestCase extends PHPUnit_Framework_TestCase {
	
		protected function setUp() {

		}

		public function testConstruct() {
			global $context;

			$error = new Error(1, 'message');
			$this->assertEquals(1, $context->lastError->errno);
			$this->assertEquals('message', $context->lastError->error);
		}
	}

?>
