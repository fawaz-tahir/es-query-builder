<?php

namespace FTahir\ESQuery\Query\TermLevel;

use FTahir\ESQuery\ParametersTrait;
use FTahir\ESQuery\QueryInterface;

class IdsQuery implements QueryInterface {

	use ParametersTrait;

	private $ids;

	public function __construct($ids, array $parameters = []) {
		$this->ids = $ids;
		$this->setParameters($parameters);
	}

	public function getType() {
		return 'ids';
	}

	public function getBuild() {
		$query = [
			'value' => $this->ids
		];

		$query = $this->parameters($query);

		return [
			$this->getType() => $query
		];
	}
}