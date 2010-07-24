<?php
$GLOBALS['include_path'] = dirname(__FILE__) . PATH_SEPARATOR . dirname(__FILE__) . '/../' . PATH_SEPARATOR . get_include_path();
ini_set('include_path', $GLOBALS['include_path']);
$GLOBALS['intraface_private_key'] = "L9FtAdfAu8QwLSChGZehzeZwiAhXNwsqwWIMZF4avCw6jY6HN2G";
$GLOBALS['intraface_site_id'] = 35;
$GLOBALS['cache_dir'] = "";

define('DB_DSN', 'mysql://vih:password@localhost/vih');
define('PATH_ROOT', '/home/vih/');


define('PATH_TEMPLATE_KUNDELOGIN', dirname(__FILE__) . '/View/Kundelogin/');
define('PATH_TEMPLATE', dirname(__FILE__) . '/View/Kundelogin/');

$private_key = 'xx';

define('INTRAFACE_PRIVATE_KEY', $private_key);


