<?php

class php_db__Sqlite_SqliteConnection implements php_db_Connection{
	public function __construct($file) {
		if(!php_Boot::$skip_constructor) {
		$this->c = sqlite_open($file, 666, $this->e);
	}}
	public $c;
	public $e;
	public function close() {
		sqlite_close($this->c);
		unset($this->c);
	}
	public function request($s) {
		$h = sqlite_query($this->c, $s, SQLITE_BOTH, $this->e);
		if($h === false) {
			throw new HException("Error while executing " . $s . " (" . $this->e . ")");
		}
		return new php_db__Sqlite_SqliteResultSet($h);
	}
	public function escape($s) {
		return sqlite_escape_string($s);
	}
	public function quote($s) {
		if(_hx_index_of($s, "\x00", null) >= 0) {
			return "x'" . $this->base16_encode($s) . "'";
		}
		return "'" . (sqlite_escape_string($s) . "'");
	}
	public function addValue($s, $v) {
		if(is_int($v) || is_null($v)) {
			$s->b .= $v;
		} else {
			if(is_bool($v)) {
				$s->b .= php_db__Sqlite_SqliteConnection_0($this, $s, $v);
			} else {
				$s->b .= $this->quote(Std::string($v));
			}
		}
	}
	public function lastInsertId() {
		return sqlite_last_insert_rowid($this->c);
	}
	public function dbName() {
		return "SQLite";
	}
	public function startTransaction() {
		$this->request("BEGIN TRANSACTION");
	}
	public function commit() {
		$this->request("COMMIT");
		$this->startTransaction();
	}
	public function rollback() {
		$this->request("ROLLBACK");
		$this->startTransaction();
	}
	public function base16_encode($str) {
		$str = unpack("H" . 2 * strlen($str), $str);
		$str = chunk_split($str[1]);
		return $str;
	}
	public function __call($m, $a) {
		if(isset($this->$m) && is_callable($this->$m))
			return call_user_func_array($this->$m, $a);
		else if(isset($this->»dynamics[$m]) && is_callable($this->»dynamics[$m]))
			return call_user_func_array($this->»dynamics[$m], $a);
		else if('toString' == $m)
			return $this->__toString();
		else
			throw new HException('Unable to call «'.$m.'»');
	}
	function __toString() { return 'php.db._Sqlite.SqliteConnection'; }
}
function php_db__Sqlite_SqliteConnection_0(&$»this, &$s, &$v) {
	if($v) {
		return 1;
	} else {
		return 0;
	}
}
