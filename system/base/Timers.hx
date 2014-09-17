package system.base;

class Timers
{
	private var time : Float;
	private var name : String;
	
	public function new(?n : String) 
	{
		this.time = haxe.Timer.stamp();
		
		if (n != null)
		{
			this.name = n;
		}
	}
	
	/**
	* Stop a named or unnamed STOP timer.
	* Return is dynamic because it could be a Float used for a calculation
	* OR a String if needed for debugging which makes it easier to trace.
	*
	*/
	
	public function stop() : Dynamic				
	{
		if (this.name != null)
		{
			return (named_stop());
		}
		else
		{
			return(unnamed_stop());
		}
	}	

	private function unnamed_stop() : Float
	{
		return haxe.Timer.stamp() - this.time;
	}

	private function named_stop() : String
	{
		var total_time = haxe.Timer.stamp() - this.time;
		return (this.name + ": " +  Std.string(total_time));
	}
	
}