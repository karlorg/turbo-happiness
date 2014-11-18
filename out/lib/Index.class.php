<?php

class Index {
	public function __construct(){}
	static $platform = "PHP";
	static $dbconn = null;
	static function main() {
		try {
			_hx_deref(new haxe_web_Dispatch(php_Web::getURI(), php_Web::getParams()))->runtimeDispatch(_hx_anonymous(array("obj" => _hx_qtype("Index"), "rules" => _hx_anonymous(array("cool" => haxe_web_DispatchRule::DRArgs(haxe_web_DispatchRule::DRMult((new _hx_array(array()))), (new _hx_array(array(_hx_anonymous(array("opt" => false, "rule" => haxe_web_MatchRule::$MRString, "name" => "v")), _hx_anonymous(array("opt" => false, "rule" => haxe_web_MatchRule::$MRInt, "name" => "x"))))), false), "get" => haxe_web_DispatchRule::DRMult((new _hx_array(array()))), "insert" => haxe_web_DispatchRule::DRArgs(haxe_web_DispatchRule::DRMult((new _hx_array(array()))), (new _hx_array(array(_hx_anonymous(array("opt" => false, "rule" => haxe_web_MatchRule::$MRInt, "name" => "age")), _hx_anonymous(array("opt" => false, "rule" => haxe_web_MatchRule::$MRString, "name" => "name"))))), false))))));
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			if(($de = $_ex_) instanceof haxe_web_DispatchError){
				switch($de->index) {
				case 0:{
					$part = $de->params[0];
					php_Lib::hprint("No such page: " . _hx_string_or_null($part));
				}break;
				case 1:{
					php_Lib::hprint("Invalid value");
				}break;
				case 3:{
					$p = $de->params[0];
					php_Lib::hprint("Missing parameter: " . _hx_string_or_null($p));
				}break;
				case 4:{
					php_Lib::hprint("Too many values");
				}break;
				default:{
					php_Lib::hprint("Weird error");
				}break;
				}
			} else throw $__hx__e;;
		}
	}
	static function getDbConn() {
		if(Index::$dbconn === null) {
			sys_db_Manager::initialize();
			Index::$dbconn = sys_db_Sqlite::open("test.sqlite");
			sys_db_Manager::set_cnx(Index::$dbconn);
		}
		if(!sys_db_TableCreate::exists(TestTable::$manager)) {
			sys_db_TableCreate::create(TestTable::$manager, null);
		}
		return Index::$dbconn;
	}
	static function doCool($args) {
		$str = haxe_Resource::getString("testpage");
		$t = new haxe_Template($str);
		$output = $t->execute(_hx_anonymous(array("title" => "Cool page " . _hx_string_or_null(Index::$platform), "body" => "" . _hx_string_rec($args->x, "") . " " . _hx_string_or_null($args->v))), null);
		php_Lib::hprint($output);
	}
	static function doGet() {
		$conn = Index::getDbConn();
		$results = TestTable::$manager->unsafeObjects("SELECT * FROM TestTable WHERE 1", true);
		$table = "<ul>";
		if(null == $results) throw new HException('null iterable');
		$__hx__it = $results->iterator();
		while($__hx__it->hasNext()) {
			$r = $__hx__it->next();
			$table .= "<li>";
			$table .= _hx_string_or_null($r->name) . ", " . _hx_string_rec($r->age, "");
			$table .= "</li>";
		}
		$table .= "</ul>";
		$str = haxe_Resource::getString("testpage");
		$t = new haxe_Template($str);
		$output = $t->execute(_hx_anonymous(array("title" => "DB contents " . _hx_string_or_null(Index::$platform), "body" => "" . _hx_string_or_null($table))), null);
		php_Lib::hprint($output);
	}
	static function doInsert($args) {
		$conn = Index::getDbConn();
		$entry = new TestTable();
		$entry->name = $args->name;
		$entry->age = $args->age;
		$entry->insert();
		$str = haxe_Resource::getString("testpage");
		$t = new haxe_Template($str);
		$output = $t->execute(_hx_anonymous(array("title" => "Insert " . _hx_string_or_null($entry->name) . " " . _hx_string_or_null(Index::$platform), "body" => "inserted " . _hx_string_or_null($entry->name) . ", " . _hx_string_rec($entry->age, "") . " years old")), null);
		php_Lib::hprint($output);
	}
	function __toString() { return 'Index'; }
}
