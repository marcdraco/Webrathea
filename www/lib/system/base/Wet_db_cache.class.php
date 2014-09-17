<?php

class system_base_Wet_db_cache {
	public function __construct(){}
	static $db;
	static $cache;
	static function get_instance() {
		if(system_base_Wet_db_cache::$db === null) {
			system_base_Wet_db_cache::$db = system_base_Database::get_instance("mysql", null, null, null, null, null, null, null);
		}
		return system_base_Wet_db_cache::$db;
	}
	function __toString() { return 'system.base.Wet_db_cache'; }
}
