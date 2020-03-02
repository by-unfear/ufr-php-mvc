<?php
if (file_exists('framework' . DIRECTORY_SEPARATOR . 'load.inc.php')) {
    require_once 'framework' . DIRECTORY_SEPARATOR . 'load.inc.php';
} else {
    echo 'Não foi possivel carregar o sistema<br/>';
}

if (class_exists('App')) {

	$app = new App();

	$app->run();

} else {
    echo 'Não foi possivel criar o sistema';
}
