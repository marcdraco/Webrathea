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

import system.base.Base;
import system.base.Buffer;
import system.base.Cache;
import system.base.Config;
import system.base.Controller;
import system.base.Database;
import system.base.Error;
import system.base.Profiler;
import system.base.Router;
import system.base.String_buffer;
import system.base.Timers;


/*
*/

class Index
{	
	static function main()
	{
		var user_method		: String;
		var params			: String;
		var route			: Router;
		var user_class 		: Controller;
		var base			= WB.get_instance();
		var cache 			= WC.get_instance();
		var profiler		= Profiler.get_instance();
		
		var cl 				: Dynamic;

		try
		{
			route = Router.get_instance();
			if (! route.decode_route())
			{
				if (route.controller == "_load")
				{					
					WC.load_asset(route.method);
				}
				return;
			}
			
			// display page from cache if available
			if (WC.display_cache())
			{
				return;
			}

			cl = Type.resolveClass("system.application.controllers." + route.controller);
					
			if (cl == null) 
			{
				
				throw new Http_exception(route.controller + " " + W._PAGE_NOT_FOUND, 404);
			}
			else
			{
				user_class	= Type.createInstance(cl,[]);
				user_method	= Reflect.field(user_class, route.method);
				if (user_method == null) 
				{
					throw new Http_exception(route.method + " " + W._PAGE_NOT_FOUND, 404);
				}
				else
				{	
					user_class.set_params(route.get_params());
				 	Reflect.callMethod(user_class, user_method, []);
				 	Reflect.callMethod(user_class, Reflect.field(user_class, "flush"), []);	// clean up and display the page.
			 	}		 		
			 }
	 	}
 		catch (e : Error) {} 	// These exceptions are handled by the Wet_Exception Class. No further action should be required... I hope!

 	Database.close();
	}	
}

