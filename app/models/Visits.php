<?php

namespace Dasshy\Models;

use Phalcon\Mvc\Collection;

class Visits extends Collection
{

	public $ip;

	public $userAgent;

	public $country;

	public $countryCode;

	public $createdAt;

	/**
	 * Allows to perform a summatory group for a column in the collection
	 *
	 * @param string $field
	 * @param array $conditions
	 * @param string $finalize
	 * @return array
	 */
	public static function summatory($field, $conditions=null, $finalize=null)
	{

		$aggregate = self::aggregate(array(
			'$group' => array(
				"_id" => '$' . $field,
				"count" => array('$sum' => 1),
        	)
    	));

    	if (isset($aggregate['result'])) {
			$retval = $aggregate['result'];
			return $retval;
		}

		return array();
	}

}