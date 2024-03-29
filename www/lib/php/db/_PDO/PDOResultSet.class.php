<?php

class php_db__PDO_PDOResultSet extends php_db__PDO_BaseResultSet {
	public function __construct($pdo, $typeStrategy) {
		if(!php_Boot::$skip_constructor) {
		parent::__construct($pdo,$typeStrategy);
	}}
	public $cache;
	public function getResult($index) {
		if(!$this->hasNext()) {
			return null;
		}
		return $this->cache[$index];
	}
	public function hasNext() {
		if((null === $this->cache)) {
			$this->cacheRow();
		}
		return $this->cache;
	}
	public function get_length() {
		if(($this->pdo === false)) {
			return 0;
		}
		return $this->pdo->rowCount();
	}
	public function cacheRow() {
		$this->cache = $this->pdo->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT, null);
	}
	public function nextRow() {
		if(!$this->hasNext()) {
			return null;
		} else {
			$v = $this->cache;
			$this->cache = null;
			return $v;
		}
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
	static $__properties__ = array("get_nfields" => "get_nfields","get_length" => "get_length");
	function __toString() { return 'php.db._PDO.PDOResultSet'; }
}
