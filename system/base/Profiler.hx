package system.base;
import system.base.Base;
import system.base.Pcall;
import system.base.Config;

class Profiler
{
	static private var instance 	: Profiler;
	
	static public var start_time	= haxe.Timer.stamp();
	static public var stop_time		: Float;
	static public var run_time		: Float;
	static public var query			= new Pcall_sql();
	static public var connections	= new Pcall_sql();
	static public var inserts		= new Pcall_sql();
	static public var updates		= new Pcall_sql();
	static public var deletes		= new Pcall_sql();
	static public var selects		= new Pcall_sql();
	static public var others		= new Pcall_sql();
	static public var prepare		= new Pcall_sql();
	static public var execute		= new Pcall_sql();
	static public var logic			= new Pcall_sql();
	static public var setting		= new Pcall_sql();
	
	private function new () {}

	
	static public function get_instance() : Profiler
	{
		if (instance == null)
		{
			instance = new Profiler();
		}
		return instance;
	}

	/*
	*
	* Stop the profiler
	*/
	
	static public function stop() : Float
	{
		stop_time	= haxe.Timer.stamp();
		run_time	= stop_time - start_time;

		return run_time;
	}

	/*
	*
	* Get a snapshot of how long since started
	*/
	

	static public function lap() : Float
	{
		return haxe.Timer.stamp()- start_time;
	}


	/*
	*
	* bump a function variable (usually SQL functions)
	*/
	public function increment(name : String, time : Float, ?sql : String )
	{
		switch(name)
		{
			case W.INSERT_TIME:
			{
				inserts.add_sql(time, sql);
			}
			
			case W.UPDATE_TIME:
			{
				updates.add_sql(time, sql);
			}
			
			case W.DELETE_TIME:
			{
				deletes.add_sql(time, sql);
			}
			
			case W.SELECT_TIME:
			{
				selects.add_sql(time, sql);
			}

			case W.OTHER_TIME:
			{
				others.add_sql(time, sql);
			}
			case W.CONNECT_TIME:
			{
				connections.add(time);
			}

			case W.QUERY_TIME:
			{
				query.add(time);
			}
			
			case W.LOGIC_TIME:
			{
				logic.add(time);
			}
			case W.PREPARE_TIME:
			{
				prepare.add_sql(time, sql);
			}
			
			case W.EXEC_TIME:
			{
				execute.add_sql(time, sql);
			}

			case W.SET_TIME:
			{
				setting.add_sql(time, sql);
			}
			
			default:
			{
				WB.echo("Function: {"+ name + "}" + W._FUNC_NOT_RGTD + "<br>");
			}
		}
	}
	
	public function get(name : String) : Pcall_sql
	{
		switch(name)
		{
			case W.INSERT_TIME:
			{
				return inserts;
			}
			
			case W.UPDATE_TIME:
			{
				return updates;
			}
			
			case W.DELETE_TIME:
			{
				return deletes;
			}
			
			case W.SELECT_TIME:
			{
				return selects;
			}

			case W.OTHER_TIME:
			{
				return others;
			}
			
			case W.CONNECT_TIME:
			{
				return connections;
			}

			case W.QUERY_TIME:
			{
				return query;
			}

			case W.LOGIC_TIME:
			{
				return logic;
			}

			case W.PREPARE_TIME:
			{
				return prepare;
			}

			case W.EXEC_TIME:
			{
				return execute;
			}
			
			case W.SET_TIME:
			{
				return setting;
			}
			
			default:
			{
				throw("Function "+name+W._FUNC_NOT_RGTD);
			}
		}
	}
}