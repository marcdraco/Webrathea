package system.base;
import system.base.Base;


class String_buffer
{	
	public var body						: String;
	public var length (get_length, null) 	: Int;

	public function new(?s : String)
	{
		this.body = (s == null) ? "" : s;
	}

	
	/*
	* return TRUE if the closing body tag is found.
	*/
	
	public function fast_body_is_closed() : Bool
	{
		return (body.lastIndexOf("</body>") != -1);
	}

	/*
	* return TRUE if the closing body tag is present using a regexp in case the CaSe is WonKy.
	*/
	
	public function body_is_closed() : Bool
	{
		var body_tag	: EReg = ~/\/(body)/i;
		var found 		= body_tag.match(body);
		
		if (found)
		{
			body = body_tag.matchedLeft() + "/body" + body_tag.matchedRight();
		}
		
		return (found);
	}
	
	public function append(t : String) : String
	{
		this.body += t;
		return body;
	}

	public function toString() : String
	{
		return this.body;
	}


	public function reset() : Void
	{
		this.body = "";
	}
	
	public function get_length() : Int
	{
		return body.length;
	}
	
	/**
	* Insert some text into the buffer AFTER some element.
	* used by the engine to add debug information to the bottom of the page.
	* but available for any use.
	*/

	public function insert_after(needle : String, text : String, ?offset : Int) : Bool
	{
		var start 			: Int;

		if (this.body.length == 0)
		{
			return false;	// needle not in buffer.		
		}

		// If there's an offset, make sure we pick the correct version of indexOf()
		
		if (offset == null || offset == 0)
		{
			start = this.body.indexOf(needle);
		}
		else
		{
			start = this.body.indexOf(needle, offset);			
		}
		
		// Make sure the needle is actually there or this makes no sense.
		
		if (start == -1)
		{
			return false;	// needle not in buffer.
		}
		
		start 			+= needle.length;
		this.body 		= this.body.substr(0,start) + text + this.body.substr(start);
		return true;	
	}


	/**
	* Insert some text into the buffer before some element.
	* used by the engine to add debug information to the bottom of the page.
	* but available for any use.
	*/

	public function insert_before(needle : String, text : String) : Bool
	{
		var start 			: Int;

		if (this.body.length == 0)
		{
			return false;	// needle not in buffer.		
		}

		// Make sure the needle is actually there or this makes no sense.

		start = this.body.indexOf(needle);

		if (start == -1)
		{
			return false;	// needle not in buffer.
		}
		
		this.body 		= this.body.substr(0,start) + text + this.body.substr(start);
		return true;	
	}
}