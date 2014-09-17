<?php

class haxe_Timer {
	public function __construct(){}
	static function stamp() {
		return Sys::time();
	}
	function __toString() { return 'haxe.Timer'; }
}
