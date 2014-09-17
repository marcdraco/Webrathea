<?php

class system_base_Tabulator {
	public function __construct(){}
	static function tabulate($o, $headings, $footers, $table, $header, $body, $footer, $rowA, $rowB, $tcol, $tcol_pos) {
		$output = new StringBuf();
		$i = null;
		$j = null;
		$fields = Reflect::fields($o[0]);
		$defs = null;
		$tcol_pos = system_base_Tabulator_0($body, $defs, $fields, $footer, $footers, $header, $headings, $i, $j, $o, $output, $rowA, $rowB, $table, $tcol, $tcol_pos);
		$output->b .= "<table " . (system_base_Tabulator_1($body, $defs, $fields, $footer, $footers, $header, $headings, $i, $j, $o, $output, $rowA, $rowB, $table, $tcol, $tcol_pos)) . ">";
		if($headings === null) {
			$output->b .= "<thead" . (system_base_Tabulator_2($body, $defs, $fields, $footer, $footers, $header, $headings, $i, $j, $o, $output, $rowA, $rowB, $table, $tcol, $tcol_pos)) . ">";
			$output->b .= "<tr>";
			{
				$_g1 = 0; $_g = $fields->length;
				while($_g1 < $_g) {
					$i1 = $_g1++;
					$output->b .= "<th>" . $fields[$i1] . "</th>";
					unset($i1);
				}
			}
			$output->b .= "</tr></thead>";
		} else {
			$output->b .= "<thead" . (system_base_Tabulator_3($body, $defs, $fields, $footer, $footers, $header, $headings, $i, $j, $o, $output, $rowA, $rowB, $table, $tcol, $tcol_pos)) . ">";
			$output->b .= "<tr>";
			{
				$_g1 = 0; $_g = $headings->length;
				while($_g1 < $_g) {
					$i1 = $_g1++;
					if($i1 === $tcol_pos) {
						$output->b .= "<th" . (system_base_Tabulator_4($_g, $_g1, $body, $defs, $fields, $footer, $footers, $header, $headings, $i, $i1, $j, $o, $output, $rowA, $rowB, $table, $tcol, $tcol_pos)) . ">" . $headings[$i1] . "</th>";
					} else {
						$output->b .= "<th>" . $headings[$i1] . "</th>";
					}
					unset($i1);
				}
			}
			$output->b .= "</tr></thead>";
		}
		if($footers !== null) {
			$output->b .= "<tfoot" . (system_base_Tabulator_5($body, $defs, $fields, $footer, $footers, $header, $headings, $i, $j, $o, $output, $rowA, $rowB, $table, $tcol, $tcol_pos)) . ">";
			$output->b .= "<tr>";
			{
				$_g1 = 0; $_g = $footers->length;
				while($_g1 < $_g) {
					$i1 = $_g1++;
					if($i1 === $tcol_pos) {
						$output->b .= "<td" . (system_base_Tabulator_6($_g, $_g1, $body, $defs, $fields, $footer, $footers, $header, $headings, $i, $i1, $j, $o, $output, $rowA, $rowB, $table, $tcol, $tcol_pos)) . ">" . $footers[$i1] . "</td>";
					} else {
						$output->b .= "<td>" . $footers[$i1] . "</td>";
					}
					unset($i1);
				}
			}
			$output->b .= "</tr></tfoot>";
		}
		$output->b .= "<tbody" . (system_base_Tabulator_7($body, $defs, $fields, $footer, $footers, $header, $headings, $i, $j, $o, $output, $rowA, $rowB, $table, $tcol, $tcol_pos)) . ">";
		$toggle = true;
		{
			$_g1 = 0; $_g = $o->length;
			while($_g1 < $_g) {
				$i1 = $_g1++;
				$output->b .= "<tr" . (system_base_Tabulator_8($_g, $_g1, $body, $defs, $fields, $footer, $footers, $header, $headings, $i, $i1, $j, $o, $output, $rowA, $rowB, $table, $tcol, $tcol_pos, $toggle)) . ">";
				{
					$_g3 = 0; $_g2 = $fields->length;
					while($_g3 < $_g2) {
						$j1 = $_g3++;
						if($j1 === $tcol_pos) {
							$output->b .= "<td" . (system_base_Tabulator_9($_g, $_g1, $_g2, $_g3, $body, $defs, $fields, $footer, $footers, $header, $headings, $i, $i1, $j, $j1, $o, $output, $rowA, $rowB, $table, $tcol, $tcol_pos, $toggle)) . ">" . Reflect::field($o[$i1], $fields[$j1]) . "</td>";
						} else {
							$output->b .= "<td>" . Reflect::field($o[$i1], $fields[$j1]) . "</td>";
						}
						unset($j1);
					}
					unset($_g3,$_g2);
				}
				$output->b .= "</tr>";
				$toggle = $toggle === false;
				unset($i1);
			}
		}
		$output->b .= "</tbody></table>";
		return $output->b;
	}
	function __toString() { return 'system.base.Tabulator'; }
}
function system_base_Tabulator_0(&$body, &$defs, &$fields, &$footer, &$footers, &$header, &$headings, &$i, &$j, &$o, &$output, &$rowA, &$rowB, &$table, &$tcol, &$tcol_pos) {
	if($tcol_pos === null) {
		return 0;
	} else {
		return $tcol_pos;
	}
}
function system_base_Tabulator_1(&$body, &$defs, &$fields, &$footer, &$footers, &$header, &$headings, &$i, &$j, &$o, &$output, &$rowA, &$rowB, &$table, &$tcol, &$tcol_pos) {
	if($table !== null) {
		return $table->insert_attributes();
	} else {
		return "";
	}
}
function system_base_Tabulator_2(&$body, &$defs, &$fields, &$footer, &$footers, &$header, &$headings, &$i, &$j, &$o, &$output, &$rowA, &$rowB, &$table, &$tcol, &$tcol_pos) {
	if($header !== null) {
		return $header->insert_attributes();
	} else {
		return "";
	}
}
function system_base_Tabulator_3(&$body, &$defs, &$fields, &$footer, &$footers, &$header, &$headings, &$i, &$j, &$o, &$output, &$rowA, &$rowB, &$table, &$tcol, &$tcol_pos) {
	if($header !== null) {
		return $header->insert_attributes();
	} else {
		return "";
	}
}
function system_base_Tabulator_4(&$_g, &$_g1, &$body, &$defs, &$fields, &$footer, &$footers, &$header, &$headings, &$i, &$i1, &$j, &$o, &$output, &$rowA, &$rowB, &$table, &$tcol, &$tcol_pos) {
	if($tcol !== null) {
		return $tcol->insert_attributes();
	} else {
		return "";
	}
}
function system_base_Tabulator_5(&$body, &$defs, &$fields, &$footer, &$footers, &$header, &$headings, &$i, &$j, &$o, &$output, &$rowA, &$rowB, &$table, &$tcol, &$tcol_pos) {
	if($footer !== null) {
		return $footer->insert_attributes();
	} else {
		return "";
	}
}
function system_base_Tabulator_6(&$_g, &$_g1, &$body, &$defs, &$fields, &$footer, &$footers, &$header, &$headings, &$i, &$i1, &$j, &$o, &$output, &$rowA, &$rowB, &$table, &$tcol, &$tcol_pos) {
	if($tcol !== null) {
		return $tcol->insert_attributes();
	} else {
		return "";
	}
}
function system_base_Tabulator_7(&$body, &$defs, &$fields, &$footer, &$footers, &$header, &$headings, &$i, &$j, &$o, &$output, &$rowA, &$rowB, &$table, &$tcol, &$tcol_pos) {
	if($body !== null) {
		return $body->insert_attributes();
	} else {
		return "";
	}
}
function system_base_Tabulator_8(&$_g, &$_g1, &$body, &$defs, &$fields, &$footer, &$footers, &$header, &$headings, &$i, &$i1, &$j, &$o, &$output, &$rowA, &$rowB, &$table, &$tcol, &$tcol_pos, &$toggle) {
	if($toggle === true) {
		return $rowA->insert_attributes();
	} else {
		return $rowB->insert_attributes();
	}
}
function system_base_Tabulator_9(&$_g, &$_g1, &$_g2, &$_g3, &$body, &$defs, &$fields, &$footer, &$footers, &$header, &$headings, &$i, &$i1, &$j, &$j1, &$o, &$output, &$rowA, &$rowB, &$table, &$tcol, &$tcol_pos, &$toggle) {
	if($tcol !== null) {
		return $tcol->insert_attributes();
	} else {
		return "";
	}
}
