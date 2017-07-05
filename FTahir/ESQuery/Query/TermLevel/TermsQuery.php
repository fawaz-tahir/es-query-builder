<?php

namespace FTahir\ESQuery\Query\TermLevel;

use FTahir\ESQuery\ParametersTrait;
use FTahir\ESQuery\QueryInterface;

class TermsQuery implements QueryInterface {
	use ParametersTrait;

	private $field;
	private $terms;

	public function __construct( $field, array $terms, array $parameters = [] ) {
		$this->field = (string)$field;
		$this->terms = $terms;
		$this->setParameters( $parameters );
	}

	public function getType() {
		return 'terms';
	}

	public function getBuild() {

		$query = [
			$this->field => $this->terms
		];

		$query = $this->parameters( $query );

		return [
			$this->getType() => $query
		];
	}
}