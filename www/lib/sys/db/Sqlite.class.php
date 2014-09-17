<?php

class sys_db_Sqlite {
	public function __construct(){}
	static function open($file) {
		return php_db_PDO::open("sqlite:" . _hx_string_or_null($file), null, null, null);
	}
	function __toString() { return 'sys.db.Sqlite'; }
}
