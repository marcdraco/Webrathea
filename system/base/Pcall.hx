package system.base;
import system.base.Base;
typedef WP = Pcall;

class Pcall
{
	public var time 				: Float;
	public var calls				: Int;	
	public var slow					: Float;	
	public var fast					: Float;	
	static private var stop_time	: Float;

	public function new() 
	{
		time 	= 0;
		calls	= 0;
		slow	= 0;
		fast	= 9999.99;
	}
	
	static public function set_stop_time(t : Float) : Void
	{
		stop_time = t;
	}
	
	/**
	* Add a single unit of time (Float) and increment the number of times called.
	*/
	
	public function add(t : Float) : Float
	{
		this.calls	+= 1;
		this.time  	+= t;
		if (t > this.slow)
		{
			this.slow = t;
		}
		if (t < this.fast)
		{
			this.fast = t;
		}
		return time;
	}
	
	/**
	* Return PC of some value (typically Run Time - which is set by the Cache or an optional value)
	*/

	public function percent(?t_stop : Float) : Float
	{
		var stopped_at : Float;
		
		stopped_at = (t_stop == null) ? stop_time : t_stop;		
		return ((this.time / stopped_at) * 100);
	}
	
	/**
	* Helper for neater code elsewhere - returns the percentage runtime as a string %
	*/
	public function percentf(?t_stop : Float) : String
	{
		return Std.string(Math.round(percent(t_stop))) + "%";
	}
	
	/**
	* Helper for neater code elsewhere - returns the number of times called as a string
	*/
	public function callsf() : String
	{
		return Std.string(this.calls);
	}

	/**
	* Helper for neater code elsewhere - returns the total time as a string
	*/
	public function timef(?t_stop : Float) : String
	{
		return Std.string(this.time);
	}

}

class Pcall_sql extends Pcall
{
	public var slow_sql : String;
	public var fast_sql : String;

	public function new()
	{
		super();
		slow_sql = "";
		fast_sql = "";
	}
	
	public function add_sql(t : Float, sql : String) : Float
	{
		super.add(t);
		if (t >= this.slow)
		{
			slow_sql = sql;
		}
		if (t <= this.fast)
		{
			fast_sql = sql;		
		}
		return time;
	}
}
