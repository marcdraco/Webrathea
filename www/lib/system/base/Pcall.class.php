<?php

class system_base_Pcall {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$this->time = 0;
		$this->calls = 0;
		$this->slow = 0;
		$this->fast = 9999.99;
	}}
	public $time;
	public $calls;
	public $slow;
	public $fast;
	public function add($t) {
		$this->calls += 1;
		$this->time += $t;
		if($t > $this->slow) {
			$this->slow = $t;
		}
		if($t < $this->fast) {
			$this->fast = $t;
		}
		return $this->time;
	}
	public function percent($t_stop = null) {
		$stopped_at = null;
		if($t_stop === null) {
			$stopped_at = system_base_Pcall::$stop_time;
		} else {
			$stopped_at = $t_stop;
		}
		return $this->time / $stopped_at * 100;
	}
	public function percentf($t_stop = null) {
		return Std::string(Math::round($this->percent($t_stop))) . "%";
	}
	public function callsf() {
		return Std::string($this->calls);
	}
	public function timef($t_stop = null) {
		return Std::string($this->time);
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
	static $stop_time;
	static function set_stop_time($t) {
		system_base_Pcall::$stop_time = $t;
	}
	function __toString() { return 'system.base.Pcall'; }
}
