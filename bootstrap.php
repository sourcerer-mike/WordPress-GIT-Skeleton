<?php

/*
 * }}} Things a rookie understands. {{{
 */

// used protocol: either http or https
$protocol = 'http' .
            ((!empty($_SERVER['HTTPS'])
              && $_SERVER['HTTPS'] !== 'off'
              || $_SERVER['SERVER_PORT'] == 443)) ? 's' : '';

// url to the website
$websiteUrl = $protocol . '://'
              . $_SERVER['HTTP_HOST']
              . max('/', dirname($_SERVER['PHP_SELF'])) . '/';

/*
 * }}} Get off if you are not a WordPress pro! {{{
 */

// rewrite plugin
define('WP_PLUGIN_URL', $websiteUrl . 'plugins');
define('WP_PLUGIN_DIR', __DIR__ . '/plugins');
define('PLUGINDIR', WP_PLUGIN_DIR);
