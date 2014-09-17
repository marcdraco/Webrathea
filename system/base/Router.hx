package system.base;
import system.base.Base;
import system.base.Cache;
import system.base.Config;
import system.base.Error;

typedef WR = Router;

class Router
{
	static private var regexp				: EReg = ~/[^\x5F\x2Ea-z0-9\-\/]/i;				// limited characters on GET line. A-Z, 0-9, -, . and _ that is all.

	static private var DEFAULT_METHOD		= "index";
	static private var FRONT_CONTROLLER		= "front";
	static private var instance 			: Router;
	
	public var controller 	(default, null)	: String;
	public var method		(default, null) : String;
	public var params		(default, null) : Array<String>;
	private var query_string				: String;
	private var query_hash 					: String;
			
	private function new()	
	{
		query_string 	= remove_trailing_slash(WB.get_param_string());
		if (query_string.length >= 255)
		{
			throw new Http_exception("Query string malformed or too long", 414);
		
		}
		query_hash 		= haxe.crypto.Md5.encode(query_string);
	}
	
	/**
	* @return an instance of the router (which is a Singleton)
	*
	*/

	inline static public function get_instance() : Router
	{
		if (instance == null)
		{
			instance = new Router();
		}

		return instance;
	}


	/**
	* @return The original query string
	*/
	
	inline public function get_query_string() : String
	{
		return query_string;
	}


	/**
	*
	* @return The controller (class) name
	*
	*/
	
	inline public function get_controller() : String
	{
		return controller;
	}

	/**
	*
	* @return The method (function) name
	*
	*/

	inline public function get_method() : String
	{
		return method;
	}

	/**
	*
	* @return The Md5 has of the original query string (function) name
	*
	*/

	inline public function get_query_hash() : String
	{
		return query_hash;
	}

	/**
	*
	* Returns an array containing any additional parameters passed
	*
	*/

	inline public function get_params() : Array<String>
	{
		return params;
	}

	/**
	*
	* Calculate routing from the URL
	* Leaves the array of arguments/parameters in the params array
	* Returns false if a "magic" method is seen e.g. _load
	* Magics are handled further up the call stack.
	* return bool
	*/

	public function decode_route() : Bool
	{
		params	= [];
				
		if (regexp.match(query_string))
		{
			throw new Http_exception(Config._BAD_URL_STRING + query_string, 400);
		}		
		if (query_string.length == 0)
		{
			controller 		= FRONT_CONTROLLER;
			controller 		= class_case(controller.toLowerCase());
			method 			= (DEFAULT_METHOD).toLowerCase();
			query_string	= controller + "/" + method;
			return true;
		}
		
		if (query_string.indexOf("/") == -1)
		{
			params.push(query_string.toLowerCase());				// class only supplied
		}
		else
		{
			params	= (query_string.toLowerCase()).split("/");		// class and method (and maybe some parameters) supplied
		}

		controller	= (params[0] != null && params[0].length > 0) ? class_case(params[0])	: FRONT_CONTROLLER;
		method 		= (params[1] != null && params[0].length > 0) ? params[1]				: DEFAULT_METHOD;

		// Is this one of the special "magic" methods?
		if (controller == "_load")
		{
			return false;
		}		
		return true;
	}
	
	inline function remove_trailing_slash(s : String) : String 
	{
		if (s.charAt(s.length -1) == "/")
		{			
			s = s.substr(0,s.length -1);
		}
		return s;
	}
	
	/**
	*
	* HaXe classes (controllers) start with a capital letter
	* This minifunction does that for any string. This is 
	* primarily a helper for the Relection class.
	*
	*/

	inline function class_case(s : String) : String 
	{
		return (s.substr(0,1)).toUpperCase() + s.substr(1);
	}
	
	


}