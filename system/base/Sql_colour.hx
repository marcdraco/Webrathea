package system.base;
import system.base.Base;

typedef Skipper = 
{
	var position 	: Int;
	var string		: String;
}

class Sql_colour
{
	static var SPACE		= String.fromCharCode(32);
	static var QUOTES		= String.fromCharCode(34);
	static var QUOTE		= "'";
	static var REV_TICK		= String.fromCharCode(96);
	static var REV_SOLDIUS 	= String.fromCharCode(92);
	static var INDENT		= "&nbsp;&nbsp;&nbsp;";
	
	static var NEWLINE		: EReg = ~/[\n]/g;				 // this is a *nix version Windows is different...
	
	static var TAB			: EReg = ~/[\t]/g;
	
	static var NUMBERS		: EReg = ~/([^0-9+-.]+)/;
	
	static var SYMBOLS		: EReg = ~/(=|!=|<>|<=>|>=|<=|>>|<<|\^|:=|~|\*|\/|\-|\+)/;

	static var FUNCTIONS	: EReg = ~/(ASCII|BIN|BIT_LENGTH|CHAR_LENGTH|CHAR|CHARACTER_LENGTH|CHAR_LENGTH|CONCAT_WS|CONCAT|CONV|ELT|EXPORT_SET|FIELD|FIND_IN_SET|FORMAT|HEX|INSERT|INSTR|LCASE|LEFT|LENGTH|LOWER|LOAD_FILE|LOWER|LOCATE|LPAD|LTRIM|MAKE_SET|MID|OCT|OCTET_LENGTH|LENGTH|ORD|POSITION|LOCATE|QUOTE|REPEAT|REPLACE|REVERSE|RIGHT|RPAD|RTRIM|SOUNDEX|SPACE|STRCMP|SUBSTRING_INDEX|SUBSTRING|SUBSTR|TRIM|UCASE|UPPER|UNHEX|UPPER|ABS|ACOS|ASIN|ATAN2|ATAN|CEIL|CEILING|CONV|COS|COT|DEGREES|CRC32|EXP|FLOOR|LN|TAN|LOG10|LOG2|LOG|MOD|OCT|PI|POW|POWER|RADIANS|RAND|ROUND|SIGN|SIN|SQRT|TRUNCATE|BIT_COUNT|ADDDATE|ADDTIME|CONVERT_TZ|CURDATE|CURRENT_DATE|CURRENT_TIME|CURTIME|DATE_ADD|DATE_FORMAT|DATE_SUB|DATE|DATEDIFF|DAY|DAYOFMONTH|DAYNAME|DAYOFMONTH|DAYOFWEEK|DAYOFYEAR|EXTRACT|FROM_DAYS|FROM_UNIXTIME|GET_FORMAT|HOUR|LOCALTIME|NOW|LOCALTIMESTAMP|MAKEDATE|MAKETIME|MICROSECOND|MINUTE|MONTH|MONTHNAME|MONTHNAME|NOW|PERIOD_ADD|PERIOD_DIFF|QUARTER|SEC_TO_TIME|STR_TO_DATE|SECOND|SUBDATE|DATE_SUB|SUBTIME|SYSDATE|TIME_FORMAT|TIME_TO_SEC|TIME|TIMEDIFF|TIMESTAMP|TIMESTAMPADD|TIMESTAMPDIFF|TO_DAYS|UNIX_TIMESTAMP|UTC_DATE|UTC_TIME|UTC_TIMESTAMP|WEEK|WEEKDAY|WEEKOFYEAR|YEAR|YEARWEEK|BINARYCAST|CONVERT|CASEIF|IFNULL|NULLIF|AES_DECRYPT|AES_ENCRYPT|COMPRESS|DECODE|ENCODE|DES_DECRYPT|DES_ENCRYPT|ENCRYPT|MD5|OLD_PASSWORD|PASSWORD|SHA1|SHA|UNCOMPRESS|UNCOMPRESSED_LENGTH|BENCHMARK|CHARSET|COERCIBILITY|COLLATION|CONNECTION_ID|CURRENT_USER|DATABASE|FOUND_ROWS|LAST_INSERT_ID|ROW_COUNT|SCHEMA|DATABASE|SESSION_USER|USER|SYSTEM_USER|VERSION|DEFAULT|GET_LOCK|INET_ATON|INET_NTOA|IS_FREE_LOCK|IS_USED_LOCK|NAME_CONST|MASTER_POS_WAIT|RAND|RELEASE_LOCK|SLEEP|UUID|UUID_SHORT|VALUES|VARIANCE|VAR_POP|VAR_SAMP|VERSION|AVG|BIT_AND|BIT_OR|BIT_XOR|COUNT(DISTINCT)|COUNT|GROUP_CONCAT|MAX|MIN|STD|STDDEV_POP|STDDEV_SAMP|STDDEV|SUM|VAR_POP|VAR_SAMP|VARIANCE)\(+/ig;

	static var RESERVED	:	EReg = ~/([\0x20\t\n\r\(\))])?(ACCESSIBLE|ADD|ALL|ALTER|ANALYZE|AND|AS|ASC|ASENSITIVE|BEFORE|BETWEEN|BIGINT|BINARY|BLOB|BOTH|BY|CALL|CASCADE|CASE|CHANGE|CHAR|CHARACTER|CHECK|COLLATE|COLUMN|CONDITION|CONSTRAINT|CONTINUE|CONVERT|CREATE|CROSS|CURRENT_DATE|CURRENT_TIME|CURRENT_TIMESTAMP|CURRENT_USER|CURSOR|DATABASE|DATABASES|DAY_HOUR|DAY_MICROSECOND|DAY_MINUTE|DAY_SECOND|DEC|DECIMAL|DECLARE|DEFAULT|DELAYED|DELETE|DESC|DESCRIBE|DETERMINISTIC|DISTINCT|DISTINCTROW|DIV|DOUBLE|DROP|DUAL|EACH|ELSE|ELSEIF|ENCLOSED|ESCAPED|EXISTS|EXIT|EXPLAIN|FALSE|FETCH|FLOAT|FLOAT4|FLOAT8|FOR|FORCE|FOREIGN|FROM|FULLTEXT|GENERAL|GRANT|GROUP|HAVING|HIGH_PRIORITY|HOUR_MICROSECOND|HOUR_MINUTE|HOUR_SECOND|IF|IGNORE|IGNORE_SERVER_IDS|IN|INDEX|INFILE|INNER|INOUT|INSENSITIVE|INSERT|INT|INT1|INT2|INT3|INT4|INT8|INTEGER|INTERVAL|INTO|IS|ITERATE|JOIN|KEY|KEYS|KILL|LEADING|LEAVE|LEFT|LIKE|LIMIT|LINEAR|LINES|LOAD|LOCALTIME|LOCALTIMESTAMP|LOCK|LONG|LONGBLOB|LONGTEXT|LOOP|LOW_PRIORITY|MASTER_HEARTBEAT_PERIOD|MASTER_SSL_VERIFY_SERVER_CERT|MATCH|MAXVALUE|MEDIUMBLOB|MEDIUMINT|MEDIUMTEXT|MIDDLEINT|MINUTE_MICROSECOND|MINUTE_SECOND|MOD|MODIFIES|NATURAL|NOT|NO_WRITE_TO_BINLOG|NULL|NUMERIC|ON|OPTIMIZE|OPTION|OPTIONALLY|OR|ORDER|OUT|OUTER|OUTFILE|PRECISION|PRIMARY|PROCEDURE|PURGE|RANGE|READ|READS|READ_WRITE|REAL|REFERENCES|REGEXP|RELEASE|RENAME|REPEAT|REPLACE|REQUIRE|RESIGNAL|RESTRICT|RETURN|REVOKE|RIGHT|RLIKE|SCHEMA|SCHEMAS|SECOND_MICROSECOND|SELECT|SENSITIVE|SEPARATOR|SET|SHOW|SIGNAL|SLOW|SMALLINT|SPATIAL|SPECIFIC|SQL|SQLEXCEPTION|SQLSTATE|SQLWARNING|SQL_BIG_RESULT|SQL_CALC_FOUND_ROWS|SQL_SMALL_RESULT|SSL|STARTING|STRAIGHT_JOIN|TABLE|TERMINATED|THEN|TINYBLOB|TINYINT|TINYTEXT|TO|TRAILING|TRIGGER|TRUE|UNDO|UNION|UNIQUE|UNLOCK|UNSIGNED|UPDATE|USAGE|USE|USING|UTC_DATE|UTC_TIME|UTC_TIMESTAMP|VALUES|VARBINARY|VARCHAR|VARCHARACTER|VARYING|WHEN|WHERE|WHILE|WITH|WRITE|XOR|YEAR_MONTH|ZEROFILL|REGEXP|RLIKE|WHEN|THEN|ELSE|END) +/ig;



	/*
	*
	* Makes dull SQL a little bit more colourful to help find bugs and W.H.Y.
	*
	*/
	static public function pretify(sql : String) : String
	{

		var position 	= 0;
		var completed	= 0;
		var start		= 0;
		var end			= 0;
		var skips		: Skipper;
		var c 			: String;
		var literals	: Array<String> = new Array();


		
		while(position <= sql.length)
		{
			c = sql.charAt(position++);
			
			switch (c)
			{
				case "\\":									// backslash (reverse solidus) escapes the next character - so we don't process it.
				{
					position += 1;									// skip the backslash and skip the literal - leaving the routine to process a meaningless solidus for the rest of this loop
				}
				
				case "\'":											// if a quotation is found, that means this is a string (colour and ignore it)
				{
					start		= position;
					skips 		= skippy(QUOTE, sql, position);					
					end 		= skips.position;					
					skips 		= now_in_colour(sql, completed, start, end);
					sql 		= skips.string;
					completed	= skips.position;
					position 	= completed + 1;
					
				}

				case "\"":										// if a quotation is found, that means this is a string (colour and ignore it)
				{
					start		= position;
					skips 		= skippy(QUOTES, sql, position);					
					end 		= skips.position;					
					skips 		= now_in_colour(sql, completed, start, end);
					sql 		= skips.string;
					completed	= skips.position;
					position 	= completed + 1;
				}
	
				case "`":										// if a rev tick is found, that means this is a string - probably a field name.
				{
					start		= position;
					skips 		= skippy(REV_TICK, sql, position);					
					end 		= skips.position;					
					skips 		= now_in_colour(sql, completed, start, end, REV_TICK);
					sql 		= skips.string;
					completed	= skips.position;
					position 	= completed + 1;
				}	
			}
		}

		sql = now_in_colour(sql, completed, position, position).string;
		sql = NEWLINE.replace(sql, "<br>");							// convert newlines
		sql = TAB.replace(sql, "&nbsp;&nbsp;&nbsp;&nbsp;");				// convert tabs.
				

		return sql;
	}

	

	/**
	* Colourise a section of an SQL string - ALL sql commands (even quoted ones!) are coloured.
	*
	*
	*/
	
	static private function now_in_colour(old_sql : String, completed : Int, start : Int, end : Int, ?char : String) : Skipper
	{

		var sql = old_sql;
		start 	-= 1;
		
		var done		= sql.substr(0, completed);
		var left 		= sql.substr(completed, start - completed);
		var middle		= sql.substr(start, end - start);
		var right		= sql.substr(end);
						
		if (SYMBOLS.match(left))								
		{
			left = SYMBOLS.replace(left, "<span class=\"__symbs__ __bold__\">$1</span>");									
		}

		if (FUNCTIONS.match(left))
		{
			left = FUNCTIONS.replace(left, "<span class=\"__funcs__ __bold__\">$1(</span>");
		}

		if (RESERVED.match(left))
		{
			left = RESERVED.replace(left, "<span class=\"__sqlv__ __bold__\"> $1$2 </span>");				
		}

		if (! NUMBERS.match(left))																// a match here means this string is a number!
		{
			left = NUMBERS.replace(left, "<span class=\"__literal__\">$1</span>");									
		}
		
		if (char == null)
		{
			left =  done + left + "<span class=\"__literal__\">"+middle+"</span>";
		}
		else
		{
			left =  done + left + "<span class=\"__fields__\">"+middle+"</span>";
		}

		return {position : left.length, string : left + right};
	}
		
	/**
	* Skips a sequence of characters marked out by character "needle"
	*/
	
	static private function skippy(needle : String, sql : String, position : Int) : Skipper
	{
		var c 			: String;
		var string 	= new StringBuf();

		string.add(needle);
		
		do	
		{
			c = sql.charAt(position++);

			if (c == REV_SOLDIUS)									// backslash (reverse solidus) escapes the next character - so we don't process it.
			{
					position += 1;									// skip the backslash and skip the string - leaving the routine to process a meaningless solidus for the rest of this loop
					c = sql.charAt(position);
			}
			
			string.add(c);
		}
		
		while( (c != needle) && position <= sql.length);			//until the closing delimiter is located

		return {position : position, string : string.toString()};
	}
	
	
	/**
	* Generate some white (or not white) space by repeating a character COUNT times.
	* char could easily be the entity &nbsp; (default) but it does not have to be.
	*/
	
	static private function make_indent(count : Int, ?char : String) : String
	{
		var s 	= new StringBuf();
		char = (char == null) ? "&nbsp;" : char;
		
		for (i in 0 ... count)
		{
			s.add(char);
		}
		
		return s.toString();
	}
	
	static private function min(values : Array<Int>) : Int
	{
		throw("Not functional");
		return 0;
	}

	static private function max(values : Array<Int>) : Int
	{
		throw("Not functional");
		return 0;
	}
	

}