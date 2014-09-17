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
import system.base.Attributes;
import system.base.Cache;
import system.base.Config;
import sys.io.File;

typedef WB = Wet_base;

typedef Wet_cookie =
{	
	var key 	: String;
	var value 	: String;
	var expire 	: Date;
	var domain 	: String;
	var path	: String; 
	var secure 	: Bool;
};

typedef Wet_parsed_path = 
{
	var filename : String;
	var pathname : String;
}

typedef FileOutput	= sys.io.FileOutput;
typedef FileInput	= sys.io.FileInput;
typedef FileSeek	= sys.io.FileSeek;

/**
*
* Base object attempts to set the essential variables and 
* normalise code for PHP and Neko
*
* Base is a Singleton
*/

class Wet_base
{
	static private var instance 		: Wet_base;
	static public var asset_path		: String;
	static public var datastore_path	: String;
	static public var cache_path		: String;
	static public var root_directory	: String;
	static public var views_path		: String;
	static public var conf_path			: String;

	private function new() 
	{
		root_directory		= get_full_path();
		
		// this liddle gotchya comes from the PHP install which adds its own directory!
		#if php
		root_directory		+= "/lib";
		#end
		
		asset_path			= root_directory + "/" + "system/application/assets/";
		cache_path			= root_directory + "/" + "system/application/cache/";
		datastore_path		= root_directory + "/" + "system/application/datastore/";
		views_path			= root_directory + "/" + "system/application/views/";
		conf_path			= root_directory + "/" + "system/application/config/";
	}
	
	
	static public function get_instance() : Wet_base
	{
		if (instance == null)
		{
			instance = new Wet_base();
		}
		return instance;
	}

	/**
	* Insert a Webrathea asset.
	* @param path The path (relative to your assets directory) where the asset resides.
 	* @returns A string containing the fully formatted link ready to use

	*/

	inline static public function create_asset_src (path : String) : String
	{
		return "src=\"" + W.SITE_ROOT + "?_load/" + path + "\"";
	}

	/**
	* Create a hyperlink - this function is inlined for speed.
	* @param uri A fully qualified URL - including the HTTP:, FTP: etc.
	* @param link_text The text that will appear on the link
	* @param attribs An optional Webrathea asset class
 	* @returns A string containing the fully formatted link ready to use

	*/

	inline static public function make_link(uri : String, link_text : String, ?attribs : WA) : String
	{
		return "<a href=\"" + Std.string(uri) + "\"" + attribs.insert_attributes() + ">" + link_text + "</a>";
	}


	/**
	* Create a detailed HTTP anchor - this function is inlined for speed.
	* @param uri A basic URL - EXcluding the HTTP:// as this is added by the function
	* @param attribs An optional Webrathea asset class
	* @see make_link for more information

	*/
	inline static public function make_http_link(uri : String, ?link_text : String, ?attribs : WA) : String
	{
		return make_link("http://" + uri, ( (link_text == null) ? uri : link_text), attribs);
	}

	/**
	* Set a cookie for caching. Cookies are sent at the last possible momement and stored in an object format.
	* @param key Name
	* @param value contents of this cookie
	* @param expire optional expiration date
	* @param domain operation domain
	* @param path path this cookie is available to
	* @param secure true if this can only be tansmitted securely
	*/
	static public function set_cookie
	( 
		key 	: String, 
		value 	: String, 
		?expire : Date, 
		?domain : String, 
		?path 	: String, 
		?secure : Bool 
	) : Void

	{
		WC.cache_cookie
		(
			{
				key 	: key, 
				value 	: value, 
				expire 	: expire, 
				domain 	: domain, 
				path	: path, 
				secure 	: secure				
			}
		);
	}
	
	/**
	* Wraps the neko or php set_cookie function - end-users should not use this function but use SET_COOKIE instead
	* @param c cookie data in Wet's internal object format.
	*/
	static public function send_cookie(c : Wet_cookie) : Void
	{
		_set_cookie(c);
	}

	/**
	* Creates a unique (per server!) Entity tag for Etag caching. This function 
	* is not intended for reliable use across multiple servers. Expires header might
	* or entity unique hashcodes might serve the purpose better in that case.
	* This method is ideal for single servers and even multiple servers unless Etags
	* have to be synchronized - your mileage may vary.
	* Tag is created from the INODE, SIZE and CREATION seconds of the file.
	* @return Etag string or null if the file does not exist
	*/
	
	inline static public function get_file_etag(fullpath : String) : String
	{
		if (file_exists(fullpath))
		{
			// last bit is the SECONDS of the creation time.
			var stats = get_file_stat(fullpath);
			return StringTools.hex(stats.size) + "-" + StringTools.hex(stats.ino) + "-" + stats.mtime.toString().substr(17,2);				
		}
		else
		{
			return "";
		}
	}
	
	/**
	* Takes a file (typically a temporary) and renames it with its ETag name
	* this makes it easy to find when requested by the upstream cache. 
	*/
	
	static public function set_file_etag(fullpath : String) : Void
	{
		var filename 	: String;
		var pathname	: String;
		
		if (file_exists(fullpath))
		{
			trace(parse_file_path(fullpath).filename);
			trace(parse_file_path(fullpath).pathname + "/" +get_file_etag(fullpath));
		}
	}
	
	/**
	* Using a timer, this uses the number elapsed seconds to generate a 
	* name for a directory cache - effectively randomly because this happens entirely
	* based on some time effect.
	* @return A single letter from A-Z used as a cache subdirectory name.
	* 
	*/
	static public function get_random_cache_dir() : String
	{
		return(String.fromCharCode((Date.now().getSeconds() % 26)+65));
	}
	
	/**
	* Splits a file/pathname string into FILENAME and PATHNAME
	* @return Wet_parsed_path (see typedef) or nulls if there's an error
	*/
	static public function parse_file_path(fullpath : String) : Wet_parsed_path
	{
		var pos 		= fullpath.lastIndexOf("/");

		if (pos == -1)
		{
			return {pathname : "", filename : ""};
		}

		return {pathname : fullpath.substr(0, pos), filename : fullpath.substr(pos + 1)};	
	}
	
	/**
	* Returns a read handle (shared) to an asset in the application assets path.
	* Subdirectories are handled based on the /system/application/assets root.
	* @return file handle or null if file not found
	*/
	static public function open_asset(path) : Dynamic
	{
		var fullpath = WB.asset_path + path;
		
		if (file_exists(fullpath))
		{
			return get_read_handle(fullpath);
		}
		return null;
	}

	/**
	* Returns a binary file in a haxe.io.Bytes object
	* @return file or null if file not found
	*/
	static public function open_image_asset(path) : haxe.io.Bytes
	{
		var fullpath = WB.asset_path + path;
		
		if (file_exists(fullpath))
		{
			return get_bin_content(fullpath);
		}
		return null;
	}

	
	/*****************************************************************************************************
	* PHP Functions
	*****************************************************************************************************/

	#if php

	/**
	* Returns the full list of headers sent by the client (cache, browser, etc.)
	* List is of the form List<{header_name : header_value}>
	* For common functions see get_modified_since_header and get_etag_header
	*/
	
	static inline public function get_http_headers() : List<Dynamic>
	{	
		return php.Web.getClientHeaders();
	}
	
	/**
	* Returns the HTTP request verb (usually GET or POST, but can be others such as PUT and DELETE)
	*/
	
	static inline public function get_http_method() : String
	{	
		return php.Web.getMethod();
	}
	
	/**
	* Returns the HTTP request cache directive base on a GMT string
	* Return date (as a string) OR null if not present.
	*/
	
	static inline public function get_modified_since_header() : String
	{	
		return php.Web.getClientHeader("If-modified-since");
	}

	/**
	* Returns the HTTP request cache directive for caching on an Etag
	* Return tag (as a string) OR null if not present.
	*/
	
	static inline public function get_etag_header() : String
	{	
		return php.Web.getClientHeader("If-none-match");
	}
	
	/**
	* Check if a given path points to a directory
	* @return true if the path is a valid directory - false otherwise (including a non-existant path)
	*/
	
	static inline public function is_directory(fullpath : String) : Bool
	{	
		if (file_exists(fullpath))
		{
			return sys.FileSystem.isDirectory(fullpath);
		}
		else
		{
			return false;
		}
	}
	
	
	/**
	* Get an Md5 hash of the cookies sent.
	* @return Md5 string
	*/

	static inline public function get_MD5_cookies() : String
	{	
		return (haxe.crypto.Md5.encode(Std.string(php.Web.getCookies())));
	}

	/**
	* The parameters as sent in the request
	* @return a string of the ?parameters
	*/

	static inline public function get_param_string() : String
	{	
		return (StringTools.urlDecode(php.Web.getParamsString()));
	}

	/**
	* Returns a string (sent by the browser in the REQUEST header
	* Indicating where the current request originated.
	* or NULL if the string is not present. This can be fudged or removed - don't rely on it!
	*/
	static inline public function get_referrer() : String
	{
		return php.Web.getClientHeader("Referer");
	}

	/**
	* The root directory of the host.
	* (Subject to CHROOT jail, of course)
	* @return A string showing the base path
	*/

	static inline public function get_full_path() : String
	{	
		return (sys.FileSystem.fullPath("."));		
	}

	/**
	* Load an ASCII file all in one go
	* @param fullpath Path and filename
	* @return string containing the entire file
	*/
	
	static inline public function get_file_content(fullpath : String) : String
	{
		return sys.io.File.getContent(fullpath);	
	}

	/**
	* Load an BINARY file all in one go
	* @param fullpath Path and filename
	* @return string containing the entire file
	*/
	
	static inline public function get_bin_content(fullpath : String) : haxe.io.Bytes
	{
		return sys.io.File.getBytes(fullpath);
	}


	/**
	* Load an ASCII file
	* @param fullpath Path and filename
	* @return a FileInput structure
	*/
	
	static inline public function get_ascii_content(fullpath : String) : FileInput
	{
		return sys.io.File.read(fullpath, false);
	}
	

	/**
	* Load an ASCII file from a position some way from the start
	* @param fullpath Path and filename
	* @param pos The position to seek to and start reading from
	* @return string containing the entire file
	*/
	static inline public function get_ascii_from(fullpath : String, pos : Int) : String
	{
		var fin 	= get_read_handle(fullpath);
		var size	= get_file_stat(fullpath).size;
		fin.seek(pos, FileSeek.SeekBegin);
		var output 	= fin.readString(size - pos);
		fin.close();
		return output;
	}


	/**
	* Utility function for all classs to echo to SCREEN!
	* This function is not to be confused with cache/buffer
	* but it can be used pretty whenever TRACE cannot.
	*	
	*/
	static inline public function echo(m : Dynamic) : Void
	{
		var message : String;
		message 	= Std.string(m);
		trace("DEPRECATED FUNCTION: " + message);
	}

	/**
	* Obtain a handle to do some READ ONLY work on a file.
	* @param fullpath Path and filename
	* @param binary Set to true for a binary file
	*/
	
	static inline public function get_read_handle(fullpath : String, ?binary = false) : FileInput
	{
		return sys.io.File.read(fullpath, binary);
	}			

	/**
	* Obtain a handle to do some WRITE work on a file.
	* @param fullpath Path and filename
	*/
	
	static inline public function get_write_handle(fullpath : String, ?binary = false) : FileOutput
	{
		return sys.io.File.write(fullpath, binary);
	}		

	/**
	* DEPRECATED due to missing function (should write to stderror)
	* @param m a short message to send to the error  log.
	*/
	static inline public function log_error(m : String) : Void
	{
		m = Std.string(Date.now()) + ": " + m;
		// this error shold be recorded in the log.
	}
	
	/**
	* @return The name of the current host.
	*/
	static inline public function get_hostname() : String
	{
		return php.Web.getHostName();
	}

	/**
	* Checks for the existence of a file or directory
	* @param fullpath The full path to the file - including the filename!
	* @return True if the file exists, false otherwise
	*/
	
	static inline public function file_exists(fullpath : String) : Bool
	{
	    return sys.FileSystem.exists(fullpath);	
	}
	/**
	*
	* Get file information such as creation date, etc.
	* @param fullpath The full path to the file - including the filename!
	* @return fileinfo enum
	*/
	
	static inline public function get_file_stat(fullpath : String) : Dynamic
	{
	    return sys.FileSystem.stat(fullpath);	
	}


	/**
	* Send an HTTP cookie
	*/
	
	static inline private function _set_cookie( c : Wet_cookie ) : Void
	{
	    php.Web.setCookie(c.key, c.value, c.expire, c.domain, c.path, c.secure);	
	}

	/**
	*
	* Send an HTTP header
	* @param header - header name
	* @param value - header value
	*/
	
	static inline public function send_header( header : String, value : String ) : Void
	{
	    php.Web.setHeader(header, value);
	}

	/**
	* Send the HTTP return code, i.e. 200, 404, 500 etc.
	*/
	
	static inline public function set_return_code( r : Int ) : Void
	{
		php.Web.setReturnCode(r);	
	}


	/*
	* NEKO Functions - these functions are essentially copies of the
	* PHP ones above, but set for Neko/Tora instead.
	*/
	
	#elseif neko
	
	static inline public function is_directory(fullpath : String) : Bool
	{	
		if (file_exists(fullpath))
		{
			return neko.FileSystem.isDirectory(fullpath);
		}
		else
		{
			return false;
		}
	}
	
	static inline public function get_http_headers() : List<Dynamic>
	{	
		return neko.Web.getClientHeaders();
	}

	static inline public function get_http_modified_since() : String
	{	
		return neko.Web.getClientHeader("If-modified-since");
	}

	static inline public function get_http_none_match() : String
	{	
		return neko.Web.getClientHeader("If-none-match");
	}
		
	static inline public function get_http_method() : String
	{	
		return neko.Web.getMethod();
	}
	
	static inline public function get_MD5_cookies() : String
	{			
		return (haxe.crypto.Md5.encode(Std.string(neko.Web.getCookies())));
	}

	static inline public function get_referrer() : String
	{
		return neko.Web.getClientHeader("Referer");
	}
	
	static inline public function get_param_string() : String
	{	
		return (StringTools.urlDecode(neko.Web.getParamsString()));
	}

	static inline public function set_return_code( r : Int ) : Void
	{
		neko.Web.setReturnCode(r);	
	}
	
	static inline public function send_header( header : String, value : String ) : Void
	{
	    php.Web.setHeader(header, value);
	}

	static inline public function get_hostname() : String
	{
		return neko.Web.getHostName();
	}

	static private function _set_cookie( c : Wet_cookie ) : Void
	{
	    neko.Web.setCookie(c.key, c.value, c.expire, c.domain, c.path, c.secure);
	}

	static inline public function get_full_path() : String
	{	
		return (neko.FileSystem.fullPath("."));		
	}

	static inline public function get_file_content(fullpath : String) : String
	{
		return neko.io.File.getContent(fullpath);	
	}
	
	static inline public function get_bin_content(fullpath : String) : haxe.io.Bytes
	{
		return neko.io.File.getBytes(fullpath);
	}
	
	static inline public function get_ascii_content(fullpath : String) : neko.io.FileInput
	{
		return neko.io.File.read(fullpath, false);
	}

	static inline public function get_ascii_from(fullpath : String, pos : Int) : String
	{
		var fin 	= get_read_handle(fullpath);
		var size	= get_file_stat(fullpath).size;
		fin.seek(pos, FileSeek.SeekBegin);
		var output 	= fin.readString(size - pos);
		fin.close();
		return output;
	}

	static inline public function echo(m : Dynamic) : Void
	{
		neko.Lib.print(Std.string(m));		
	}

	static inline public function get_read_handle(fullpath : String, ?binary = False) : FileInput
	{
		return neko.io.File.read(fullpath, binary);
	}			

	static inline public function get_write_handle(fullpath : String, ?binary = False)) : FileOutput
	{
		return neko.io.File.write(fullpath, binary);
	}

	static inline public function log_error(m : String) : Void
	{
		m = Std.string(Date.now()) + ": " + m;
		neko.io.File.stderr().writeString(m);
	}
	
	static inline public function file_exists(fullpath : String) : Bool
	{
	    return neko.FileSystem.exists(fullpath);	
	}
	
	static inline public function get_file_stat(fullpath : String) : Dynamic
	{
	    return neko.FileSystem.stat(fullpath);	
	}

	#end

	
}
