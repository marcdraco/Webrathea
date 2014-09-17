<?php

class StringTools {
	public function __construct(){}
	static function htmlEscape($s, $quotes = null) {
		$s = _hx_explode(">", _hx_explode("<", _hx_explode("&", $s)->join("&amp;"))->join("&lt;"))->join("&gt;");
		if($quotes) {
			return _hx_explode("'", _hx_explode("\"", $s)->join("&quot;"))->join("&#039;");
		} else {
			return $s;
		}
	}
	static function hex($n, $digits = null) {
		$s = dechex($n);
		$len = 8;
		if(strlen($s) > (StringTools_0($digits, $len, $n, $s))) {
			$s = _hx_substr($s, -$len, null);
		} else {
			if($digits !== null) {
				if(strlen("0") === 0 || strlen($s) >= $digits) {
					$s = $s;
				} else {
					$s = str_pad($s, Math::ceil(($digits - strlen($s)) / strlen("0")) * strlen("0") + strlen($s), "0", STR_PAD_LEFT);
				}
			}
		}
		return strtoupper($s);
	}
	function __toString() { return 'StringTools'; }
}
function StringTools_0(&$digits, &$len, &$n, &$s) {
	if(null === $digits) {
		return $len;
	} else {
		if($digits > $len) {
			return $len = $digits;
		} else {
			return $len = $len;
		}
	}
}
