<?php

class Math {
	public function __construct(){}
	static $PI;
	static $NaN;
	static $POSITIVE_INFINITY;
	static $NEGATIVE_INFINITY;
	static function abs($v) {
		return abs($v);
	}
	static function round($v) {
		return (int) floor($v + 0.5);
	}
	static function ceil($v) {
		return (int) ceil($v);
	}
	static function isNaN($f) {
		return is_nan($f);
	}
	static function isFinite($f) {
		return is_finite($f);
	}
	function __toString() { return 'Math'; }
}
{
	Math::$PI = M_PI;
	Math::$NaN = acos(1.01);
	Math::$NEGATIVE_INFINITY = log(0);
	Math::$POSITIVE_INFINITY = -Math::$NEGATIVE_INFINITY;
}
