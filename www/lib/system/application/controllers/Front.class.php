<?php

class system_application_controllers_Front extends system_base_Controller {
	public function __construct() { if(!php_Boot::$skip_constructor) {
		parent::__construct();
	}}
	public function index() {
		$this->demo();
	}
	public function demo2() {
		$this->cache->append("<html><head></head><body>");
	}
	public function demo() {
		$this->cache->append("<html><head></head><body>");
		$pg = new system_base_Paginator("http://localhost:8888/?front/demo/", 200, 5);
		$pg->generate_links(_hx_anonymous(array("separator" => " ", "sideband_width" => 6)));
		haxe_Log::trace($pg->get_current_links(), _hx_anonymous(array("fileName" => "Front.hx", "lineNumber" => 38, "className" => "system.application.controllers.Front", "methodName" => "demo")));
		$this->cache->append("<img src='http://localhost:8888/?_load/sxy.jpg'> </img>");
		$this->route = system_application_controllers_Front_0($this, $pg);
		haxe_Log::trace("src=\"" . "http://localhost:8888/" . "?_load/" . "sxy.jpg" . "\"", _hx_anonymous(array("fileName" => "Front.hx", "lineNumber" => 43, "className" => "system.application.controllers.Front", "methodName" => "demo")));
		$rb = new system_base_Attributes("red bold", "test", null, null, null, null, null, null, null, null, null);
		haxe_Log::trace($rb->insert_attributes(), _hx_anonymous(array("fileName" => "Front.hx", "lineNumber" => 46, "className" => "system.application.controllers.Front", "methodName" => "demo")));
		haxe_Log::trace("<a href=\"" . Std::string("http://" . "www.google.com") . "\"" . $rb->insert_attributes() . ">" . (system_application_controllers_Front_1($this, $pg, $rb)) . "</a>", _hx_anonymous(array("fileName" => "Front.hx", "lineNumber" => 48, "className" => "system.application.controllers.Front", "methodName" => "demo")));
		haxe_Log::trace(system_base_Wet_base::$cache_path, _hx_anonymous(array("fileName" => "Front.hx", "lineNumber" => 49, "className" => "system.application.controllers.Front", "methodName" => "demo")));
		haxe_Log::trace($_SERVER['SERVER_NAME'], _hx_anonymous(array("fileName" => "Front.hx", "lineNumber" => 50, "className" => "system.application.controllers.Front", "methodName" => "demo")));
		haxe_Log::trace(system_base_Wet_base::get_file_etag(system_base_Wet_base::$views_path . "simple_view.wtv"), _hx_anonymous(array("fileName" => "Front.hx", "lineNumber" => 52, "className" => "system.application.controllers.Front", "methodName" => "demo")));
		haxe_Log::trace(system_base_Wet_base::get_file_etag(system_base_Wet_base::$views_path . "simple_view2.wtv"), _hx_anonymous(array("fileName" => "Front.hx", "lineNumber" => 53, "className" => "system.application.controllers.Front", "methodName" => "demo")));
		haxe_Log::trace(system_application_controllers_Front_2($this, $pg, $rb), _hx_anonymous(array("fileName" => "Front.hx", "lineNumber" => 54, "className" => "system.application.controllers.Front", "methodName" => "demo")));
		haxe_Log::trace(system_application_controllers_Front_3($this, $pg, $rb), _hx_anonymous(array("fileName" => "Front.hx", "lineNumber" => 55, "className" => "system.application.controllers.Front", "methodName" => "demo")));
		system_base_Wet_base::set_file_etag(system_base_Wet_base::$views_path . "simple_view2.wtv");
		haxe_Log::trace(haxe_Timer::stamp(), _hx_anonymous(array("fileName" => "Front.hx", "lineNumber" => 57, "className" => "system.application.controllers.Front", "methodName" => "demo")));
		$this->cache->inject_style(".red {color:red}", null);
		$this->cache->inject_style(".bold", "font-weight: bold;");
		$this->cache->append("<span class='bold red'>This is a test run...</span>");
		$this->cache->append("This is a working copy" . Std::string($this->params));
		$this->cache->append("</body></html>");
	}
	function __toString() { return 'system.application.controllers.Front'; }
}
function system_application_controllers_Front_0(&$퍁his, &$pg) {
	{
		if(system_base_Router::$instance === null) {
			system_base_Router::$instance = new system_base_Router();
		}
		return system_base_Router::$instance;
	}
}
function system_application_controllers_Front_1(&$퍁his, &$pg, &$rb) {
	if("Google" === null) {
		return "www.google.com";
	} else {
		return "Google";
	}
}
function system_application_controllers_Front_2(&$퍁his, &$pg, &$rb) {
	{
		$fullpath = system_base_Wet_base::$views_path . "simple_view2.wtv";
		if(file_exists($fullpath)) {
			return is_dir($fullpath);
		} else {
			return false;
		}
		unset($fullpath);
	}
}
function system_application_controllers_Front_3(&$퍁his, &$pg, &$rb) {
	{
		$fullpath = system_base_Wet_base::$views_path;
		if(file_exists($fullpath)) {
			return is_dir($fullpath);
		} else {
			return false;
		}
		unset($fullpath);
	}
}
