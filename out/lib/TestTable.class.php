<?php

class TestTable extends sys_db_Object {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		parent::__construct();
	}}
	public $id;
	public $name;
	public $age;
	public function __call($m, $a) {
		if(isset($this->$m) && is_callable($this->$m))
			return call_user_func_array($this->$m, $a);
		else if(isset($this->__dynamics[$m]) && is_callable($this->__dynamics[$m]))
			return call_user_func_array($this->__dynamics[$m], $a);
		else if('toString' == $m)
			return $this->__toString();
		else
			throw new HException('Unable to call <'.$m.'>');
	}
	static function __meta__() { $args = func_get_args(); return call_user_func_array(self::$__meta__, $args); }
	static $__meta__;
	static $manager;
	function __toString() { return 'TestTable'; }
}
TestTable::$__meta__ = _hx_anonymous(array("obj" => _hx_anonymous(array("rtti" => (new _hx_array(array("oy4:namey9:TestTabley7:indexesahy9:relationsahy7:hfieldsby2:idoR0R5y6:isNullfy1:tjy17:sys.db.RecordType:0:0gR0oR0R0R6fR7jR8:9:1i32gy3:ageoR0R9R6fR7jR8:1:0ghy3:keyaR5hy6:fieldsar4r6r8hg")))))));
TestTable::$manager = new sys_db_Manager(_hx_qtype("TestTable"));
