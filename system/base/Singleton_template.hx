package system.base;
import system.base.Base;

/**
* Basic template for a Singleton pattern
*/

class Singleton
{
	
	static private var instance 	: Singleton;

	private function new () {}

	
	static public function get_instance() : Singleton
	{
		if (instance == null)
		{
			instance = new Singleton();
		}
		return instance;
	}

}