<?php

class haxe_xml__Fast_NodeAccess {
	public function __construct($x) {
		if(!php_Boot::$skip_constructor) {
		$this->__x = $x;
	}}
	public $__x;
	public function resolve($name) {
		$x = $this->__x->elementsNamed($name)->next();
		if($x === null) {
			$xname = null;
			if((is_object($_t = $this->__x->nodeType) && !($_t instanceof Enum) ? $_t === Xml::$Document : $_t == Xml::$Document)) {
				$xname = "Document";
			} else {
				$xname = $this->__x->get_nodeName();
			}
			throw new HException(_hx_string_or_null($xname) . " is missing element " . _hx_string_or_null($name));
		}
		return new haxe_xml_Fast($x);
	}
	public $__dynamics = array();
	public function __get($n) {
		if(isset($this->__dynamics[$n]))
			return $this->__dynamics[$n];
	}
	public function __set($n, $v) {
		$this->__dynamics[$n] = $v;
	}
	public function __call($n, $a) {
		if(isset($this->__dynamics[$n]) && is_callable($this->__dynamics[$n]))
			return call_user_func_array($this->__dynamics[$n], $a);
		if('toString' == $n)
			return $this->__toString();
		throw new HException("Unable to call <".$n.">");
	}
	function __toString() { return 'haxe.xml._Fast.NodeAccess'; }
}
