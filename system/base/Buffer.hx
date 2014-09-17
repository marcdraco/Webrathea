
package system.base;

class Buffer extends StringBuf
{
	
	public var strLength		: Int;

	public function new () 
	{
		super();
		this.strLength = 0;
	}
	
	public function append(t : String) : Void
	{
		this.strLength += t.length;		
		super.add(t);
	}
}