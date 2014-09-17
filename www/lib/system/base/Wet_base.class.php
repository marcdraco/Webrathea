<?php

class system_base_Wet_base {
	public function __construct() { if(!php_Boot::$skip_constructor) {
		{
			$p = realpath(".");
			if(($p === false)) {
				system_base_Wet_base::$root_directory = null;
			} else {
				system_base_Wet_base::$root_directory = $p;
			}
		}
		system_base_Wet_base::$root_directory .= "/lib";
		system_base_Wet_base::$asset_path = _hx_string_or_null(system_base_Wet_base::$root_directory) . "/" . "system/application/assets/";
		system_base_Wet_base::$cache_path = _hx_string_or_null(system_base_Wet_base::$root_directory) . "/" . "system/application/cache/";
		system_base_Wet_base::$datastore_path = _hx_string_or_null(system_base_Wet_base::$root_directory) . "/" . "system/application/datastore/";
		system_base_Wet_base::$views_path = _hx_string_or_null(system_base_Wet_base::$root_directory) . "/" . "system/application/views/";
		system_base_Wet_base::$conf_path = _hx_string_or_null(system_base_Wet_base::$root_directory) . "/" . "system/application/config/";
	}}
	static $instance;
	static $asset_path;
	static $datastore_path;
	static $cache_path;
	static $root_directory;
	static $views_path;
	static $conf_path;
	static function get_instance() {
		if(system_base_Wet_base::$instance === null) {
			system_base_Wet_base::$instance = new system_base_Wet_base();
		}
		return system_base_Wet_base::$instance;
	}
	static function create_asset_src($path) {
		return "src=\"" . "http://localhost:8888/" . "?_load/" . _hx_string_or_null($path) . "\"";
	}
	static function make_link($uri, $link_text, $attribs = null) {
		return "<a href=\"" . Std::string($uri) . "\"" . _hx_string_or_null($attribs->insert_attributes()) . ">" . _hx_string_or_null($link_text) . "</a>";
	}
	static function make_http_link($uri, $link_text = null, $attribs = null) {
		return "<a href=\"" . Std::string("http://" . _hx_string_or_null($uri)) . "\"" . _hx_string_or_null($attribs->insert_attributes()) . ">" . _hx_string_or_null(((($link_text === null) ? $uri : $link_text))) . "</a>";
	}
	static function set_cookie($key, $value, $expire = null, $domain = null, $path = null, $secure = null) {
		system_base_Cache::cache_cookie(_hx_anonymous(array("key" => $key, "value" => $value, "expire" => $expire, "domain" => $domain, "path" => $path, "secure" => $secure)));
	}
	static function send_cookie($c) {
		php_Web::setCookie($c->key, $c->value, $c->expire, $c->domain, $c->path, $c->secure, null);
	}
	static function get_file_etag($fullpath) {
		if(file_exists($fullpath)) {
			$stats = sys_FileSystem::stat($fullpath);
			return _hx_string_or_null(StringTools::hex($stats->size, null)) . "-" . _hx_string_or_null(StringTools::hex($stats->ino, null)) . "-" . _hx_string_or_null(_hx_string_call(_hx_string_call($stats->mtime, "toString", array()), "substr", array(17, 2)));
		} else {
			return "";
		}
	}
	static function set_file_etag($fullpath) {
		$filename = null;
		$pathname = null;
		if(file_exists($fullpath)) {
			haxe_Log::trace(system_base_Wet_base::parse_file_path($fullpath)->filename, _hx_anonymous(array("fileName" => "Base.hx", "lineNumber" => 217, "className" => "system.base.Wet_base", "methodName" => "set_file_etag")));
			haxe_Log::trace(_hx_string_or_null(system_base_Wet_base::parse_file_path($fullpath)->pathname) . "/" . _hx_string_or_null((system_base_Wet_base_0($filename, $fullpath, $pathname))), _hx_anonymous(array("fileName" => "Base.hx", "lineNumber" => 218, "className" => "system.base.Wet_base", "methodName" => "set_file_etag")));
		}
	}
	static function get_random_cache_dir() {
		return chr(_hx_mod(Date::now()->getSeconds(), 26) + 65);
	}
	static function parse_file_path($fullpath) {
		$pos = _hx_last_index_of($fullpath, "/", null);
		if($pos === -1) {
			return _hx_anonymous(array("pathname" => "", "filename" => ""));
		}
		return _hx_anonymous(array("pathname" => _hx_substr($fullpath, 0, $pos), "filename" => _hx_substr($fullpath, $pos + 1, null)));
	}
	static function open_asset($path) {
		$fullpath = _hx_string_or_null(system_base_Wet_base::$asset_path) . _hx_string_or_null($path);
		if(file_exists($fullpath)) {
			return sys_io_File::read($fullpath, false);
		}
		return null;
	}
	static function open_image_asset($path) {
		$fullpath = _hx_string_or_null(system_base_Wet_base::$asset_path) . _hx_string_or_null($path);
		if(file_exists($fullpath)) {
			return sys_io_File::getBytes($fullpath);
		}
		return null;
	}
	static function get_http_headers() {
		return php_Web::getClientHeaders();
	}
	static function get_http_method() {
		return php_Web::getMethod();
	}
	static function get_modified_since_header() {
		return php_Web::getClientHeader("If-modified-since");
	}
	static function get_etag_header() {
		return php_Web::getClientHeader("If-none-match");
	}
	static function is_directory($fullpath) {
		if(file_exists($fullpath)) {
			return is_dir($fullpath);
		} else {
			return false;
		}
	}
	static function get_MD5_cookies() {
		return haxe_crypto_Md5::encode(Std::string(php_Web::getCookies()));
	}
	static function get_param_string() {
		$s = php_Web::getParamsString();
		return urldecode($s);
	}
	static function get_referrer() {
		return php_Web::getClientHeader("Referer");
	}
	static function get_full_path() {
		$p = realpath(".");
		if(($p === false)) {
			return null;
		} else {
			return $p;
		}
	}
	static function get_file_content($fullpath) {
		return sys_io_File::getContent($fullpath);
	}
	static function get_bin_content($fullpath) {
		return sys_io_File::getBytes($fullpath);
	}
	static function get_ascii_content($fullpath) {
		return sys_io_File::read($fullpath, false);
	}
	static function get_ascii_from($fullpath, $pos) {
		$fin = sys_io_File::read($fullpath, false);
		$size = sys_FileSystem::stat($fullpath)->size;
		$fin->seek($pos, sys_io_FileSeek::$SeekBegin);
		$output = $fin->readString($size - $pos);
		$fin->close();
		return $output;
	}
	static function hecho($m) {
		$message = null;
		$message = Std::string($m);
		haxe_Log::trace("DEPRECATED FUNCTION: " . _hx_string_or_null($message), _hx_anonymous(array("fileName" => "Base.hx", "lineNumber" => 449, "className" => "system.base.Wet_base", "methodName" => "echo")));
	}
	static function get_read_handle($fullpath, $binary = null) {
		if($binary === null) {
			$binary = false;
		}
		return sys_io_File::read($fullpath, $binary);
	}
	static function get_write_handle($fullpath, $binary = null) {
		if($binary === null) {
			$binary = false;
		}
		return sys_io_File::write($fullpath, $binary);
	}
	static function log_error($m) {
		$m = Std::string(Date::now()) . ": " . _hx_string_or_null($m);
	}
	static function get_hostname() {
		return $_SERVER['SERVER_NAME'];
	}
	static function file_exists($fullpath) {
		return file_exists($fullpath);
	}
	static function get_file_stat($fullpath) {
		return sys_FileSystem::stat($fullpath);
	}
	static function _set_cookie($c) {
		php_Web::setCookie($c->key, $c->value, $c->expire, $c->domain, $c->path, $c->secure, null);
	}
	static function send_header($header, $value) {
		header(_hx_string_or_null($header) . ": " . _hx_string_or_null($value));
	}
	static function set_return_code($r) {
		php_Web::setReturnCode($r);
	}
	function __toString() { return 'system.base.Wet_base'; }
}
function system_base_Wet_base_0(&$filename, &$fullpath, &$pathname) {
	if(file_exists($fullpath)) {
		$stats = sys_FileSystem::stat($fullpath);
		return _hx_string_or_null(StringTools::hex($stats->size, null)) . "-" . _hx_string_or_null(StringTools::hex($stats->ino, null)) . "-" . _hx_string_or_null(_hx_string_call(_hx_string_call($stats->mtime, "toString", array()), "substr", array(17, 2)));
	} else {
		return "";
	}
}
