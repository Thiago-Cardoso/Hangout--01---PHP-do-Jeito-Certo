<?php 
$GLOBALS['KTML4_XHTMLLocations'] = array(
	"tidy",
	"/usr/bin/tidy",
	"/usr/local/bin/tidy",
	"/usr/local/tidy/bin/tidy",
	"/usr/bin/tidy/bin/tidy",
	"tidy.exe", 
	"C:/Progra~1/tidy/tidy.exe",
	"C:/Windows/tidy.exe", 
	"C:/utils/dlls/tidy.exe"
	);
$GLOBALS['KTML4_XHTMLConfigPath'] = KT_RealPath(dirname(realpath(__FILE__)), true) . '.tidyconf';
$GLOBALS['KTML4_XHTMLTempPath'] = dirname(__FILE__).'/../../temp/.tidy/';
?>