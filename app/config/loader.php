<?php

$loader = new Phalcon\Loader();

$loader->registerNamespaces(array(
	'Dasshy\Models' => APP_PATH . '/models/',
	'Dasshy\Validators' => APP_PATH . '/validators/',
	'Dasshy\Forms' => APP_PATH . '/forms/',
));

$loader->register();