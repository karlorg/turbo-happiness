#if php
import php.Lib;
import php.Web;
#elseif neko
import neko.Lib;
import neko.Web;
#end

import haxe.web.Dispatch;
import sys.db.Types;

class Index {

	#if php
	static var platform = "PHP";
	#elseif neko
	static var platform = "neko";
	#end

	static var dbconn : Null<sys.db.Connection> = null;

	public static function main() {
		try {
			Dispatch.run(Web.getURI(), Web.getParams(), Index);
		} catch (de : DispatchError) {
			switch (de) {
				case DENotFound(part):
					Lib.print("No such page: " + part);
				case DEInvalidValue:
					Lib.print("Invalid value");
				case DEMissingParam(p):
					Lib.print("Missing parameter: " + p);
				case DETooManyValues:
					Lib.print("Too many values");
				default:
					Lib.print("Weird error");
			}
		}
	}

	private static function initDb() : Void {
		if (dbconn == null) {
			sys.db.Manager.initialize();
			dbconn = sys.db.Sqlite.open("test.sqlite");
			sys.db.Manager.cnx = dbconn;
		}
		if (!sys.db.TableCreate.exists(TestTable.manager)) {
			sys.db.TableCreate.create(TestTable.manager);
		}
	}

	public static function doCool(args : { x : Int, v : String } ) : Void {
		var str = haxe.Resource.getString("testpage");
		var t = new haxe.Template(str);
		var output = t.execute({ title: "Cool page " + platform,
								 body: "" + args.x + " " + args.v });
		Lib.print(output);
	}

	public static function doGet() : Void {
		initDb();
		var results = TestTable.manager.search(true);
		var table = "<ul>";
		for (r in results) {
			table += "<li>";
			table += r.name + ", " + r.age;
			table += "</li>";
		}
		table += "</ul>";

		var str = haxe.Resource.getString("testpage");
		var t = new haxe.Template(str);
		var output = t.execute({
			title: "DB contents " + platform,
			body: "" + table });
		Lib.print(output);
	}

	public static function doInsert(args : {
		name : String, age : Int }) : Void {
		initDb();
		var entry = new TestTable();
		entry.name = args.name;
		entry.age = args.age;
		entry.insert();

		var str = haxe.Resource.getString("testpage");
		var t = new haxe.Template(str);
		var output = t.execute({
			title: "Insert " + entry.name + " " + platform,
			body: "inserted " + entry.name + ", " + entry.age + " years old" });
		Lib.print(output);
	}

}

class TestTable extends sys.db.Object {
	public var id : SId;
	public var name : SString<32>;
	public var age : SInt;
}
