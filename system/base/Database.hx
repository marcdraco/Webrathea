package system.base;
import system.base.Config;
import system.base.Base;
import system.base.Cache;
import system.base.Error;
import system.base.Hashes;
import system.base.Profiler;
import system.base.Sql_colour;
import system.base.Timers;

typedef Extended_Explain = 
{
	var Level 			: String;
	var Code 			: String;
	var Message 		: String;
}

typedef Hush_array = Array<Map<String, String>>;

typedef Arr_String = Array<String>;

typedef ResultSet = sys.db.ResultSet;

typedef Cached_result =
{
	var total_rows	: Int;
	var rows		: List<Dynamic>;
}

typedef Sql_explanation = 
{
	var SQL 			: String;
	var base 			: Hush_array;
	var analysys 		: Hush_array;	
	var extra 			: Extended_Explain;	
}

class Database
{	
	private static var stmnt_id			= 0;
	private static var Explain_array	= ["ID","SELECT_TYPE","TABLE","TYPE","POSSIBLE_KEYS","KEY","KEY_LEN","REF","ROWS","EXTRA"];
	private static var Proc_array		= ["FIELD_NAME", "MIN_VALUE", "MAX_VALUE", "MIN_LENGTH", "MAX_LENGTH", "EMPTIES_OR_ZEROS", "NULLS", "AVG_VALUE_OR_AVG_LENGTH", "STD", "OPTIMAL_FIELDTYPE"];

	private static var regexp   : EReg  = ~/^(SELECT|UPDATE|INSERT|DELETE|PREPARE|EXECUTE|SET)/i;

	private var length			: Int;
	private var sql				: String;
	static private var instance	: Database;
	static private var cnx 		: sys.db.Connection; 

	/**
	* Constructor creates a connection to a database
	* The SQlite factory is special in that it operates on a FILE
	* so the HOST parameter is the filename (database name)
	* but can be an absolute path too.
	*
	* If just a filename is supplied, SQlite will work on a 
	* the magic system path DATASTORE which is in your 
	* application folder and should be read/writable by Apache etc. but protected from World access.
	* If you supply a path, that will be used instead 
	* (this is the recommended method) you can put the database out of reach.
	* Giving TRUE to the trace element gets the syste to output connection information.
	*/
	

	static public function get_instance(?dbtype : String, ?host : String, ?port : Int, ?socket : String, ?user : String, ?pass : String, ?database : String, ?trase : Bool)
	{
		WC.enable_db_profiling();

		if (instance == null)
		{
			instance = new Database(dbtype, host, port, socket, user, pass, database, trase);
		}

		return instance;
	}
	
	private function new(?dbtype : String, ?host : String, ?port : Int, ?socket : String, ?user : String, ?pass : String, ?database : String, ?trase : Bool)
	{
		var timer 		: Timers;
		var stoptime	: Float;
		var profiler	= Profiler.get_instance();
		var db_config	= "";
		var config_path	= WB.conf_path + "database.xml";

		try
		{
			db_config		= WB.get_file_content(config_path);
		}
		catch (e : Dynamic)
		{
			throw new NoFileError(config_path + W._NOT_PRESENT);
		}

		var xml 	= Xml.parse(db_config);
		var config 	= new haxe.xml.Fast(xml.firstElement());

		dbtype		= (dbtype 	== null) ? config.node.type.innerHTML 				: dbtype;
		user		= (user 	== null) ? config.node.user.innerHTML 				: user;
		pass		= (pass 	== null) ? config.node.pass.innerHTML 				: pass;
		port		= (port 	== null) ? Std.parseInt(config.node.port.innerHTML) : port;
		socket		= (socket 	== null) ? config.node.socket.innerHTML 			: socket;
		database 	= (database == null) ? config.node.schema.innerHTML 			: database;
				
		timer		= new Timers();
		
		switch(dbtype)
		{
			case "mysql" :
			{
				host = (host == null) ? config.node.host.innerHTML : host;
	
				if (trase)
				{
					trace(W._ATTEMPT_CONNECT + "MySQL " + user + "@"+host);
				}
				
				try
				{
					if (cnx == null)
					{
						cnx = 
							sys.db.Mysql.connect({ 
							host		: host,
							port 		: port,
							user 		: user,
							pass 		: pass,
							socket 		: socket,
							database 	: database
						});
					}
				}
				
				catch (e : Dynamic)
				{
					throw new NoConnectionError(e); return;
				}
				
				stoptime = timer.stop();

			}

			case "sqlite" :
			{
				host 	= (host == null)				? config.node.host.innerHTML 	: host;				
				host	= (host.indexOf("/") == -1 ) 	? WB.datastore_path + host		: host;				

				if (trase)
				{
					trace(W._ATTEMPT_CONNECT + "SQLite@"+host);
				}

				cnx		=
					sys.db.Sqlite.open( 
					host
				);
				
				stoptime = timer.stop();
			}			
			
			default:
			{				
				throw new NoSuchDbexception(dbtype);
			}
		}
		
		profiler.increment(W.CONNECT_TIME, stoptime);
	}

	/*
	* Run a query against the datbase. Note the "TRACE" boolean - if set to TRUE, this TRACES the full SQL back 
	* to the debugging console making it simpler to debug malformed SQL statements.
	* SQL_cmd is the string SQL statement with positional ?s and the arguments follow in an array.
	* The arguments array is not required for basic statements.
	* Arguments are automatically escaped.
	* @param sql_cmd A correctly formatted SQL statement; arguments can be inserted at the points marked by a ?
	* @param args A dynamic array containing the arguments to be matched to the placeholders - strings are automatically escaped.
	* @param explain set to true to have SQL explain how the query will be performed. Experimental.
	*/

	static public function query(sql_cmd : String, ? args : Array<Dynamic>, ?explain : Bool) : ResultSet
	{ 
		return run_query(parse_query(sql_cmd, args, explain));
	}
		
	/*
	* Parse and escape "?" in a SQL string. Used interally by Webrathea but public to allow external access.
	* Normal developers should not need to call this function except for debugging.
	* @See query
	*/

	inline static public function parse_query(sql_cmd : String, ? args : Array<Dynamic>, ?explain : Bool) : String
	{
		var i 			: Int;
		var usr_sql 	: String;				// the user (SQL supplied to the API)
		var strings 	: Array<String>;
							
		strings			= sql_cmd.split("?");	// sql_cmd will be later PREPARED by SQL.
		usr_sql 		= "";

		if (cnx == null)
		{
			throw new Dbexception();
		}
		
		if (args != null)
		{

			if ( (strings.length -1) != args.length )
			{
				throw(W._WRONG_DB_ARGUMENTS);
			}		

			for (i in 0...args.length)
			{
				if (Reflect.isObject(args[i]))
				{
					usr_sql += strings[i] + "\"" + cnx.escape(args[i]) + "\"";
				}
				else
				{
					usr_sql += strings[i] + args[i];
				}
			}
			if (strings.length > 0)
			{
				usr_sql += strings[strings.length -1];
			}
		}
		else 
		{
			usr_sql = sql_cmd;
		}
		
		if (explain)
		{
			Sql_colour.pretify(usr_sql);
		}
		return usr_sql;
	}
	
	inline static public function run_query(usr_sql : String) : Dynamic
	{
		var profiler	= Profiler.get_instance();
		var verb		: String;

		var results     : sys.db.ResultSet;

		results = null;
		
		if (cnx == null)
		{
			throw new Dbexception();
		}
		
		var timer		= new Timers();			// start the clock for this run
		
		try
		{
			results = cnx.request(usr_sql);
		}
		catch(e : String)
		{
			throw new BadSQLException(e, usr_sql);	
		}
		
		var stopped		= timer.stop();				// stop the clock as soon as poss!

		
		if (regexp.match(usr_sql))					// check it's a query I recognise... strictly, not really needed but a sanity check.
		{

			verb = (usr_sql.substr(0,3)).toUpperCase();
			{
				profiler.increment(verb, stopped, usr_sql);
			}
			
		}
		else
		{
			profiler.increment(W.OTHER_TIME, stopped, usr_sql);

		}
		profiler.increment(W.QUERY_TIME, stopped);
		
		return results;
	}


	/**
	* Does a cached SQL query - caching to the local file store. Tracing is not used here. 
	* The filename is generated from a simple hash based on the SQL command (has to be
	* a SELECT, other things dirty the cache). The data is seralised and stored in the File
	* together with the full SQL string to ensure collisions do not return the wrong info!
	* @param dirty_pages This is list of all the TABLES that are used in this query.
	* to ensure that the garbage collector only clears caches that are involved in subsquent writes.
	* @see query()
	* @see TODO GARBAGE COLLECTION!
	* @see TODO This could impliment an auto function to automatically cache functions that take more than N uSeconds to complete.
	* @see TODO A function to FORCE an overwrite on collision might be useful.
	*/

	static public function cached_query(sql_cmd : String, ? args : Array<Dynamic>, ?dirty_pages : List<String>) : Cached_result
	{
		var s_args 			= args.join(":");							// serialize the args as the exact format of the final string is not important - just a unique - we're not converting back!
		var header 			= sql_cmd + s_args;
		var filename 		= WB.cache_path + Hashes.do_hash(header);
		var resultset 		: ResultSet;
		var cached_results	: String;
		var rows	 		: List<Dynamic> = new List();
		var data 			: String;
		var total_rows		: Int;
		var results 		: String;
		var return_data		: Cached_result = {rows : rows, total_rows : 0};

		// only SELECT statements make any sense.
				
		if ((StringTools.ltrim(sql_cmd)).substr(0,6).toUpperCase() != "SELECT")
		{			
			get_instance();
			resultset = query(sql_cmd, args);
			return ({rows : resultset.results(), total_rows : resultset.length});
		}
		
		if (WB.file_exists(filename))
		{
			var fin 	= WB.get_read_handle(filename);			
			results 	= fin.readLine();

			if (results == header)
			{
				cached_results 	= fin.readLine();
				return_data		= haxe.Unserializer.run(cached_results);
			}
			else
			{
				// Not cached, so we run the query as per normal!
				WB.log_error(W._COLLISION + sql_cmd + "\n");
				get_instance();
				resultset = query(sql_cmd, args);
				return ({rows : resultset.results(), total_rows : resultset.length});
			}
		}
		
		else
		{
			// This query isn't cached - so we'll execute and cache it for later use.
			get_instance();
			resultset		= query(sql_cmd, args);
			data 			= haxe.Serializer.run({rows : resultset.results(), total_rows : resultset.length});
			var fout		= WB.get_write_handle(filename);
			fout.writeString(header + "\n");
		    fout.writeString(data + "\n");
    		fout.close();
		}
		return return_data;
	}

	/*
	* Wrapper around lastinsertID
	*/
	public function last_insert_id(?dbtype : String) : Int
	{
		var profiler	= Profiler.get_instance();
		var timer		= new Timers();		// start the clock for this run
		var id 			= cnx.lastInsertId();
		var stopped 	= timer.stop();
		
		profiler.increment(W.QUERY_TIME, stopped);
		profiler.increment(W.OTHER_TIME, stopped,"{System} Last Insert ID");
		
		return id;
	}

	/*
	* Closes the current connection
	*/

	static public function close() : Void
	{
		if (cnx != null)
		{
			cnx.close();
		}

		WC.disable_db_profiling();
		cnx = null;
		instance = null;
	}
	
	/*
	* Prepares a MySQL statement and returns the reference for deallocation
	*
	*/
	
	public function prepare(user_sql : String) : Int
	{		
		var sql 		= "PREPARE __" + Std.string(stmnt_id ++) + "__ FROM \"" + user_sql + "\";";
		try 
		{
			run_query(sql);
		}
		catch (e : String)
		{
			throw new BadSQLException(e);
		}
		return stmnt_id-1;
	}

	/*
	* Execute a prepared statement
	*
	*/
	
	public function execute(stmnt_id : Int, parameters : Array<Dynamic>) : Void
	{
		var base_charcode	= 65;		// the letter A - used for the naming variables. 
		var sql 			= "";

		if (parameters.length != 0)
		{
			var sql_vars	= "SET ";
			var str_using	= "";
			
			for (i in 0...parameters.length)
			{
				sql_vars		+= "@" + String.fromCharCode(base_charcode) + "=" + "\"" + Std.string(parameters[i] + "\"" + ", ");
				str_using		+= "@" + String.fromCharCode(base_charcode) + ", ";
				base_charcode	+= 1;
			}
			
			sql_vars	= sql_vars.substr(0,sql_vars.length -2);
			str_using	= str_using.substr(0,str_using.length -2);			
			sql			= "EXECUTE __" + Std.string(stmnt_id) + "__ USING " + str_using + ";";

			try 
			{
				run_query(sql_vars);
				run_query(sql);
			}
			catch (e : String)
			{
				throw new BadSQLException(e);
			}
		}
		else
		{
			sql = "EXECUTE " + Std.string(stmnt_id) + ";";
		}				
	}


	/*
	* Explains an MySQL statement and a lot more!
	*/
	
	public function explain(sql : String, ?print : Bool) : String
	{
		var results = analyse_sql(sql);
		if (print)
		{
			WB.echo(explain_formatted(results));
		}
		return (explain_formatted(results));
	}


	/** 
	* Possible fieldnames (not all present in every instance)
	* ID, SELECT_TYPE, TABLE, TYPE, POSSIBLE_KEYS, KEY, KEY_LEN, REF, ROWS, EXTRA
	* See: http://dev.mysql.com/doc/refman/5.0/en/explain-output.html
	* for more information
	*/

	private function explain_formatted(pack : Sql_explanation, ?sys_print : Bool) : String
	{
		var s : String;
		s = explain_table(pack.SQL, pack.base, Explain_array);
		s += explain_table(pack.SQL, pack.analysys, Proc_array);
		return(s);
		
	}

	private function explain_table(sql : String, data : Hush_array, keynames : Arr_String) : String
	{
		var dataset 	: Map<String, String>;
		var output 		= new StringBuf();
	
		// Build a new table
		output.add("<table class=\"__table__\">");
		output.add("<tr><td colspan=" + keynames.length + ">");
		output.add(sql);
		output.add("</td></tr>");

		// Now put the headings in over a new row.
		output.add("<tr>");
				
		for (i in 0 ... keynames.length)
		{
			output.add("<th>" + keynames[i] + "</th>");
		}		
		
		output.add("</tr>");


		// OK, now iterate over the actual data
		for (i in 0 ... data.length)
		{
			output.add("<tr>");

			dataset = data[i];							// get a reference to the hash - these are key=value pairs from SQL
	
			for (j in 0 ... keynames.length)			// get the key names in a decent order!
			{
				if (dataset.exists(keynames[j]))		// and see if those keys are set - adding the ones that are
				{
					output.add("<td>" + dataset.get(keynames[j]) + "</td>");
				}
				else
				{
					output.add("<td> </td>");				
				}
			}
			
			output.add("</tr>");
		}
		
		output.add("</table>");
		
		return output.toString();
	}

	/*
	* Asks MySQL to explains an SQL statement
	* This returns an extended syntax which repeats the precise query used by MySQL **supposedly!.
	*
	*/
	
	private function analyse_sql(sql : String) : Sql_explanation
	{
		var rows 			: sys.db.ResultSet;
		var dataset			: Map<String,String>;
		var base			: Array<Map<String,String>> = new Array();
		var analysys		: Array<Map<String,String>> = new Array();
		var resultset		: List<Dynamic>;
		var row				: Dynamic;
		var fields			: Dynamic;
		var field_name 		: String;
		
		rows 				= cnx.request("EXPLAIN EXTENDED " + sql);
		
		resultset 			= rows.results();			// Resultset is a list of 1 (OR more) hashes.

		for (j in 0 ... rows.length)					// iterate over each row (usually only 1 or 2 but could be more!)
		{
			dataset = new Map();						// The array (base[n]) stores REFERENCES to the hash - so we need a new one for each row.
			row = resultset.pop();						// Get the row that's been returned...

			for (i in 0 ... rows.nfields)				// iterate over the fieldnames in this row
			{
				fields 		=  Reflect.fields(row);		// don't know what the fields are called or how many there are at compile time
				field_name 	= (fields[i]); 				// this might even be NULL!

				if (field_name != null)					// when not NULL, reflect the field (COLUMN) name from the ROW object
				{
					dataset.set(field_name.toUpperCase(), Reflect.field(row, field_name));
				}				
			}
			base[j] = dataset;							// and finally, store the reference to the hash.
		}
		
		rows 				= cnx.request("SHOW WARNINGS;");
			
		var extended : Extended_Explain = 
		{ 
			Level	: rows.getResult(0),
			Code 	: rows.getResult(1),  
			Message : rows.getResult(2) 
		}	

		rows 				= cnx.request(sql + " PROCEDURE ANALYSE()");
		
		resultset 			= rows.results();			// Resultset is a list of 1 (OR more) hashes.

		for (j in 0 ... rows.length)					// iterate over each row (usually only 1 or 2 but could be more!)
		{
			dataset = new Map();						// The array (base[n]) stores REFERENCES to the hash - so we need a new one for each row.
			row = resultset.pop();						// Get the row that's been returned...

			for (i in 0 ... rows.nfields)				// iterate over the fieldnames in this row
			{
				fields 		=  Reflect.fields(row);		// don't know what the fields are called or how many there are at compile time
				field_name 	= (fields[i]); 				// this might even be NULL!

				if (field_name != null)					// when not NULL, reflect the field (COLUMN) name from the ROW object
				{
					dataset.set(field_name.toUpperCase(), Reflect.field(row, field_name));
				}				
			}
			analysys[j] = dataset;							// and finally, store the reference to the hash.
		}
		return {SQL: Sql_colour.pretify(sql), base : base, analysys : analysys, extra : extended};
	}
	

	/*
	* Removes a MySQL prepared statement
	*
	*/
	
	public function deallocate(stmnt_id : Int) : Void
	{
		var statment_name = "__" + Std.string(stmnt_id) + "__";
	}

	/*
	* Formats a numeric string using MySQL formatting functions
	*
	*/
	static public function sprint_float(v : Float, places : Int) : String
	{
		var sql = "SELECT FORMAT("+ Std.string(v) + "," + Std.string(places) + ") AS n;";		// stuff the results into the field name "N"
		return(cnx.request(sql).results().first().n);											// and return N
	}
}