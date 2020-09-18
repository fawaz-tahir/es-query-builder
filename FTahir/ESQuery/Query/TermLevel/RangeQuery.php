<?php

namespace FTahir\ESQuery\Query\TermLevel;

use FTahir\ESQuery\ParametersTrait;
use FTahir\ESQuery\QueryInterface;

class RangeQuery implements QueryInterface {

	use ParametersTrait;

	const GT  = 'gt';
	const GTE = 'gte';
	const LT  = 'lt';
	const LTE = 'lte';

	private $field;

	public function __construct($field, array $parameters = []) {
		$this->setParameters($parameters);
		$this->field = (string)$field;
	}

	public function getType() {
		return 'range';
	}

	public function getBuild(){

		if ($this->hasParameter(self::GT) && $this->hasParameter(self::GTE)) {
			$this->removeParameter(self::GTE);
		}

		if($this->hasParameter(self::LT) && $this->hasParameter(self::LTE)) {
			$this->removeParameter(self::LTE);
		}

		$query = $this->parameters();

		return [
			$this->getType() => [
				$this->field => $query
			]
		];
	}
}
