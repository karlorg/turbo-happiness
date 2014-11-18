<?php

class haxe_Resource {
	public function __construct(){}
	static function cleanName($name) {
		return _hx_deref(new EReg("[\\\\/:?\"*<>|]", ""))->replace($name, "_");
	}
	static function getDir() {
		return _hx_string_or_null(dirname(__FILE__)) . "/../../res";
	}
	static function getPath($name) {
		return _hx_string_or_null(haxe_Resource::getDir()) . "/" . _hx_string_or_null(haxe_Resource::cleanName($name));
	}
	static function getString($name) {
		return sys_io_File::getContent(haxe_Resource::getPath($name));
	}
	function __toString() { return 'haxe.Resource'; }
}
