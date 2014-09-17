<?php

class system_base_NoSuchDbexception extends system_base_Error {
	public function __construct($e) { if(!php_Boot::$skip_constructor) {
		parent::__construct(null,_hx_anonymous(array("fileName" => "Error.hx", "lineNumber" => 69, "className" => "system.base.NoSuchDbexception", "methodName" => "new")));
		system_base_Error::wipe(_hx_string_or_null($e) . ": " . "The database type you have requested is not available.");
	}}
	function __toString() { return 'system.base.NoSuchDbexception'; }
}
