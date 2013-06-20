<?php

use Phalcon\DI\FactoryDefault,
	Phalcon\Assets\Manager as AssetsManager,
	Phalcon\Mvc\Collection\Manager as CollectionManager,
	Phalcon\Mvc\View\Simple as View,
	Phalcon\Mvc\View\Engine\Volt,
	Phalcon\Mvc\Url as UrlResolver,
	Phalcon\Flash\Session as Flash,
	Phalcon\Flash\Direct as FlashDirect,
	Phalcon\Session\Adapter\Files as Session;

$di = new FactoryDefault();

//View service
$di['view'] = function() {

	$view = new View();

	$view->setViewsDir(APP_PATH . '/views/');

	$view->registerEngines(array(
		'.volt' => function ($view, $di) {

			$volt = new Volt($view, $di);

			$volt->setOptions(array(
				'compiledPath' => APP_PATH . '/cache/volt/',
				'compiledSeparator' => '_'
			));

			return $volt;
		}
	));

	return $view;
};

$di['url'] = function() {
	$url = new UrlResolver();
	$url->setBaseUri('/dasshy/');
	return $url;
};

$di['assets'] = function() {

	$assets = new AssetsManager();

	$assets
		->addJs('//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js', false)
		->addJs('//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js', false);

	return $assets;
};

/**
 * Flash service with custom CSS classes
 */
$di['flash'] = function(){
	return new Flash(array(
		'error' => 'alert alert-error',
		'success' => 'alert alert-success',
		'notice' => 'alert alert-info',
	));
};

/**
 * Flash service with custom CSS classes
 */
$di['flashDirect'] = function(){
	return new FlashDirect(array(
		'error' => 'alert alert-error',
		'success' => 'alert alert-success',
		'notice' => 'alert alert-info',
	));
};

$di['session'] = function(){
	$session = new Session(array(
		'uniqueId' => 'dasshy-'
	));
	$session->start();
	return $session;
};

// Simple database connection to localhost
$di['mongo'] = function() {
    $mongo = new Mongo();
    return $mongo->selectDb("stats");
};

//Collection manager
$di['collectionManager'] = function() {
	return new CollectionManager();
};
