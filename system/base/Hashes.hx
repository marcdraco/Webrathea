package system.base;

class Hashes
{

	/**
	* @see Adapted from examples by Arash Partow
	* @see http://www.partow.net/programming/hashfunctions/
	* @param s String to be hashed
	* @return unsigned integer hash value - not unique - probably should be expressed as HEX
	*/
	static public function do_hash(s : String) : Int
	{
	   var b    = 378551;
	   var a    = 63689;
	   var hash = 0;
	   var i    = 0;
	
	   for(i in 0...s.length)
	   {
	      hash = hash * a + (s.charCodeAt(i));
	      a    = a * b;
	   }
	   return cast(Math.abs(cast(hash, Float)), Int);
	}
	/* End Of Hash Function */
}
