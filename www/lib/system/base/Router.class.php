<?php

class system_base_Router {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		{
			$s = null;
			{
				$s1 = php_Web::getParamsString();
				$s = urldecode($s1);
			}
			if(_hx_char_at($s, strlen($s) - 1) === "/") {
				$s = _hx_substr($s, 0, strlen($s) - 1);
			}
			$this->query_string = $s;
		}
		if(strlen($this->query_string) >= 255) {
			throw new HException(new system_base_Http_exception("Query string malformed or too long", 414, _hx_anonymous(array("fileName" => "Router.hx", "lineNumber" => 28, "className" => "system.base.Router", "methodName" => "new"))));
		}
		$this->query_hash = haxe_crypto_Md5::encode($this->query_string);
	}}
	public $controller;
	public $method;
	public $params;
	public $query_string;
	public $query_hash;
	public function get_query_string() {
		return $this->query_string;
	}
	public function get_controller() {
		return $this->controller;
	}
	public function get_method() {
		return $this->method;
	}
	public function get_query_hash() {
		return $this->query_hash;
	}
	public function get_params() {
		return $this->params;
	}
	public function decode_route() {
		$this->params = (new _hx_array(array()));
		if(system_base_Router::$regexp->match($this->query_string)) {
			throw new HException(new system_base_Http_exception("Illegal character(s) in URI: " . _hx_string_or_null($this->query_string), 400, _hx_anonymous(array("fileName" => "Router.hx", "lineNumber" => 119, "className" => "system.base.Router", "methodName" => "decode_route"))));
		}
		if(strlen($this->query_string) === 0) {
			$this->controller = system_base_Router::$FRONT_CONTROLLER;
			{
				$s = strtolower($this->controller);
				$this->controller = _hx_string_or_null(strtoupper(_hx_substr($s, 0, 1))) . _hx_string_or_null(_hx_substr($s, 1, null));
			}
			$this->method = strtolower(system_base_Router::$DEFAULT_METHOD);
			$this->query_string = _hx_string_or_null($this->controller) . "/" . _hx_string_or_null($this->method);
			return true;
		}
		if(_hx_index_of($this->query_string, "/", null) === -1) {
			$this->params->push(strtolower($this->query_string));
		} else {
			$this->params = _hx_explode("/", strtolower($this->query_string));
		}
		if($this->params[0] !== null && strlen($this->params[0]) > 0) {
			$s1 = $this->params[0];
			$this->controller = _hx_string_or_null(strtoupper(_hx_substr($s1, 0, 1))) . _hx_string_or_null(_hx_substr($s1, 1, null));
		} else {
			$this->controller = system_base_Router::$FRONT_CONTROLLER;
		}
		if($this->params[1] !== null && strlen($this->params[0]) > 0) {
			$this->method = $this->params[1];
		} else {
			$this->method = system_base_Router::$DEFAULT_METHOD;
		}
		if($this->controller === "_load") {
			return false;
		}
		return true;
	}
	public function remove_trailing_slash($s) {
		if(_hx_char_at($s, strlen($s) - 1) === "/") {
			$s = _hx_substr($s, 0, strlen($s) - 1);
		}
		return $s;
	}
	public function class_case($s) {
		return _hx_string_or_null(strtoupper(_hx_substr($s, 0, 1))) . _hx_string_or_null(_hx_substr($s, 1, null));
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
	static $regexp;
	static $DEFAULT_METHOD = "index";
	static $FRONT_CONTROLLER = "front";
	static $instance;
	static function get_instance() {
		if(system_base_Router::$instance === null) {
			system_base_Router::$instance = new system_base_Router();
		}
		return system_base_Router::$instance;
	}
	function __toString() { return 'system.base.Router'; }
}
system_base_Router::$regexp = new EReg("[^\\x5F\\x2Ea-z0-9\\-/]", "i");
