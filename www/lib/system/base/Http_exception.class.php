<?php

class system_base_Http_exception extends system_base_Error {
	public function __construct($message, $Http_Code, $info = null) { if(!php_Boot::$skip_constructor) {
		parent::__construct(null,_hx_anonymous(array("fileName" => "Error.hx", "lineNumber" => 50, "className" => "system.base.Http_exception", "methodName" => "new")));
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
			php_Web::setReturnCode($Http_Code);
		}
		{
			$message1 = null;
			$message1 = Std::string($message);
			haxe_Log::trace("DEPRECATED FUNCTION: " . _hx_string_or_null($message1), _hx_anonymous(array("fileName" => "Base.hx", "lineNumber" => 449, "className" => "system.base.Wet_base", "methodName" => "echo")));
		}
	}}
	function __toString() { return 'system.base.Http_exception'; }
}
