package system.base;
import system.base.Base;
import system.base.Cache;
import system.base.Config;
import system.base.Error;

class Controller
{
	
	private var params	(default, default)	: Array<String>;
	public var cache						: Cache;

	private var route						: Router;
	private var arguments					: Array<String>;

	public function new() 
	{
		arguments 	= [];
		cache 		= Cache.get_instance();
	}

	/**
	* Load a view using a hash function to carry the variables.
	*
	*/
	
	public function load_view_hash(view : String, ?vars : Map<String,Dynamic>) : Void
	{
		var base		= WB.get_instance;
		var viewpath	= WB.views_path + view+".wtv";
		var view 		: String;
		var pos 		= 0;
		var left		: String;
		var right		: String;
		var uservar		: String;
		
		try
		{
			view		= WB.get_file_content(viewpath);
		}
		catch (e : Dynamic)
		{
			throw new NoFileError(viewpath + W._NOT_PRESENT);
		}
	
		if (vars != null)
		{
			for (k in vars.keys())
			{
				pos = 0;
				uservar 	= Std.string(vars.get(k));
				
				while ( (pos = view.indexOf("::" + k + "::", pos)) != -1)
				{
					
					left 	= view.substr(0,pos);
					right 	= view.substr(pos + k.length + 4);	//add 4 for the colons.
					
					view= (left + uservar + right);
					pos += 1;
				}
				
			}
		}
		
		cache.append(view);
	}


	/**
	* Load a view using an anonymous object to carry the variables.
	* The loader is repeated here to save copying large strings (for performance)
	* References would be better.
	*/
	
	public function load_view_object(view : String, ?vars : Dynamic) : Void
	{
		var base		= WB.get_instance;
		var viewpath	= WB.views_path + view+".wtv";
		var view 		: String;
		var pos 		= 0;
		var left		: String;
		var right		: String;
		var uservar		: String;
		var fieldname 	: String;
		
		try
		{
			view		= WB.get_file_content(viewpath);
		}
		
		catch (e : Dynamic)
		{
			throw new NoFileError(viewpath + " does not exist or cannot be opened for reading");
		}
			
		if (vars != null)
		{		
			var fields = Reflect.fields(vars);										// get an array of the object's fieldnames

			for (fieldname in fields)												// and iterate over them
			{
				uservar 	= Std.string(Reflect.field(vars, fieldname));
				pos 		= 0;

				while ( (pos = view.indexOf("::" + fieldname + "::", pos)) != -1)
				{
					
					left 	= view.substr(0,pos);
					right 	= view.substr(pos + fieldname.length + 4);				//add 4 for the colons.
					
					view= (left + uservar + right);
					pos += 1;
				}
				
			}
		}
		
		cache.append(view);
	}
		
	/**
	*
	* This is called by the Reflection API during the startup phase
	* and causes the routing parameters (URI options) to be stored 
	* for later retrival.
	*/
	
	public function set_params(p : Array<String>) : Void
	{
		params = p;
	}
	
	/*
	* Returns the parameter array
	*/

	public function get_params() : Array<String>
	{
		return arguments;
	}

	/**
	*
	* Base index function - should normally be overridden.
	*	
	*/

	public function index() : Void
	{
	}
	
	/**
	*
	* Immediately flushes the main cache
	* this function is primarily to display the final output
	*/

	public function flush()
	{
		WC.flush();
	}	
	
}