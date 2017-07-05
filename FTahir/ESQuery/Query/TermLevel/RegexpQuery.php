<?php

namespace FTahir\ESQuery\Query\TermLevel;

use FTahir\ESQuery\ParametersTrait;
use FTahir\ESQuery\QueryInterface;

class RegexpQuery implements QueryInterface {

	use ParametersTrait;

	private $field;
	private $value;

	public function __construct( $field, $value, array $parameters = [] ) {
		$this->field = (string)$field;
		$this->value = $value;
		$this->setParameters($parameters);
	}

	public function getType() {
		return 'regexp';
	}

	public function getBuild() {
		$query = [
			'value' => $this->value
		];

		$query = $this->parameters( $query );

		return [
			$this->getType() => [
				$this->field => $query
			]
		];
	}
}