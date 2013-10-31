<?php

header ('Content-Type: application/json');

$patches = glob ('patches/*.patch');
$scripts = glob ('patches/*.sql');

foreach ($patches as $k => $patch) {
	$patches[$k] = 'http://www.elefantcms.com/updates/' . $patch;
}

foreach ($scripts as $k => $script) {
	$scripts[$k] = 'http://www.elefantcms.com/updates/' . $script;
}

echo json_encode (array (
	'patches' => $patches,
	'scripts' => $scripts
));

?>