package system.base;
import system.base.Attributes;
import system.base.Base;
import system.base.Config;
import system.base.Error;

typedef Pagination =
{
	var paginated	: String;
	var total		: Int;
	var current 	: Int;
}

class Paginator
{
	var total_pages		: Int;
	var base_url		: String;
	var current_links	: String;
	
	/**
	* @param this.base_url required parameter, baseURL of the controller/method including the website base.
	* @param number_of_results The total number of records in available for display - the count from your SQL query, typically
	* @param results_per_page The number of results you're going to ouput in a single page.
	* @throws a general error if results per page is silly ( i.e. <= 0)
	* @see * USAGE: var pg = new Paginator("http://localhost:2000/?front/demo/", 200, 5);
	* @see pg.generate_links({separator : " ", sideband_width : 6});
	* @see trace(pg.get_current_links());
	*
	* @TODO should really have an option to skip "N" results in a single bound.
	*/
	
	public function new(baseURL : String, number_of_results : Int, results_per_page : Int)
	{
	
		if (results_per_page <= 0)
		{
			throw new General_error(W._PAG_DIV_BY_ZERO,500);
		}
		
		var full_pages		= Math.floor(number_of_results / results_per_page);
		var spill_pages		= ((number_of_results % results_per_page) != 0) ? 1 : 0;			// if there's a leftover (non-zero modulus) there's an extra page.
		
		current_links 		= null;		
		this.base_url 		= baseURL;		
		total_pages			= full_pages + spill_pages;
	}
	
	/**
	* @see option names are provided for broad compatibility with Codeigniter 1.6+ with extentions unique to Webrathea
	* @see config is an anonymous dynamic object formatted (for example):
	* @see {link_class : "link special", nolink_class : "greyed"}
	* @param this.base_url A required parameter, baseURL of the controller/method including the website base.
	* @param url_segment the segment number carrying the current page number - this is defaults to seg. 3 which assumes a path of uri://controller/method/page
	* @param full_tag_open HTML inserted BEFORE the entire paginator string is output - typically a DIV section.
	* @param full_tag_close HTML inserted AFTER the entire paginator string is output - typically a closing DIV.
	* @param first_tag_open HTML before the FIRST PAGE link.
	* @param first_link HTML character or phrase denoting the FIRST page link. Defaults to "<<". Use of entities such as &rsaquo is discouraged,
	* @param first_link_id unique DIV ID of the first link for scripting the link
	* @param first_tag_close HTML after the FIRST PAGE link.
	* @param last_tag_open HTML before the LAST PAGE link.
	* @param last_link HTML character or phrase denoting the LAST page link. Defaults to ">>".
	* @param last_tag_close HTML after the LAST PAGE link.
	* @param last_link_id unique DIV ID of the last link for scripting the link
	* @param next_link HTML or character denoting move UP one page. Defaults to ">"
	* @param next_link_id see first_link_id
	* @param next_tag_open see first_tag_open
	* @param next_tag_close see first_tag_close
	* @param prev_link see first_link
	* @param prev_link_id see first_link_id
	* @param prev_tag_open see first_tag_open
	* @param prev_tag_close see first_tag_close
	* @param number_class style definition applied to every page number except the current page
	* @param link_class style definition applied to every non-numeric link
	* @param nolink_class style definition applied to the current page
	* @param elipses Used when there are more pages available than can be displayed (can appear either or both sides). Defaults to "..."
	* @param separator separates the numbers when used. Defaults to "-"
	* @param sideband_width the number of pages on either side of the CURRENT page (where available.) If more pages are available, a ELIPSES is displayed.
	* @param hints Include hints in the links such as Page X of Y
	* @returns A formatted string ready to insert into your HTML
	*/
	public function generate_links(config : Dynamic) : String
	{	
		
		var	router_params	= Router.get_instance().get_params();
		var option_value	: Dynamic;							
		var uri_segment		= 2;								
		var full_tag_open	= "";
		var full_tag_close	= "";
		var first_link		= "<<";
		var first_tag_open	= "";
		var first_tag_close	= "";
		var first_link_id	= "first_paginated_link";
		var last_link		= ">>";
		var last_tag_open	= "";
		var last_tag_close	= "";
		var last_link_id	= "last_paginated_link";
		var next_link		= ">";
		var next_tag_open	= "";
		var next_tag_close	= "";
		var next_link_id	= "next_paginated_link";
		var prev_link		= "<";
		var prev_tag_open	= "";
		var prev_tag_close	= "";
		var prev_link_id	= "prev_paginated_link";
		var elipses			= "...";
		var separator		= "-";
		var number_class	= "";
		var cur_tag_open	= "";
		var cur_tag_close	= "";
		var num_tag_open	= "";
		var num_tag_close	= "";
		var link_class		= "";
		var nolink_class	= "";
		var sideband_width	= 5;
		var sband			: Int;
		var hints 			= true;

		var options 		= Reflect.fields(config);						// read the override options
		var urls 			= new StringBuf();
		
		
		for (option_name in options)								// and iterate over them
		{
			option_value = Reflect.field(config, option_name);		
			
			switch (option_name)
			{				
				//normally segmented URIs place the current page number in SEG 2 (CONTROLLER/METHOD/**PAGE**)				
				case "this.base_url":
				{
					this.base_url = (option_value != null) ? option_value : this.base_url;
				}
				//normally segmented URIs place the current page number in SEG 2 (CONTROLLER/METHOD/**PAGE**)				
				case "uri_segment":
				{
					uri_segment = (option_value != null) ? option_value : uri_segment;
				}
				
				// the maximum number of links to show either side of the current page (insert a continuation marker if exceeded)
				case "sideband_width":
				{
					sideband_width = (option_value != null) ? option_value : sideband_width;
				}

				// Separator (where required) divides up the results.
				case "separator":
				{
					separator = (option_value != null) ? option_value : separator;
				}

				// Full tag encloses the whole "" so you can style it with a DIV or whatever.
				case "full_tag_open":
				{
					full_tag_open = (option_value != null) ? option_value : full_tag_open;
				}
				case "full_tag_close":
				{
					full_tag_close = (option_value != null) ? option_value : full_tag_close;
				}

				// First link is the very first page.
				case "first_link":
				{
					first_link = (option_value != null) ? option_value : first_link;
				}
				case "first_tag_open":
				{
					first_tag_open = (option_value != null) ? option_value : first_tag_open;
				}
				case "first_tag_close":
				{
					first_tag_close = (option_value != null) ? option_value : first_tag_close;
				}
				case "first_link_id":
				{
					first_link_id = (option_value != null) ? option_value : first_link_id;
				}

				// Last link is the very last page.
				case "last_link":
				{
					last_link = (option_value != null) ? option_value : last_link;
				}
				case "last_tag_open":
				{
					last_tag_open = (option_value != null) ? option_value : last_tag_open;
				}
				case "last_tag_close":
				{
					last_tag_close = (option_value != null) ? option_value : last_tag_close;
				}
				case "last_link_id":
				{
					last_link_id = (option_value != null) ? option_value : last_link_id;
				}

				// Next available page link
				case "next_link":
				{
					next_link = (option_value != null) ? option_value : next_link;
				}
				case "next_tag_open":
				{
					full_tag_open = (option_value != null) ? option_value : full_tag_open;
				}
				case "next_tag_close":
				{
					next_tag_close = (option_value != null) ? option_value : next_tag_close;
				}

				// Go back one page link
				case "prev_link":
				{
					prev_link = (option_value != null) ? option_value : prev_link;
				}
				case "prev_tag_open":
				{
					prev_tag_open = (option_value != null) ? option_value : prev_tag_open;
				}
				case "prev_tag_close":
				{
					prev_tag_close = (option_value != null) ? option_value : prev_tag_close;
				}
				case "prev_link_id":
				{
					prev_link_id = (option_value != null) ? option_value : prev_link_id;
				}

				// Styles for the current page on display
				case "cur_tag_open":
				{
					cur_tag_open = (option_value != null) ? option_value : cur_tag_open;
				}
				case "cur_tag_close":
				{
					cur_tag_close = (option_value != null) ? option_value : cur_tag_close;
				}

				case "num_tag_open":
				{
					num_tag_open = (option_value != null) ? option_value : num_tag_open;
				}
				case "num_tag_close":
				{
					num_tag_close = (option_value != null) ? option_value : num_tag_close;
				}

				// When more than X links are show, elipses continuation is shown. This allows you to customise
				case "elipses":
				{
					elipses = (option_value != null) ? option_value : elipses;
				}

				case "link_class":
				{
					link_class = (option_value != null) ? option_value : link_class;
				}
				
				case "nolink_class":
				{
					nolink_class = (option_value != null) ? option_value : nolink_class;
				}
			}

		}

		var current_page	= (router_params[uri_segment] == null) ? 1 : Std.parseInt(router_params[uri_segment]);
	
		if (current_page < 1)
		{
			current_page = 1;
		}
	
		if (current_page > total_pages)
		{
			current_page = total_pages;
		}
	
		urls.add(full_tag_open);
	
		var attribs		= new Attributes();
		attribs.id 		= first_link_id;
		attribs.iclass	= link_class;
		
		if (current_page > 1)
		{

			attribs.id = first_link_id;
			urls.add(first_tag_open);
			urls.add(WB.make_link(this.base_url + "1", first_link, attribs));
			urls.add(first_tag_close);

			urls.add(separator);

			attribs.id 	= prev_link_id;
			urls.add(prev_tag_open);
			urls.add(WB.make_link(this.base_url + Std.string(current_page -1), prev_link, attribs));
			urls.add(prev_tag_close);
		}
	
		// do the page numbers UP TO the current page
	
		sband = (current_page - sideband_width > 1) ? current_page - sideband_width : 1;
				
		urls.add( (sband == 1) ? separator : elipses);
	
		attribs.id 	= null;
		for (i in sband...current_page)
		{
			
			attribs.title 	= (hints) ? Std.string(i) + W._OF + Std.string(total_pages) : "";
			urls.add(num_tag_open);
			urls.add(WB.make_link(this.base_url + Std.string(i), Std.string(i), attribs));
			urls.add(num_tag_close);
			urls.add(separator);
		}
		
		// deal with the CURRENT page					
		urls.add(cur_tag_open);
		urls.add("<span class=\""+ nolink_class +"\">" + Std.string(current_page) + "</span>");
		urls.add(cur_tag_close);
	
		// do the page numbers AFTER the current page
	
		sband = (current_page + sideband_width < total_pages) ? current_page + sideband_width +1 : total_pages +1;
	
		for (i in (current_page +1) ... sband )
		{
			attribs.title 	= (hints) ? Std.string(i) + W._OF + Std.string(total_pages) : "";
			urls.add(separator);
			urls.add(num_tag_open);
			urls.add(WB.make_link(this.base_url + Std.string(i), Std.string(i), attribs));
			urls.add(num_tag_close);
		}
	
		urls.add( (sband == total_pages +1) ? separator : elipses);
	
		// deal with the VERY last page links

		urls.add(last_tag_open);

		if (current_page < total_pages)
		{
			attribs.id 		= next_link_id;
			attribs.title 	= null;
			urls.add(next_tag_open);
			urls.add(WB.make_link(this.base_url + Std.string(current_page +1), next_link, attribs));
			urls.add(next_tag_close);
			
			urls.add(separator);

			attribs.id 		= last_link_id;
			urls.add(last_tag_open);
			urls.add(WB.make_link(this.base_url + Std.string(total_pages), last_link, attribs));
			urls.add(last_tag_close);
		}

		urls.add(last_tag_close);

		// close the final tag
		urls.add(full_tag_close);
		current_links = urls.toString();
		return current_links;
	}
	
	/**
	* @return A string containing the last set of links generated. 
	* This function can be used multiple times for speed, but custom options should be sepecified by generate_links FIRST
	*/
	public function get_current_links() : String
	{	
		if (current_links == null)
		{
			generate_links({});
		}
		return current_links;
	}

}
