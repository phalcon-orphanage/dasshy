<?php

namespace Dasshy\Validators;

use Phalcon\Mvc\Model\Validator,
	Phalcon\Mvc\Model\ValidatorInterface,
	Phalcon\Mvc\Model\Message;

class Uniqueness extends Validator implements ValidatorInterface
{
	/**
	 * Validates that the record is unique
	 *
	 * @param Phalcon\Mvc\Collection $record
	 * @return boolean
	 */
	public function validate($record)
	{
		$field = $this->getOption('field');

		$count = $record::count(array(
			array($field => $record->readAttribute($field))
		));

		if ($count > 0) {
			$message = $this->getOption('message');
			$this->appendMessage(new Message($message, $field));
			return false;
		}

		return true;
	}
}