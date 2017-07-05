<?php

namespace FTahir\ESQuery\Query\TermLevel;

use FTahir\ESQuery\QueryInterface;

class ExistsQuery implements QueryInterface {

	private $field;

	public function __construct($field) {
		$this->field = $field;
	}

	public function getType() {
		return 'exists';
	}

	public function getBuild() {

		$query = [
			'field' => $this->field;
		];

		return [
			$this->getType() => $query;
		];
	}
}