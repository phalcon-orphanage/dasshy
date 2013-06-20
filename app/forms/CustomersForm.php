<?php

use Phalcon\Forms\Form,
	Phalcon\Forms\Element\Text,
	Phalcon\Forms\Element\Hidden,
	Phalcon\Forms\Element\Password,
	Phalcon\Forms\Element\Submit,
	Phalcon\Forms\Element\Select,
	Phalcon\Forms\Element\Check,
	Phalcon\Validation\Validator\PresenceOf,
	Phalcon\Validation\Validator\Email;

class CustomersForm extends Form
{

	public function initialize($entity=null, $options=null)
	{

		//In edition the id is hidden
		if (isset($options['edit']) && $options['edit']) {
			$id = new Hidden('id');
		} else {
			$id = new Text('id');
		}

		$this->add($id);

		$this->add(new Text('name'));

		$this->add(new Text('prefix'));
	}

}