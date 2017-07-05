<?php

namespace FTahir\ESQuery\Query\TermLevel;

use FTahir\ESQuery\QueryInterface;

class TermQuery implements QueryInterface {

	private $value;

	public function __construct($value) {
		$this->value = (string)$value;
	}

	public function getType() {
		return 'type';
	}

	public function getBuild() {
		$query = [
			'value' => $this->value
		];

		return [
			$this->getType() => $query
		];
	}
}