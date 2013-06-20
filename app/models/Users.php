<?php

namespace Dasshy\Models;

use Phalcon\Mvc\Collection,
	Phalcon\Mvc\Model\Validator\PresenceOf,
	Dasshy\Validators\Uniqueness;

class Users extends Collection
{
	public $login;

	public $password;

	public $name;

	public function validation()
	{
		$this->validate(new PresenceOf(array(
			'field' => 'login',
			'message' => 'The login is required',
		)));

		$this->validate(new PresenceOf(array(
			'field' => 'password',
			'message' => 'The name is required',
		)));

		$this->validate(new PresenceOf(array(
			'field' => 'name',
			'message' => 'The name is required',
		)));

		$this->validate(new Uniqueness(array(
			'field' => 'login',
			'message' => 'The login must be unique',
		)));
		return $this->validationHasFailed() != true;
	}

}