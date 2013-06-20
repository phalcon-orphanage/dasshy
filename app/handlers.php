<?php

use Dasshy\Models\Users,
	Dasshy\Models\Visits,
	Dasshy\Forms\LoginForm,
	Dasshy\Forms\SignUpForm,
	Phalcon\Mvc\Micro\Collection,
	Phalcon\Validation\Message;

//$collection = new Collection();

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

return;

/**
 * Reporte por numero de correos
 */
$app->map('/reports', function() use ($app) {

	$request = $app['request'];

	if (!$request->isPost()) {
		Tag::setDefault('initialDate', date('Y-m-d', Mails::minimum(array('column' => 'received'))));
		Tag::setDefault('finalDate', date('Y-m-d'));
	}

	$builder = $app['modelsManager']->createBuilder()
		->columns('customersId, COUNT(*) rowcount, Customers.name')
		->from('Mails')
		->leftJoin('Customers')
		->where('status = "C"');

	if ($request->isPost()) {
		$builder->andWhere('received >= ?0 AND received <= ?1', array(
			strtotime($request->getPost('initialDate').' 00:00'),
			strtotime($request->getPost('finalDate').' 23:59')
		));
	}

	$data =	$builder->groupBy('customersId')
		->orderBy('rowcount DESC')
		->getQuery()
		->execute();

	echo $app->render('reports/index', array(
		'summary' => $data
	));
});

/**
 * Reporte por tipo
 */
$app->map('/reports/type', function() use ($app) {

	$request = $app['request'];

	if (!$request->isPost()) {
		Tag::setDefault('initialDate', date('Y-m-d', Mails::minimum(array('column' => 'received'))));
		Tag::setDefault('finalDate', date('Y-m-d'));
	}

	$builder = $app['modelsManager']->createBuilder()
		->columns('status, COUNT(*) rowcount')
		->from('Mails');

	if ($request->isPost()) {
		$builder->andWhere('received >= ?0 AND received <= ?1', array(
			strtotime($request->getPost('initialDate').' 00:00'),
			strtotime($request->getPost('finalDate').' 23:59')
		));
	}

	$data = $builder->groupBy('status')
		->orderBy('rowcount DESC')
		->getQuery()
		->execute();

	echo $app->render('reports/type', array(
		'summary' => $data
	));
});

/**
 * Reporte por tipo
 */
$app->map('/reports/daily-trend', function() use ($app) {

	$request = $app['request'];

	if (!$request->isPost()) {
		$d = new DateTime();
		Tag::setDefault('initialDate', $d->modify('-5 days')->format('Y-m-d'));
		Tag::setDefault('finalDate', date('Y-m-d'));
	}

	$builder = $app['modelsManager']->createBuilder()
		->columns('date(received, "unixepoch") period, Customers.name customer, COUNT(*) rowcount, received')
		->from('Mails')
		->join('Customers');

	if ($request->isPost()) {
		$builder->andWhere('received >= ?0 AND received <= ?1', array(
			strtotime($request->getPost('initialDate') . ' 00:00'),
			strtotime($request->getPost('finalDate') . ' 23:59')
		));
	} else {
		$builder->andWhere('received >= ?0 AND received <= ?1', array(
			strtotime($d->format('Y-m-d') . ' 00:00'),
			strtotime(date('Y-m-d') . ' 23:59')
		));
	}

	$data = $builder->groupBy(array('period', 'customer'))
		->orderBy('period')
		->getQuery()
		->execute();

	$headers = array('Periodo' => true);
	$days = array();

	$table = array();
	foreach ($data as $row) {
		$period = date('m/d', $row->received);
		$headers[$row->customer] = true;
		$days[$period] = true;
		$table[$period][$row->customer] = $row->rowcount;
	}

	echo $app->render('reports/daily-trend', array(
		'table' => $table,
		'headers' => array_keys($headers),
		'days' => array_keys($days)
	));
});

/**
 * Clasificar los dominios
 */
$app->map('/classify', function() use ($app) {
	echo $app->render('classify/index', array(
		'domains' => UnclassifiedDomains::find('type = "U"')
	));
});

/**
 * Clasificar los correos
 */
$app->map('/classify-emails', function() use ($app) {
	echo $app->render('classify/emails', array(
		'emails' => UnclassifiedEmails::find('type = "U"')
	));
});

/**
 * Clasificar dominio
 */
$app->map('/classify/{id:[0-9]+}', function($id) use ($app) {

	$unclassified = UnclassifiedDomains::findFirstById($id);
	if (!$unclassified) {
		$app['flash']->error('Dominio no encontrado');
		return;
	}

	$request = $app['request'];

	if ($request->isPost()) {

		$tipo = $request->getPost('tipo');
		if ($tipo == 'C') {
			$customer = new CustomersDomains();
			$customer->customersId = $request->getPost('cliente');
			$customer->domain = $unclassified->domain;
			if (!$customer->save()) {
				var_dump($customer->getMessages());
			} else {
				$app['flash']->success('Se clasificó correctamente el dominio');
			}
		}

		$unclassified->type = $tipo;
		if ($unclassified->save()) {
			if ($tipo != 'C') {
				$app['flash']->success('Se clasificó correctamente el dominio');
			}
		}

	}

	echo $app->render('classify/domain', array(
		'domain' => $unclassified,
		'customers' => Customers::find(['order' => 'name'])
	));

});

/**
 * Clasificar dominio
 */
$app->map('/mails/{id:[0-9]+}', function($id) use ($app) {

	echo $app->render('mails/list', array(
		'emails' => Mails::find(array(
			'customersId = ?0',
			'bind' => [$id],
			'order' => 'id DESC'
		))
	));

});

/**
 * Sin clasificar
 */
$app->map('/unclassified', function() use ($app) {

	echo $app->render('mails/list', array(
		'emails' => Mails::find(array(
			'status = "U"',
			'order' => 'id DESC'
		))
	));

});

/**
 * Clasificar email
 */
$app->map('/classify-email/{id:[0-9]+}', function($id) use ($app) {

	$unclassified = UnclassifiedEmails::findFirstById($id);
	if (!$unclassified) {
		$app['flash']->error('E-mail no encontrado');
		return;
	}

	$request = $app['request'];

	if ($request->isPost()) {

		$tipo = $request->getPost('tipo');
		if ($tipo == 'C') {
			$customer = new CustomersEmails();
			$customer->customersId = $request->getPost('cliente');
			$customer->email = $unclassified->email;
			if (!$customer->save()) {
				var_dump($customer->getMessages());
			} else {
				$app['flash']->success('Se clasificó correctamente el correo');
			}
		}

		$unclassified->type = $tipo;
		if ($unclassified->save()) {
			if ($tipo != 'C') {
				$app['flash']->success('Se clasificó correctamente el correo');
			}
		}

	}

	echo $app->render('classify/email', array(
		'email' => $unclassified,
		'customers' => Customers::find()
	));

});

$app->map('/classify-email/{email:[a-zA-Z0-9\.\-\_]+@[a-zA-Z0-9\.\-\_]+}', function($email) use ($app) {

	$unclassified = UnclassifiedEmails::findFirstByEmail($email);
	if (!$unclassified) {
		$app['flash']->error('E-Mail no encontrado');
		return;
	}

	$app['response']->redirect('classify-email/' . $unclassified->id)->send();

});

/**
 * Procesar nuevos correos
 */
$app->map('/process/new', function() use ($app) {

	set_time_limit(0);

	$connection = $app['db'];

	$connection->begin();

	Mail::processUnseen($connection);
	Mail::processUnclassified();

	$connection->commit();

	$app['flash']->success('Proceso ejecutado correctamente');

	echo $app->render('process/index');

});

/**
 * Procesar correos sin clasificar
 */
$app->map('/process/unclassified', function() use ($app) {

	set_time_limit(0);

	$connection = $app['db'];

	$connection->begin();
	Mail::processUnclassified();
	$connection->commit();

	$app['flash']->success('Proceso ejecutado correctamente');

	echo $app->render('process/index');

});

$app->map('/customers', function() use ($app) {

	echo $app->render('customers/index', array(
		'form' => new CustomersForm()
	));
});

$app->map('/customers/create', function() use ($app) {

	$request = $app['request'];

	if ($request->isPost()) {

		$customer = new Customers();

		$customer->assign(array(
			'name' => $request->getPost('name', 'striptags'),
			'prefix' => $request->getPost('prefix', 'striptags')
		));

		if (!$customer->save()) {
			$app['flash']->error($customer->getMessages());
		} else {
			$app['flash']->success("Se creó el cliente correctamente");
			Tag::resetInput();
		}
	}

	echo $app->render('customers/create', array(
		'form' => new CustomersForm()
	));
});

$app->map('/customers/search', function() use ($app) {

	$numberPage = 1;
	if ($app['request']->isPost()) {
		$query = Criteria::fromInput($app->getDI(), 'Customers', $app['request']->getPost());
		$app['session']->set('searchParams', $query->getParams());
	} else {
		$numberPage = $app['request']->getQuery("page", "int");
	}

	$parameters = array();
	if ($app['session']->get('searchParams')) {
		$parameters = $app['session']->get('searchParams');
	}

	$paginator = new Paginator(array(
		"data" => Customers::find($parameters),
		"limit" => 10,
		"page" => $numberPage
	));

	echo $app->render('customers/search', array(
		'page' => $paginator->getPaginate()
	));
});

$app->map('/customers/edit/{id}', function($id) use ($app) {

	$customer = Customers::findFirstById($id);
	if (!$customer) {
		return $app['response']->redirect('customers')->send();
	}

	$request = $app['request'];

	if ($request->isPost()) {

		$customer->assign(array(
			'name' => $request->getPost('name', 'striptags'),
			'prefix' => $request->getPost('prefix', 'striptags')
		));

		if (!$customer->save()) {
			$app['flash']->error($customer->getMessages());
		} else {
			$app['flash']->success("Se actualizó el cliente correctamente");
			Tag::resetInput();
		}
	}

	echo $app->render('customers/edit', array(
		'customer' => $customer,
		'form' => new CustomersForm($customer, array('edit' => true))
	));

});

