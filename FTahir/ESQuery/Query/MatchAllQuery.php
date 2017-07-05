<?php

namespace FTahir\ESQuery\Query;

use FTahir\ESQuery\QueryInterface;
use FTahir\ESQuery\ParametersTrait;

class MatchAllQuery implements QueryInterface {

	public function __construct(array $parameters = []) {
		$this->setParameters($parameters);
	}

	public function getType() {
		return 'match_all';
	}

	public function getBuild() {
		$parameters = $this->parameters();

		return [
			$this->getType() => !empty($parameters) ? $parameters : new \stdClass()
		];
	}
}