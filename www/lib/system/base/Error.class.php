<?php

class system_base_Error {
	public function __construct($desc = null, $info = null) {
		if(!php_Boot::$skip_constructor) {
		$this->__description = $desc;
		$this->__info = $info;
	}}
	public $message;
	public $__description;
	public $__info;
	public function get_description() {
		$msg = "Class : " . _hx_string_or_null($this->__info->className) . " - > ";
		$msg .= _hx_string_or_null($this->__info->methodName) . "()\x0Aline ";
		$msg .= _hx_string_rec($this->__info->lineNumber, "") . " : " . _hx_string_or_null($this->__description);
		return $msg;
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
	static function wipe($e) {
		haxe_Log::trace("<span class=\"__fatal__\">" . _hx_string_or_null($e) . "</span>", _hx_anonymous(array("fileName" => "Error.hx", "lineNumber" => 31, "className" => "system.base.Error", "methodName" => "wipe")));
		system_base_Cache::flush_log();
	}
	function __toString() { return 'system.base.Error'; }
}
