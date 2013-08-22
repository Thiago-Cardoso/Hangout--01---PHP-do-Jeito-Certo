<?php 
$GLOBALS['KTML4_aspellpaths'] = array(
	'aspell',
	'/usr/bin/aspell',
	'/usr/local/bin/aspell',
	'/usr/local/aspell/bin/aspell',
	'/usr/bin/aspell/bin/aspell',
	'aspell.exe',
	'c:/Progra~1/Aspell/bin/aspell.exe',
	'c:/Windows/aspell.exe'
	);
$GLOBALS['KTML4_languagelist'] = array(
	array("en_GB", "british","English (UK)"),
	array("en_US", "american","English (USA)"),
	array("de", "german", "German"),
	array("es", "espanol", "Spanish"),
	array("fr", "french", "French"), 
	array("nl", "dutch", "Dutch"),
	array("no", "norwegian", "Norwegian"),
	array("it", "italian", "Italian"),
	array("el", "greek", "Greek"),
	array("ro", "romanian", "Romanian"),
	array("cs", "czech", "Czech")
	);
$GLOBALS['KTML4_aspellTempPath'] = dirname(__FILE__).'/../../temp/.aspell/';
$GLOBALS['KTML4_interakt_service_server'] = 'spell.interaktonline.com';
$GLOBALS['KTML4_interakt_service_path'] = '/service.php';
?>