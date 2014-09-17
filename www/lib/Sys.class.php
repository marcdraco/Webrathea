<?php

class Sys {
	public function __construct(){}
	static function time() {
		return microtime(true);
	}
	function __toString() { return 'Sys'; }
}
