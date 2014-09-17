package system.application.controllers;
import system.base.Attributes;
import system.base.Controller;
import system.base.Base;
import system.base.Config;
import system.base.Database;
import system.base.Db_cache;
import system.base.Hashes;
import system.base.Sql_colour;
import system.base.Tabulator;
import system.base.Timers;
import system.base.Paginator;

class Front extends Controller
{
	
	public function new() 
	{
		super();
	}
	
	override public function index()
	{
		demo();
		
	}	
	
	function demo2()
	{
		cache.append("<html><head></head><body>");
	}
	
	function demo()
	{
		cache.append("<html><head></head><body>");
		var pg = new Paginator("http://localhost:8888/?front/demo/",200,5);
		pg.generate_links({separator : " ", sideband_width : 6});
		trace(pg.get_current_links());
		cache.append("<img src='http://localhost:8888/?_load/sxy.jpg'> </img>");
	
		route = system.base.Router.get_instance();
	
		trace(WB.create_asset_src("sxy.jpg"));
		
		var rb = new WA("red bold","test");
		trace(rb.insert_attributes());
		
		trace(WB.make_http_link("www.google.com","Google",rb));
		trace(WB.cache_path);
		trace(WB.get_hostname());
		
		trace(WB.get_file_etag(WB.views_path + "simple_view.wtv" ));
		trace(WB.get_file_etag(WB.views_path + "simple_view2.wtv" ));
		trace(WB.is_directory(WB.views_path + "simple_view2.wtv" ));
		trace(WB.is_directory(WB.views_path));
		WB.set_file_etag(WB.views_path + "simple_view2.wtv" );		
		trace(haxe.Timer.stamp());

		//trace(Sql_colour.pretify("SELECT WHERE T='2' AND E='3' AND D='4';"));
		//ar bs = {name: "marc", sex: "yes", wank : 20};
		
		//load_view_object("simple_view2",bs);
		
		//trace(Tabulator.tabulate([{a : 2, b: 3, c : "String"}, {a : 5, b: 3, c : "New "}, {a : 5, b: 3, c : "Jac is nuttyString"}, {a : 5, b: 3, c : "New String"}, {a : 5, b: 3, c : "New String"}], ["total", "part", "avg"], ["total", "part", "avg"],a,a,a,a,ra,rb,rf,0));
		
		///trace(Database.cached_query("select * from test where id in (select id from test where id between 1 and ?)",[5]));
		//trace(Database.cached_query("select * from test where id in (select id from test where id between 1 and ?)",[6]));
		//trace(Database.cached_query("select * from test where id in (select id from test where id between 1 and ?)",[90]));
/*
		var db = Database.get_instance("mysql",true);
		db.query("select * from test where id in (select id from test where id between 1 and ?)",[5]);
		db.query("select * from test where id in (select id from test where id between 1 and ?)",[199]);
*/

		cache.inject_style(".red {color:red}");
		cache.inject_style(".bold", "font-weight: bold;");
		cache.append("<span class='bold red'>This is a test run...</span>");		
		cache.append("This is a working copy" + Std.string(params));
		cache.append("</body></html>");
	}
}
