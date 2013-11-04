<?php

$dir = dirname (__FILE__);
chdir ($dir);
chdir ('..');

file_put_contents (
	'../checksums/patches.json.sha',
	hash_file ('sha512', 'patches.json')
);

$releases = glob ('releases/*.json');
foreach ($releases as $release) {
	file_put_contents (
		'../checksums/' . $release . '.sha',
		hash_file ('sha512', $release)
	);
}

$patches = glob ('patches/*.patch');
foreach ($patches as $patch) {
	file_put_contents (
		'../checksums/' . $patch . '.sha',
		hash_file ('sha512', $patch)
	);
}

?>