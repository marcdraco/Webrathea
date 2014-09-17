<?php

class system_base_Timers {
	public function __construct($n = null) {
		if(!php_Boot::$skip_constructor) {
		$this->time = haxe_Timer::stamp();
		if($n !== null) {
			$this->name = $n;
		}
	}}
	public $time;
	public $name;
	public function stop() {
		if($this->name !== null) {
			return $this->named_stop();
		} else {
			return $this->unnamed_stop();
		}
	}
	public function unnamed_stop() {
		return haxe_Timer::stamp() - $this->time;
	}
	public function named_stop() {
		$total_time = haxe_Timer::stamp() - $this->time;
		return _hx_string_or_null($this->name) . ": " . Std::string($total_time);
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
	function __toString() { return 'system.base.Timers'; }
}
