<?php

$dir = dirname (__FILE__);
chdir ($dir);
chdir ('..');

$patches = glob ('patches/*.patch');
$scripts = glob ('patches/*.sql');

foreach ($patches as $k => $patch) {
	$patches[$k] = $patch;
}

foreach ($scripts as $k => $script) {
	$scripts[$k] = $script;
}

file_put_contents (
	'patches.json',
	json_encode (array (
		'patches' => $patches,
		'scripts' => $scripts
	))
);

?>