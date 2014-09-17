<?php

class system_base_Config {
	public function __construct(){}
	static $USE_ETAGS = true;
	static $SITE_ROOT = "http://localhost:8888/";
	static $_HTML_DOCTYPE = "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01//EN\"\x0A\"http://www.w3.org/TR/html4/strict.dtd\">\x0A";
	static $_WEBRATHEA_DEBUG = "\x0A\x09\x0A\x09\x09<style type=\"text/css\">\x0A\x09\x09\x09.__webrathea_debug__ {\x09font-size:12px;font-family:monospace;background-color:black;color:white;clear:both; \x0A\x09\x09\x09\x09\x09\x09\x09\x09\x09width:100%;height:16px;padding:2px;margin-top:20px}\x0A\x09\x09\x09.__webrathea_echo__ {font-size:12px;font-family:monospace;background-color:white;color:black;\x0A\x09\x09\x09\x09\x09\x09\x09\x09\x09width:100%;height:32px;padding:2px;text-align:left;}\x0A\x09\x09\x09.__table__ {text-align:left;font-size:12px;font-family:monospace;}\x0A\x09\x09\x09.__table__ tr th {text-align:left;background-color:#feffe5;}\x0A\x09\x09\x09.__table__ tr {text-align:left;background-color:#d6ffcd;}\x0A\x09\x09\x09.__table2__ tr {text-align:left;font-size:12px;font-family:monospace;}\x0A\x09\x09\x09.__webrathea_highlight__ {color: red;}\x0A\x09\x09\x09.__webrathea_itals__ {font-style: italic;}\x0A\x09\x09\x09.__webrathea_ttime__ {width:110px;cursor:pointer}\x0A\x09\x09\x09.__webrathea_trace__ {width:900px; font-family:monospace;}\x0A\x09\x09\x09.__webrathea_dbg__ {font-family:monospace;}\x0A\x09\x09\x09.__webrathea_inv__ {color:white; background-color:black;}\x0A\x09\x09\x09.__100px__ {width:100px;}\x0A\x09\x09\x09.__dcalls__ {width:50px;}\x0A\x09\x09\x09.__pcent__ {width:30px;}\x0A\x09\x09\x09.__sqlv__ {color: purple;}\x0A\x09\x09\x09.__fields__ {color: green;}\x0A\x09\x09\x09.__literal__ {color: red;}\x0A\x09\x09\x09.__symbs__ {color: blue;}\x0A\x09\x09\x09.__funcs__ {color: teal;}\x0A\x09\x09\x09.__bold__ {font-weight:bold;}\x0A\x09\x09\x09.__mono__ {font-family:monospace;}\x0A\x09\x09\x09.__hand__ {cursor: pointer;}\x0A\x09\x09\x09.__fatal__ {background-color:black; color: white;}\x0A\x09\x09</style>";
	static $_PAGE_NOT_FOUND = "Not found";
	static $_METHOD_NOT_FOUND = "Not found";
	static $_BAD_ARGUMENTS = "I don't understand your request";
	static $_BAD_URL_STRING = "Illegal character(s) in URI: ";
	static $_OF = " of ";
	static $_ATTEMPT_CONNECT = "Attempting connection to ";
	static $_CONNECTED_IN = "Connection establised in: ";
	static $_TOTAL_DB_TIME = "Queries: ";
	static $_TOTAL_RUN_TIME = "Run time: ";
	static $_TOTAL_CNX_TIME = "Connecting: ";
	static $_TOTAL_LOG_TIME = "Base logic: ";
	static $_TOTAL_INSERT = "&nbsp;&nbsp;Inserting: ";
	static $_TOTAL_SELECT = "&nbsp;&nbsp;Selecting: ";
	static $_TOTAL_UPDATE = "&nbsp;&nbsp;Updating: ";
	static $_TOTAL_DELETE = "&nbsp;&nbsp;Deleting: ";
	static $_TOTAL_PREPARE = "Preparing: ";
	static $_TOTAL_EXEC = "Executing: ";
	static $_TOTAL_SET = "Setting @?: ";
	static $_TOTAL_OTHER = "Other: ";
	static $_COLLISION = "Database cache collision running query: ";
	static $_NOT_A_SELECT = "SQL statment sent to cache was not a SELECT statment";
	static $INSERT_TIME = "INS";
	static $UPDATE_TIME = "UPD";
	static $DELETE_TIME = "DEL";
	static $SELECT_TIME = "SEL";
	static $OTHER_TIME = "OTH";
	static $CONNECT_TIME = "CON";
	static $QUERY_TIME = "QUE";
	static $LOGIC_TIME = "LOG";
	static $PREPARE_TIME = "PRE";
	static $EXEC_TIME = "EXE";
	static $SET_TIME = "SET";
	static $TIME_PLACES = 6;
	static $_WRONG_DB_ARGUMENTS = "Number of SQL arguments supplied must match the number of placeholders";
	static $_WRONG_DB_TYPE = "The database type you have requested is not available.";
	static $_ERROR_BUF_PRIMED = "Error: Output buffer already primed.";
	static $_DESC_TEXT_RQRD = "Descriptive text is required";
	static $_THIS_IS_A_STUB = "This function is a stub!";
	static $_NO_DB_CNX_YET = " connection not established or already closed.";
	static $_FUNC_NOT_RGTD = " is not registered with the profiler";
	static $_NOT_PRESENT = " does not exist or cannot be opened for reading";
	static $_PAG_DIV_BY_ZERO = " results per page must be 1 or larger";
	static $_NO_BASE_URL = " Base url must be supplied to the paginator";
	function __toString() { return 'system.base.Config'; }
}
