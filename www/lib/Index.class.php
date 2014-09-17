<?php

class Index {
	public function __construct(){}
	static function main() {
		$user_method = null;
		$params = null;
		$route = null;
		$user_class = null;
		$base = system_base_Wet_base::get_instance();
		$cache = system_base_Cache::get_instance();
		$profiler = system_base_Profiler::get_instance();
		$cl = null;
		try {
			{
				if(system_base_Router::$instance === null) {
					system_base_Router::$instance = new system_base_Router();
				}
				$route = system_base_Router::$instance;
			}
			if(!$route->decode_route()) {
				if($route->controller === "_load") {
					system_base_Cache::load_asset($route->method);
				}
				return;
			}
			if(Index_0($base, $cache, $cl, $params, $profiler, $route, $user_class, $user_method)) {
				return;
			}
			$cl = Type::resolveClass("system.application.controllers." . _hx_string_or_null($route->controller));
			if($cl === null) {
				throw new HException(new system_base_Http_exception(_hx_string_or_null($route->controller) . " " . "Not found", 404, _hx_anonymous(array("fileName" => "Index.hx", "lineNumber" => 81, "className" => "Index", "methodName" => "main"))));
			} else {
				$user_class = Type::createInstance($cl, (new _hx_array(array())));
				$user_method = Reflect::field($user_class, $route->method);
				if($user_method === null) {
					throw new HException(new system_base_Http_exception(_hx_string_or_null($route->method) . " " . "Not found", 404, _hx_anonymous(array("fileName" => "Index.hx", "lineNumber" => 89, "className" => "Index", "methodName" => "main"))));
				} else {
					$user_class->set_params($route->params);
					Reflect::callMethod($user_class, $user_method, (new _hx_array(array())));
					Reflect::callMethod($user_class, Reflect::field($user_class, "flush"), (new _hx_array(array())));
				}
			}
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			if(($e = $_ex_) instanceof system_base_Error){
			} else throw $__hx__e;;
		}
		system_base_Database::close();
	}
	function __toString() { return 'Index'; }
}
function Index_0(&$base, &$cache, &$cl, &$params, &$profiler, &$route, &$user_class, &$user_method) {
	{
		$router = null;
		{
			if(system_base_Router::$instance === null) {
				system_base_Router::$instance = new system_base_Router();
			}
			$router = system_base_Router::$instance;
		}
		$hash = $router->query_hash;
		$fullpath = _hx_string_or_null(system_base_Wet_base::$cache_path) . _hx_string_or_null($hash) . ".htm";
		if(!file_exists($fullpath)) {
			return false;
		} else {
			$r_query = $router->query_string;
			$fin = sys_io_File::read($fullpath, false);
			$query = $fin->readLine();
			if($r_query === $query) {
				$etag = null;
				if(file_exists($fullpath)) {
					$stats = sys_FileSystem::stat($fullpath);
					$etag = _hx_string_or_null(StringTools::hex($stats->size, null)) . "-" . _hx_string_or_null(StringTools::hex($stats->ino, null)) . "-" . _hx_string_or_null(_hx_string_call(_hx_string_call($stats->mtime, "toString", array()), "substr", array(17, 2)));
				} else {
					$etag = "";
				}
				if(php_Web::getClientHeader("If-none-match") === $etag) {
					php_Web::setReturnCode(304);
					$fin->close();
					return true;
				} else {
					{
						while(!system_base_Cache::$cookie_buffer->isEmpty()) {
							system_base_Wet_base::send_cookie(system_base_Cache::$cookie_buffer->pop());
						}
						header("X-Powered-By" . ": " . "Webrathea/0.4 (PHP)");
						{
							$value = DateTools::format(Date::now(), "%a, %d %b %Y %X %Z");
							header("Date" . ": " . _hx_string_or_null($value));
						}
						header("X-Frame-Options" . ": " . "sameorigin");
						header("X-XSS-Protection" . ": " . "1; mode=block");
						php_Web::setReturnCode(200);
					}
					{
						$value1 = Std::string(sys_FileSystem::stat($fullpath)->size);
						header("Content-Length" . ": " . _hx_string_or_null($value1));
					}
					header("ETag" . ": " . _hx_string_or_null($etag));
					{
						$m = null;
						{
							$pos = strlen($query);
							$fin1 = sys_io_File::read($fullpath, false);
							$size = sys_FileSystem::stat($fullpath)->size;
							$fin1->seek($pos, sys_io_FileSeek::$SeekBegin);
							$output = $fin1->readString($size - $pos);
							$fin1->close();
							$m = $output;
						}
						$message = null;
						$message = Std::string($m);
						haxe_Log::trace("DEPRECATED FUNCTION: " . _hx_string_or_null($message), _hx_anonymous(array("fileName" => "Base.hx", "lineNumber" => 449, "className" => "system.base.Wet_base", "methodName" => "echo")));
					}
					$fin->close();
					return true;
				}
				unset($etag);
			} else {
				$fin->close();
				return false;
			}
			unset($r_query,$query,$fin);
		}
		unset($router,$hash,$fullpath);
	}
}
