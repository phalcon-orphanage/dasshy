<?php

use Dasshy\Models\Users,
	Dasshy\Models\Visits,
	Dasshy\Forms\LoginForm,
	Dasshy\Forms\SignUpForm,
	Phalcon\Mvc\Micro\Collection,
	Phalcon\Validation\Message;

$app->map('/', function() use ($app) {
	return $app->response->redirect('login');
});

$app->map('/login', function() use ($app) {

	$loginForm = new LoginForm();

	if ($app->request->isPost()) {

		if ($loginForm->isValid($app->request->getPost())) {

			$user = Users::findFirst(array(
				array('login' => $app->request->getPost('login'))
			));

			if (!$user) {
				$loginForm->getMessagesFor('login')->appendMessage(new Message('User/Password is not valid'));
			} else {
				if (!$app->security->checkHash($app->request->getPost('password'), $user->password)) {
					$loginForm->getMessagesFor('login')->appendMessage(new Message('User/Password is not valid'));
				} else {
					$app->flash->success('Welcome ' . $user->login . '!');
					return $app->response->redirect('dashboard');
				}
			}

		}
	}

	echo $app->view->render('login', array(
		'loginForm' => $loginForm,
		'signUpForm' => new SignUpForm()
	));
});

$app->map('/signup', function() use ($app) {

	$signUpForm = new SignUpForm();

	if ($app->request->isPost()) {
		if ($signUpForm->isValid($app->request->getPost())) {

			$user = new Users();
			$user->name = $app->request->getPost('name');
			$user->login = $app->request->getPost('login');
			$user->password = $app->security->hash($app->request->getPost('password'));

			if ($user->save()) {
				$app->flash->success('Welcome ' . $user->login . '!');
				return $app->response->redirect('dashboard');
			}

		}
	}

	echo $app->view->render('login', array(
		'loginForm' => new LoginForm(),
		'signUpForm' => $signUpForm
	));

});

$app->map('/dashboard', function() use ($app) {

	echo $app->view->render('dashboard', array(
		'summatory' => Visits::summatory('countryCode')
	));

});

$app->notFound(function() use ($app) {
	echo $app->view->render('errors/404');
});
