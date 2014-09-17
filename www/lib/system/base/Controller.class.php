<?php

class system_base_Controller {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$this->arguments = (new _hx_array(array()));
		$this->cache = system_base_Cache::get_instance();
	}}
	public $params;
	public $cache;
	public $route;
	public $arguments;
	public function load_view_hash($view, $vars = null) {
		$base = (isset(system_base_Wet_base::$get_instance) ? system_base_Wet_base::$get_instance: array("system_base_Wet_base", "get_instance"));
		$viewpath = _hx_string_or_null(system_base_Wet_base::$views_path) . _hx_string_or_null($view) . ".wtv";
		$view1 = null;
		$pos = 0;
		$left = null;
		$right = null;
		$uservar = null;
		try {
			$view1 = sys_io_File::getContent($viewpath);
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			$e = $_ex_;
			{
				throw new HException(new system_base_NoFileError(_hx_string_or_null($viewpath) . " does not exist or cannot be opened for reading"));
			}
		}
		if($vars !== null) {
			if(null == $vars) throw new HException('null iterable');
			$__hx__it = $vars->keys();
			while($__hx__it->hasNext()) {
				$k = $__hx__it->next();
				$pos = 0;
				$uservar = Std::string($vars->get($k));
				while(($pos = _hx_index_of($view1, "::" . _hx_string_or_null($k) . "::", $pos)) !== -1) {
					$left = _hx_substr($view1, 0, $pos);
					$right = _hx_substr($view1, $pos + strlen($k) + 4, null);
					$view1 = _hx_string_or_null($left) . _hx_string_or_null($uservar) . _hx_string_or_null($right);
					$pos += 1;
				}
			}
		}
		$this->cache->append($view1);
	}
	public function load_view_object($view, $vars = null) {
		$base = (isset(system_base_Wet_base::$get_instance) ? system_base_Wet_base::$get_instance: array("system_base_Wet_base", "get_instance"));
		$viewpath = _hx_string_or_null(system_base_Wet_base::$views_path) . _hx_string_or_null($view) . ".wtv";
		$view1 = null;
		$pos = 0;
		$left = null;
		$right = null;
		$uservar = null;
		$fieldname = null;
		try {
			$view1 = sys_io_File::getContent($viewpath);
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			$e = $_ex_;
			{
				throw new HException(new system_base_NoFileError(_hx_string_or_null($viewpath) . " does not exist or cannot be opened for reading"));
			}
		}
		if($vars !== null) {
			$fields = Reflect::fields($vars);
			{
				$_g = 0;
				while($_g < $fields->length) {
					$fieldname1 = $fields[$_g];
					++$_g;
					$uservar = Std::string(Reflect::field($vars, $fieldname1));
					$pos = 0;
					while(($pos = _hx_index_of($view1, "::" . _hx_string_or_null($fieldname1) . "::", $pos)) !== -1) {
						$left = _hx_substr($view1, 0, $pos);
						$right = _hx_substr($view1, $pos + strlen($fieldname1) + 4, null);
						$view1 = _hx_string_or_null($left) . _hx_string_or_null($uservar) . _hx_string_or_null($right);
						$pos += 1;
					}
					unset($fieldname1);
				}
			}
		}
		$this->cache->append($view1);
	}
	public function set_params($p) {
		$this->params = $p;
	}
	public function get_params() {
		return $this->arguments;
	}
	public function index() {
	}
	public function flush() {
		system_base_Cache::flush();
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
	function __toString() { return 'system.base.Controller'; }
}
