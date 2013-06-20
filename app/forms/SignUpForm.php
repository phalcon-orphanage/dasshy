<?php

namespace Dasshy\Forms;

use Phalcon\Forms\Form,
	Phalcon\Forms\Element\Text,
	Phalcon\Forms\Element\Hidden,
	Phalcon\Forms\Element\Password,
	Phalcon\Forms\Element\Submit,
	Phalcon\Forms\Element\Check,
	Phalcon\Validation\Validator\PresenceOf,
	Phalcon\Validation\Validator\Email,
	Phalcon\Validation\Validator\Identical,
	Phalcon\Validation\Validator\StringLength,
	Phalcon\Validation\Validator\Confirmation;

class SignUpForm extends Form
{

	/**
	 * @param object $entity
	 * @param array $options
	 */
	public function initialize($entity=null, $options=null)
	{

		//Name
		$name = new Text('name', array(
			'placeholder' => 'Full name'
		));

		$name->setLabel('Name');

		$name->addValidators(array(
			new PresenceOf(array(
				'message' => 'The name is required'
			)),
			new StringLength(array(
				'min' => 8,
				'messageMinimum' => 'Name is too short. Minimum 8 characters'
			))
		));

		$this->add($name);

		//Username
		$username = new Text('login', array(
			'placeholder' => 'Username'
		));

		$username->addValidators(array(
			new PresenceOf(array(
				'message' => 'The username is required',
				'cancelOnFail' => true
			)),
			new StringLength(array(
				'min' => 5,
				'messageMinimum' => 'Username is too short. Minimum 5 characters'
			)),
		));

		$this->add($username);

		//Password
		$password = new Password('password', array(
			'placeholder' => 'Password'
		));

		$password->addValidators(array(
			new PresenceOf(array(
				'message' => 'The password is required',
				'cancelOnFail' => true
			)),
			new StringLength(array(
				'min' => 8,
				'messageMinimum' => 'Password is too short. Minimum 8 characters'
			)),
			new Confirmation(array(
				'message' => 'Password doesn\'t match confirmation',
				'with' => 'confirmPassword'
			))
		));

		$this->add($password);

		//Confirm Password
		$confirmPassword = new Password('confirmPassword', array(
			'placeholder' => 'Confirm Password',
			'cancelOnFail' => true
		));

		$confirmPassword->addValidators(array(
			new PresenceOf(array(
				'message' => 'The confirmation password is required'
			))
		));

		$this->add($confirmPassword);

		//Remember
		$terms = new Check('terms', array(
			'value' => 'yes'
		));

		$terms->setLabel('Accept terms and conditions');

		$terms->addValidator(
			new Identical(array(
				'value' => 'yes',
				'message' => 'Terms and conditions must be accepted'
			))
		);

		$this->add($terms);

		//Sign Up
		$this->add(new Submit('Sign Up', array(
			'class' => 'btn btn-success'
		)));
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