<?php

class system_base_BadSQLException extends system_base_Error {
	public function __construct($e, $sql = null) { if(!php_Boot::$skip_constructor) {
		parent::__construct(null,_hx_anonymous(array("fileName" => "Error.hx", "lineNumber" => 78, "className" => "system.base.BadSQLException", "methodName" => "new")));
		$strings = null;
		$strings = _hx_string_call($e, "split", array(";"));
		haxe_Log::trace(system_base_Sql_colour::pretify($sql), _hx_anonymous(array("fileName" => "Error.hx", "lineNumber" => 81, "className" => "system.base.BadSQLException", "methodName" => "new")));
		haxe_Log::trace(system_base_Sql_colour::pretify($strings[0]), _hx_anonymous(array("fileName" => "Error.hx", "lineNumber" => 82, "className" => "system.base.BadSQLException", "methodName" => "new")));
		system_base_Error::wipe("SQL said: " . _hx_string_or_null($strings[1]));
	}}
	function __toString() { return 'system.base.BadSQLException'; }
}
