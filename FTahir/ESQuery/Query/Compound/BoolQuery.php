<?php

namespace FTahir\ESQuery\Query\Compound;

use FTahir\ESQuery\ParametersTrait;
use FTahir\ESQuery\QueryInterface;

class BoolQuery implements QueryInterface {

	use ParametersTrait;

	const MUST = 'must';
	const MUST_NOT = 'must_not';
	const SHOULD = 'should';
	const FILTER = 'filter';

	private $queries = [];

	public function __construct(){}

	public function getType() {
		return 'bool';
	}

	public function getQueries($type = null) {

		if(is_null($type) === true) {
			$queries = [];

			foreach($this->queries as $query) {
				$queries = array_merge($queries,$query);
			}

			return $queries;
		}

		if(isset($this->queries[$type]) === true) {
			return $this->queries[$type];
		}

		return [];
	}

	public function addQuery(QueryInterface $query, $type = self::MUST ) {

		if( $type === null ) {
			$type = self::MUST;
		}

		if(!in_array($type,[self::MUST,self::MUST_NOT,self::SHOULD,self::FILTER])) {
			throw new \UnexpectedValueException(sprintf('The bool type \'%s\' is not supported', $type));
		}

		$this->queries[$type][] = $query;
	}

	public function getBuild() {

		// if (count($this->queries) === 1 ) {
		// 	$query = null;

		// 	if(isset($this->queries[self::MUST]) && count($this->queries[self::MUST]) === 1 ) {
		// 		$query = reset($this->queries[self::MUST]);
		// 	}

		// 	if(!is_null($query)) {
		// 		return $query->getBuild();
		// 	}
		// }

		$queries = [];

		foreach($this->queries as $type => $interfaces) {
			foreach($interfaces as $queryInterface) {
				$queries[$type][] = $queryInterface->getBuild();
			}
		}

		$queries = $this->parameters($queries);

		return [
			$this->getType() => $queries
		];
	}
}
