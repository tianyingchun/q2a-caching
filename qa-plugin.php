<?php

/*
  Plugin Name: q2a-caching
  Plugin URI: https://github.com/sama55/q2a-caching
  Plugin Description: Question2Answer Caching plugin
  Plugin Version: 0.5
  Plugin Date: 2015-07-24
  Plugin Author: Vadim Kr. bndr + sama55 + stevenev
  Plugin License: http://creativecommons.org/licenses/by-sa/3.0/legalcode
  Plugin Minimum Question2Answer Version: 1.7
 */

if (!defined('QA_VERSION'))
{ // don't allow this page to be requested directly from browser
    header('Location: ../../');
    exit;
}

//register a special module that resets the session flag if logging in
qa_register_plugin_module(
    'event', // type of module
    'qa-caching-event.php', // PHP file containing module class
    'qa_caching_session_reset_event', // module class name in that PHP file
    'q2a Caching Plugin Session Reset Event Handler' // human-readable name of module
);

if ( isset( $_SESSION['cache_use_off'] )) {	
	return;  //just get out! this is for anon users who have posted something, don't exec. any of the cache code, see event that turns this status off		
}

/**
 * Include the caching for registered users
 */
include_once(dirname(__FILE__).'/qa-caching-registered.php');

/**
 * Register the plugin
 */
qa_register_plugin_module(
    'process', // type of module
    'qa-caching-main.php', // PHP file containing module class
    'qa_caching_main', // module class name in that PHP file
    'q2a Caching Plugin' // human-readable name of module
);
qa_register_plugin_module(
    'event', // type of module
    'qa-caching-event.php', // PHP file containing module class
    'qa_caching_event', // module class name in that PHP file
    'q2a Caching Plugin Event Handler' // human-readable name of module
);
qa_register_plugin_layer(
    'qa-caching-layer.php', // PHP file containing module class
    'q2a Caching Plugin Layer'
);
qa_register_plugin_overrides(
    'qa-caching-overrides.php' // PHP file containing overrided function
);

/*
	Omit PHP closing tag to help avoid accidental output
*/