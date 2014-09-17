/**
Webrathea Engine (WET). 
Get WET, stay DRY - for developers who really know where their towels are!
Copyright (c) 2010 Marc Draco

Webrathea WET is herby dedicated to the loving memory of Douglas Adams

Permission is hereby granted, free of charge, to any person obtaining a copy of
this software and associated documentation files (the "Software"), to deal in
the Software without restriction, including without limitation the rights to
use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies
of the Software, and to permit persons to whom the Software is furnished to do
so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.


THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
*/

package system.base;
import system.base.Base;
import system.base.Buffer;
import system.base.Config;
import system.base.Database;
import system.base.Hashes;
import system.base.Pcall;
import system.base.Profiler;
import system.base.Router;
import system.base.String_buffer;


typedef WC = Cache;

class Cache
{
	static var HTML_REM_ON			= "\n<!--\n";
	static var HTML_REM_OF			= "//-->\n";
	static var CDATA_ON				= "//<![CDATA[\n";
	static var CDATA_OFF			= "\n//]]>\n";
	
	static var output_buffer		= new String_buffer(W._HTML_DOCTYPE);
	static var cookie_buffer		: List<Wet_cookie> = new List();
	static var javascript_buffer	= new Buffer();
	static var debug_buffer			= new Buffer();
	static var profile_buffer		= new Buffer();
	static var profile_sql			= false;
	static var return_code			= 200;
	static var entity_tag			= "";

	static private var instance 	: Cache;
	static private var debugging 	= true;
	
	static public var mime_type 	= {acx:"application/internet-property-stream",ai:"application/postscript",aif:"audio/x-aiff",aifc:"audio/x-aiff",aiff:"audio/x-aiff",asf:"video/x-ms-asf",asr:"video/x-ms-asf",asx:"video/x-ms-asf",au:"audio/basic",avi:"video/x-msvideo",axs:"application/olescript",bas:"text/plain",bcpio:"application/x-bcpio",bin:"application/octet-stream",bmp:"image/bmp",c:"text/plain",cat:"application/vnd.ms-pkiseccat",cdf:"application/x-cdf",cer:"application/x-x509-ca-cert",clp:"application/x-msclip",cmx:"image/x-cmx",cod:"image/cis-cod",cpio:"application/x-cpio",crd:"application/x-mscardfile",crl:"application/pkix-crl",crt:"application/x-x509-ca-cert",csh:"application/x-csh",css:"text/css",dcr:"application/x-director",der:"application/x-x509-ca-cert",dir:"application/x-director",dll:"application/x-msdownload",dms:"application/octet-stream",doc:"application/msword",docx:"application/vnd.openxmlformats-officedocument.wordprocessingml.document",dot:"application/msword",dvi:"application/x-dvi",dxr:"application/x-director",eps:"application/postscript",etx:"text/x-setext",evy:"application/envoy",exe:"application/octet-stream",fif:"application/fractals",flr:"x-world/x-vrml",gif:"image/gif",gtar:"application/x-gtar",gz:"application/x-gzip",h:"text/plain",hdf:"application/x-hdf",hlp:"application/winhlp",hqx:"application/mac-binhex40",hta:"application/hta",htc:"text/x-component",htm:"text/html",html:"text/html",htt:"text/webviewhtml",ico:"image/x-icon",ief:"image/ief",iii:"application/x-iphone",ins:"application/x-internet-signup",isp:"application/x-internet-signup",jfif:"image/pipeg",jpe:"image/jpeg",jpeg:"image/jpeg",jpg:"image/jpeg",js:"application/x-javascript",latex:"application/x-latex",lha:"application/octet-stream",lsf:"video/x-la-asf",lsx:"video/x-la-asf",lzh:"application/octet-stream",m13:"application/x-msmediaview",m14:"application/x-msmediaview",m3u:"audio/x-mpegurl",man:"application/x-troff-man",mdb:"application/x-msaccess",me:"application/x-troff-me",mht:"message/rfc822",mhtml:"message/rfc822",mid:"audio/mid",mny:"application/x-msmoney",mov:"video/quicktime",movie:"video/x-sgi-movie",mp2:"video/mpeg",mp3:"audio/mpeg",mpa:"video/mpeg",mpe:"video/mpeg",mpeg:"video/mpeg",mpg:"video/mpeg",mpp:"application/vnd.ms-project",mpv2:"video/mpeg",ms:"application/x-troff-ms",mvb:"application/x-msmediaview",nws:"message/rfc822",oda:"application/oda",p10:"application/pkcs10",p12:"application/x-pkcs12",p7b:"application/x-pkcs7-certificates",p7c:"application/x-pkcs7-mime",p7m:"application/x-pkcs7-mime",p7r:"application/x-pkcs7-certreqresp",p7s:"application/x-pkcs7-signature",pbm:"image/x-portable-bitmap",pdf:"application/pdf",pfx:"application/x-pkcs12",pgm:"image/x-portable-graymap",pko:"application/ynd.ms-pkipko",pma:"application/x-perfmon",pmc:"application/x-perfmon",pml:"application/x-perfmon",pmr:"application/x-perfmon",pmw:"application/x-perfmon",pnm:"image/x-portable-anymap",pot:"application/vnd.ms-powerpoint",ppm:"image/x-portable-pixmap",pps:"application/vnd.ms-powerpoint",ppt:"application/vnd.ms-powerpoint",pptx:"application/vnd.openxmlformats-officedocument.presentationml.presentation",prf:"application/pics-rules",ps:"application/postscript",pub:"application/x-mspublisher",qt:"video/quicktime",ra:"audio/x-pn-realaudio",ram:"audio/x-pn-realaudio",ras:"image/x-cmu-raster",rgb:"image/x-rgb",rmi:"audio/mid",roff:"application/x-troff",rtf:"application/rtf",rtx:"text/richtext",scd:"application/x-msschedule",sct:"text/scriptlet",setpay:"application/set-payment-initiation",setreg:"application/set-registration-initiation",sh:"application/x-sh",shar:"application/x-shar",sit:"application/x-stuffit",snd:"audio/basic",spc:"application/x-pkcs7-certificates",spl:"application/futuresplash",src:"application/x-wais-source",sst:"application/vnd.ms-pkicertstore",stl:"application/vnd.ms-pkistl",stm:"text/html",svg:"image/svg+xml",sv4cpio:"application/x-sv4cpio",sv4crc:"application/x-sv4crc",swf:"application/x-shockwave-flash",t:"application/x-troff",tar:"application/x-tar",tcl:"application/x-tcl",tex:"application/x-tex",texi:"application/x-texinfo",texinfo:"application/x-texinfo",tgz:"application/x-compressed",tif:"image/tiff",tiff:"image/tiff",tr:"application/x-troff",trm:"application/x-msterminal",tsv:"text/tab-separated-values",txt:"text/plain",uls:"text/iuls",ustar:"application/x-ustar",vcf:"text/x-vcard",vrml:"x-world/x-vrml",wav:"audio/x-wav",wcm:"application/vnd.ms-works",wdb:"application/vnd.ms-works",wks:"application/vnd.ms-works",wmf:"application/x-msmetafile",wps:"application/vnd.ms-works",wri:"application/x-mswrite",wrl:"x-world/x-vrml",wrz:"x-world/x-vrml",xaf:"x-world/x-vrml",xbm:"image/x-xbitmap",xla:"application/vnd.ms-excel",xlc:"application/vnd.ms-excel",xlm:"application/vnd.ms-excel",xls:"application/vnd.ms-excel",xlsx:"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",xlt:"application/vnd.ms-excel",xlw:"application/vnd.ms-excel",xof:"x-world/x-vrml",xpm:"image/x-xpixmap",xwd:"image/x-xwindowdump",z:"application/x-compress",zip:"application/zip"};

	
	private function new() 
	{
		init_profile_buffer();
		haxe.Log.trace = this.wet_trace;			// this tells HaXe to redirect TRACE calls to the Webrathea engine.
	}

	static public function get_instance() : Cache
	{
		if (instance == null)
		{
			instance = new Cache();
		}
		return instance;
	}
	
	
		/**
	*/
	static inline public function get_mime_type(path : String) : String
	{
		var ext = path.substr(path.lastIndexOf(".")+1).toLowerCase();
		return Reflect.field(mime_type,ext);
	}
	
	/**
	* Enables the global profiler
	*/
	static public function enable_db_profiling() : Void
	{
		profile_sql = true;
	}

	/**
	* Disables the global SQL profiler
	*/
	static public function disable_db_profiling() : Void
	{
		profile_sql = false;		
	}

	
	public function toString() : String
	{
		return Std.string(output_buffer);
	}

	/**
	* Stores a cookie "object" for easier cache use
	*/
	static public function cache_cookie(cookie : Wet_cookie) : Void
	{
		cookie_buffer.push(cookie);
	}

	/**
	* Checks if the BODY tag has been closed.
	* Caution: this IS case sensitive to "body" all lower case!
	*/

	public function fast_body_is_closed() : Bool
	{
		return output_buffer.fast_body_is_closed();
	}
	
	/*
	* Checks if the BODY tag has been closed.
	* This is the slow function using a REGEXP which is reliable but slower!
	*/
	public function body_is_closed() : Bool
	{
		return output_buffer.body_is_closed();
	}
	
	/**
	* Append a string to the buffer
	*/

	public function append(s : String) : Void
	{
		output_buffer.append(s);
	}


	/**
	* Insert a meta description into the HEAD element.
	* Recent standards suggest that keywords are not used
	* but that descriptions are. Description is limited to 155 characters as per recommendations.
	*/
	public function insert_description(content : String, ?suppress_warnings : Bool) : Void
	{
		if (content == null || content.length == 0)
		{
			throw(W._DESC_TEXT_RQRD);
		}
		
		if (content.length > 155 && suppress_warnings != true)
		{
			content = content.substr(0, 154);
		}
		
		insert_meta("description", content);		
	}

	/**
	* Insert a meta http-equiv into the HEAD element.
	* @param tag http-equiv=XXX tag
	* @param content tag content
	*/
	public function insert_http_equiv(tag : String, content : String) : Void
	{
		output_buffer.insert_after("<head>", "<meta http-equiv=\"" + tag + "\" content=\"" + content + "\">\n");
	}

	/**
	* Insert a meta tag into the HEAD element.
	* @param tag tagname
	* @param content tag content
	*/

	public function insert_meta(tag : String, content : String) : Void
	{
		output_buffer.insert_after("<head>", "<meta name=\"" + tag + "\" content=\"" + content + "\">\n");
	}

	/**
	* Insert a correctly formatted CSS file include.
	* @param path The file and path to the CSS you want to include.
	*/

	public function insert_css_file(path : String) : Void
	{
		output_buffer.insert_before("</head>", "<link rel=\"stylesheet\" type=\"text/css\" href=\"" + path + "\" />\n");
	}

	/**
	* Insert EITHER a style(s) definition OR a stylename : definition couplet
	* The when supplying these separately, the {} are added for you.
	* cache.inject_style(".redText {color:red}"); OR, similarly, 
	* cache.inject_style(".boldText", "font-weight: bold;");
	*/
	
	public function inject_style(css : String, ?definition : String) : Void
	{
		if (definition == null)
		{
			output_buffer.insert_before("</head>", "<style type=\"text/css\">" + css + "</style>\n");
		}
		else
		{
			output_buffer.insert_before("</head>", "<style type=\"text/css\">" + css + " {" + definition + "}</style>\n");			
		}
	}

	/**
	* Check for and display cached content
	*/
	
	inline static public function display_cache() : Bool
	{

		// router instance
		var router		= WR.get_instance();

		// get the MD5 hash of the query string
		var hash 		= router.get_query_hash();

		// construct path and check file is present
		var fullpath 	= WB.cache_path + hash + ".htm";
		
		if (! WB.file_exists(fullpath))
		{
			return false;
		}
		else
		{
			// get a copy of the current query string
			var r_query 	= router.get_query_string();

			// prepare a file to write based on the MD5
			var fin 		= WB.get_read_handle(fullpath);

			//get the original query string
			var query 		= fin.readLine();
			
			// check if this query string matches that in the file 
			// it USUALLY will but might not - due to a hash collision			
			if (r_query == query)
			{			

				// OK, we're sure this is a matched query 
				// If there's an ETag, does it match?
				var etag = WB.get_file_etag(fullpath);

				if (WB.get_etag_header() == etag)
				{
					// Yes! Send Not_modified!
					WB.set_return_code(304);
					fin.close();
					return true;
				}
				else
				{
					// OK, no ETag sent - probably a random browser "refresh". Serve from disk
					send_basic_headers(200);
					WB.send_header("Content-Length", Std.string(WB.get_file_stat(fullpath).size) );
					WB.send_header("ETag", etag);
					WB.echo(WB.get_ascii_from(fullpath,query.length));
					fin.close();
					return true;
				}
			}
			else
			{
				fin.close();
				return false;
			}
		}
	}
	
	/**
	* Load a Webrathea asset (a resource such as an image, css or js file...)
	* All assets are stored in the application/assets directory and subdirectories
	*/
	
	static public function load_asset(pathname : String) : Void
	{		
		var fullpath	= WB.asset_path + pathname;
		var etag	 	= WB.get_file_etag(fullpath);
		if (etag == "")
		{
			throw new system.base.Error.Http_exception("",404);		// essentially, resource not found.
		}
		
		if (W.USE_ETAGS)
		{
			if (WB.get_etag_header() == etag)
			{
				WB.set_return_code(304);
				return;
			}

			WB.send_header("Content-Type",get_mime_type(fullpath));
			WB.send_header("ETag",etag);
		}
		else 
		{
			WB.send_header("Content-Type",get_mime_type(fullpath));
			send_basic_headers(200);
		}
		
		WB.send_header("Content-Length", Std.string(WB.get_file_stat(fullpath).size) );
		WB.echo(WB.get_bin_content(fullpath).getData());
	}

	/**
	*
	* Write the cached copy to file.
	*	
	*/
	
	static public function cache_to_disk() : String
	{
		var router	= WR.get_instance();

		// get the MD5 hash of the query string
		var hash 	= router.get_query_hash();

		// get the query string itself
		var query 	= router.get_query_string();

		// prepare a file to write based on the MD5
		var fout 	= WB.get_write_handle(WB.cache_path + hash + ".htm");

		// Construct and write the special buffer HTML
		// Note that the first line is the actual query string
		fout.writeString(query + "\n" + output_buffer.toString());
		fout.close();
		
		return WB.get_file_etag(WB.cache_path + hash + ".htm");
	}

	/**
	*
	* Flush the output buffer. This is an internal function for the Webrathea engine and should not normally be called by developers
	*
	*/

	static public function flush() : Void
	{
		var stop_time	= Profiler.stop();

		add_script_cache();
		if (debugging)
		{
			add_debug_cache();
			add_benchmark_cache();
		}

		if (output_buffer.length != 0)
		{
			return_code = 200;
			
			try
			{
				var route = Router.get_instance();
				send_basic_headers(return_code);
				WB.send_header("Last-modified",DateTools.format(Date.now(), "%a, %d %b %Y %X %Z" ));
				WB.send_header("Content-Type","text/html");
				WB.send_header("Content-Length", Std.string(output_buffer.length) );
				WB.send_header("Cache-Control","max-age=3600");
				WB.send_header("ETag",cache_to_disk());
			}	

			catch (e : Dynamic ) {}
			
			WB.echo(output_buffer);
		}
	}


	static public function flush_log() : Void
	{
		
		output_buffer.reset();
		output_buffer.append("<html><head></head><body></body></html>");
		init_debug_buffer();
		add_debug_cache();
		
		if (output_buffer.length != 0)
		{
			WB.echo(output_buffer);
		}
	}

	/**
	* Sends a set of essentially headers, including any cookies that have been collected (or set!)
	* Note that some of these headers may be replaced by Apache (etc.)
	* @param return_code The HTTP return code - usually just 200
	*/

	inline public static function send_basic_headers(return_code : Int)
	{
		while (! cookie_buffer.isEmpty())
		{
			WB.send_cookie(cookie_buffer.pop());
		}
		
		#if php
			WB.send_header("X-Powered-By", "Webrathea/0.4 (PHP)") ;
		#elseif neko
			WB.send_header("X-Powered-By", "Webrathea/0.4 (Neko)") ;
		#end

		WB.send_header("Date",DateTools.format(Date.now(), "%a, %d %b %Y %X %Z" ));
		WB.send_header("X-Frame-Options", "sameorigin");
		WB.send_header("X-XSS-Protection", "1; mode=block");
		WB.set_return_code(return_code);
	}


	/**
	* Inserts a line of Javascript at the current point.
	* The correct script tags are added by the engine.
	*/
	
	public function inline_javascript(script : String) : Void
	{
		output_buffer.append("<script type=\"text/javascript\">" + HTML_REM_ON + CDATA_ON + script + CDATA_OFF + HTML_REM_OF + "</script>");
	}

	/**
	*
	* Inserts a line of EXTERNAL Javascript.
	*	
	*/
	
	public function external_javascript(src : String) : Void
	{
		javascript_buffer.append("<script type=\"text/javascript\" src=\"" + src + "\"></script>");
	}


	/**
	*
	* Inserts a line of EXTERNAL VBscript.
	*	
	*/
	
	public function external_vbscript(src : String) : Void
	{
		javascript_buffer.append("<script type=\"text/vbscript\" src=\"" + src + "\"></script>");
	}

	
	/**
	*
	* Completely reset the buffer!
	*	
	*/

	public function dump_buffer() : Void
	{
		output_buffer.reset();
	}
	
	/**
	*
	* Add user-debug information to the base of the page.
	*	
	*/

	static function add_debug_cache() : Void
	{
		if (debug_buffer.length == 0)
		{
			return;
		}
		debug_buffer.append("</table>");						// this element has to be added to clean up the table created elsewhere.


		if (output_buffer.length == 0)
		{
			output_buffer.append("<html><head></head><body>");	// Ah! No output at all, add some stuff I can work with! 
		}

		if (! output_buffer.body_is_closed())
		{
			output_buffer.append("</body></html>");
		}
		
		output_buffer.insert_before("</body>", debug_buffer.toString());
	}

	static 	function add_script_cache() : Void
	{
		if (javascript_buffer.length == 0)
		{
			return;
		}		

		if (! output_buffer.body_is_closed())
		{
			output_buffer.append("</body></html>");
		}
		output_buffer.insert_before("</body>", javascript_buffer.toString());
	}

	static function add_benchmark_cache() : Void
	{
		var profiler	= Profiler.get_instance();
		var stop_time 	= Profiler.stop();
		Pcall.set_stop_time(stop_time);								// set the stop time for the percentage calcs.
			
		profile_buffer.append("<table class='__table__'><tr>");		
		profile_buffer.append("<th class='__100px__'>Function</th>");
		profile_buffer.append("<th class='__dcalls__'>Calls</th>");
		profile_buffer.append("<th class='__100px__'>Total</th>");
		profile_buffer.append("<th class='__100px__'>Fastest</th>");
		profile_buffer.append("<th class='__100px__'>Slowest</th>");
		profile_buffer.append("<th class='__pcent__'>%</th>");
		profile_buffer.append("<th class='__pcent__'>Avg.%</th>");
		profile_buffer.append("</tr>");

		benchmark_message(format_profiler_t_total(W._TOTAL_RUN_TIME, 	stop_time));
		benchmark_message(format_profiler_message(W._TOTAL_LOG_TIME, 	profiler.get(W.LOGIC_TIME)));

		if (profile_sql)
		{
			benchmark_message(format_profiler_message(W._TOTAL_CNX_TIME, 	profiler.get(W.CONNECT_TIME)));
			benchmark_message(format_profiler_message(W._TOTAL_DB_TIME, 	profiler.get(W.QUERY_TIME)));
			benchmark_message(format_profiler_message(W._TOTAL_INSERT, 		profiler.get(W.INSERT_TIME)));
			benchmark_message(format_profiler_message(W._TOTAL_UPDATE, 		profiler.get(W.UPDATE_TIME)));
			benchmark_message(format_profiler_message(W._TOTAL_SELECT, 		profiler.get(W.SELECT_TIME)));
			benchmark_message(format_profiler_message(W._TOTAL_DELETE, 		profiler.get(W.DELETE_TIME)));
			benchmark_message(format_profiler_message(W._TOTAL_PREPARE,		profiler.get(W.PREPARE_TIME)));
			benchmark_message(format_profiler_message(W._TOTAL_EXEC,		profiler.get(W.EXEC_TIME)));
			benchmark_message(format_profiler_message(W._TOTAL_SET,			profiler.get(W.SET_TIME)));
			benchmark_message(format_profiler_message(W._TOTAL_OTHER, 		profiler.get(W.OTHER_TIME)));
		}
		profile_buffer.append("</table>");

		if (profile_sql)
		{
			explain_all();
		}
		
		if (! output_buffer.body_is_closed())
		{
			output_buffer.append("</body></html>");
		}
		output_buffer.insert_before("</body>", profile_buffer.toString());
	}


	static private function format_profiler_message(type : String, instance : Pcall_sql) : String
	{
		var t = new StringBuf();
		
		if (instance.calls > 0 )
		{
			t.add("<td>" + type + "</td>");
			t.add("<td>" + Std.string(instance.calls) + "</td>");
			t.add("<td>" + Database.sprint_float(instance.time, W.TIME_PLACES) + "</td>");
			t.add("<td class=\"__hand__\" title = '"+Std.string(instance.fast_sql)+"'>" + Database.sprint_float(instance.fast, W.TIME_PLACES) + "</td>");
			t.add("<td class=\"__hand__\" title = '"+Std.string(instance.slow_sql)+"'>" + Database.sprint_float(instance.slow, W.TIME_PLACES) + "</td>");
			t.add("<td>" + Std.string(instance.percentf())  + "</td>");
			t.add("<td>" + Std.string(Math.round(instance.percent()/instance.calls))  + "%</td>");
			return (t.toString());
		}
		else
		{
			t.add("<td>" + type + "</td>");
			t.add("<td></td>");
			t.add("<td></td>");
			t.add("<td></td>");
			t.add("<td></td>");
			t.add("<td></td>");
			t.add("<td></td>");
			return (t.toString());
		}
	}

	/*
	*	The title of the the profiler
	*/

	static private function format_profiler_t_total(type : String, t : Float) : String
	{
		if (profile_sql)
		{
			return ("<td>" + type + "</td><td></td><td>" + Database.sprint_float(t, W.TIME_PLACES) + "</td><td></td><td></td><td></td>");
		}
		else
		{
			return ("<td>" + type + "</td><td></td><td>" + Std.string(t) + "</td><td></td><td></td><td></td>");		
		}
	}


	/*
	*	Format the explain functions
	*	The profiler keeps a record of the SQL for the fastest and slowest
	* 	queries in order to help identify where you need to optimise (rather than THINK you should)
	*/

	static private function explain_all() : Void
	{
		var profiler	= Profiler.get_instance();
		var db			= Database.get_instance();
		if ((profiler.get(W.SELECT_TIME)).slow_sql.length > 1)
		{
			profile_buffer.append("<div class=\"__webrathea_debug__\">Webrathea Engine Slow Query Analysys</div>");
			profile_buffer.append(db.explain((profiler.get(W.SELECT_TIME)).slow_sql,false));	
		}
	}

	/**
	*
	* Add a debugging message
	*	
	*/

	private function debug_message(m : Dynamic) : Void
	{
		
		if (debug_buffer.length == 0)
		{
			init_debug_buffer();
		}

		debug_buffer.append(Std.string(m));
	}

	/**
	*
	* The benchmarking timings are added here
	*	
	*/

	static private function benchmark_message(m : Dynamic) : Void
	{
		if (profile_buffer.length == 0)
		{
			init_profile_buffer();
		}
		
		profile_buffer.append("<tr>" + Std.string(m) + "</tr>" );
	}
	
	
	/**
	*
	* A custom tracing function for Webrathea users.
	*
	*/
	
	public function wet_trace(v : Dynamic, ?inf : haxe.PosInfos)
	{
		var profiler	= Profiler.get_instance();
		var run_time	= Profiler.lap();

		var m			= new StringBuf();
		var trase 		: String;
		
		trase 			= Std.string(v);

		m.add("<tr><td class=\"__webrathea_ttime__\"");
		m.add("title=\"Line: " + inf.lineNumber);
		m.add(" of " + inf.fileName);
		m.add(" [" +  inf.methodName + "]");
		m.add("\n in " + inf.className);
		m.add(" \">");
		m.add(Std.string(run_time) + ": </td>");
		m.add("<td class=\"__webrathea_trace__\">");
		m.add(trase);
		m.add("</td></tr>");
		debug_message(m.toString());
    }

	
	/**
	*
	* Initialise the debugger functions.
	*	
	*/

	static private function init_debug_buffer() : Void
	{
		output_buffer.insert_after("<head>", W._WEBRATHEA_DEBUG);
		if (debug_buffer.length == 0)
		{
			debug_buffer.append("<div class=\"__webrathea_debug__\">Webrathea Engine Debug</div>");
			debug_buffer.append("<table class=\"__table2__\" style=\"width:100%\">");
		}
	}

	static private function init_profile_buffer() : Void
	{
		profile_buffer.append("<div class=\"__webrathea_debug__\">Webrathea Engine Profiler</div>");
	}
	

}