package system.base;
import system.base.Base;
import system.base.Cache;
import system.base.Config;
import system.base.Sql_colour;

typedef WET = Error;

class Error
{
	public 	var message( default,null )	: String;
	private var __description 			: String;
	private var __info 					: haxe.PosInfos;

	public function new(? desc : String, ?info : haxe.PosInfos ) : Void
	{
		this.__description	= desc;
		this.__info 		= info;
	}

	private function get_description() : String
	{
		var msg : String = "Class : " + this.__info.className + " - > ";
		msg += this.__info.methodName + "()\nline ";
		msg += this.__info.lineNumber + " : " + this.__description;
		return msg;
	}
	
	static public function wipe(e : String) : Void
	{
		trace("<span class=\"__fatal__\">" + e + "</span>");
		WC.flush_log();
	}
			
}

class General_error extends Error
{
	public function new(message : String, ?Http_Code : Int, ?info : haxe.PosInfos )
	{
		super();
		WB.echo(message);
	}
}

class Http_exception extends Error
{
	public function new(message : String, Http_Code : Int, ?info : haxe.PosInfos )
	{
		super();
		WC.send_basic_headers(Http_Code);
		WB.echo(message);
	}
}

class Dbexception extends Error
{
	public function new()
	{
		super();
		WET.wipe(W._NO_DB_CNX_YET);
	}
}

class NoSuchDbexception extends Error
{
	public function new(e)
	{
		super();
		WET.wipe(e + ": " + W._WRONG_DB_TYPE);
	}
}

class BadSQLException extends Error
{
	public function new(e, ? sql : String)
	{
		super();
		var strings 	: Array<String>;		
		strings 		= e.split(";");
		trace(Sql_colour.pretify(sql));
		trace(Sql_colour.pretify(strings[0]));
		WET.wipe("SQL said: " + strings[1]);
	}
}


class NoConnectionError extends Error
{
	public function new(e)
	{
		super();
		WET.wipe(e);
	}
}


class NoFileError extends Error
{
	public function new(e)
	{
		super();
		WET.wipe(e);
	}
}
