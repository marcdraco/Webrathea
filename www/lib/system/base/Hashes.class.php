<?php

class system_base_Hashes {
	public function __construct(){}
	static function do_hash($s) {
		$b = 378551;
		$a = 63689;
		$hash = 0;
		$i = 0;
		{
			$_g1 = 0;
			$_g = strlen($s);
			while($_g1 < $_g) {
				$i1 = $_g1++;
				$hash = $hash * $a + _hx_char_code_at($s, $i1);
				$a = $a * $b;
				unset($i1);
			}
		}
		return Math::abs($hash);
	}
	function __toString() { return 'system.base.Hashes'; }
}
