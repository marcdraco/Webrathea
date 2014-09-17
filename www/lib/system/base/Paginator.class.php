<?php

class system_base_Paginator {
	public function __construct($baseURL, $number_of_results, $results_per_page) {
		if(!php_Boot::$skip_constructor) {
		if($results_per_page <= 0) {
			throw new HException(new system_base_General_error(" results per page must be 1 or larger", 500, _hx_anonymous(array("fileName" => "Paginator.hx", "lineNumber" => 37, "className" => "system.base.Paginator", "methodName" => "new"))));
		}
		$full_pages = Math::floor($number_of_results / $results_per_page);
		$spill_pages = system_base_Paginator_0($this, $baseURL, $full_pages, $number_of_results, $results_per_page);
		$this->current_links = null;
		$this->base_url = $baseURL;
		$this->total_pages = $full_pages + $spill_pages;
	}}
	public $total_pages;
	public $base_url;
	public $current_links;
	public function generate_links($config) {
		$router_params = _hx_deref((system_base_Paginator_1($this, $config)))->params;
		$option_value = null;
		$uri_segment = 2;
		$full_tag_open = "";
		$full_tag_close = "";
		$first_link = "<<";
		$first_tag_open = "";
		$first_tag_close = "";
		$first_link_id = "first_paginated_link";
		$last_link = ">>";
		$last_tag_open = "";
		$last_tag_close = "";
		$last_link_id = "last_paginated_link";
		$next_link = ">";
		$next_tag_open = "";
		$next_tag_close = "";
		$next_link_id = "next_paginated_link";
		$prev_link = "<";
		$prev_tag_open = "";
		$prev_tag_close = "";
		$prev_link_id = "prev_paginated_link";
		$elipses = "...";
		$separator = "-";
		$number_class = "";
		$cur_tag_open = "";
		$cur_tag_close = "";
		$num_tag_open = "";
		$num_tag_close = "";
		$link_class = "";
		$nolink_class = "";
		$sideband_width = 5;
		$sband = null;
		$hints = true;
		$options = Reflect::fields($config);
		$urls = new StringBuf();
		{
			$_g = 0;
			while($_g < $options->length) {
				$option_name = $options[$_g];
				++$_g;
				$option_value = Reflect::field($config, $option_name);
				switch($option_name) {
				case "this.base_url":{
					{
						$this->base_url = system_base_Paginator_2($this, $_g, $config, $cur_tag_close, $cur_tag_open, $elipses, $first_link, $first_link_id, $first_tag_close, $first_tag_open, $full_tag_close, $full_tag_open, $hints, $last_link, $last_link_id, $last_tag_close, $last_tag_open, $link_class, $next_link, $next_link_id, $next_tag_close, $next_tag_open, $nolink_class, $num_tag_close, $num_tag_open, $number_class, $option_name, $option_value, $options, $prev_link, $prev_link_id, $prev_tag_close, $prev_tag_open, $router_params, $sband, $separator, $sideband_width, $uri_segment, $urls);
					}
				}break;
				case "uri_segment":{
					{
						$uri_segment = system_base_Paginator_3($this, $_g, $config, $cur_tag_close, $cur_tag_open, $elipses, $first_link, $first_link_id, $first_tag_close, $first_tag_open, $full_tag_close, $full_tag_open, $hints, $last_link, $last_link_id, $last_tag_close, $last_tag_open, $link_class, $next_link, $next_link_id, $next_tag_close, $next_tag_open, $nolink_class, $num_tag_close, $num_tag_open, $number_class, $option_name, $option_value, $options, $prev_link, $prev_link_id, $prev_tag_close, $prev_tag_open, $router_params, $sband, $separator, $sideband_width, $uri_segment, $urls);
					}
				}break;
				case "sideband_width":{
					{
						$sideband_width = system_base_Paginator_4($this, $_g, $config, $cur_tag_close, $cur_tag_open, $elipses, $first_link, $first_link_id, $first_tag_close, $first_tag_open, $full_tag_close, $full_tag_open, $hints, $last_link, $last_link_id, $last_tag_close, $last_tag_open, $link_class, $next_link, $next_link_id, $next_tag_close, $next_tag_open, $nolink_class, $num_tag_close, $num_tag_open, $number_class, $option_name, $option_value, $options, $prev_link, $prev_link_id, $prev_tag_close, $prev_tag_open, $router_params, $sband, $separator, $sideband_width, $uri_segment, $urls);
					}
				}break;
				case "separator":{
					{
						$separator = system_base_Paginator_5($this, $_g, $config, $cur_tag_close, $cur_tag_open, $elipses, $first_link, $first_link_id, $first_tag_close, $first_tag_open, $full_tag_close, $full_tag_open, $hints, $last_link, $last_link_id, $last_tag_close, $last_tag_open, $link_class, $next_link, $next_link_id, $next_tag_close, $next_tag_open, $nolink_class, $num_tag_close, $num_tag_open, $number_class, $option_name, $option_value, $options, $prev_link, $prev_link_id, $prev_tag_close, $prev_tag_open, $router_params, $sband, $separator, $sideband_width, $uri_segment, $urls);
					}
				}break;
				case "full_tag_open":{
					{
						$full_tag_open = system_base_Paginator_6($this, $_g, $config, $cur_tag_close, $cur_tag_open, $elipses, $first_link, $first_link_id, $first_tag_close, $first_tag_open, $full_tag_close, $full_tag_open, $hints, $last_link, $last_link_id, $last_tag_close, $last_tag_open, $link_class, $next_link, $next_link_id, $next_tag_close, $next_tag_open, $nolink_class, $num_tag_close, $num_tag_open, $number_class, $option_name, $option_value, $options, $prev_link, $prev_link_id, $prev_tag_close, $prev_tag_open, $router_params, $sband, $separator, $sideband_width, $uri_segment, $urls);
					}
				}break;
				case "full_tag_close":{
					{
						$full_tag_close = system_base_Paginator_7($this, $_g, $config, $cur_tag_close, $cur_tag_open, $elipses, $first_link, $first_link_id, $first_tag_close, $first_tag_open, $full_tag_close, $full_tag_open, $hints, $last_link, $last_link_id, $last_tag_close, $last_tag_open, $link_class, $next_link, $next_link_id, $next_tag_close, $next_tag_open, $nolink_class, $num_tag_close, $num_tag_open, $number_class, $option_name, $option_value, $options, $prev_link, $prev_link_id, $prev_tag_close, $prev_tag_open, $router_params, $sband, $separator, $sideband_width, $uri_segment, $urls);
					}
				}break;
				case "first_link":{
					{
						$first_link = system_base_Paginator_8($this, $_g, $config, $cur_tag_close, $cur_tag_open, $elipses, $first_link, $first_link_id, $first_tag_close, $first_tag_open, $full_tag_close, $full_tag_open, $hints, $last_link, $last_link_id, $last_tag_close, $last_tag_open, $link_class, $next_link, $next_link_id, $next_tag_close, $next_tag_open, $nolink_class, $num_tag_close, $num_tag_open, $number_class, $option_name, $option_value, $options, $prev_link, $prev_link_id, $prev_tag_close, $prev_tag_open, $router_params, $sband, $separator, $sideband_width, $uri_segment, $urls);
					}
				}break;
				case "first_tag_open":{
					{
						$first_tag_open = system_base_Paginator_9($this, $_g, $config, $cur_tag_close, $cur_tag_open, $elipses, $first_link, $first_link_id, $first_tag_close, $first_tag_open, $full_tag_close, $full_tag_open, $hints, $last_link, $last_link_id, $last_tag_close, $last_tag_open, $link_class, $next_link, $next_link_id, $next_tag_close, $next_tag_open, $nolink_class, $num_tag_close, $num_tag_open, $number_class, $option_name, $option_value, $options, $prev_link, $prev_link_id, $prev_tag_close, $prev_tag_open, $router_params, $sband, $separator, $sideband_width, $uri_segment, $urls);
					}
				}break;
				case "first_tag_close":{
					{
						$first_tag_close = system_base_Paginator_10($this, $_g, $config, $cur_tag_close, $cur_tag_open, $elipses, $first_link, $first_link_id, $first_tag_close, $first_tag_open, $full_tag_close, $full_tag_open, $hints, $last_link, $last_link_id, $last_tag_close, $last_tag_open, $link_class, $next_link, $next_link_id, $next_tag_close, $next_tag_open, $nolink_class, $num_tag_close, $num_tag_open, $number_class, $option_name, $option_value, $options, $prev_link, $prev_link_id, $prev_tag_close, $prev_tag_open, $router_params, $sband, $separator, $sideband_width, $uri_segment, $urls);
					}
				}break;
				case "first_link_id":{
					{
						$first_link_id = system_base_Paginator_11($this, $_g, $config, $cur_tag_close, $cur_tag_open, $elipses, $first_link, $first_link_id, $first_tag_close, $first_tag_open, $full_tag_close, $full_tag_open, $hints, $last_link, $last_link_id, $last_tag_close, $last_tag_open, $link_class, $next_link, $next_link_id, $next_tag_close, $next_tag_open, $nolink_class, $num_tag_close, $num_tag_open, $number_class, $option_name, $option_value, $options, $prev_link, $prev_link_id, $prev_tag_close, $prev_tag_open, $router_params, $sband, $separator, $sideband_width, $uri_segment, $urls);
					}
				}break;
				case "last_link":{
					{
						$last_link = system_base_Paginator_12($this, $_g, $config, $cur_tag_close, $cur_tag_open, $elipses, $first_link, $first_link_id, $first_tag_close, $first_tag_open, $full_tag_close, $full_tag_open, $hints, $last_link, $last_link_id, $last_tag_close, $last_tag_open, $link_class, $next_link, $next_link_id, $next_tag_close, $next_tag_open, $nolink_class, $num_tag_close, $num_tag_open, $number_class, $option_name, $option_value, $options, $prev_link, $prev_link_id, $prev_tag_close, $prev_tag_open, $router_params, $sband, $separator, $sideband_width, $uri_segment, $urls);
					}
				}break;
				case "last_tag_open":{
					{
						$last_tag_open = system_base_Paginator_13($this, $_g, $config, $cur_tag_close, $cur_tag_open, $elipses, $first_link, $first_link_id, $first_tag_close, $first_tag_open, $full_tag_close, $full_tag_open, $hints, $last_link, $last_link_id, $last_tag_close, $last_tag_open, $link_class, $next_link, $next_link_id, $next_tag_close, $next_tag_open, $nolink_class, $num_tag_close, $num_tag_open, $number_class, $option_name, $option_value, $options, $prev_link, $prev_link_id, $prev_tag_close, $prev_tag_open, $router_params, $sband, $separator, $sideband_width, $uri_segment, $urls);
					}
				}break;
				case "last_tag_close":{
					{
						$last_tag_close = system_base_Paginator_14($this, $_g, $config, $cur_tag_close, $cur_tag_open, $elipses, $first_link, $first_link_id, $first_tag_close, $first_tag_open, $full_tag_close, $full_tag_open, $hints, $last_link, $last_link_id, $last_tag_close, $last_tag_open, $link_class, $next_link, $next_link_id, $next_tag_close, $next_tag_open, $nolink_class, $num_tag_close, $num_tag_open, $number_class, $option_name, $option_value, $options, $prev_link, $prev_link_id, $prev_tag_close, $prev_tag_open, $router_params, $sband, $separator, $sideband_width, $uri_segment, $urls);
					}
				}break;
				case "last_link_id":{
					{
						$last_link_id = system_base_Paginator_15($this, $_g, $config, $cur_tag_close, $cur_tag_open, $elipses, $first_link, $first_link_id, $first_tag_close, $first_tag_open, $full_tag_close, $full_tag_open, $hints, $last_link, $last_link_id, $last_tag_close, $last_tag_open, $link_class, $next_link, $next_link_id, $next_tag_close, $next_tag_open, $nolink_class, $num_tag_close, $num_tag_open, $number_class, $option_name, $option_value, $options, $prev_link, $prev_link_id, $prev_tag_close, $prev_tag_open, $router_params, $sband, $separator, $sideband_width, $uri_segment, $urls);
					}
				}break;
				case "next_link":{
					{
						$next_link = system_base_Paginator_16($this, $_g, $config, $cur_tag_close, $cur_tag_open, $elipses, $first_link, $first_link_id, $first_tag_close, $first_tag_open, $full_tag_close, $full_tag_open, $hints, $last_link, $last_link_id, $last_tag_close, $last_tag_open, $link_class, $next_link, $next_link_id, $next_tag_close, $next_tag_open, $nolink_class, $num_tag_close, $num_tag_open, $number_class, $option_name, $option_value, $options, $prev_link, $prev_link_id, $prev_tag_close, $prev_tag_open, $router_params, $sband, $separator, $sideband_width, $uri_segment, $urls);
					}
				}break;
				case "next_tag_open":{
					{
						$full_tag_open = system_base_Paginator_17($this, $_g, $config, $cur_tag_close, $cur_tag_open, $elipses, $first_link, $first_link_id, $first_tag_close, $first_tag_open, $full_tag_close, $full_tag_open, $hints, $last_link, $last_link_id, $last_tag_close, $last_tag_open, $link_class, $next_link, $next_link_id, $next_tag_close, $next_tag_open, $nolink_class, $num_tag_close, $num_tag_open, $number_class, $option_name, $option_value, $options, $prev_link, $prev_link_id, $prev_tag_close, $prev_tag_open, $router_params, $sband, $separator, $sideband_width, $uri_segment, $urls);
					}
				}break;
				case "next_tag_close":{
					{
						$next_tag_close = system_base_Paginator_18($this, $_g, $config, $cur_tag_close, $cur_tag_open, $elipses, $first_link, $first_link_id, $first_tag_close, $first_tag_open, $full_tag_close, $full_tag_open, $hints, $last_link, $last_link_id, $last_tag_close, $last_tag_open, $link_class, $next_link, $next_link_id, $next_tag_close, $next_tag_open, $nolink_class, $num_tag_close, $num_tag_open, $number_class, $option_name, $option_value, $options, $prev_link, $prev_link_id, $prev_tag_close, $prev_tag_open, $router_params, $sband, $separator, $sideband_width, $uri_segment, $urls);
					}
				}break;
				case "prev_link":{
					{
						$prev_link = system_base_Paginator_19($this, $_g, $config, $cur_tag_close, $cur_tag_open, $elipses, $first_link, $first_link_id, $first_tag_close, $first_tag_open, $full_tag_close, $full_tag_open, $hints, $last_link, $last_link_id, $last_tag_close, $last_tag_open, $link_class, $next_link, $next_link_id, $next_tag_close, $next_tag_open, $nolink_class, $num_tag_close, $num_tag_open, $number_class, $option_name, $option_value, $options, $prev_link, $prev_link_id, $prev_tag_close, $prev_tag_open, $router_params, $sband, $separator, $sideband_width, $uri_segment, $urls);
					}
				}break;
				case "prev_tag_open":{
					{
						$prev_tag_open = system_base_Paginator_20($this, $_g, $config, $cur_tag_close, $cur_tag_open, $elipses, $first_link, $first_link_id, $first_tag_close, $first_tag_open, $full_tag_close, $full_tag_open, $hints, $last_link, $last_link_id, $last_tag_close, $last_tag_open, $link_class, $next_link, $next_link_id, $next_tag_close, $next_tag_open, $nolink_class, $num_tag_close, $num_tag_open, $number_class, $option_name, $option_value, $options, $prev_link, $prev_link_id, $prev_tag_close, $prev_tag_open, $router_params, $sband, $separator, $sideband_width, $uri_segment, $urls);
					}
				}break;
				case "prev_tag_close":{
					{
						$prev_tag_close = system_base_Paginator_21($this, $_g, $config, $cur_tag_close, $cur_tag_open, $elipses, $first_link, $first_link_id, $first_tag_close, $first_tag_open, $full_tag_close, $full_tag_open, $hints, $last_link, $last_link_id, $last_tag_close, $last_tag_open, $link_class, $next_link, $next_link_id, $next_tag_close, $next_tag_open, $nolink_class, $num_tag_close, $num_tag_open, $number_class, $option_name, $option_value, $options, $prev_link, $prev_link_id, $prev_tag_close, $prev_tag_open, $router_params, $sband, $separator, $sideband_width, $uri_segment, $urls);
					}
				}break;
				case "prev_link_id":{
					{
						$prev_link_id = system_base_Paginator_22($this, $_g, $config, $cur_tag_close, $cur_tag_open, $elipses, $first_link, $first_link_id, $first_tag_close, $first_tag_open, $full_tag_close, $full_tag_open, $hints, $last_link, $last_link_id, $last_tag_close, $last_tag_open, $link_class, $next_link, $next_link_id, $next_tag_close, $next_tag_open, $nolink_class, $num_tag_close, $num_tag_open, $number_class, $option_name, $option_value, $options, $prev_link, $prev_link_id, $prev_tag_close, $prev_tag_open, $router_params, $sband, $separator, $sideband_width, $uri_segment, $urls);
					}
				}break;
				case "cur_tag_open":{
					{
						$cur_tag_open = system_base_Paginator_23($this, $_g, $config, $cur_tag_close, $cur_tag_open, $elipses, $first_link, $first_link_id, $first_tag_close, $first_tag_open, $full_tag_close, $full_tag_open, $hints, $last_link, $last_link_id, $last_tag_close, $last_tag_open, $link_class, $next_link, $next_link_id, $next_tag_close, $next_tag_open, $nolink_class, $num_tag_close, $num_tag_open, $number_class, $option_name, $option_value, $options, $prev_link, $prev_link_id, $prev_tag_close, $prev_tag_open, $router_params, $sband, $separator, $sideband_width, $uri_segment, $urls);
					}
				}break;
				case "cur_tag_close":{
					{
						$cur_tag_close = system_base_Paginator_24($this, $_g, $config, $cur_tag_close, $cur_tag_open, $elipses, $first_link, $first_link_id, $first_tag_close, $first_tag_open, $full_tag_close, $full_tag_open, $hints, $last_link, $last_link_id, $last_tag_close, $last_tag_open, $link_class, $next_link, $next_link_id, $next_tag_close, $next_tag_open, $nolink_class, $num_tag_close, $num_tag_open, $number_class, $option_name, $option_value, $options, $prev_link, $prev_link_id, $prev_tag_close, $prev_tag_open, $router_params, $sband, $separator, $sideband_width, $uri_segment, $urls);
					}
				}break;
				case "num_tag_open":{
					{
						$num_tag_open = system_base_Paginator_25($this, $_g, $config, $cur_tag_close, $cur_tag_open, $elipses, $first_link, $first_link_id, $first_tag_close, $first_tag_open, $full_tag_close, $full_tag_open, $hints, $last_link, $last_link_id, $last_tag_close, $last_tag_open, $link_class, $next_link, $next_link_id, $next_tag_close, $next_tag_open, $nolink_class, $num_tag_close, $num_tag_open, $number_class, $option_name, $option_value, $options, $prev_link, $prev_link_id, $prev_tag_close, $prev_tag_open, $router_params, $sband, $separator, $sideband_width, $uri_segment, $urls);
					}
				}break;
				case "num_tag_close":{
					{
						$num_tag_close = system_base_Paginator_26($this, $_g, $config, $cur_tag_close, $cur_tag_open, $elipses, $first_link, $first_link_id, $first_tag_close, $first_tag_open, $full_tag_close, $full_tag_open, $hints, $last_link, $last_link_id, $last_tag_close, $last_tag_open, $link_class, $next_link, $next_link_id, $next_tag_close, $next_tag_open, $nolink_class, $num_tag_close, $num_tag_open, $number_class, $option_name, $option_value, $options, $prev_link, $prev_link_id, $prev_tag_close, $prev_tag_open, $router_params, $sband, $separator, $sideband_width, $uri_segment, $urls);
					}
				}break;
				case "elipses":{
					{
						$elipses = system_base_Paginator_27($this, $_g, $config, $cur_tag_close, $cur_tag_open, $elipses, $first_link, $first_link_id, $first_tag_close, $first_tag_open, $full_tag_close, $full_tag_open, $hints, $last_link, $last_link_id, $last_tag_close, $last_tag_open, $link_class, $next_link, $next_link_id, $next_tag_close, $next_tag_open, $nolink_class, $num_tag_close, $num_tag_open, $number_class, $option_name, $option_value, $options, $prev_link, $prev_link_id, $prev_tag_close, $prev_tag_open, $router_params, $sband, $separator, $sideband_width, $uri_segment, $urls);
					}
				}break;
				case "link_class":{
					{
						$link_class = system_base_Paginator_28($this, $_g, $config, $cur_tag_close, $cur_tag_open, $elipses, $first_link, $first_link_id, $first_tag_close, $first_tag_open, $full_tag_close, $full_tag_open, $hints, $last_link, $last_link_id, $last_tag_close, $last_tag_open, $link_class, $next_link, $next_link_id, $next_tag_close, $next_tag_open, $nolink_class, $num_tag_close, $num_tag_open, $number_class, $option_name, $option_value, $options, $prev_link, $prev_link_id, $prev_tag_close, $prev_tag_open, $router_params, $sband, $separator, $sideband_width, $uri_segment, $urls);
					}
				}break;
				case "nolink_class":{
					{
						$nolink_class = system_base_Paginator_29($this, $_g, $config, $cur_tag_close, $cur_tag_open, $elipses, $first_link, $first_link_id, $first_tag_close, $first_tag_open, $full_tag_close, $full_tag_open, $hints, $last_link, $last_link_id, $last_tag_close, $last_tag_open, $link_class, $next_link, $next_link_id, $next_tag_close, $next_tag_open, $nolink_class, $num_tag_close, $num_tag_open, $number_class, $option_name, $option_value, $options, $prev_link, $prev_link_id, $prev_tag_close, $prev_tag_open, $router_params, $sband, $separator, $sideband_width, $uri_segment, $urls);
					}
				}break;
				}
				unset($option_name);
			}
		}
		$current_page = system_base_Paginator_30($this, $config, $cur_tag_close, $cur_tag_open, $elipses, $first_link, $first_link_id, $first_tag_close, $first_tag_open, $full_tag_close, $full_tag_open, $hints, $last_link, $last_link_id, $last_tag_close, $last_tag_open, $link_class, $next_link, $next_link_id, $next_tag_close, $next_tag_open, $nolink_class, $num_tag_close, $num_tag_open, $number_class, $option_value, $options, $prev_link, $prev_link_id, $prev_tag_close, $prev_tag_open, $router_params, $sband, $separator, $sideband_width, $uri_segment, $urls);
		if($current_page < 1) {
			$current_page = 1;
		}
		if($current_page > $this->total_pages) {
			$current_page = $this->total_pages;
		}
		$urls->b .= $full_tag_open;
		$attribs = new system_base_Attributes(null, null, null, null, null, null, null, null, null, null, null);
		$attribs->set_id($first_link_id);
		$attribs->set_iclass($link_class);
		if($current_page > 1) {
			$attribs->set_id($first_link_id);
			$urls->b .= $first_tag_open;
			$urls->b .= "<a href=\"" . Std::string($this->base_url . "1") . "\"" . $attribs->insert_attributes() . ">" . $first_link . "</a>";
			$urls->b .= $first_tag_close;
			$urls->b .= $separator;
			$attribs->set_id($prev_link_id);
			$urls->b .= $prev_tag_open;
			$urls->b .= "<a href=\"" . Std::string($this->base_url . Std::string($current_page - 1)) . "\"" . $attribs->insert_attributes() . ">" . $prev_link . "</a>";
			$urls->b .= $prev_tag_close;
		}
		$sband = system_base_Paginator_31($this, $attribs, $config, $cur_tag_close, $cur_tag_open, $current_page, $elipses, $first_link, $first_link_id, $first_tag_close, $first_tag_open, $full_tag_close, $full_tag_open, $hints, $last_link, $last_link_id, $last_tag_close, $last_tag_open, $link_class, $next_link, $next_link_id, $next_tag_close, $next_tag_open, $nolink_class, $num_tag_close, $num_tag_open, $number_class, $option_value, $options, $prev_link, $prev_link_id, $prev_tag_close, $prev_tag_open, $router_params, $sband, $separator, $sideband_width, $uri_segment, $urls);
		$urls->b .= system_base_Paginator_32($this, $attribs, $config, $cur_tag_close, $cur_tag_open, $current_page, $elipses, $first_link, $first_link_id, $first_tag_close, $first_tag_open, $full_tag_close, $full_tag_open, $hints, $last_link, $last_link_id, $last_tag_close, $last_tag_open, $link_class, $next_link, $next_link_id, $next_tag_close, $next_tag_open, $nolink_class, $num_tag_close, $num_tag_open, $number_class, $option_value, $options, $prev_link, $prev_link_id, $prev_tag_close, $prev_tag_open, $router_params, $sband, $separator, $sideband_width, $uri_segment, $urls);
		$attribs->set_id(null);
		{
			$_g = $sband;
			while($_g < $current_page) {
				$i = $_g++;
				$attribs->set_title(system_base_Paginator_33($this, $_g, $attribs, $config, $cur_tag_close, $cur_tag_open, $current_page, $elipses, $first_link, $first_link_id, $first_tag_close, $first_tag_open, $full_tag_close, $full_tag_open, $hints, $i, $last_link, $last_link_id, $last_tag_close, $last_tag_open, $link_class, $next_link, $next_link_id, $next_tag_close, $next_tag_open, $nolink_class, $num_tag_close, $num_tag_open, $number_class, $option_value, $options, $prev_link, $prev_link_id, $prev_tag_close, $prev_tag_open, $router_params, $sband, $separator, $sideband_width, $uri_segment, $urls));
				$urls->b .= $num_tag_open;
				$urls->b .= "<a href=\"" . Std::string($this->base_url . Std::string($i)) . "\"" . $attribs->insert_attributes() . ">" . Std::string($i) . "</a>";
				$urls->b .= $num_tag_close;
				$urls->b .= $separator;
				unset($i);
			}
		}
		$urls->b .= $cur_tag_open;
		$urls->b .= "<span class=\"" . $nolink_class . "\">" . Std::string($current_page) . "</span>";
		$urls->b .= $cur_tag_close;
		$sband = system_base_Paginator_34($this, $attribs, $config, $cur_tag_close, $cur_tag_open, $current_page, $elipses, $first_link, $first_link_id, $first_tag_close, $first_tag_open, $full_tag_close, $full_tag_open, $hints, $last_link, $last_link_id, $last_tag_close, $last_tag_open, $link_class, $next_link, $next_link_id, $next_tag_close, $next_tag_open, $nolink_class, $num_tag_close, $num_tag_open, $number_class, $option_value, $options, $prev_link, $prev_link_id, $prev_tag_close, $prev_tag_open, $router_params, $sband, $separator, $sideband_width, $uri_segment, $urls);
		{
			$_g = $current_page + 1;
			while($_g < $sband) {
				$i = $_g++;
				$attribs->set_title(system_base_Paginator_35($this, $_g, $attribs, $config, $cur_tag_close, $cur_tag_open, $current_page, $elipses, $first_link, $first_link_id, $first_tag_close, $first_tag_open, $full_tag_close, $full_tag_open, $hints, $i, $last_link, $last_link_id, $last_tag_close, $last_tag_open, $link_class, $next_link, $next_link_id, $next_tag_close, $next_tag_open, $nolink_class, $num_tag_close, $num_tag_open, $number_class, $option_value, $options, $prev_link, $prev_link_id, $prev_tag_close, $prev_tag_open, $router_params, $sband, $separator, $sideband_width, $uri_segment, $urls));
				$urls->b .= $separator;
				$urls->b .= $num_tag_open;
				$urls->b .= "<a href=\"" . Std::string($this->base_url . Std::string($i)) . "\"" . $attribs->insert_attributes() . ">" . Std::string($i) . "</a>";
				$urls->b .= $num_tag_close;
				unset($i);
			}
		}
		$urls->b .= system_base_Paginator_36($this, $attribs, $config, $cur_tag_close, $cur_tag_open, $current_page, $elipses, $first_link, $first_link_id, $first_tag_close, $first_tag_open, $full_tag_close, $full_tag_open, $hints, $last_link, $last_link_id, $last_tag_close, $last_tag_open, $link_class, $next_link, $next_link_id, $next_tag_close, $next_tag_open, $nolink_class, $num_tag_close, $num_tag_open, $number_class, $option_value, $options, $prev_link, $prev_link_id, $prev_tag_close, $prev_tag_open, $router_params, $sband, $separator, $sideband_width, $uri_segment, $urls);
		$urls->b .= $last_tag_open;
		if($current_page < $this->total_pages) {
			$attribs->set_id($next_link_id);
			$attribs->set_title(null);
			$urls->b .= $next_tag_open;
			$urls->b .= "<a href=\"" . Std::string($this->base_url . Std::string($current_page + 1)) . "\"" . $attribs->insert_attributes() . ">" . $next_link . "</a>";
			$urls->b .= $next_tag_close;
			$urls->b .= $separator;
			$attribs->set_id($last_link_id);
			$urls->b .= $last_tag_open;
			$urls->b .= "<a href=\"" . Std::string($this->base_url . Std::string($this->total_pages)) . "\"" . $attribs->insert_attributes() . ">" . $last_link . "</a>";
			$urls->b .= $last_tag_close;
		}
		$urls->b .= $last_tag_close;
		$urls->b .= $full_tag_close;
		$this->current_links = $urls->b;
		return $this->current_links;
	}
	public function get_current_links() {
		if($this->current_links === null) {
			$this->generate_links(_hx_anonymous(array()));
		}
		return $this->current_links;
	}
	public function __call($m, $a) {
		if(isset($this->$m) && is_callable($this->$m))
			return call_user_func_array($this->$m, $a);
		else if(isset($this->팪ynamics[$m]) && is_callable($this->팪ynamics[$m]))
			return call_user_func_array($this->팪ynamics[$m], $a);
		else if('toString' == $m)
			return $this->__toString();
		else
			throw new HException('Unable to call �'.$m.'�');
	}
	function __toString() { return 'system.base.Paginator'; }
}
function system_base_Paginator_0(&$퍁his, &$baseURL, &$full_pages, &$number_of_results, &$results_per_page) {
	if($number_of_results % $results_per_page !== 0) {
		return 1;
	} else {
		return 0;
	}
}
function system_base_Paginator_1(&$퍁his, &$config) {
	{
		if(system_base_Router::$instance === null) {
			system_base_Router::$instance = new system_base_Router();
		}
		return system_base_Router::$instance;
	}
}
function system_base_Paginator_2(&$퍁his, &$_g, &$config, &$cur_tag_close, &$cur_tag_open, &$elipses, &$first_link, &$first_link_id, &$first_tag_close, &$first_tag_open, &$full_tag_close, &$full_tag_open, &$hints, &$last_link, &$last_link_id, &$last_tag_close, &$last_tag_open, &$link_class, &$next_link, &$next_link_id, &$next_tag_close, &$next_tag_open, &$nolink_class, &$num_tag_close, &$num_tag_open, &$number_class, &$option_name, &$option_value, &$options, &$prev_link, &$prev_link_id, &$prev_tag_close, &$prev_tag_open, &$router_params, &$sband, &$separator, &$sideband_width, &$uri_segment, &$urls) {
	if($option_value !== null) {
		return $option_value;
	} else {
		return $퍁his->base_url;
	}
}
function system_base_Paginator_3(&$퍁his, &$_g, &$config, &$cur_tag_close, &$cur_tag_open, &$elipses, &$first_link, &$first_link_id, &$first_tag_close, &$first_tag_open, &$full_tag_close, &$full_tag_open, &$hints, &$last_link, &$last_link_id, &$last_tag_close, &$last_tag_open, &$link_class, &$next_link, &$next_link_id, &$next_tag_close, &$next_tag_open, &$nolink_class, &$num_tag_close, &$num_tag_open, &$number_class, &$option_name, &$option_value, &$options, &$prev_link, &$prev_link_id, &$prev_tag_close, &$prev_tag_open, &$router_params, &$sband, &$separator, &$sideband_width, &$uri_segment, &$urls) {
	if($option_value !== null) {
		return $option_value;
	} else {
		return $uri_segment;
	}
}
function system_base_Paginator_4(&$퍁his, &$_g, &$config, &$cur_tag_close, &$cur_tag_open, &$elipses, &$first_link, &$first_link_id, &$first_tag_close, &$first_tag_open, &$full_tag_close, &$full_tag_open, &$hints, &$last_link, &$last_link_id, &$last_tag_close, &$last_tag_open, &$link_class, &$next_link, &$next_link_id, &$next_tag_close, &$next_tag_open, &$nolink_class, &$num_tag_close, &$num_tag_open, &$number_class, &$option_name, &$option_value, &$options, &$prev_link, &$prev_link_id, &$prev_tag_close, &$prev_tag_open, &$router_params, &$sband, &$separator, &$sideband_width, &$uri_segment, &$urls) {
	if($option_value !== null) {
		return $option_value;
	} else {
		return $sideband_width;
	}
}
function system_base_Paginator_5(&$퍁his, &$_g, &$config, &$cur_tag_close, &$cur_tag_open, &$elipses, &$first_link, &$first_link_id, &$first_tag_close, &$first_tag_open, &$full_tag_close, &$full_tag_open, &$hints, &$last_link, &$last_link_id, &$last_tag_close, &$last_tag_open, &$link_class, &$next_link, &$next_link_id, &$next_tag_close, &$next_tag_open, &$nolink_class, &$num_tag_close, &$num_tag_open, &$number_class, &$option_name, &$option_value, &$options, &$prev_link, &$prev_link_id, &$prev_tag_close, &$prev_tag_open, &$router_params, &$sband, &$separator, &$sideband_width, &$uri_segment, &$urls) {
	if($option_value !== null) {
		return $option_value;
	} else {
		return $separator;
	}
}
function system_base_Paginator_6(&$퍁his, &$_g, &$config, &$cur_tag_close, &$cur_tag_open, &$elipses, &$first_link, &$first_link_id, &$first_tag_close, &$first_tag_open, &$full_tag_close, &$full_tag_open, &$hints, &$last_link, &$last_link_id, &$last_tag_close, &$last_tag_open, &$link_class, &$next_link, &$next_link_id, &$next_tag_close, &$next_tag_open, &$nolink_class, &$num_tag_close, &$num_tag_open, &$number_class, &$option_name, &$option_value, &$options, &$prev_link, &$prev_link_id, &$prev_tag_close, &$prev_tag_open, &$router_params, &$sband, &$separator, &$sideband_width, &$uri_segment, &$urls) {
	if($option_value !== null) {
		return $option_value;
	} else {
		return $full_tag_open;
	}
}
function system_base_Paginator_7(&$퍁his, &$_g, &$config, &$cur_tag_close, &$cur_tag_open, &$elipses, &$first_link, &$first_link_id, &$first_tag_close, &$first_tag_open, &$full_tag_close, &$full_tag_open, &$hints, &$last_link, &$last_link_id, &$last_tag_close, &$last_tag_open, &$link_class, &$next_link, &$next_link_id, &$next_tag_close, &$next_tag_open, &$nolink_class, &$num_tag_close, &$num_tag_open, &$number_class, &$option_name, &$option_value, &$options, &$prev_link, &$prev_link_id, &$prev_tag_close, &$prev_tag_open, &$router_params, &$sband, &$separator, &$sideband_width, &$uri_segment, &$urls) {
	if($option_value !== null) {
		return $option_value;
	} else {
		return $full_tag_close;
	}
}
function system_base_Paginator_8(&$퍁his, &$_g, &$config, &$cur_tag_close, &$cur_tag_open, &$elipses, &$first_link, &$first_link_id, &$first_tag_close, &$first_tag_open, &$full_tag_close, &$full_tag_open, &$hints, &$last_link, &$last_link_id, &$last_tag_close, &$last_tag_open, &$link_class, &$next_link, &$next_link_id, &$next_tag_close, &$next_tag_open, &$nolink_class, &$num_tag_close, &$num_tag_open, &$number_class, &$option_name, &$option_value, &$options, &$prev_link, &$prev_link_id, &$prev_tag_close, &$prev_tag_open, &$router_params, &$sband, &$separator, &$sideband_width, &$uri_segment, &$urls) {
	if($option_value !== null) {
		return $option_value;
	} else {
		return $first_link;
	}
}
function system_base_Paginator_9(&$퍁his, &$_g, &$config, &$cur_tag_close, &$cur_tag_open, &$elipses, &$first_link, &$first_link_id, &$first_tag_close, &$first_tag_open, &$full_tag_close, &$full_tag_open, &$hints, &$last_link, &$last_link_id, &$last_tag_close, &$last_tag_open, &$link_class, &$next_link, &$next_link_id, &$next_tag_close, &$next_tag_open, &$nolink_class, &$num_tag_close, &$num_tag_open, &$number_class, &$option_name, &$option_value, &$options, &$prev_link, &$prev_link_id, &$prev_tag_close, &$prev_tag_open, &$router_params, &$sband, &$separator, &$sideband_width, &$uri_segment, &$urls) {
	if($option_value !== null) {
		return $option_value;
	} else {
		return $first_tag_open;
	}
}
function system_base_Paginator_10(&$퍁his, &$_g, &$config, &$cur_tag_close, &$cur_tag_open, &$elipses, &$first_link, &$first_link_id, &$first_tag_close, &$first_tag_open, &$full_tag_close, &$full_tag_open, &$hints, &$last_link, &$last_link_id, &$last_tag_close, &$last_tag_open, &$link_class, &$next_link, &$next_link_id, &$next_tag_close, &$next_tag_open, &$nolink_class, &$num_tag_close, &$num_tag_open, &$number_class, &$option_name, &$option_value, &$options, &$prev_link, &$prev_link_id, &$prev_tag_close, &$prev_tag_open, &$router_params, &$sband, &$separator, &$sideband_width, &$uri_segment, &$urls) {
	if($option_value !== null) {
		return $option_value;
	} else {
		return $first_tag_close;
	}
}
function system_base_Paginator_11(&$퍁his, &$_g, &$config, &$cur_tag_close, &$cur_tag_open, &$elipses, &$first_link, &$first_link_id, &$first_tag_close, &$first_tag_open, &$full_tag_close, &$full_tag_open, &$hints, &$last_link, &$last_link_id, &$last_tag_close, &$last_tag_open, &$link_class, &$next_link, &$next_link_id, &$next_tag_close, &$next_tag_open, &$nolink_class, &$num_tag_close, &$num_tag_open, &$number_class, &$option_name, &$option_value, &$options, &$prev_link, &$prev_link_id, &$prev_tag_close, &$prev_tag_open, &$router_params, &$sband, &$separator, &$sideband_width, &$uri_segment, &$urls) {
	if($option_value !== null) {
		return $option_value;
	} else {
		return $first_link_id;
	}
}
function system_base_Paginator_12(&$퍁his, &$_g, &$config, &$cur_tag_close, &$cur_tag_open, &$elipses, &$first_link, &$first_link_id, &$first_tag_close, &$first_tag_open, &$full_tag_close, &$full_tag_open, &$hints, &$last_link, &$last_link_id, &$last_tag_close, &$last_tag_open, &$link_class, &$next_link, &$next_link_id, &$next_tag_close, &$next_tag_open, &$nolink_class, &$num_tag_close, &$num_tag_open, &$number_class, &$option_name, &$option_value, &$options, &$prev_link, &$prev_link_id, &$prev_tag_close, &$prev_tag_open, &$router_params, &$sband, &$separator, &$sideband_width, &$uri_segment, &$urls) {
	if($option_value !== null) {
		return $option_value;
	} else {
		return $last_link;
	}
}
function system_base_Paginator_13(&$퍁his, &$_g, &$config, &$cur_tag_close, &$cur_tag_open, &$elipses, &$first_link, &$first_link_id, &$first_tag_close, &$first_tag_open, &$full_tag_close, &$full_tag_open, &$hints, &$last_link, &$last_link_id, &$last_tag_close, &$last_tag_open, &$link_class, &$next_link, &$next_link_id, &$next_tag_close, &$next_tag_open, &$nolink_class, &$num_tag_close, &$num_tag_open, &$number_class, &$option_name, &$option_value, &$options, &$prev_link, &$prev_link_id, &$prev_tag_close, &$prev_tag_open, &$router_params, &$sband, &$separator, &$sideband_width, &$uri_segment, &$urls) {
	if($option_value !== null) {
		return $option_value;
	} else {
		return $last_tag_open;
	}
}
function system_base_Paginator_14(&$퍁his, &$_g, &$config, &$cur_tag_close, &$cur_tag_open, &$elipses, &$first_link, &$first_link_id, &$first_tag_close, &$first_tag_open, &$full_tag_close, &$full_tag_open, &$hints, &$last_link, &$last_link_id, &$last_tag_close, &$last_tag_open, &$link_class, &$next_link, &$next_link_id, &$next_tag_close, &$next_tag_open, &$nolink_class, &$num_tag_close, &$num_tag_open, &$number_class, &$option_name, &$option_value, &$options, &$prev_link, &$prev_link_id, &$prev_tag_close, &$prev_tag_open, &$router_params, &$sband, &$separator, &$sideband_width, &$uri_segment, &$urls) {
	if($option_value !== null) {
		return $option_value;
	} else {
		return $last_tag_close;
	}
}
function system_base_Paginator_15(&$퍁his, &$_g, &$config, &$cur_tag_close, &$cur_tag_open, &$elipses, &$first_link, &$first_link_id, &$first_tag_close, &$first_tag_open, &$full_tag_close, &$full_tag_open, &$hints, &$last_link, &$last_link_id, &$last_tag_close, &$last_tag_open, &$link_class, &$next_link, &$next_link_id, &$next_tag_close, &$next_tag_open, &$nolink_class, &$num_tag_close, &$num_tag_open, &$number_class, &$option_name, &$option_value, &$options, &$prev_link, &$prev_link_id, &$prev_tag_close, &$prev_tag_open, &$router_params, &$sband, &$separator, &$sideband_width, &$uri_segment, &$urls) {
	if($option_value !== null) {
		return $option_value;
	} else {
		return $last_link_id;
	}
}
function system_base_Paginator_16(&$퍁his, &$_g, &$config, &$cur_tag_close, &$cur_tag_open, &$elipses, &$first_link, &$first_link_id, &$first_tag_close, &$first_tag_open, &$full_tag_close, &$full_tag_open, &$hints, &$last_link, &$last_link_id, &$last_tag_close, &$last_tag_open, &$link_class, &$next_link, &$next_link_id, &$next_tag_close, &$next_tag_open, &$nolink_class, &$num_tag_close, &$num_tag_open, &$number_class, &$option_name, &$option_value, &$options, &$prev_link, &$prev_link_id, &$prev_tag_close, &$prev_tag_open, &$router_params, &$sband, &$separator, &$sideband_width, &$uri_segment, &$urls) {
	if($option_value !== null) {
		return $option_value;
	} else {
		return $next_link;
	}
}
function system_base_Paginator_17(&$퍁his, &$_g, &$config, &$cur_tag_close, &$cur_tag_open, &$elipses, &$first_link, &$first_link_id, &$first_tag_close, &$first_tag_open, &$full_tag_close, &$full_tag_open, &$hints, &$last_link, &$last_link_id, &$last_tag_close, &$last_tag_open, &$link_class, &$next_link, &$next_link_id, &$next_tag_close, &$next_tag_open, &$nolink_class, &$num_tag_close, &$num_tag_open, &$number_class, &$option_name, &$option_value, &$options, &$prev_link, &$prev_link_id, &$prev_tag_close, &$prev_tag_open, &$router_params, &$sband, &$separator, &$sideband_width, &$uri_segment, &$urls) {
	if($option_value !== null) {
		return $option_value;
	} else {
		return $full_tag_open;
	}
}
function system_base_Paginator_18(&$퍁his, &$_g, &$config, &$cur_tag_close, &$cur_tag_open, &$elipses, &$first_link, &$first_link_id, &$first_tag_close, &$first_tag_open, &$full_tag_close, &$full_tag_open, &$hints, &$last_link, &$last_link_id, &$last_tag_close, &$last_tag_open, &$link_class, &$next_link, &$next_link_id, &$next_tag_close, &$next_tag_open, &$nolink_class, &$num_tag_close, &$num_tag_open, &$number_class, &$option_name, &$option_value, &$options, &$prev_link, &$prev_link_id, &$prev_tag_close, &$prev_tag_open, &$router_params, &$sband, &$separator, &$sideband_width, &$uri_segment, &$urls) {
	if($option_value !== null) {
		return $option_value;
	} else {
		return $next_tag_close;
	}
}
function system_base_Paginator_19(&$퍁his, &$_g, &$config, &$cur_tag_close, &$cur_tag_open, &$elipses, &$first_link, &$first_link_id, &$first_tag_close, &$first_tag_open, &$full_tag_close, &$full_tag_open, &$hints, &$last_link, &$last_link_id, &$last_tag_close, &$last_tag_open, &$link_class, &$next_link, &$next_link_id, &$next_tag_close, &$next_tag_open, &$nolink_class, &$num_tag_close, &$num_tag_open, &$number_class, &$option_name, &$option_value, &$options, &$prev_link, &$prev_link_id, &$prev_tag_close, &$prev_tag_open, &$router_params, &$sband, &$separator, &$sideband_width, &$uri_segment, &$urls) {
	if($option_value !== null) {
		return $option_value;
	} else {
		return $prev_link;
	}
}
function system_base_Paginator_20(&$퍁his, &$_g, &$config, &$cur_tag_close, &$cur_tag_open, &$elipses, &$first_link, &$first_link_id, &$first_tag_close, &$first_tag_open, &$full_tag_close, &$full_tag_open, &$hints, &$last_link, &$last_link_id, &$last_tag_close, &$last_tag_open, &$link_class, &$next_link, &$next_link_id, &$next_tag_close, &$next_tag_open, &$nolink_class, &$num_tag_close, &$num_tag_open, &$number_class, &$option_name, &$option_value, &$options, &$prev_link, &$prev_link_id, &$prev_tag_close, &$prev_tag_open, &$router_params, &$sband, &$separator, &$sideband_width, &$uri_segment, &$urls) {
	if($option_value !== null) {
		return $option_value;
	} else {
		return $prev_tag_open;
	}
}
function system_base_Paginator_21(&$퍁his, &$_g, &$config, &$cur_tag_close, &$cur_tag_open, &$elipses, &$first_link, &$first_link_id, &$first_tag_close, &$first_tag_open, &$full_tag_close, &$full_tag_open, &$hints, &$last_link, &$last_link_id, &$last_tag_close, &$last_tag_open, &$link_class, &$next_link, &$next_link_id, &$next_tag_close, &$next_tag_open, &$nolink_class, &$num_tag_close, &$num_tag_open, &$number_class, &$option_name, &$option_value, &$options, &$prev_link, &$prev_link_id, &$prev_tag_close, &$prev_tag_open, &$router_params, &$sband, &$separator, &$sideband_width, &$uri_segment, &$urls) {
	if($option_value !== null) {
		return $option_value;
	} else {
		return $prev_tag_close;
	}
}
function system_base_Paginator_22(&$퍁his, &$_g, &$config, &$cur_tag_close, &$cur_tag_open, &$elipses, &$first_link, &$first_link_id, &$first_tag_close, &$first_tag_open, &$full_tag_close, &$full_tag_open, &$hints, &$last_link, &$last_link_id, &$last_tag_close, &$last_tag_open, &$link_class, &$next_link, &$next_link_id, &$next_tag_close, &$next_tag_open, &$nolink_class, &$num_tag_close, &$num_tag_open, &$number_class, &$option_name, &$option_value, &$options, &$prev_link, &$prev_link_id, &$prev_tag_close, &$prev_tag_open, &$router_params, &$sband, &$separator, &$sideband_width, &$uri_segment, &$urls) {
	if($option_value !== null) {
		return $option_value;
	} else {
		return $prev_link_id;
	}
}
function system_base_Paginator_23(&$퍁his, &$_g, &$config, &$cur_tag_close, &$cur_tag_open, &$elipses, &$first_link, &$first_link_id, &$first_tag_close, &$first_tag_open, &$full_tag_close, &$full_tag_open, &$hints, &$last_link, &$last_link_id, &$last_tag_close, &$last_tag_open, &$link_class, &$next_link, &$next_link_id, &$next_tag_close, &$next_tag_open, &$nolink_class, &$num_tag_close, &$num_tag_open, &$number_class, &$option_name, &$option_value, &$options, &$prev_link, &$prev_link_id, &$prev_tag_close, &$prev_tag_open, &$router_params, &$sband, &$separator, &$sideband_width, &$uri_segment, &$urls) {
	if($option_value !== null) {
		return $option_value;
	} else {
		return $cur_tag_open;
	}
}
function system_base_Paginator_24(&$퍁his, &$_g, &$config, &$cur_tag_close, &$cur_tag_open, &$elipses, &$first_link, &$first_link_id, &$first_tag_close, &$first_tag_open, &$full_tag_close, &$full_tag_open, &$hints, &$last_link, &$last_link_id, &$last_tag_close, &$last_tag_open, &$link_class, &$next_link, &$next_link_id, &$next_tag_close, &$next_tag_open, &$nolink_class, &$num_tag_close, &$num_tag_open, &$number_class, &$option_name, &$option_value, &$options, &$prev_link, &$prev_link_id, &$prev_tag_close, &$prev_tag_open, &$router_params, &$sband, &$separator, &$sideband_width, &$uri_segment, &$urls) {
	if($option_value !== null) {
		return $option_value;
	} else {
		return $cur_tag_close;
	}
}
function system_base_Paginator_25(&$퍁his, &$_g, &$config, &$cur_tag_close, &$cur_tag_open, &$elipses, &$first_link, &$first_link_id, &$first_tag_close, &$first_tag_open, &$full_tag_close, &$full_tag_open, &$hints, &$last_link, &$last_link_id, &$last_tag_close, &$last_tag_open, &$link_class, &$next_link, &$next_link_id, &$next_tag_close, &$next_tag_open, &$nolink_class, &$num_tag_close, &$num_tag_open, &$number_class, &$option_name, &$option_value, &$options, &$prev_link, &$prev_link_id, &$prev_tag_close, &$prev_tag_open, &$router_params, &$sband, &$separator, &$sideband_width, &$uri_segment, &$urls) {
	if($option_value !== null) {
		return $option_value;
	} else {
		return $num_tag_open;
	}
}
function system_base_Paginator_26(&$퍁his, &$_g, &$config, &$cur_tag_close, &$cur_tag_open, &$elipses, &$first_link, &$first_link_id, &$first_tag_close, &$first_tag_open, &$full_tag_close, &$full_tag_open, &$hints, &$last_link, &$last_link_id, &$last_tag_close, &$last_tag_open, &$link_class, &$next_link, &$next_link_id, &$next_tag_close, &$next_tag_open, &$nolink_class, &$num_tag_close, &$num_tag_open, &$number_class, &$option_name, &$option_value, &$options, &$prev_link, &$prev_link_id, &$prev_tag_close, &$prev_tag_open, &$router_params, &$sband, &$separator, &$sideband_width, &$uri_segment, &$urls) {
	if($option_value !== null) {
		return $option_value;
	} else {
		return $num_tag_close;
	}
}
function system_base_Paginator_27(&$퍁his, &$_g, &$config, &$cur_tag_close, &$cur_tag_open, &$elipses, &$first_link, &$first_link_id, &$first_tag_close, &$first_tag_open, &$full_tag_close, &$full_tag_open, &$hints, &$last_link, &$last_link_id, &$last_tag_close, &$last_tag_open, &$link_class, &$next_link, &$next_link_id, &$next_tag_close, &$next_tag_open, &$nolink_class, &$num_tag_close, &$num_tag_open, &$number_class, &$option_name, &$option_value, &$options, &$prev_link, &$prev_link_id, &$prev_tag_close, &$prev_tag_open, &$router_params, &$sband, &$separator, &$sideband_width, &$uri_segment, &$urls) {
	if($option_value !== null) {
		return $option_value;
	} else {
		return $elipses;
	}
}
function system_base_Paginator_28(&$퍁his, &$_g, &$config, &$cur_tag_close, &$cur_tag_open, &$elipses, &$first_link, &$first_link_id, &$first_tag_close, &$first_tag_open, &$full_tag_close, &$full_tag_open, &$hints, &$last_link, &$last_link_id, &$last_tag_close, &$last_tag_open, &$link_class, &$next_link, &$next_link_id, &$next_tag_close, &$next_tag_open, &$nolink_class, &$num_tag_close, &$num_tag_open, &$number_class, &$option_name, &$option_value, &$options, &$prev_link, &$prev_link_id, &$prev_tag_close, &$prev_tag_open, &$router_params, &$sband, &$separator, &$sideband_width, &$uri_segment, &$urls) {
	if($option_value !== null) {
		return $option_value;
	} else {
		return $link_class;
	}
}
function system_base_Paginator_29(&$퍁his, &$_g, &$config, &$cur_tag_close, &$cur_tag_open, &$elipses, &$first_link, &$first_link_id, &$first_tag_close, &$first_tag_open, &$full_tag_close, &$full_tag_open, &$hints, &$last_link, &$last_link_id, &$last_tag_close, &$last_tag_open, &$link_class, &$next_link, &$next_link_id, &$next_tag_close, &$next_tag_open, &$nolink_class, &$num_tag_close, &$num_tag_open, &$number_class, &$option_name, &$option_value, &$options, &$prev_link, &$prev_link_id, &$prev_tag_close, &$prev_tag_open, &$router_params, &$sband, &$separator, &$sideband_width, &$uri_segment, &$urls) {
	if($option_value !== null) {
		return $option_value;
	} else {
		return $nolink_class;
	}
}
function system_base_Paginator_30(&$퍁his, &$config, &$cur_tag_close, &$cur_tag_open, &$elipses, &$first_link, &$first_link_id, &$first_tag_close, &$first_tag_open, &$full_tag_close, &$full_tag_open, &$hints, &$last_link, &$last_link_id, &$last_tag_close, &$last_tag_open, &$link_class, &$next_link, &$next_link_id, &$next_tag_close, &$next_tag_open, &$nolink_class, &$num_tag_close, &$num_tag_open, &$number_class, &$option_value, &$options, &$prev_link, &$prev_link_id, &$prev_tag_close, &$prev_tag_open, &$router_params, &$sband, &$separator, &$sideband_width, &$uri_segment, &$urls) {
	if($router_params[$uri_segment] === null) {
		return 1;
	} else {
		return Std::parseInt($router_params[$uri_segment]);
	}
}
function system_base_Paginator_31(&$퍁his, &$attribs, &$config, &$cur_tag_close, &$cur_tag_open, &$current_page, &$elipses, &$first_link, &$first_link_id, &$first_tag_close, &$first_tag_open, &$full_tag_close, &$full_tag_open, &$hints, &$last_link, &$last_link_id, &$last_tag_close, &$last_tag_open, &$link_class, &$next_link, &$next_link_id, &$next_tag_close, &$next_tag_open, &$nolink_class, &$num_tag_close, &$num_tag_open, &$number_class, &$option_value, &$options, &$prev_link, &$prev_link_id, &$prev_tag_close, &$prev_tag_open, &$router_params, &$sband, &$separator, &$sideband_width, &$uri_segment, &$urls) {
	if($current_page - $sideband_width > 1) {
		return $current_page - $sideband_width;
	} else {
		return 1;
	}
}
function system_base_Paginator_32(&$퍁his, &$attribs, &$config, &$cur_tag_close, &$cur_tag_open, &$current_page, &$elipses, &$first_link, &$first_link_id, &$first_tag_close, &$first_tag_open, &$full_tag_close, &$full_tag_open, &$hints, &$last_link, &$last_link_id, &$last_tag_close, &$last_tag_open, &$link_class, &$next_link, &$next_link_id, &$next_tag_close, &$next_tag_open, &$nolink_class, &$num_tag_close, &$num_tag_open, &$number_class, &$option_value, &$options, &$prev_link, &$prev_link_id, &$prev_tag_close, &$prev_tag_open, &$router_params, &$sband, &$separator, &$sideband_width, &$uri_segment, &$urls) {
	if($sband === 1) {
		return $separator;
	} else {
		return $elipses;
	}
}
function system_base_Paginator_33(&$퍁his, &$_g, &$attribs, &$config, &$cur_tag_close, &$cur_tag_open, &$current_page, &$elipses, &$first_link, &$first_link_id, &$first_tag_close, &$first_tag_open, &$full_tag_close, &$full_tag_open, &$hints, &$i, &$last_link, &$last_link_id, &$last_tag_close, &$last_tag_open, &$link_class, &$next_link, &$next_link_id, &$next_tag_close, &$next_tag_open, &$nolink_class, &$num_tag_close, &$num_tag_open, &$number_class, &$option_value, &$options, &$prev_link, &$prev_link_id, &$prev_tag_close, &$prev_tag_open, &$router_params, &$sband, &$separator, &$sideband_width, &$uri_segment, &$urls) {
	if($hints) {
		return Std::string($i) . " of " . Std::string($퍁his->total_pages);
	} else {
		return "";
	}
}
function system_base_Paginator_34(&$퍁his, &$attribs, &$config, &$cur_tag_close, &$cur_tag_open, &$current_page, &$elipses, &$first_link, &$first_link_id, &$first_tag_close, &$first_tag_open, &$full_tag_close, &$full_tag_open, &$hints, &$last_link, &$last_link_id, &$last_tag_close, &$last_tag_open, &$link_class, &$next_link, &$next_link_id, &$next_tag_close, &$next_tag_open, &$nolink_class, &$num_tag_close, &$num_tag_open, &$number_class, &$option_value, &$options, &$prev_link, &$prev_link_id, &$prev_tag_close, &$prev_tag_open, &$router_params, &$sband, &$separator, &$sideband_width, &$uri_segment, &$urls) {
	if($current_page + $sideband_width < $퍁his->total_pages) {
		return $current_page + $sideband_width + 1;
	} else {
		return $퍁his->total_pages + 1;
	}
}
function system_base_Paginator_35(&$퍁his, &$_g, &$attribs, &$config, &$cur_tag_close, &$cur_tag_open, &$current_page, &$elipses, &$first_link, &$first_link_id, &$first_tag_close, &$first_tag_open, &$full_tag_close, &$full_tag_open, &$hints, &$i, &$last_link, &$last_link_id, &$last_tag_close, &$last_tag_open, &$link_class, &$next_link, &$next_link_id, &$next_tag_close, &$next_tag_open, &$nolink_class, &$num_tag_close, &$num_tag_open, &$number_class, &$option_value, &$options, &$prev_link, &$prev_link_id, &$prev_tag_close, &$prev_tag_open, &$router_params, &$sband, &$separator, &$sideband_width, &$uri_segment, &$urls) {
	if($hints) {
		return Std::string($i) . " of " . Std::string($퍁his->total_pages);
	} else {
		return "";
	}
}
function system_base_Paginator_36(&$퍁his, &$attribs, &$config, &$cur_tag_close, &$cur_tag_open, &$current_page, &$elipses, &$first_link, &$first_link_id, &$first_tag_close, &$first_tag_open, &$full_tag_close, &$full_tag_open, &$hints, &$last_link, &$last_link_id, &$last_tag_close, &$last_tag_open, &$link_class, &$next_link, &$next_link_id, &$next_tag_close, &$next_tag_open, &$nolink_class, &$num_tag_close, &$num_tag_open, &$number_class, &$option_value, &$options, &$prev_link, &$prev_link_id, &$prev_tag_close, &$prev_tag_open, &$router_params, &$sband, &$separator, &$sideband_width, &$uri_segment, &$urls) {
	if($sband === $퍁his->total_pages + 1) {
		return $separator;
	} else {
		return $elipses;
	}
}
