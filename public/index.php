<?php

error_reporting(E_ALL);

use Phalcon\Mvc\Micro as App;

define ('APP_PATH', realpath('../app'));

require APP_PATH . '/config/loader.php';
require APP_PATH . '/config/services.php';

//try {

	$app = new App();

	$app->setDI($di);

	require APP_PATH . '/handlers.php';

	$response = $app->handle();

	if ($response instanceof Phalcon\Http\ResponseInterface) {
		$response->send();
	}

//} catch (Exception $e) {
//	echo $app->view->render('errors/500', array(
//		'exception' => $e
//	));
//}