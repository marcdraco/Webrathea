<?php

class system_base_Sql_colour {
	public function __construct(){}
	static $SPACE = " ";
	static $QUOTES = "\"";
	static $QUOTE = "'";
	static $REV_TICK = "`";
	static $REV_SOLDIUS = "\\";
	static $INDENT = "&nbsp;&nbsp;&nbsp;";
	static $NEWLINE;
	static $TAB;
	static $NUMBERS;
	static $SYMBOLS;
	static $FUNCTIONS;
	static $RESERVED;
	static function pretify($sql) {
		$position = 0;
		$completed = 0;
		$start = 0;
		$end = 0;
		$skips = null;
		$c = null;
		$literals = new _hx_array(array());
		while($position <= strlen($sql)) {
			$c = _hx_char_at($sql, $position++);
			switch($c) {
			case "\\":{
				$position += 1;
			}break;
			case "'":{
				$start = $position;
				$skips = system_base_Sql_colour::skippy(system_base_Sql_colour::$QUOTE, $sql, $position);
				$end = $skips->position;
				$skips = system_base_Sql_colour::now_in_colour($sql, $completed, $start, $end, null);
				$sql = $skips->string;
				$completed = $skips->position;
				$position = $completed + 1;
			}break;
			case "\"":{
				$start = $position;
				$skips = system_base_Sql_colour::skippy(system_base_Sql_colour::$QUOTES, $sql, $position);
				$end = $skips->position;
				$skips = system_base_Sql_colour::now_in_colour($sql, $completed, $start, $end, null);
				$sql = $skips->string;
				$completed = $skips->position;
				$position = $completed + 1;
			}break;
			case "`":{
				$start = $position;
				$skips = system_base_Sql_colour::skippy(system_base_Sql_colour::$REV_TICK, $sql, $position);
				$end = $skips->position;
				$skips = system_base_Sql_colour::now_in_colour($sql, $completed, $start, $end, system_base_Sql_colour::$REV_TICK);
				$sql = $skips->string;
				$completed = $skips->position;
				$position = $completed + 1;
			}break;
			}
		}
		$sql = system_base_Sql_colour::now_in_colour($sql, $completed, $position, $position, null)->string;
		$sql = system_base_Sql_colour::$NEWLINE->replace($sql, "<br>");
		$sql = system_base_Sql_colour::$TAB->replace($sql, "&nbsp;&nbsp;&nbsp;&nbsp;");
		return $sql;
	}
	static function now_in_colour($old_sql, $completed, $start, $end, $char = null) {
		$sql = $old_sql;
		$start -= 1;
		$done = _hx_substr($sql, 0, $completed);
		$left = _hx_substr($sql, $completed, $start - $completed);
		$middle = _hx_substr($sql, $start, $end - $start);
		$right = _hx_substr($sql, $end, null);
		if(system_base_Sql_colour::$SYMBOLS->match($left)) {
			$left = system_base_Sql_colour::$SYMBOLS->replace($left, "<span class=\"__symbs__ __bold__\">\$1</span>");
		}
		if(system_base_Sql_colour::$FUNCTIONS->match($left)) {
			$left = system_base_Sql_colour::$FUNCTIONS->replace($left, "<span class=\"__funcs__ __bold__\">\$1(</span>");
		}
		if(system_base_Sql_colour::$RESERVED->match($left)) {
			$left = system_base_Sql_colour::$RESERVED->replace($left, "<span class=\"__sqlv__ __bold__\"> \$1\$2 </span>");
		}
		if(!system_base_Sql_colour::$NUMBERS->match($left)) {
			$left = system_base_Sql_colour::$NUMBERS->replace($left, "<span class=\"__literal__\">\$1</span>");
		}
		if($char === null) {
			$left = _hx_string_or_null($done) . _hx_string_or_null($left) . "<span class=\"__literal__\">" . _hx_string_or_null($middle) . "</span>";
		} else {
			$left = _hx_string_or_null($done) . _hx_string_or_null($left) . "<span class=\"__fields__\">" . _hx_string_or_null($middle) . "</span>";
		}
		return _hx_anonymous(array("position" => strlen($left), "string" => _hx_string_or_null($left) . _hx_string_or_null($right)));
	}
	static function skippy($needle, $sql, $position) {
		$c = null;
		$string = new StringBuf();
		$string->add($needle);
		do {
			$c = _hx_char_at($sql, $position++);
			if($c === system_base_Sql_colour::$REV_SOLDIUS) {
				$position += 1;
				$c = _hx_char_at($sql, $position);
			}
			$string->add($c);
		} while($c !== $needle && $position <= strlen($sql));
		return _hx_anonymous(array("position" => $position, "string" => $string->b));
	}
	static function make_indent($count, $char = null) {
		$s = new StringBuf();
		if($char === null) {
			$char = "&nbsp;";
		} else {
			$char = $char;
		}
		{
			$_g = 0;
			while($_g < $count) {
				$i = $_g++;
				$s->add($char);
				unset($i);
			}
		}
		return $s->b;
	}
	static function min($values) {
		throw new HException("Not functional");
		return 0;
	}
	static function max($values) {
		throw new HException("Not functional");
		return 0;
	}
	function __toString() { return 'system.base.Sql_colour'; }
}
system_base_Sql_colour::$NEWLINE = new EReg("[\x0A]", "g");
system_base_Sql_colour::$TAB = new EReg("[\x09]", "g");
system_base_Sql_colour::$NUMBERS = new EReg("([^0-9+-.]+)", "");
system_base_Sql_colour::$SYMBOLS = new EReg("(=|!=|<>|<=>|>=|<=|>>|<<|\\^|:=|~|\\*|/|\\-|\\+)", "");
system_base_Sql_colour::$FUNCTIONS = new EReg("(ASCII|BIN|BIT_LENGTH|CHAR_LENGTH|CHAR|CHARACTER_LENGTH|CHAR_LENGTH|CONCAT_WS|CONCAT|CONV|ELT|EXPORT_SET|FIELD|FIND_IN_SET|FORMAT|HEX|INSERT|INSTR|LCASE|LEFT|LENGTH|LOWER|LOAD_FILE|LOWER|LOCATE|LPAD|LTRIM|MAKE_SET|MID|OCT|OCTET_LENGTH|LENGTH|ORD|POSITION|LOCATE|QUOTE|REPEAT|REPLACE|REVERSE|RIGHT|RPAD|RTRIM|SOUNDEX|SPACE|STRCMP|SUBSTRING_INDEX|SUBSTRING|SUBSTR|TRIM|UCASE|UPPER|UNHEX|UPPER|ABS|ACOS|ASIN|ATAN2|ATAN|CEIL|CEILING|CONV|COS|COT|DEGREES|CRC32|EXP|FLOOR|LN|TAN|LOG10|LOG2|LOG|MOD|OCT|PI|POW|POWER|RADIANS|RAND|ROUND|SIGN|SIN|SQRT|TRUNCATE|BIT_COUNT|ADDDATE|ADDTIME|CONVERT_TZ|CURDATE|CURRENT_DATE|CURRENT_TIME|CURTIME|DATE_ADD|DATE_FORMAT|DATE_SUB|DATE|DATEDIFF|DAY|DAYOFMONTH|DAYNAME|DAYOFMONTH|DAYOFWEEK|DAYOFYEAR|EXTRACT|FROM_DAYS|FROM_UNIXTIME|GET_FORMAT|HOUR|LOCALTIME|NOW|LOCALTIMESTAMP|MAKEDATE|MAKETIME|MICROSECOND|MINUTE|MONTH|MONTHNAME|MONTHNAME|NOW|PERIOD_ADD|PERIOD_DIFF|QUARTER|SEC_TO_TIME|STR_TO_DATE|SECOND|SUBDATE|DATE_SUB|SUBTIME|SYSDATE|TIME_FORMAT|TIME_TO_SEC|TIME|TIMEDIFF|TIMESTAMP|TIMESTAMPADD|TIMESTAMPDIFF|TO_DAYS|UNIX_TIMESTAMP|UTC_DATE|UTC_TIME|UTC_TIMESTAMP|WEEK|WEEKDAY|WEEKOFYEAR|YEAR|YEARWEEK|BINARYCAST|CONVERT|CASEIF|IFNULL|NULLIF|AES_DECRYPT|AES_ENCRYPT|COMPRESS|DECODE|ENCODE|DES_DECRYPT|DES_ENCRYPT|ENCRYPT|MD5|OLD_PASSWORD|PASSWORD|SHA1|SHA|UNCOMPRESS|UNCOMPRESSED_LENGTH|BENCHMARK|CHARSET|COERCIBILITY|COLLATION|CONNECTION_ID|CURRENT_USER|DATABASE|FOUND_ROWS|LAST_INSERT_ID|ROW_COUNT|SCHEMA|DATABASE|SESSION_USER|USER|SYSTEM_USER|VERSION|DEFAULT|GET_LOCK|INET_ATON|INET_NTOA|IS_FREE_LOCK|IS_USED_LOCK|NAME_CONST|MASTER_POS_WAIT|RAND|RELEASE_LOCK|SLEEP|UUID|UUID_SHORT|VALUES|VARIANCE|VAR_POP|VAR_SAMP|VERSION|AVG|BIT_AND|BIT_OR|BIT_XOR|COUNT(DISTINCT)|COUNT|GROUP_CONCAT|MAX|MIN|STD|STDDEV_POP|STDDEV_SAMP|STDDEV|SUM|VAR_POP|VAR_SAMP|VARIANCE)\\(+", "ig");
system_base_Sql_colour::$RESERVED = new EReg("([\\0x20\x09\x0A\x0D\\(\\))])?(ACCESSIBLE|ADD|ALL|ALTER|ANALYZE|AND|AS|ASC|ASENSITIVE|BEFORE|BETWEEN|BIGINT|BINARY|BLOB|BOTH|BY|CALL|CASCADE|CASE|CHANGE|CHAR|CHARACTER|CHECK|COLLATE|COLUMN|CONDITION|CONSTRAINT|CONTINUE|CONVERT|CREATE|CROSS|CURRENT_DATE|CURRENT_TIME|CURRENT_TIMESTAMP|CURRENT_USER|CURSOR|DATABASE|DATABASES|DAY_HOUR|DAY_MICROSECOND|DAY_MINUTE|DAY_SECOND|DEC|DECIMAL|DECLARE|DEFAULT|DELAYED|DELETE|DESC|DESCRIBE|DETERMINISTIC|DISTINCT|DISTINCTROW|DIV|DOUBLE|DROP|DUAL|EACH|ELSE|ELSEIF|ENCLOSED|ESCAPED|EXISTS|EXIT|EXPLAIN|FALSE|FETCH|FLOAT|FLOAT4|FLOAT8|FOR|FORCE|FOREIGN|FROM|FULLTEXT|GENERAL|GRANT|GROUP|HAVING|HIGH_PRIORITY|HOUR_MICROSECOND|HOUR_MINUTE|HOUR_SECOND|IF|IGNORE|IGNORE_SERVER_IDS|IN|INDEX|INFILE|INNER|INOUT|INSENSITIVE|INSERT|INT|INT1|INT2|INT3|INT4|INT8|INTEGER|INTERVAL|INTO|IS|ITERATE|JOIN|KEY|KEYS|KILL|LEADING|LEAVE|LEFT|LIKE|LIMIT|LINEAR|LINES|LOAD|LOCALTIME|LOCALTIMESTAMP|LOCK|LONG|LONGBLOB|LONGTEXT|LOOP|LOW_PRIORITY|MASTER_HEARTBEAT_PERIOD|MASTER_SSL_VERIFY_SERVER_CERT|MATCH|MAXVALUE|MEDIUMBLOB|MEDIUMINT|MEDIUMTEXT|MIDDLEINT|MINUTE_MICROSECOND|MINUTE_SECOND|MOD|MODIFIES|NATURAL|NOT|NO_WRITE_TO_BINLOG|NULL|NUMERIC|ON|OPTIMIZE|OPTION|OPTIONALLY|OR|ORDER|OUT|OUTER|OUTFILE|PRECISION|PRIMARY|PROCEDURE|PURGE|RANGE|READ|READS|READ_WRITE|REAL|REFERENCES|REGEXP|RELEASE|RENAME|REPEAT|REPLACE|REQUIRE|RESIGNAL|RESTRICT|RETURN|REVOKE|RIGHT|RLIKE|SCHEMA|SCHEMAS|SECOND_MICROSECOND|SELECT|SENSITIVE|SEPARATOR|SET|SHOW|SIGNAL|SLOW|SMALLINT|SPATIAL|SPECIFIC|SQL|SQLEXCEPTION|SQLSTATE|SQLWARNING|SQL_BIG_RESULT|SQL_CALC_FOUND_ROWS|SQL_SMALL_RESULT|SSL|STARTING|STRAIGHT_JOIN|TABLE|TERMINATED|THEN|TINYBLOB|TINYINT|TINYTEXT|TO|TRAILING|TRIGGER|TRUE|UNDO|UNION|UNIQUE|UNLOCK|UNSIGNED|UPDATE|USAGE|USE|USING|UTC_DATE|UTC_TIME|UTC_TIMESTAMP|VALUES|VARBINARY|VARCHAR|VARCHARACTER|VARYING|WHEN|WHERE|WHILE|WITH|WRITE|XOR|YEAR_MONTH|ZEROFILL|REGEXP|RLIKE|WHEN|THEN|ELSE|END) +", "ig");
