<?php

class system_base_NoConnectionError extends system_base_Error {
	public function __construct($e) { if(!php_Boot::$skip_constructor) {
		parent::__construct(null,_hx_anonymous(array("fileName" => "Error.hx", "lineNumber" => 92, "className" => "system.base.NoConnectionError", "methodName" => "new")));
		system_base_Error::wipe($e);
	}}
	function __toString() { return 'system.base.NoConnectionError'; }
}
