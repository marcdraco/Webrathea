package system.base;
import system.base.Base;
import system.base.Database;
import system.base.Hashes;


/**
* Caches DB queries. Primarily for external databases and really, *really* BUSY SQLite servers.
* right now, it's just a reserved class. 
* TODO - it's practical (and perhaps even desirable) to cache MySQL queries in SQLite for speed - particularly when the DB server is on a remote machine elsewhere.
* it's even possible (if unlikely) to store SQLite queries in SQLite itself on the offchance that you have to do very slow queries.
*/

class Wet_db_cache
{

	static var db 		: Database;
	static var cache	: String;
	
	static private function get_instance() : Database
	{
		
		if (db == null)
		{
			db = Database.get_instance("mysql");
		}
		return db;
	}
	

}