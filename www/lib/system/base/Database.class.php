<?php

class system_base_Database {
	public function __construct($dbtype = null, $host = null, $port = null, $socket = null, $user = null, $pass = null, $database = null, $trase = null) {
		if(!php_Boot::$skip_constructor) {
		$timer = null;
		$stoptime = null;
		$profiler = system_base_Profiler::get_instance();
		$db_config = "";
		$config_path = _hx_string_or_null(system_base_Wet_base::$conf_path) . "database.xml";
		try {
			$db_config = sys_io_File::getContent($config_path);
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			$e = $_ex_;
			{
				throw new HException(new system_base_NoFileError(_hx_string_or_null($config_path) . " does not exist or cannot be opened for reading"));
			}
		}
		$xml = Xml::parse($db_config);
		$config = new haxe_xml_Fast($xml->firstElement());
		if($dbtype === null) {
			$dbtype = $config->node->resolve("type")->get_innerHTML();
		} else {
			$dbtype = $dbtype;
		}
		if($user === null) {
			$user = $config->node->resolve("user")->get_innerHTML();
		} else {
			$user = $user;
		}
		if($pass === null) {
			$pass = $config->node->resolve("pass")->get_innerHTML();
		} else {
			$pass = $pass;
		}
		if($port === null) {
			$port = Std::parseInt($config->node->resolve("port")->get_innerHTML());
		} else {
			$port = $port;
		}
		if($socket === null) {
			$socket = $config->node->resolve("socket")->get_innerHTML();
		} else {
			$socket = $socket;
		}
		if($database === null) {
			$database = $config->node->resolve("schema")->get_innerHTML();
		} else {
			$database = $database;
		}
		$timer = new system_base_Timers(null);
		switch($dbtype) {
		case "mysql":{
			if($host === null) {
				$host = $config->node->resolve("host")->get_innerHTML();
			} else {
				$host = $host;
			}
			if($trase) {
				haxe_Log::trace("Attempting connection to " . "MySQL " . _hx_string_or_null($user) . "@" . _hx_string_or_null($host), _hx_anonymous(array("fileName" => "Database.hx", "lineNumber" => 115, "className" => "system.base.Database", "methodName" => "new")));
			}
			try {
				if(system_base_Database::$cnx === null) {
					system_base_Database::$cnx = sys_db_Mysql::connect(_hx_anonymous(array("host" => $host, "port" => $port, "user" => $user, "pass" => $pass, "socket" => $socket, "database" => $database)));
				}
			}catch(Exception $__hx__e) {
				$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
				$e1 = $_ex_;
				{
					throw new HException(new system_base_NoConnectionError($e1));
					return;
				}
			}
			$stoptime = $timer->stop();
		}break;
		case "sqlite":{
			if($host === null) {
				$host = $config->node->resolve("host")->get_innerHTML();
			} else {
				$host = $host;
			}
			if(_hx_index_of($host, "/", null) === -1) {
				$host = _hx_string_or_null(system_base_Wet_base::$datastore_path) . _hx_string_or_null($host);
			} else {
				$host = $host;
			}
			if($trase) {
				haxe_Log::trace("Attempting connection to " . "SQLite@" . _hx_string_or_null($host), _hx_anonymous(array("fileName" => "Database.hx", "lineNumber" => 150, "className" => "system.base.Database", "methodName" => "new")));
			}
			system_base_Database::$cnx = sys_db_Sqlite::open($host);
			$stoptime = $timer->stop();
		}break;
		default:{
			throw new HException(new system_base_NoSuchDbexception($dbtype));
		}break;
		}
		$profiler->increment("CON", $stoptime, null);
	}}
	public $length;
	public $sql;
	public function last_insert_id($dbtype = null) {
		$profiler = system_base_Profiler::get_instance();
		$timer = new system_base_Timers(null);
		$id = system_base_Database::$cnx->lastInsertId();
		$stopped = $timer->stop();
		$profiler->increment("QUE", $stopped, null);
		$profiler->increment("OTH", $stopped, "{System} Last Insert ID");
		return $id;
	}
	public function prepare($user_sql) {
		$sql = "PREPARE __" . Std::string(system_base_Database::$stmnt_id++) . "__ FROM \"" . _hx_string_or_null($user_sql) . "\";";
		try {
			{
				$profiler = system_base_Profiler::get_instance();
				$verb = null;
				$results = null;
				$results = null;
				if(system_base_Database::$cnx === null) {
					throw new HException(new system_base_Dbexception());
				}
				$timer = new system_base_Timers(null);
				try {
					$results = system_base_Database::$cnx->request($sql);
				}catch(Exception $__hx__e) {
					$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
					if(is_string($e = $_ex_)){
						throw new HException(new system_base_BadSQLException($e, $sql));
					} else throw $__hx__e;;
				}
				$stopped = $timer->stop();
				if(system_base_Database::$regexp->match($sql)) {
					$verb = strtoupper(_hx_substr($sql, 0, 3));
					$profiler->increment($verb, $stopped, $sql);
				} else {
					$profiler->increment("OTH", $stopped, $sql);
				}
				$profiler->increment("QUE", $stopped, null);
				$results;
			}
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			if(is_string($e1 = $_ex_)){
				throw new HException(new system_base_BadSQLException($e1, null));
			} else throw $__hx__e;;
		}
		return system_base_Database::$stmnt_id - 1;
	}
	public function execute($stmnt_id, $parameters) {
		$base_charcode = 65;
		$sql = "";
		if($parameters->length !== 0) {
			$sql_vars = "SET ";
			$str_using = "";
			{
				$_g1 = 0;
				$_g = $parameters->length;
				while($_g1 < $_g) {
					$i = $_g1++;
					$sql_vars .= "@" . _hx_string_or_null(chr($base_charcode)) . "=" . "\"" . Std::string(_hx_string_or_null($parameters[$i]) . "\"" . ", ");
					$str_using .= "@" . _hx_string_or_null(chr($base_charcode)) . ", ";
					$base_charcode += 1;
					unset($i);
				}
			}
			$sql_vars = _hx_substr($sql_vars, 0, strlen($sql_vars) - 2);
			$str_using = _hx_substr($str_using, 0, strlen($str_using) - 2);
			$sql = "EXECUTE __" . Std::string($stmnt_id) . "__ USING " . _hx_string_or_null($str_using) . ";";
			try {
				{
					$profiler = system_base_Profiler::get_instance();
					$verb = null;
					$results = null;
					$results = null;
					if(system_base_Database::$cnx === null) {
						throw new HException(new system_base_Dbexception());
					}
					$timer = new system_base_Timers(null);
					try {
						$results = system_base_Database::$cnx->request($sql_vars);
					}catch(Exception $__hx__e) {
						$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
						if(is_string($e = $_ex_)){
							throw new HException(new system_base_BadSQLException($e, $sql_vars));
						} else throw $__hx__e;;
					}
					$stopped = $timer->stop();
					if(system_base_Database::$regexp->match($sql_vars)) {
						$verb = strtoupper(_hx_substr($sql_vars, 0, 3));
						$profiler->increment($verb, $stopped, $sql_vars);
					} else {
						$profiler->increment("OTH", $stopped, $sql_vars);
					}
					$profiler->increment("QUE", $stopped, null);
					$results;
				}
				{
					$profiler1 = system_base_Profiler::get_instance();
					$verb1 = null;
					$results1 = null;
					$results1 = null;
					if(system_base_Database::$cnx === null) {
						throw new HException(new system_base_Dbexception());
					}
					$timer1 = new system_base_Timers(null);
					try {
						$results1 = system_base_Database::$cnx->request($sql);
					}catch(Exception $__hx__e) {
						$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
						if(is_string($e1 = $_ex_)){
							throw new HException(new system_base_BadSQLException($e1, $sql));
						} else throw $__hx__e;;
					}
					$stopped1 = $timer1->stop();
					if(system_base_Database::$regexp->match($sql)) {
						$verb1 = strtoupper(_hx_substr($sql, 0, 3));
						$profiler1->increment($verb1, $stopped1, $sql);
					} else {
						$profiler1->increment("OTH", $stopped1, $sql);
					}
					$profiler1->increment("QUE", $stopped1, null);
					$results1;
				}
			}catch(Exception $__hx__e) {
				$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
				if(is_string($e2 = $_ex_)){
					throw new HException(new system_base_BadSQLException($e2, null));
				} else throw $__hx__e;;
			}
		} else {
			$sql = "EXECUTE " . Std::string($stmnt_id) . ";";
		}
	}
	public function explain($sql, $print = null) {
		$results = $this->analyse_sql($sql);
		if($print) {
			$m = $this->explain_formatted($results, null);
			$message = null;
			$message = Std::string($m);
			haxe_Log::trace("DEPRECATED FUNCTION: " . _hx_string_or_null($message), _hx_anonymous(array("fileName" => "Base.hx", "lineNumber" => 449, "className" => "system.base.Wet_base", "methodName" => "echo")));
		}
		return $this->explain_formatted($results, null);
	}
	public function explain_formatted($pack, $sys_print = null) {
		$s = null;
		$s = $this->explain_table($pack->SQL, $pack->base, system_base_Database::$Explain_array);
		$s .= _hx_string_or_null($this->explain_table($pack->SQL, $pack->analysys, system_base_Database::$Proc_array));
		return $s;
	}
	public function explain_table($sql, $data, $keynames) {
		$dataset = null;
		$output = new StringBuf();
		$output->add("<table class=\"__table__\">");
		$output->add("<tr><td colspan=" . _hx_string_rec($keynames->length, "") . ">");
		$output->add($sql);
		$output->add("</td></tr>");
		$output->add("<tr>");
		{
			$_g1 = 0;
			$_g = $keynames->length;
			while($_g1 < $_g) {
				$i = $_g1++;
				$output->add("<th>" . _hx_string_or_null($keynames[$i]) . "</th>");
				unset($i);
			}
		}
		$output->add("</tr>");
		{
			$_g11 = 0;
			$_g2 = $data->length;
			while($_g11 < $_g2) {
				$i1 = $_g11++;
				$output->add("<tr>");
				$dataset = $data[$i1];
				{
					$_g3 = 0;
					$_g21 = $keynames->length;
					while($_g3 < $_g21) {
						$j = $_g3++;
						if($dataset->exists($keynames[$j])) {
							$output->add("<td>" . _hx_string_or_null($dataset->get($keynames[$j])) . "</td>");
						} else {
							$output->add("<td> </td>");
						}
						unset($j);
					}
					unset($_g3,$_g21);
				}
				$output->add("</tr>");
				unset($i1);
			}
		}
		$output->add("</table>");
		return $output->b;
	}
	public function analyse_sql($sql) {
		$rows = null;
		$dataset = null;
		$base = new _hx_array(array());
		$analysys = new _hx_array(array());
		$resultset = null;
		$row = null;
		$fields = null;
		$field_name = null;
		$rows = system_base_Database::$cnx->request("EXPLAIN EXTENDED " . _hx_string_or_null($sql));
		$resultset = $rows->results();
		{
			$_g1 = 0;
			$_g = $rows->get_length();
			while($_g1 < $_g) {
				$j = $_g1++;
				$dataset = new haxe_ds_StringMap();
				$row = $resultset->pop();
				{
					$_g3 = 0;
					$_g2 = $rows->get_nfields();
					while($_g3 < $_g2) {
						$i = $_g3++;
						$fields = Reflect::fields($row);
						$field_name = $fields[$i];
						if($field_name !== null) {
							$key = strtoupper($field_name);
							$value = Reflect::field($row, $field_name);
							$dataset->set($key, $value);
							unset($value,$key);
						}
						unset($i);
					}
					unset($_g3,$_g2);
				}
				$base[$j] = $dataset;
				unset($j);
			}
		}
		$rows = system_base_Database::$cnx->request("SHOW WARNINGS;");
		$extended = _hx_anonymous(array("Level" => $rows->getResult(0), "Code" => $rows->getResult(1), "Message" => $rows->getResult(2)));
		$rows = system_base_Database::$cnx->request(_hx_string_or_null($sql) . " PROCEDURE ANALYSE()");
		$resultset = $rows->results();
		{
			$_g11 = 0;
			$_g4 = $rows->get_length();
			while($_g11 < $_g4) {
				$j1 = $_g11++;
				$dataset = new haxe_ds_StringMap();
				$row = $resultset->pop();
				{
					$_g31 = 0;
					$_g21 = $rows->get_nfields();
					while($_g31 < $_g21) {
						$i1 = $_g31++;
						$fields = Reflect::fields($row);
						$field_name = $fields[$i1];
						if($field_name !== null) {
							$key1 = strtoupper($field_name);
							$value1 = Reflect::field($row, $field_name);
							$dataset->set($key1, $value1);
							unset($value1,$key1);
						}
						unset($i1);
					}
					unset($_g31,$_g21);
				}
				$analysys[$j1] = $dataset;
				unset($j1);
			}
		}
		return _hx_anonymous(array("SQL" => system_base_Sql_colour::pretify($sql), "base" => $base, "analysys" => $analysys, "extra" => $extended));
	}
	public function deallocate($stmnt_id) {
		$statment_name = "__" . Std::string($stmnt_id) . "__";
	}
	public function __call($m, $a) {
		if(isset($this->$m) && is_callable($this->$m))
			return call_user_func_array($this->$m, $a);
		else if(isset($this->__dynamics[$m]) && is_callable($this->__dynamics[$m]))
			return call_user_func_array($this->__dynamics[$m], $a);
		else if('toString' == $m)
			return $this->__toString();
		else
			throw new HException('Unable to call <'.$m.'>');
	}
	static $stmnt_id = 0;
	static $Explain_array;
	static $Proc_array;
	static $regexp;
	static $instance;
	static $cnx;
	static function get_instance($dbtype = null, $host = null, $port = null, $socket = null, $user = null, $pass = null, $database = null, $trase = null) {
		system_base_Cache::enable_db_profiling();
		if(system_base_Database::$instance === null) {
			system_base_Database::$instance = new system_base_Database($dbtype, $host, $port, $socket, $user, $pass, $database, $trase);
		}
		return system_base_Database::$instance;
	}
	static function query($sql_cmd, $args = null, $explain = null) {
		$usr_sql = null;
		{
			$i = null;
			$usr_sql1 = null;
			$strings = null;
			$strings = _hx_explode("?", $sql_cmd);
			$usr_sql1 = "";
			if(system_base_Database::$cnx === null) {
				throw new HException(new system_base_Dbexception());
			}
			if($args !== null) {
				if($strings->length - 1 !== $args->length) {
					throw new HException("Number of SQL arguments supplied must match the number of placeholders");
				}
				{
					$_g1 = 0;
					$_g = $args->length;
					while($_g1 < $_g) {
						$i1 = $_g1++;
						if(Reflect::isObject($args[$i1])) {
							$usr_sql1 .= _hx_string_or_null($strings[$i1]) . "\"" . _hx_string_or_null(system_base_Database::$cnx->escape($args[$i1])) . "\"";
						} else {
							$usr_sql1 .= _hx_string_or_null($strings[$i1]) . _hx_string_or_null($args[$i1]);
						}
						unset($i1);
					}
				}
				if($strings->length > 0) {
					$usr_sql1 .= _hx_string_or_null($strings[$strings->length - 1]);
				}
			} else {
				$usr_sql1 = $sql_cmd;
			}
			if($explain) {
				system_base_Sql_colour::pretify($usr_sql1);
			}
			$usr_sql = $usr_sql1;
		}
		$profiler = system_base_Profiler::get_instance();
		$verb = null;
		$results = null;
		$results = null;
		if(system_base_Database::$cnx === null) {
			throw new HException(new system_base_Dbexception());
		}
		$timer = new system_base_Timers(null);
		try {
			$results = system_base_Database::$cnx->request($usr_sql);
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			if(is_string($e = $_ex_)){
				throw new HException(new system_base_BadSQLException($e, $usr_sql));
			} else throw $__hx__e;;
		}
		$stopped = $timer->stop();
		if(system_base_Database::$regexp->match($usr_sql)) {
			$verb = strtoupper(_hx_substr($usr_sql, 0, 3));
			$profiler->increment($verb, $stopped, $usr_sql);
		} else {
			$profiler->increment("OTH", $stopped, $usr_sql);
		}
		$profiler->increment("QUE", $stopped, null);
		return $results;
	}
	static function parse_query($sql_cmd, $args = null, $explain = null) {
		$i = null;
		$usr_sql = null;
		$strings = null;
		$strings = _hx_explode("?", $sql_cmd);
		$usr_sql = "";
		if(system_base_Database::$cnx === null) {
			throw new HException(new system_base_Dbexception());
		}
		if($args !== null) {
			if($strings->length - 1 !== $args->length) {
				throw new HException("Number of SQL arguments supplied must match the number of placeholders");
			}
			{
				$_g1 = 0;
				$_g = $args->length;
				while($_g1 < $_g) {
					$i1 = $_g1++;
					if(Reflect::isObject($args[$i1])) {
						$usr_sql .= _hx_string_or_null($strings[$i1]) . "\"" . _hx_string_or_null(system_base_Database::$cnx->escape($args[$i1])) . "\"";
					} else {
						$usr_sql .= _hx_string_or_null($strings[$i1]) . _hx_string_or_null($args[$i1]);
					}
					unset($i1);
				}
			}
			if($strings->length > 0) {
				$usr_sql .= _hx_string_or_null($strings[$strings->length - 1]);
			}
		} else {
			$usr_sql = $sql_cmd;
		}
		if($explain) {
			system_base_Sql_colour::pretify($usr_sql);
		}
		return $usr_sql;
	}
	static function run_query($usr_sql) {
		$profiler = system_base_Profiler::get_instance();
		$verb = null;
		$results = null;
		$results = null;
		if(system_base_Database::$cnx === null) {
			throw new HException(new system_base_Dbexception());
		}
		$timer = new system_base_Timers(null);
		try {
			$results = system_base_Database::$cnx->request($usr_sql);
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			if(is_string($e = $_ex_)){
				throw new HException(new system_base_BadSQLException($e, $usr_sql));
			} else throw $__hx__e;;
		}
		$stopped = $timer->stop();
		if(system_base_Database::$regexp->match($usr_sql)) {
			$verb = strtoupper(_hx_substr($usr_sql, 0, 3));
			$profiler->increment($verb, $stopped, $usr_sql);
		} else {
			$profiler->increment("OTH", $stopped, $usr_sql);
		}
		$profiler->increment("QUE", $stopped, null);
		return $results;
	}
	static function cached_query($sql_cmd, $args = null, $dirty_pages = null) {
		$s_args = $args->join(":");
		$header = _hx_string_or_null($sql_cmd) . _hx_string_or_null($s_args);
		$filename = _hx_string_or_null(system_base_Wet_base::$cache_path) . _hx_string_rec(system_base_Hashes::do_hash($header), "");
		$resultset = null;
		$cached_results = null;
		$rows = new HList();
		$data = null;
		$total_rows = null;
		$results = null;
		$return_data = _hx_anonymous(array("rows" => $rows, "total_rows" => 0));
		if(strtoupper(_hx_substr(ltrim($sql_cmd), 0, 6)) !== "SELECT") {
			system_base_Database::get_instance(null, null, null, null, null, null, null, null);
			$resultset = system_base_Database::query($sql_cmd, $args, null);
			return _hx_anonymous(array("rows" => $resultset->results(), "total_rows" => $resultset->get_length()));
		}
		if(file_exists($filename)) {
			$fin = sys_io_File::read($filename, false);
			$results = $fin->readLine();
			if($results === $header) {
				$cached_results = $fin->readLine();
				$return_data = haxe_Unserializer::run($cached_results);
			} else {
				{
					$m = "Database cache collision running query: " . _hx_string_or_null($sql_cmd) . "\x0A";
					$m = Std::string(Date::now()) . ": " . _hx_string_or_null($m);
				}
				system_base_Database::get_instance(null, null, null, null, null, null, null, null);
				$resultset = system_base_Database::query($sql_cmd, $args, null);
				return _hx_anonymous(array("rows" => $resultset->results(), "total_rows" => $resultset->get_length()));
			}
		} else {
			system_base_Database::get_instance(null, null, null, null, null, null, null, null);
			$resultset = system_base_Database::query($sql_cmd, $args, null);
			$data = haxe_Serializer::run(_hx_anonymous(array("rows" => $resultset->results(), "total_rows" => $resultset->get_length())));
			$fout = sys_io_File::write($filename, false);
			$fout->writeString(_hx_string_or_null($header) . "\x0A");
			$fout->writeString(_hx_string_or_null($data) . "\x0A");
			$fout->close();
		}
		return $return_data;
	}
	static function close() {
		if(system_base_Database::$cnx !== null) {
			system_base_Database::$cnx->close();
		}
		system_base_Cache::disable_db_profiling();
		system_base_Database::$cnx = null;
		system_base_Database::$instance = null;
	}
	static function sprint_float($v, $places) {
		$sql = "SELECT FORMAT(" . Std::string($v) . "," . Std::string($places) . ") AS n;";
		return system_base_Database::$cnx->request($sql)->results()->first()->n;
	}
	function __toString() { return 'system.base.Database'; }
}
system_base_Database::$Explain_array = (new _hx_array(array("ID", "SELECT_TYPE", "TABLE", "TYPE", "POSSIBLE_KEYS", "KEY", "KEY_LEN", "REF", "ROWS", "EXTRA")));
system_base_Database::$Proc_array = (new _hx_array(array("FIELD_NAME", "MIN_VALUE", "MAX_VALUE", "MIN_LENGTH", "MAX_LENGTH", "EMPTIES_OR_ZEROS", "NULLS", "AVG_VALUE_OR_AVG_LENGTH", "STD", "OPTIMAL_FIELDTYPE")));
system_base_Database::$regexp = new EReg("^(SELECT|UPDATE|INSERT|DELETE|PREPARE|EXECUTE|SET)", "i");
