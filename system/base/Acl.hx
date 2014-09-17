package system.base;
import system.base.Base;

/**
*
* ACL package contains simple routines for access control using files
* This is all stubs, but the idea is to generate a random 2 part key with an MD5 sum.
* Server stores BOTH parts and the SUM the user receives only ONE part - say 7 ASCII characters.
* The server only needs to store a single character - or even remove one at random position
* When the cookie is returned, the full key is assembled and MD5ed to check 
* that has not been tampered with.
* 
* This allows REST-based functions (delete/Put) to work with a simple cookie.
* ACL file should be rotated automatically ever 20 mins or so.
*/

class Acl
{
	static public function uuid() : String
	{
		// generate a new unique ID
	}
	
	static function store_user_id() : String
	{
		// generate a new unique ID
	}

	static function get_user_id() : String
	{
		// generate a new unique ID
	}
	
	
}