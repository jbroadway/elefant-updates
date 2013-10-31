<?php

if (! preg_match ('/^[0-9]+\.[0-9]+$/', $_GET['v'])) {
	die ('Invalid version number');
}

header ('Content-Type: application/json');

if (isset ($_GET['callback'])) {
	echo $_GET['callback'] . '(' . file_get_contents ($_GET['v'] . '.json') . ')';
} else {
	echo file_get_contents ($_GET['v'] . '.json');
}

?>