<?php

class system_base_Pcall_sql extends system_base_Pcall {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		parent::__construct();
		$this->slow_sql = "";
		$this->fast_sql = "";
	}}
	public $slow_sql;
	public $fast_sql;
	public function add_sql($t, $sql) {
		parent::add($t);
		if($t >= $this->slow) {
			$this->slow_sql = $sql;
		}
		if($t <= $this->fast) {
			$this->fast_sql = $sql;
		}
		return $this->time;
	}
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
	function __toString() { return 'system.base.Pcall_sql'; }
}
