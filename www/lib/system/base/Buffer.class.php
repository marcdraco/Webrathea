<?php

class system_base_Buffer extends StringBuf {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		parent::__construct();
		$this->strLength = 0;
	}}
	public $strLength;
	public function append($t) {
		$this->strLength += strlen($t);
		parent::add($t);
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
	function __toString() { return 'system.base.Buffer'; }
}
