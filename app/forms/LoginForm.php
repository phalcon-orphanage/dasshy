<?php

namespace Dasshy\Forms;

use Phalcon\Forms\Form,
	Phalcon\Forms\Element\Text,
	Phalcon\Forms\Element\Password,
	Phalcon\Forms\Element\Submit,
	Phalcon\Validation\Validator\PresenceOf,
	Phalcon\Validation\Validator\Email;

class LoginForm extends Form
{

	public function initialize()
	{
		//Username
		$login = new Text('login', array(
			'placeholder' => 'Username'
		));

		$login->addValidators(array(
			new PresenceOf(array(
				'message' => 'The username is required'
			))
		));

		$this->add($login);

		//Password
		$password = new Password('password', array(
			'placeholder' => 'Password'
		));

		$password->addValidator(
			new PresenceOf(array(
				'message' => 'The password is required'
			))
		);

		$this->add($password);

		$this->add(new Submit('Log In', array(
			'class' => 'btn btn-success'
		)));
	}

	public function getMessagesFor($name)
	{
		$messages = parent::getMessagesFor($name);
		if (!isset($this->_messages[$name])) {
			$this->_messages[$name] = $messages;
		}
		return $messages;
	}

	/**
	 * Prints messages for a specific element
	 *
	 * @param string $name
	 */
	public function messages($name)
	{
		if ($this->hasMessagesFor($name)) {
			foreach ($this->getMessagesFor($name) as $message) {
				$this->flashDirect->error($message);
			}
		}
	}

}