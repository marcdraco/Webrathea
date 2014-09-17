<?php

class system_base_General_error extends system_base_Error {
	public function __construct($message, $Http_Code = null, $info = null) { if(!php_Boot::$skip_constructor) {
		parent::__construct(null,_hx_anonymous(array("fileName" => "Error.hx", "lineNumber" => 41, "className" => "system.base.General_error", "methodName" => "new")));
		{
			$message1 = null;
			$message1 = Std::string($message);
			haxe_Log::trace("DEPRECATED FUNCTION: " . _hx_string_or_null($message1), _hx_anonymous(array("fileName" => "Base.hx", "lineNumber" => 449, "className" => "system.base.Wet_base", "methodName" => "echo")));
		}
	}}
	function __toString() { return 'system.base.General_error'; }
}
