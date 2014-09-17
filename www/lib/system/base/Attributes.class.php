<?php

class system_base_Attributes {
	public function __construct($iclass = null, $i_id = null, $style = null, $title = null, $valign = null, $accesskey = null, $tabindex = null, $xml_lang = null, $nonw3c = null, $i_lang = null, $dir = null) {
		if(!php_Boot::$skip_constructor) {
		$this->set_iclass((($iclass === null) ? null : $iclass));
		$this->set_dir((($dir === null) ? null : $dir));
		$this->set_id(system_base_Attributes_0($this, $accesskey, $dir, $i_id, $i_lang, $iclass, $nonw3c, $style, $tabindex, $title, $valign, $xml_lang));
		$this->set_lang(system_base_Attributes_1($this, $accesskey, $dir, $i_id, $i_lang, $iclass, $nonw3c, $style, $tabindex, $title, $valign, $xml_lang));
		$this->set_style((($style === null) ? null : $style));
		$this->set_title((($title === null) ? null : $title));
		$this->set_tabindex((($tabindex === null) ? null : $tabindex));
		$this->set_accesskey((($accesskey === null) ? null : $accesskey));
		$this->set_xml_lang((($xml_lang === null) ? null : $xml_lang));
		$this->set_nonw3c((($nonw3c === null) ? null : $nonw3c));
	}}
	public $iclass;
	public $dir;
	public $id;
	public $lang;
	public $style;
	public $title;
	public $accesskey;
	public $tabindex;
	public $xml_lang;
	public $nonw3c;
	public function insert_attributes() {
		return _hx_string_or_null($this->id) . _hx_string_or_null($this->iclass) . _hx_string_or_null($this->style) . _hx_string_or_null($this->lang) . _hx_string_or_null($this->dir) . _hx_string_or_null($this->title) . _hx_string_or_null($this->accesskey) . _hx_string_or_null($this->xml_lang) . _hx_string_or_null($this->nonw3c) . _hx_string_or_null((system_base_Attributes_2($this)));
	}
	public function set_iclass($v) {
		return system_base_Attributes_3($this, $v);
	}
	public function set_dir($v) {
		return system_base_Attributes_4($this, $v);
	}
	public function set_id($v) {
		return system_base_Attributes_5($this, $v);
	}
	public function set_lang($v) {
		return system_base_Attributes_6($this, $v);
	}
	public function set_style($v) {
		return system_base_Attributes_7($this, $v);
	}
	public function set_title($v) {
		return system_base_Attributes_8($this, $v);
	}
	public function set_tabindex($v) {
		return system_base_Attributes_9($this, $v);
	}
	public function set_accesskey($v) {
		return system_base_Attributes_10($this, $v);
	}
	public function set_xml_lang($v) {
		return system_base_Attributes_11($this, $v);
	}
	public function set_nonw3c($v) {
		return system_base_Attributes_12($this, $v);
	}
	public function __call($m, $a) {
		if(isset($this->$m) && is_callable($this->$m))
			return call_user_func_array($this->$m, $a);
		else if(isset($this->__dynamics[$m]) && is_callable($this->__dynamics[$m]))
			return call_user_func_array($this->__dynamics[$m], $a);
		else if('toString' == $m)
			return $this->__toString();
		else
			throw new HException('Unable to call <'.$m.'>');
	}
	static $__properties__ = array("set_nonw3c" => "set_nonw3c","set_xml_lang" => "set_xml_lang","set_tabindex" => "set_tabindex","set_accesskey" => "set_accesskey","set_title" => "set_title","set_style" => "set_style","set_lang" => "set_lang","set_id" => "set_id","set_dir" => "set_dir","set_iclass" => "set_iclass");
	function __toString() { return 'system.base.Attributes'; }
}
function system_base_Attributes_0(&$__hx__this, &$accesskey, &$dir, &$i_id, &$i_lang, &$iclass, &$nonw3c, &$style, &$tabindex, &$title, &$valign, &$xml_lang) {
	if($i_id === null) {
		return null;
	} else {
		return $__hx__this->id;
	}
}
function system_base_Attributes_1(&$__hx__this, &$accesskey, &$dir, &$i_id, &$i_lang, &$iclass, &$nonw3c, &$style, &$tabindex, &$title, &$valign, &$xml_lang) {
	if($i_lang === null) {
		return null;
	} else {
		return $__hx__this->lang;
	}
}
function system_base_Attributes_2(&$__hx__this) {
	if($__hx__this->tabindex !== null) {
		return "tabindex=" . Std::string($__hx__this->tabindex);
	} else {
		return "";
	}
}
function system_base_Attributes_3(&$__hx__this, &$v) {
	if($v === null) {
		return $__hx__this->iclass = "";
	} else {
		return $__hx__this->iclass = " class=\"" . _hx_string_or_null($v) . "\" ";
	}
}
function system_base_Attributes_4(&$__hx__this, &$v) {
	if($v === null) {
		return $__hx__this->dir = "";
	} else {
		return $__hx__this->dir = " dir=\"" . _hx_string_or_null($v) . "\" ";
	}
}
function system_base_Attributes_5(&$__hx__this, &$v) {
	if($v === null) {
		return $__hx__this->id = "";
	} else {
		return $__hx__this->id = " id=\"" . _hx_string_or_null($v) . "\" ";
	}
}
function system_base_Attributes_6(&$__hx__this, &$v) {
	if($v === null) {
		return $__hx__this->lang = "";
	} else {
		return $__hx__this->lang = " lang=\"" . _hx_string_or_null($v) . "\" ";
	}
}
function system_base_Attributes_7(&$__hx__this, &$v) {
	if($v === null) {
		return $__hx__this->style = "";
	} else {
		return $__hx__this->style = " style=\"" . _hx_string_or_null($v) . "\" ";
	}
}
function system_base_Attributes_8(&$__hx__this, &$v) {
	if($v === null) {
		return $__hx__this->title = "";
	} else {
		return $__hx__this->title = " title=\"" . _hx_string_or_null($v) . "\" ";
	}
}
function system_base_Attributes_9(&$__hx__this, &$v) {
	if($v === null) {
		return $__hx__this->tabindex = null;
	} else {
		return $__hx__this->tabindex = $v;
	}
}
function system_base_Attributes_10(&$__hx__this, &$v) {
	if($v === null) {
		return $__hx__this->accesskey = "";
	} else {
		return $__hx__this->accesskey = " accesskey=\"" . _hx_string_or_null($v) . "\" ";
	}
}
function system_base_Attributes_11(&$__hx__this, &$v) {
	if($v === null) {
		return $__hx__this->xml_lang = "";
	} else {
		return $__hx__this->xml_lang = " xml:lang=\"" . _hx_string_or_null($v) . "\" ";
	}
}
function system_base_Attributes_12(&$__hx__this, &$v) {
	if($v === null) {
		return $__hx__this->nonw3c = "";
	} else {
		return $__hx__this->nonw3c = " " . _hx_string_or_null($__hx__this->nonw3c) . " ";
	}
}
