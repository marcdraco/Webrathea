<?php

class system_base_String_buffer {
	public function __construct($s = null) {
		if(!php_Boot::$skip_constructor) {
		if($s === null) {
			$this->body = "";
		} else {
			$this->body = $s;
		}
	}}
	public $body;
	public $length;
	public function fast_body_is_closed() {
		return _hx_last_index_of($this->body, "</body>", null) !== -1;
	}
	public function body_is_closed() {
		$body_tag = new EReg("/(body)", "i");
		$found = $body_tag->match($this->body);
		if($found) {
			$this->body = _hx_string_or_null($body_tag->matchedLeft()) . "/body" . _hx_string_or_null($body_tag->matchedRight());
		}
		return $found;
	}
	public function append($t) {
		$this->body .= _hx_string_or_null($t);
		return $this->body;
	}
	public function toString() {
		return $this->body;
	}
	public function reset() {
		$this->body = "";
	}
	public function get_length() {
		return strlen($this->body);
	}
	public function insert_after($needle, $text, $offset = null) {
		$start = null;
		if(strlen($this->body) === 0) {
			return false;
		}
		if($offset === null || $offset === 0) {
			$start = _hx_index_of($this->body, $needle, null);
		} else {
			$start = _hx_index_of($this->body, $needle, $offset);
		}
		if($start === -1) {
			return false;
		}
		$start += strlen($needle);
		$this->body = _hx_string_or_null(_hx_substr($this->body, 0, $start)) . _hx_string_or_null($text) . _hx_string_or_null(_hx_substr($this->body, $start, null));
		return true;
	}
	public function insert_before($needle, $text) {
		$start = null;
		if(strlen($this->body) === 0) {
			return false;
		}
		$start = _hx_index_of($this->body, $needle, null);
		if($start === -1) {
			return false;
		}
		$this->body = _hx_string_or_null(_hx_substr($this->body, 0, $start)) . _hx_string_or_null($text) . _hx_string_or_null(_hx_substr($this->body, $start, null));
		return true;
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
	static $__properties__ = array("get_length" => "get_length");
	function __toString() { return $this->toString(); }
}
