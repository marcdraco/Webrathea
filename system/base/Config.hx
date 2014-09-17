package system.base;

typedef W = Config;


class Config
{
	inline public static var USE_ETAGS		= true;						// set this to FALSE if you use multiple servers to host your ASSETS (not the database!)
	inline public static var SITE_ROOT		= "http://localhost:8888/";	// where your site base is - with the trailing slash

	public static var _HTML_DOCTYPE			= "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01//EN\"\n\"http://www.w3.org/TR/html4/strict.dtd\">\n";
	public static var _WEBRATHEA_DEBUG		= "
	
		<style type=\"text/css\">
			.__webrathea_debug__ {	font-size:12px;font-family:monospace;background-color:black;color:white;clear:both; 
									width:100%;height:16px;padding:2px;margin-top:20px}
			.__webrathea_echo__ {font-size:12px;font-family:monospace;background-color:white;color:black;
									width:100%;height:32px;padding:2px;text-align:left;}
			.__table__ {text-align:left;font-size:12px;font-family:monospace;}
			.__table__ tr th {text-align:left;background-color:#feffe5;}
			.__table__ tr {text-align:left;background-color:#d6ffcd;}
			.__table2__ tr {text-align:left;font-size:12px;font-family:monospace;}
			.__webrathea_highlight__ {color: red;}
			.__webrathea_itals__ {font-style: italic;}
			.__webrathea_ttime__ {width:110px;cursor:pointer}
			.__webrathea_trace__ {width:900px; font-family:monospace;}
			.__webrathea_dbg__ {font-family:monospace;}
			.__webrathea_inv__ {color:white; background-color:black;}
			.__100px__ {width:100px;}
			.__dcalls__ {width:50px;}
			.__pcent__ {width:30px;}
			.__sqlv__ {color: purple;}
			.__fields__ {color: green;}
			.__literal__ {color: red;}
			.__symbs__ {color: blue;}
			.__funcs__ {color: teal;}
			.__bold__ {font-weight:bold;}
			.__mono__ {font-family:monospace;}
			.__hand__ {cursor: pointer;}
			.__fatal__ {background-color:black; color: white;}
		</style>";

	
	/*
	Stuff visible to the end user!
	*/	
	inline public static var _PAGE_NOT_FOUND		= "Not found";
	inline public static var _METHOD_NOT_FOUND		= "Not found";
	inline public static var _BAD_ARGUMENTS			= "I don't understand your request";
	inline public static var _BAD_URL_STRING		= "Illegal character(s) in URI: ";
	inline public static var _OF					= " of ";

	/*
	Various status messages visible to programmers.... and ONLY programmers!
	*/	
	inline public static var _ATTEMPT_CONNECT		= "Attempting connection to ";
	inline public static var _CONNECTED_IN			= "Connection establised in: ";
	inline public static var _TOTAL_DB_TIME			= "Queries: ";
	inline public static var _TOTAL_RUN_TIME		= "Run time: ";
	inline public static var _TOTAL_CNX_TIME		= "Connecting: ";
	inline public static var _TOTAL_LOG_TIME		= "Base logic: ";
	inline public static var _TOTAL_INSERT			= "&nbsp;&nbsp;Inserting: ";
	inline public static var _TOTAL_SELECT			= "&nbsp;&nbsp;Selecting: ";
	inline public static var _TOTAL_UPDATE			= "&nbsp;&nbsp;Updating: ";
	inline public static var _TOTAL_DELETE			= "&nbsp;&nbsp;Deleting: ";
	inline public static var _TOTAL_PREPARE			= "Preparing: ";
	inline public static var _TOTAL_EXEC			= "Executing: ";
	inline public static var _TOTAL_SET				= "Setting @?: ";
	inline public static var _TOTAL_OTHER			= "Other: ";
	inline public static var _COLLISION				= "Database cache collision running query: ";
	inline public static var _NOT_A_SELECT			= "SQL statment sent to cache was not a SELECT statment";



	/*
	* Static codes for the Profiler to use
	*/

	inline public static var INSERT_TIME		= "INS";
	inline public static var UPDATE_TIME		= "UPD";	
	inline public static var DELETE_TIME		= "DEL";
	inline public static var SELECT_TIME		= "SEL";
	inline public static var OTHER_TIME			= "OTH";
	inline public static var CONNECT_TIME		= "CON";
	inline public static var QUERY_TIME			= "QUE";
	inline public static var LOGIC_TIME			= "LOG";
	inline public static var PREPARE_TIME		= "PRE";
	inline public static var EXEC_TIME			= "EXE";
	inline public static var SET_TIME			= "SET";
	inline public static var TIME_PLACES		= 6;				// decimal places used in time outputting in MySQL
	

	/*
	THROWN errors - end users SHOULD NOT see these!
	*/
	
	inline public static var _WRONG_DB_ARGUMENTS	= "Number of SQL arguments supplied must match the number of placeholders";
	inline public static var _WRONG_DB_TYPE			= "The database type you have requested is not available.";
	inline public static var _ERROR_BUF_PRIMED		= "Error: Output buffer already primed.";
	inline public static var _DESC_TEXT_RQRD		= "Descriptive text is required";
	inline public static var _THIS_IS_A_STUB		= "This function is a stub!";
	inline public static var _NO_DB_CNX_YET			= " connection not established or already closed.";
	inline public static var _FUNC_NOT_RGTD			= " is not registered with the profiler";
	inline public static var _NOT_PRESENT			= " does not exist or cannot be opened for reading";
	inline public static var _PAG_DIV_BY_ZERO		= " results per page must be 1 or larger";
	inline public static var _NO_BASE_URL			= " Base url must be supplied to the paginator";
}