<?php

class system_base_Dbexception extends system_base_Error {
	public function __construct() { if(!php_Boot::$skip_constructor) {
		parent::__construct(null,_hx_anonymous(array("fileName" => "Error.hx", "lineNumber" => 60, "className" => "system.base.Dbexception", "methodName" => "new")));
		system_base_Error::wipe(" connection not established or already closed.");
	}}
	function __toString() { return 'system.base.Dbexception'; }
}
