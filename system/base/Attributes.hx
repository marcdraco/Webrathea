package system.base;
import system.base.Base;

typedef WA = Attributes;

class Attributes
{
	 public var iclass 		(default, set_iclass) 		: String;
	 public var dir  		(default, set_dir)			: String;
	 public var id  		(default, set_id)			: String;
	 public var lang  		(default, set_lang)			: String;
	 public var style  		(default, set_style) 		: String;
	 public var title  		(default, set_title) 		: String;
	 public var accesskey  	(default, set_accesskey)	: String;
	 public var tabindex  	(default, set_tabindex) 	: Int;
	 public var xml_lang  	(default, set_xml_lang)		: String;
	 public var nonw3c		(default, set_nonw3c)		: String;


	/**
	* Creates a new attributes instance with none (!) or more of the attributes common to HTML elements. 
	* No checking is done on the integrity of the information as it might change outside of the program control.
	* Non-suppored elments (or deprecated fields) can be added in the nonw3c variable.
	* @param tclass The element's CSS class as a string. Multiple classes are supported in a single string, separated by whitespace
	* @param id The elements ID - this should be unique.
	* @param title A title hint for this element - shows as a hint in many browsers.
	* @param accesskey Used in forms only - this defines the key to press to access the control.
	* @param tabindex Used in forms only - alters how the tab key works.
	* @param xml_lang XML:LANG element - only applies to XHMTL doctypes
	* @param style A local style definition as - CLASS should be used in preference.
	* @param nonw3c a parameter (or string of parameters to pass to the element that are not available via a class/style)
	* @param lang A language element if required.
	* @param dir The dir element (LTR or RTL)
	
	*/	

	public function new(?iclass : String, 
						?i_id : String, 
						?style : String, 
						?title : String, 
						?valign : String, 
						?accesskey : String, 
						?tabindex : Int, 
						?xml_lang : String, 
						?nonw3c : String, 
						?i_lang : String, 
						?dir : String)
	{
		
		this.iclass 	= (iclass 		== null) ? null : iclass;
		this.dir 		= (dir 			== null) ? null : dir;
		this.id 		= (i_id 		== null) ? null : id;
		this.lang 		= (i_lang 		== null) ? null : lang;
		this.style 		= (style 		== null) ? null : style;
		this.title   	= (title 		== null) ? null : title;
		this.tabindex	= (tabindex 	== null) ? null : tabindex;
		this.accesskey  = (accesskey 	== null) ? null : accesskey;
		this.xml_lang   = (xml_lang		== null) ? null : xml_lang;
		this.nonw3c		= (nonw3c 		== null) ? null : nonw3c;
	}
	
	/**
	* Inserts the instance-defined set of attributes. Attributes can be changed at run time through a dot.method
	*/	
	public function insert_attributes() : String
	{		
		return 	this.id +iclass + this.style + this.lang + this.dir + this.title + this.accesskey + this.xml_lang + this.nonw3c + ( (tabindex != null) ? "tabindex="+Std.string(tabindex) : "");
	}
	
	private function set_iclass(v : String) : String
	{
		return (this.iclass = (v == null) ? "" : " class=\""+v+"\" ");
	}

	private function set_dir(v : String) : String
	{
		return (this.dir = (v == null) ? "" : " dir=\""+v+"\" ");
	}

	private function set_id(v : String) : String
	{
		return (this.id = (v == null) ? "" : " id=\""+v+"\" ");
	}
	
	private function set_lang(v : String) : String
	{
		return (this.lang = (v == null) ? "" : " lang=\""+v+"\" ");
	}
	
	private function set_style(v : String) : String
	{
		return (this.style 		= (v == null) ? "" : " style=\""+v+"\" ");
	}
	
	private function set_title(v : String) : String
	{
		return (this.title   	= (v == null) ? "" : " title=\""+v+"\" ");
	}
	
	private function set_tabindex(v : Int) : Int
	{
		return (this.tabindex	= (v == null) ? null : v);
	}
		
	private function set_accesskey(v : String) : String
	{
		return (this.accesskey  = (v == null) ? "" : " accesskey=\""+v+"\" ");
	}
	
	private function set_xml_lang(v : String) : String
	{
		return (this.xml_lang   = (v == null) ? "" : " xml:lang=\""+v+"\" ");
	}

	private function set_nonw3c(v : String) : String
	{
		return (this.nonw3c   = (v == null) ? "" : " " + nonw3c +  " ");
	}

}
