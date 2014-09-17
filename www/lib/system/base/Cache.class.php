<?php

class system_base_Cache {
	public function __construct() { if(!php_Boot::$skip_constructor) {
		system_base_Cache::init_profile_buffer();
		haxe_Log::$trace = (isset($this->wet_trace) ? $this->wet_trace: array($this, "wet_trace"));
	}}
	public function toString() {
		return Std::string(system_base_Cache::$output_buffer);
	}
	public function fast_body_is_closed() {
		return system_base_Cache::$output_buffer->fast_body_is_closed();
	}
	public function body_is_closed() {
		return system_base_Cache::$output_buffer->body_is_closed();
	}
	public function append($s) {
		system_base_Cache::$output_buffer->append($s);
	}
	public function insert_description($content, $suppress_warnings = null) {
		if($content === null || strlen($content) === 0) {
			throw new HException("Descriptive text is required");
		}
		if(strlen($content) > 155 && $suppress_warnings !== true) {
			$content = _hx_substr($content, 0, 154);
		}
		$this->insert_meta("description", $content);
	}
	public function insert_http_equiv($tag, $content) {
		system_base_Cache::$output_buffer->insert_after("<head>", "<meta http-equiv=\"" . _hx_string_or_null($tag) . "\" content=\"" . _hx_string_or_null($content) . "\">\x0A", null);
	}
	public function insert_meta($tag, $content) {
		system_base_Cache::$output_buffer->insert_after("<head>", "<meta name=\"" . _hx_string_or_null($tag) . "\" content=\"" . _hx_string_or_null($content) . "\">\x0A", null);
	}
	public function insert_css_file($path) {
		system_base_Cache::$output_buffer->insert_before("</head>", "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . _hx_string_or_null($path) . "\" />\x0A");
	}
	public function inject_style($css, $definition = null) {
		if($definition === null) {
			system_base_Cache::$output_buffer->insert_before("</head>", "<style type=\"text/css\">" . _hx_string_or_null($css) . "</style>\x0A");
		} else {
			system_base_Cache::$output_buffer->insert_before("</head>", "<style type=\"text/css\">" . _hx_string_or_null($css) . " {" . _hx_string_or_null($definition) . "}</style>\x0A");
		}
	}
	public function inline_javascript($script) {
		system_base_Cache::$output_buffer->append("<script type=\"text/javascript\">" . _hx_string_or_null(system_base_Cache::$HTML_REM_ON) . _hx_string_or_null(system_base_Cache::$CDATA_ON) . _hx_string_or_null($script) . _hx_string_or_null(system_base_Cache::$CDATA_OFF) . _hx_string_or_null(system_base_Cache::$HTML_REM_OF) . "</script>");
	}
	public function external_javascript($src) {
		system_base_Cache::$javascript_buffer->append("<script type=\"text/javascript\" src=\"" . _hx_string_or_null($src) . "\"></script>");
	}
	public function external_vbscript($src) {
		system_base_Cache::$javascript_buffer->append("<script type=\"text/vbscript\" src=\"" . _hx_string_or_null($src) . "\"></script>");
	}
	public function dump_buffer() {
		system_base_Cache::$output_buffer->reset();
	}
	public function debug_message($m) {
		if(strlen(system_base_Cache::$debug_buffer->b) === 0) {
			system_base_Cache::init_debug_buffer();
		}
		system_base_Cache::$debug_buffer->append(Std::string($m));
	}
	public function wet_trace($v, $inf = null) {
		$profiler = system_base_Profiler::get_instance();
		$run_time = system_base_Profiler::lap();
		$m = new StringBuf();
		$trase = null;
		$trase = Std::string($v);
		$m->add("<tr><td class=\"__webrathea_ttime__\"");
		$m->add("title=\"Line: " . _hx_string_rec($inf->lineNumber, ""));
		$m->add(" of " . _hx_string_or_null($inf->fileName));
		$m->add(" [" . _hx_string_or_null($inf->methodName) . "]");
		$m->add("\x0A in " . _hx_string_or_null($inf->className));
		$m->add(" \">");
		$m->add(Std::string($run_time) . ": </td>");
		$m->add("<td class=\"__webrathea_trace__\">");
		$m->add($trase);
		$m->add("</td></tr>");
		$this->debug_message($m->b);
	}
	static $HTML_REM_ON = "\x0A<!--\x0A";
	static $HTML_REM_OF = "//-->\x0A";
	static $CDATA_ON = "//<![CDATA[\x0A";
	static $CDATA_OFF = "\x0A//]]>\x0A";
	static $output_buffer;
	static $cookie_buffer;
	static $javascript_buffer;
	static $debug_buffer;
	static $profile_buffer;
	static $profile_sql = false;
	static $return_code = 200;
	static $entity_tag = "";
	static $instance;
	static $debugging = true;
	static $mime_type;
	static function get_instance() {
		if(system_base_Cache::$instance === null) {
			system_base_Cache::$instance = new system_base_Cache();
		}
		return system_base_Cache::$instance;
	}
	static function get_mime_type($path) {
		$ext = strtolower(_hx_substr($path, _hx_last_index_of($path, ".", null) + 1, null));
		return Reflect::field(system_base_Cache::$mime_type, $ext);
	}
	static function enable_db_profiling() {
		system_base_Cache::$profile_sql = true;
	}
	static function disable_db_profiling() {
		system_base_Cache::$profile_sql = false;
	}
	static function cache_cookie($cookie) {
		system_base_Cache::$cookie_buffer->push($cookie);
	}
	static function display_cache() {
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
			} else {
				$fin->close();
				return false;
			}
		}
	}
	static function load_asset($pathname) {
		$fullpath = _hx_string_or_null(system_base_Wet_base::$asset_path) . _hx_string_or_null($pathname);
		$etag = null;
		if(file_exists($fullpath)) {
			$stats = sys_FileSystem::stat($fullpath);
			$etag = _hx_string_or_null(StringTools::hex($stats->size, null)) . "-" . _hx_string_or_null(StringTools::hex($stats->ino, null)) . "-" . _hx_string_or_null(_hx_string_call(_hx_string_call($stats->mtime, "toString", array()), "substr", array(17, 2)));
		} else {
			$etag = "";
		}
		if($etag === "") {
			throw new HException(new system_base_Http_exception("", 404, _hx_anonymous(array("fileName" => "Cache.hx", "lineNumber" => 294, "className" => "system.base.Cache", "methodName" => "load_asset"))));
		}
		{
			if(php_Web::getClientHeader("If-none-match") === $etag) {
				php_Web::setReturnCode(304);
				return;
			}
			{
				$value = null;
				$value = system_base_Cache_0($etag, $fullpath, $pathname, $value);
				header("Content-Type" . ": " . _hx_string_or_null($value));
			}
			header("ETag" . ": " . _hx_string_or_null($etag));
		}
		{
			$value1 = Std::string(sys_FileSystem::stat($fullpath)->size);
			header("Content-Length" . ": " . _hx_string_or_null($value1));
		}
		{
			$m = null;
			{
				$_this = sys_io_File::getBytes($fullpath);
				$m = $_this->b;
			}
			$message = null;
			$message = Std::string($m);
			haxe_Log::trace("DEPRECATED FUNCTION: " . _hx_string_or_null($message), _hx_anonymous(array("fileName" => "Base.hx", "lineNumber" => 449, "className" => "system.base.Wet_base", "methodName" => "echo")));
		}
	}
	static function cache_to_disk() {
		$router = null;
		{
			if(system_base_Router::$instance === null) {
				system_base_Router::$instance = new system_base_Router();
			}
			$router = system_base_Router::$instance;
		}
		$hash = $router->query_hash;
		$query = $router->query_string;
		$fout = sys_io_File::write(_hx_string_or_null(system_base_Wet_base::$cache_path) . _hx_string_or_null($hash) . ".htm", false);
		$fout->writeString(_hx_string_or_null($query) . "\x0A" . _hx_string_or_null(system_base_Cache::$output_buffer->toString()));
		$fout->close();
		{
			$fullpath = _hx_string_or_null(system_base_Wet_base::$cache_path) . _hx_string_or_null($hash) . ".htm";
			if(file_exists($fullpath)) {
				$stats = sys_FileSystem::stat($fullpath);
				return _hx_string_or_null(StringTools::hex($stats->size, null)) . "-" . _hx_string_or_null(StringTools::hex($stats->ino, null)) . "-" . _hx_string_or_null(_hx_string_call(_hx_string_call($stats->mtime, "toString", array()), "substr", array(17, 2)));
			} else {
				return "";
			}
		}
	}
	static function flush() {
		$stop_time = system_base_Profiler::stop();
		system_base_Cache::add_script_cache();
		if(system_base_Cache::$debugging) {
			system_base_Cache::add_debug_cache();
			system_base_Cache::add_benchmark_cache();
		}
		if(system_base_Cache::$output_buffer->get_length() !== 0) {
			system_base_Cache::$return_code = 200;
			try {
				$route = null;
				{
					if(system_base_Router::$instance === null) {
						system_base_Router::$instance = new system_base_Router();
					}
					$route = system_base_Router::$instance;
				}
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
					php_Web::setReturnCode(system_base_Cache::$return_code);
				}
				{
					$value1 = DateTools::format(Date::now(), "%a, %d %b %Y %X %Z");
					header("Last-modified" . ": " . _hx_string_or_null($value1));
				}
				header("Content-Type" . ": " . "text/html");
				{
					$value2 = Std::string(system_base_Cache::$output_buffer->get_length());
					header("Content-Length" . ": " . _hx_string_or_null($value2));
				}
				header("Cache-Control" . ": " . "max-age=3600");
				{
					$value3 = system_base_Cache::cache_to_disk();
					header("ETag" . ": " . _hx_string_or_null($value3));
				}
			}catch(Exception $__hx__e) {
				$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
				$e = $_ex_;
				{
				}
			}
			{
				$message = null;
				$message = Std::string(system_base_Cache::$output_buffer);
				haxe_Log::trace("DEPRECATED FUNCTION: " . _hx_string_or_null($message), _hx_anonymous(array("fileName" => "Base.hx", "lineNumber" => 449, "className" => "system.base.Wet_base", "methodName" => "echo")));
			}
		}
	}
	static function flush_log() {
		system_base_Cache::$output_buffer->reset();
		system_base_Cache::$output_buffer->append("<html><head></head><body></body></html>");
		system_base_Cache::init_debug_buffer();
		system_base_Cache::add_debug_cache();
		if(system_base_Cache::$output_buffer->get_length() !== 0) {
			$message = null;
			$message = Std::string(system_base_Cache::$output_buffer);
			haxe_Log::trace("DEPRECATED FUNCTION: " . _hx_string_or_null($message), _hx_anonymous(array("fileName" => "Base.hx", "lineNumber" => 449, "className" => "system.base.Wet_base", "methodName" => "echo")));
		}
	}
	static function send_basic_headers($return_code) {
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
		php_Web::setReturnCode($return_code);
	}
	static function add_debug_cache() {
		if(strlen(system_base_Cache::$debug_buffer->b) === 0) {
			return;
		}
		system_base_Cache::$debug_buffer->append("</table>");
		if(system_base_Cache::$output_buffer->get_length() === 0) {
			system_base_Cache::$output_buffer->append("<html><head></head><body>");
		}
		if(!system_base_Cache::$output_buffer->body_is_closed()) {
			system_base_Cache::$output_buffer->append("</body></html>");
		}
		system_base_Cache::$output_buffer->insert_before("</body>", system_base_Cache::$debug_buffer->b);
	}
	static function add_script_cache() {
		if(strlen(system_base_Cache::$javascript_buffer->b) === 0) {
			return;
		}
		if(!system_base_Cache::$output_buffer->body_is_closed()) {
			system_base_Cache::$output_buffer->append("</body></html>");
		}
		system_base_Cache::$output_buffer->insert_before("</body>", system_base_Cache::$javascript_buffer->b);
	}
	static function add_benchmark_cache() {
		$profiler = system_base_Profiler::get_instance();
		$stop_time = system_base_Profiler::stop();
		system_base_Pcall::set_stop_time($stop_time);
		system_base_Cache::$profile_buffer->append("<table class='__table__'><tr>");
		system_base_Cache::$profile_buffer->append("<th class='__100px__'>Function</th>");
		system_base_Cache::$profile_buffer->append("<th class='__dcalls__'>Calls</th>");
		system_base_Cache::$profile_buffer->append("<th class='__100px__'>Total</th>");
		system_base_Cache::$profile_buffer->append("<th class='__100px__'>Fastest</th>");
		system_base_Cache::$profile_buffer->append("<th class='__100px__'>Slowest</th>");
		system_base_Cache::$profile_buffer->append("<th class='__pcent__'>%</th>");
		system_base_Cache::$profile_buffer->append("<th class='__pcent__'>Avg.%</th>");
		system_base_Cache::$profile_buffer->append("</tr>");
		system_base_Cache::benchmark_message(system_base_Cache::format_profiler_t_total("Run time: ", $stop_time));
		system_base_Cache::benchmark_message(system_base_Cache::format_profiler_message("Base logic: ", $profiler->get("LOG")));
		if(system_base_Cache::$profile_sql) {
			system_base_Cache::benchmark_message(system_base_Cache::format_profiler_message("Connecting: ", $profiler->get("CON")));
			system_base_Cache::benchmark_message(system_base_Cache::format_profiler_message("Queries: ", $profiler->get("QUE")));
			system_base_Cache::benchmark_message(system_base_Cache::format_profiler_message("&nbsp;&nbsp;Inserting: ", $profiler->get("INS")));
			system_base_Cache::benchmark_message(system_base_Cache::format_profiler_message("&nbsp;&nbsp;Updating: ", $profiler->get("UPD")));
			system_base_Cache::benchmark_message(system_base_Cache::format_profiler_message("&nbsp;&nbsp;Selecting: ", $profiler->get("SEL")));
			system_base_Cache::benchmark_message(system_base_Cache::format_profiler_message("&nbsp;&nbsp;Deleting: ", $profiler->get("DEL")));
			system_base_Cache::benchmark_message(system_base_Cache::format_profiler_message("Preparing: ", $profiler->get("PRE")));
			system_base_Cache::benchmark_message(system_base_Cache::format_profiler_message("Executing: ", $profiler->get("EXE")));
			system_base_Cache::benchmark_message(system_base_Cache::format_profiler_message("Setting @?: ", $profiler->get("SET")));
			system_base_Cache::benchmark_message(system_base_Cache::format_profiler_message("Other: ", $profiler->get("OTH")));
		}
		system_base_Cache::$profile_buffer->append("</table>");
		if(system_base_Cache::$profile_sql) {
			system_base_Cache::explain_all();
		}
		if(!system_base_Cache::$output_buffer->body_is_closed()) {
			system_base_Cache::$output_buffer->append("</body></html>");
		}
		system_base_Cache::$output_buffer->insert_before("</body>", system_base_Cache::$profile_buffer->b);
	}
	static function format_profiler_message($type, $instance) {
		$t = new StringBuf();
		if($instance->calls > 0) {
			$t->add("<td>" . _hx_string_or_null($type) . "</td>");
			$t->add("<td>" . Std::string($instance->calls) . "</td>");
			$t->add("<td>" . _hx_string_or_null(system_base_Database::sprint_float($instance->time, 6)) . "</td>");
			$t->add("<td class=\"__hand__\" title = '" . Std::string($instance->fast_sql) . "'>" . _hx_string_or_null(system_base_Database::sprint_float($instance->fast, 6)) . "</td>");
			$t->add("<td class=\"__hand__\" title = '" . Std::string($instance->slow_sql) . "'>" . _hx_string_or_null(system_base_Database::sprint_float($instance->slow, 6)) . "</td>");
			$t->add("<td>" . Std::string($instance->percentf(null)) . "</td>");
			$t->add("<td>" . Std::string(Math::round($instance->percent(null) / $instance->calls)) . "%</td>");
			return $t->b;
		} else {
			$t->add("<td>" . _hx_string_or_null($type) . "</td>");
			$t->add("<td></td>");
			$t->add("<td></td>");
			$t->add("<td></td>");
			$t->add("<td></td>");
			$t->add("<td></td>");
			$t->add("<td></td>");
			return $t->b;
		}
	}
	static function format_profiler_t_total($type, $t) {
		if(system_base_Cache::$profile_sql) {
			return "<td>" . _hx_string_or_null($type) . "</td><td></td><td>" . _hx_string_or_null(system_base_Database::sprint_float($t, 6)) . "</td><td></td><td></td><td></td>";
		} else {
			return "<td>" . _hx_string_or_null($type) . "</td><td></td><td>" . Std::string($t) . "</td><td></td><td></td><td></td>";
		}
	}
	static function explain_all() {
		$profiler = system_base_Profiler::get_instance();
		$db = system_base_Database::get_instance(null, null, null, null, null, null, null, null);
		if(strlen($profiler->get("SEL")->slow_sql) > 1) {
			system_base_Cache::$profile_buffer->append("<div class=\"__webrathea_debug__\">Webrathea Engine Slow Query Analysys</div>");
			system_base_Cache::$profile_buffer->append($db->explain($profiler->get("SEL")->slow_sql, false));
		}
	}
	static function benchmark_message($m) {
		if(strlen(system_base_Cache::$profile_buffer->b) === 0) {
			system_base_Cache::init_profile_buffer();
		}
		system_base_Cache::$profile_buffer->append("<tr>" . Std::string($m) . "</tr>");
	}
	static function init_debug_buffer() {
		system_base_Cache::$output_buffer->insert_after("<head>", system_base_Config::$_WEBRATHEA_DEBUG, null);
		if(strlen(system_base_Cache::$debug_buffer->b) === 0) {
			system_base_Cache::$debug_buffer->append("<div class=\"__webrathea_debug__\">Webrathea Engine Debug</div>");
			system_base_Cache::$debug_buffer->append("<table class=\"__table2__\" style=\"width:100%\">");
		}
	}
	static function init_profile_buffer() {
		system_base_Cache::$profile_buffer->append("<div class=\"__webrathea_debug__\">Webrathea Engine Profiler</div>");
	}
	function __toString() { return $this->toString(); }
}
system_base_Cache::$output_buffer = new system_base_String_buffer(system_base_Config::$_HTML_DOCTYPE);
system_base_Cache::$cookie_buffer = new HList();
system_base_Cache::$javascript_buffer = new system_base_Buffer();
system_base_Cache::$debug_buffer = new system_base_Buffer();
system_base_Cache::$profile_buffer = new system_base_Buffer();
system_base_Cache::$mime_type = _hx_anonymous(array("acx" => "application/internet-property-stream", "ai" => "application/postscript", "aif" => "audio/x-aiff", "aifc" => "audio/x-aiff", "aiff" => "audio/x-aiff", "asf" => "video/x-ms-asf", "asr" => "video/x-ms-asf", "asx" => "video/x-ms-asf", "au" => "audio/basic", "avi" => "video/x-msvideo", "axs" => "application/olescript", "bas" => "text/plain", "bcpio" => "application/x-bcpio", "bin" => "application/octet-stream", "bmp" => "image/bmp", "c" => "text/plain", "cat" => "application/vnd.ms-pkiseccat", "cdf" => "application/x-cdf", "cer" => "application/x-x509-ca-cert", "clp" => "application/x-msclip", "cmx" => "image/x-cmx", "cod" => "image/cis-cod", "cpio" => "application/x-cpio", "crd" => "application/x-mscardfile", "crl" => "application/pkix-crl", "crt" => "application/x-x509-ca-cert", "csh" => "application/x-csh", "css" => "text/css", "dcr" => "application/x-director", "der" => "application/x-x509-ca-cert", "dir" => "application/x-director", "dll" => "application/x-msdownload", "dms" => "application/octet-stream", "doc" => "application/msword", "docx" => "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "dot" => "application/msword", "dvi" => "application/x-dvi", "dxr" => "application/x-director", "eps" => "application/postscript", "etx" => "text/x-setext", "evy" => "application/envoy", "exe" => "application/octet-stream", "fif" => "application/fractals", "flr" => "x-world/x-vrml", "gif" => "image/gif", "gtar" => "application/x-gtar", "gz" => "application/x-gzip", "h" => "text/plain", "hdf" => "application/x-hdf", "hlp" => "application/winhlp", "hqx" => "application/mac-binhex40", "hta" => "application/hta", "htc" => "text/x-component", "htm" => "text/html", "html" => "text/html", "htt" => "text/webviewhtml", "ico" => "image/x-icon", "ief" => "image/ief", "iii" => "application/x-iphone", "ins" => "application/x-internet-signup", "isp" => "application/x-internet-signup", "jfif" => "image/pipeg", "jpe" => "image/jpeg", "jpeg" => "image/jpeg", "jpg" => "image/jpeg", "js" => "application/x-javascript", "latex" => "application/x-latex", "lha" => "application/octet-stream", "lsf" => "video/x-la-asf", "lsx" => "video/x-la-asf", "lzh" => "application/octet-stream", "m13" => "application/x-msmediaview", "m14" => "application/x-msmediaview", "m3u" => "audio/x-mpegurl", "man" => "application/x-troff-man", "mdb" => "application/x-msaccess", "me" => "application/x-troff-me", "mht" => "message/rfc822", "mhtml" => "message/rfc822", "mid" => "audio/mid", "mny" => "application/x-msmoney", "mov" => "video/quicktime", "movie" => "video/x-sgi-movie", "mp2" => "video/mpeg", "mp3" => "audio/mpeg", "mpa" => "video/mpeg", "mpe" => "video/mpeg", "mpeg" => "video/mpeg", "mpg" => "video/mpeg", "mpp" => "application/vnd.ms-project", "mpv2" => "video/mpeg", "ms" => "application/x-troff-ms", "mvb" => "application/x-msmediaview", "nws" => "message/rfc822", "oda" => "application/oda", "p10" => "application/pkcs10", "p12" => "application/x-pkcs12", "p7b" => "application/x-pkcs7-certificates", "p7c" => "application/x-pkcs7-mime", "p7m" => "application/x-pkcs7-mime", "p7r" => "application/x-pkcs7-certreqresp", "p7s" => "application/x-pkcs7-signature", "pbm" => "image/x-portable-bitmap", "pdf" => "application/pdf", "pfx" => "application/x-pkcs12", "pgm" => "image/x-portable-graymap", "pko" => "application/ynd.ms-pkipko", "pma" => "application/x-perfmon", "pmc" => "application/x-perfmon", "pml" => "application/x-perfmon", "pmr" => "application/x-perfmon", "pmw" => "application/x-perfmon", "pnm" => "image/x-portable-anymap", "pot" => "application/vnd.ms-powerpoint", "ppm" => "image/x-portable-pixmap", "pps" => "application/vnd.ms-powerpoint", "ppt" => "application/vnd.ms-powerpoint", "pptx" => "application/vnd.openxmlformats-officedocument.presentationml.presentation", "prf" => "application/pics-rules", "ps" => "application/postscript", "pub" => "application/x-mspublisher", "qt" => "video/quicktime", "ra" => "audio/x-pn-realaudio", "ram" => "audio/x-pn-realaudio", "ras" => "image/x-cmu-raster", "rgb" => "image/x-rgb", "rmi" => "audio/mid", "roff" => "application/x-troff", "rtf" => "application/rtf", "rtx" => "text/richtext", "scd" => "application/x-msschedule", "sct" => "text/scriptlet", "setpay" => "application/set-payment-initiation", "setreg" => "application/set-registration-initiation", "sh" => "application/x-sh", "shar" => "application/x-shar", "sit" => "application/x-stuffit", "snd" => "audio/basic", "spc" => "application/x-pkcs7-certificates", "spl" => "application/futuresplash", "src" => "application/x-wais-source", "sst" => "application/vnd.ms-pkicertstore", "stl" => "application/vnd.ms-pkistl", "stm" => "text/html", "svg" => "image/svg+xml", "sv4cpio" => "application/x-sv4cpio", "sv4crc" => "application/x-sv4crc", "swf" => "application/x-shockwave-flash", "t" => "application/x-troff", "tar" => "application/x-tar", "tcl" => "application/x-tcl", "tex" => "application/x-tex", "texi" => "application/x-texinfo", "texinfo" => "application/x-texinfo", "tgz" => "application/x-compressed", "tif" => "image/tiff", "tiff" => "image/tiff", "tr" => "application/x-troff", "trm" => "application/x-msterminal", "tsv" => "text/tab-separated-values", "txt" => "text/plain", "uls" => "text/iuls", "ustar" => "application/x-ustar", "vcf" => "text/x-vcard", "vrml" => "x-world/x-vrml", "wav" => "audio/x-wav", "wcm" => "application/vnd.ms-works", "wdb" => "application/vnd.ms-works", "wks" => "application/vnd.ms-works", "wmf" => "application/x-msmetafile", "wps" => "application/vnd.ms-works", "wri" => "application/x-mswrite", "wrl" => "x-world/x-vrml", "wrz" => "x-world/x-vrml", "xaf" => "x-world/x-vrml", "xbm" => "image/x-xbitmap", "xla" => "application/vnd.ms-excel", "xlc" => "application/vnd.ms-excel", "xlm" => "application/vnd.ms-excel", "xls" => "application/vnd.ms-excel", "xlsx" => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", "xlt" => "application/vnd.ms-excel", "xlw" => "application/vnd.ms-excel", "xof" => "x-world/x-vrml", "xpm" => "image/x-xpixmap", "xwd" => "image/x-xwindowdump", "z" => "application/x-compress", "zip" => "application/zip"));
function system_base_Cache_0(&$etag, &$fullpath, &$pathname, &$value) {
	{
		$ext = strtolower(_hx_substr($fullpath, _hx_last_index_of($fullpath, ".", null) + 1, null));
		return Reflect::field(system_base_Cache::$mime_type, $ext);
	}
}
