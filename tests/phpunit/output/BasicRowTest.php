<?php

namespace Capiunto\Test;

use Scribunto_LuaEngine;
use Scribunto_LuaEngineTestBase;

/**
 * A basic Infobox output test
 *
 * @license GNU GPL v2+
 *
 * @author Marius Hoch < hoo@online.de >
 */
class BasicRowTest extends Scribunto_LuaEngineTestBase {

	public function provideLuaData() {
		// We need this to override the defaults in Scribunto_LuaEngineTestBase
		return array(
			array( 'a', 'b', 'c' )
		);
	}

	/**
	 * @dataProvider provideLuaData
	 */
	public function testLua( $key, $testName, $expected ) {
		$this->assertTrue( true );
	}

	public function testOutput() {
		/** @var Scribunto_LuaEngine $engine */
		$engine = $this->getEngine();
		$interpreter = $engine->getInterpreter();

		$lua = file_get_contents( __DIR__ . '/BasicRowTest.lua' );

		list( $box ) = $interpreter->callFunction(
			$interpreter->loadString( $lua, 'Basic infobox integration test' )
		);

		$this->assertValidHtmlSnippet( $box );

		$matcher = array(
			'tag' => 'table',
			'attributes' => array( 'class' => 'mw-capiunto-infobox' ),
			'descendant' => array( 'tag' => 'caption' )
		);

		$this->assertTag(
			$matcher,
			$box,
			"Basic row infobox integration test didn't create expected html"
		);
	}

}
