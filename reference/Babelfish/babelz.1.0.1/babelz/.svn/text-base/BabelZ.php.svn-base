<?php
/*
Plugin Name: BabelZ
Plugin URI: http://blog.rswr.net/2009/02/24/babelz-babel-fish-wordpress-plugin/
Description: Displays a Yahoo Babel Fish widget in your sidebar. <a href="options-general.php?page=BabelZ.php">Admin options</a> available.
Version: 1.0.1
Author: Ryan Christenson (The RSWR Network)
Author URI: http://www.rswr.net/
*/

/*
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if (!class_exists("BabelZ")) {
	class BabelZ {
		var $adminOptionsName = "BabelZ_Admin_Options";
		function BabelZ() { //constructor
		}

		//Returns an array of admin options
		function getAdminOptions() {
			// General Admin
			$BabelZAdminOptions = array('prom' => 'true', 'lang' => 'true');
			$BabelZOptions = get_option($this->adminOptionsName);
			if (!empty($BabelZOptions)) {
				foreach ($BabelZOptions as $key => $option)
				$BabelZAdminOptions[$key] = $option;
			}
			update_option($this->adminOptionsName, $BabelZAdminOptions);
			return $BabelZAdminOptions;
		}
		function init() {
			$this->getAdminOptions();
		}
		//Prints out the admin page
		function printAdminPage() {
			$BabelZOptions = $this->getAdminOptions();
			if (isset($_POST['update_BabelZSettings'])) {
				// Save General Settings
				if($_POST['prom'] == "on") update_option('BabelZ_prom', "checked=on");
  				else update_option('BabelZ_prom', "");
  				$BabelZlang = $_POST['lang'];
  				update_option('BabelZ_lang', $BabelZlang);
  				$BabelZhide1 = $_POST['BabelZ-hide1'];
  				update_option('BabelZ_hide1', $BabelZhide1);
  				$BabelZhide2 = $_POST['BabelZ-hide2'];
  				update_option('BabelZ_hide2', $BabelZhide2);
  				$BabelZhide3 = $_POST['BabelZ-hide3'];
  				update_option('BabelZ_hide3', $BabelZhide3);

				// Update Admin
				update_option($this->adminOptionsName, $BabelZOptions);
?>
<div class="updated"><p><span class="BabelZ-Bold"><?php _e("BabelZ Options Updated!", "BabelZ");?></span></p></div>
<?php
			}
?>
<div class="wrap">
<h2><?php _e('BabelZ - 1.0.1','BabelZ'); ?></h2>
<style type="text/css">
<!--
.BabelZ-Pad td{padding:10px;text-align:left;font-weight:700;}
.BabelZ-Pad th{text-align:left;vertical-align:top;font-weight:700;}
.BabelZ-Bold{font-weight:700;}
.BabelZ-chlog{font-size:medium;}
-->
</style>
<form class="form-table" method="post" action="<?php _e($_SERVER["REQUEST_URI"]); ?>">
<?php
$path = trailingslashit(dirname(__FILE__));
//General Options
if(file_exists($path.'options/a-gen.php')) require_once($path.'options/a-gen.php');
?>
	<input type="submit" name="update_BabelZSettings" value="<?php _e('Update Settings', 'BabelZ') ?>" class="button-primary action" /><br /><br />
</form>
</div>
<?php
		}
	}
}

// Widget Content
if (!function_exists("BabelZ_Widget")) {
    function BabelZ_Widget() {
    	// Get Chosen Language
	$BabelZlang = get_option('BabelZ_lang');
	// Country Fix
	if ($BabelZlang == "en") {
	    $BabelZcty = 'uk';
	} elseif ($BabelZlang == "pt") {
	    $BabelZcty = 'br';
	} else {
	    $BabelZcty = $BabelZlang;
	}
	// Babel Fish JS
	_e('<script type="text/javascript" charset="UTF-8" language="JavaScript1.2" src="http://')._e($BabelZcty)._e('.babelfish.yahoo.com/free_trans_service/babelfish2.js?from_lang=')._e($BabelZlang)._e('&region=us"></script>');
	// Show Promote Link
  	if (get_option('BabelZ_prom') == "checked=on") {
		_e('<p><a href="http://blog.rswr.net/2009/02/24/babelz-babel-fish-wordpress-plugin/" title="BabelZ WordPress Plugin">BabelZ (WordPress Plugin)</a></p>');
	}
    }
}
// Widget Controls
if (!function_exists("BabelZ_Widget_Control")) {
    function BabelZ_Widget_Control() {
    	// On Post Save
    	if (isset($_POST['babelz-submit'])) {
    		if($_POST['prom'] == "on") update_option('BabelZ_prom', "checked=on");
  		else update_option('BabelZ_prom', "");
    		$BabelZlang = $_POST['lang'];
		update_option('BabelZ_lang', $BabelZlang);
    	}
	$BabelZlang = get_option('BabelZ_lang');
	_e('Language to Translate From<br />');
	_e('<select id="lang" name="lang">');
	_e('<option value="en"')._e($BabelZlang=="en" ? "selected" : "")._e('>English</option>');
	_e('<option value="fr"')._e($BabelZlang=="fr" ? "selected" : "")._e('>French</option>');
	_e('<option value="de"')._e($BabelZlang=="de" ? "selected" : "")._e('>German</option>');
	_e('<option value="it"')._e($BabelZlang=="it" ? "selected" : "")._e('>Italian</option>');
	_e('<option value="es"')._e($BabelZlang=="es" ? "selected" : "")._e('>Spanish</option>');
	_e('<option value="pt"')._e($BabelZlang=="pt" ? "selected" : "")._e('>Portuguese</option>');
	_e('</select><br /><br />');
	_e('<input type="checkbox" name="prom"')._e(get_option('BabelZ_prom'))._e('/> Place a support link under the widget. Thanks for your support!');
  	_e('<input type="hidden" id="babelz-submit" name="babelz-submit" value="1" />');
?>
<?php
    }
}
// Initialize Widget
if (!function_exists("BabelZ_Widget_Init")) {
    function BabelZ_Widget_Init() {
        $id = 'BabelZ-1';
        $title = 'BabelZ';
        $ops = array('classname' => 'widget_babelz', 'description' => __('Yahoo Babel Fish Translation Widget.'));
	wp_register_sidebar_widget($id, $title, "BabelZ_Widget", $ops);
	wp_register_widget_control ($id, $title, "BabelZ_Widget_Control");
    }
}

//Initialize the admin panel
if (!function_exists("BabelZ_ap")) {
	function BabelZ_ap() {
		global $BabelZ_init;
		wp_enqueue_script('BabelZ-main','/wp-content/plugins/babelz/js/BabelZ-main.js', array('jquery'), '1.0');
		if (!isset($BabelZ_init)) {
			return;
		}
		if (function_exists('add_options_page')) {
			add_options_page('BabelZ', 'BabelZ', 9, basename(__FILE__), array(&$BabelZ_init, 'printAdminPage'));
		}
	}
}

// Initialize Class
if (class_exists("BabelZ")) {
	$BabelZ_init = new BabelZ();
}

//Actions and Filters
if (isset($BabelZ_init)) {
	//Actions
	add_action('babelz/BabelZ.php', array(&$BabelZ_init, 'init'));
	add_action('admin_menu', 'BabelZ_ap');
	add_action("plugins_loaded", "BabelZ_Widget_Init");
}
?>
