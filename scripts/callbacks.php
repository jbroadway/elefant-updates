<?php

$dir = dirname (__FILE__);
chdir ($dir);
chdir ('..');

$releases = glob ('releases/*.json');

foreach ($releases as $release) {
	file_put_contents (
		str_replace ('.json', '.js', $release),
		'elefant_update_response(' . file_get_contents ($release) . ')'
	);
}

?>