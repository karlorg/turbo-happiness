<?php

class PHPMain {
	public function __construct(){}
	static function main() {
		$str = haxe_Resource::getString("testpage");
		$t = new haxe_Template($str);
		$output = $t->execute(_hx_anonymous(array("title" => "Cool page")), null);
		php_Lib::hprint($output);
	}
	function __toString() { return 'PHPMain'; }
}
