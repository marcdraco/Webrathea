<?php

class system_base_Profiler {
	public function __construct() { 
	}
	public function increment($name, $time, $sql = null) {
		switch($name) {
		case "INS":{
			system_base_Profiler::$inserts->add_sql($time, $sql);
		}break;
		case "UPD":{
			system_base_Profiler::$updates->add_sql($time, $sql);
		}break;
		case "DEL":{
			system_base_Profiler::$deletes->add_sql($time, $sql);
		}break;
		case "SEL":{
			system_base_Profiler::$selects->add_sql($time, $sql);
		}break;
		case "OTH":{
			system_base_Profiler::$others->add_sql($time, $sql);
		}break;
		case "CON":{
			system_base_Profiler::$connections->add($time);
		}break;
		case "QUE":{
			system_base_Profiler::$query->add($time);
		}break;
		case "LOG":{
			system_base_Profiler::$logic->add($time);
		}break;
		case "PRE":{
			system_base_Profiler::$prepare->add_sql($time, $sql);
		}break;
		case "EXE":{
			system_base_Profiler::$execute->add_sql($time, $sql);
		}break;
		case "SET":{
			system_base_Profiler::$setting->add_sql($time, $sql);
		}break;
		default:{
			$message = null;
			$message = Std::string("Function: {" . _hx_string_or_null($name) . "}" . " is not registered with the profiler" . "<br>");
			haxe_Log::trace("DEPRECATED FUNCTION: " . _hx_string_or_null($message), _hx_anonymous(array("fileName" => "Base.hx", "lineNumber" => 449, "className" => "system.base.Wet_base", "methodName" => "echo")));
		}break;
		}
	}
	public function get($name) {
		switch($name) {
		case "INS":{
			return system_base_Profiler::$inserts;
		}break;
		case "UPD":{
			return system_base_Profiler::$updates;
		}break;
		case "DEL":{
			return system_base_Profiler::$deletes;
		}break;
		case "SEL":{
			return system_base_Profiler::$selects;
		}break;
		case "OTH":{
			return system_base_Profiler::$others;
		}break;
		case "CON":{
			return system_base_Profiler::$connections;
		}break;
		case "QUE":{
			return system_base_Profiler::$query;
		}break;
		case "LOG":{
			return system_base_Profiler::$logic;
		}break;
		case "PRE":{
			return system_base_Profiler::$prepare;
		}break;
		case "EXE":{
			return system_base_Profiler::$execute;
		}break;
		case "SET":{
			return system_base_Profiler::$setting;
		}break;
		default:{
			throw new HException("Function " . _hx_string_or_null($name) . " is not registered with the profiler");
		}break;
		}
	}
	static $instance;
	static $start_time;
	static $stop_time;
	static $run_time;
	static $query;
	static $connections;
	static $inserts;
	static $updates;
	static $deletes;
	static $selects;
	static $others;
	static $prepare;
	static $execute;
	static $logic;
	static $setting;
	static function get_instance() {
		if(system_base_Profiler::$instance === null) {
			system_base_Profiler::$instance = new system_base_Profiler();
		}
		return system_base_Profiler::$instance;
	}
	static function stop() {
		system_base_Profiler::$stop_time = haxe_Timer::stamp();
		system_base_Profiler::$run_time = system_base_Profiler::$stop_time - system_base_Profiler::$start_time;
		return system_base_Profiler::$run_time;
	}
	static function lap() {
		return haxe_Timer::stamp() - system_base_Profiler::$start_time;
	}
	function __toString() { return 'system.base.Profiler'; }
}
system_base_Profiler::$start_time = haxe_Timer::stamp();
system_base_Profiler::$query = new system_base_Pcall_sql();
system_base_Profiler::$connections = new system_base_Pcall_sql();
system_base_Profiler::$inserts = new system_base_Pcall_sql();
system_base_Profiler::$updates = new system_base_Pcall_sql();
system_base_Profiler::$deletes = new system_base_Pcall_sql();
system_base_Profiler::$selects = new system_base_Pcall_sql();
system_base_Profiler::$others = new system_base_Pcall_sql();
system_base_Profiler::$prepare = new system_base_Pcall_sql();
system_base_Profiler::$execute = new system_base_Pcall_sql();
system_base_Profiler::$logic = new system_base_Pcall_sql();
system_base_Profiler::$setting = new system_base_Pcall_sql();
