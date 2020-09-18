<?php

namespace FTahir\ESQuery;

use FTahir\ESQuery\Query\Compound\BoolQuery;
use FTahir\ESQuery\SearchBuilder\AbstractBuilder;
use FTahir\ESQuery\SearchBuilder\SearchBuilderFactory;
use FTahir\ESQuery\SearchBuilder\QueryBuilder;
use FTahir\ESQuery\SearchBuilder\SortBuilder;

class Search {

	private $from;
	private $size;
	private $explain;
	private $version;
	private $source;

	private $index;
	private $type;

	private $uriParams = [];

	private $builders = [];

	public function __construct() {}

	public function getBuilder($name) {
		if(!array_key_exists($name,$this->builders)) {
			$this->builders[$name] = SearchBuilderFactory::make($name);
		}

		return $this->builders[$name];
	}

	public function addQuery( QueryInterface $query, $boolType = BoolQuery::MUST ) {
		$builder = $this->getBuilder( QueryBuilder::INDEX );
		return $builder->addToBool( $query, $boolType );
	}

	public function getQueries() {
		$builder = $this->getBuilder( QueryBuilder::INDEX );
		return $builder->bool()->getQueries();
	}

	public function addSort( QueryInterface $query ) {
		$builder = $this->getBuilder( SortBuilder::INDEX );
		return $builder->add( $query );
	}

	public function getSorts() {
		return $this->getBuilder(SortBuilder::INDEX)->getAll();
	}

	public function setIndex($index) {
		$this->index = (string)$index;
		return $this;
	}

	public function getIndex() {
		return $this->index;
	}

	public function setType($type) {
		$this->type = (string)$type;
		return $this;
	}

	public function getType() {
		return $this->type;
	}

	public function getFrom() {
		return (int)$this->from;
	}

	public function setFrom($from) {
		$this->from = (int)$from;
		return $this;
	}

	public function getSize() {
		return (int)$this->size;
	}

	public function setSize($size) {
		$this->size = (int)$size;
		return $this;
	}

	public function setExplain($explain) {
		$this->explain = (bool)$explain;
		return $this;
	}

	public function getExplain() {
		return $this->explain;
	}

	public function setVersion($version) {
		$this->version = (bool)$version;
		return $this;
	}

	public function getVersion() {
		return $this->version;
	}

	public function setSource($source) {
		$this->source = (bool)$source;
		return $this;
	}

	public function getSource() {
		return $this->source;
	}

	public function addUriParam($name,$value) {

		if(!in_array($name,['q','df','analyzer','analyze_wildcard','batched_reduce_size','default_operator','lenient','explain','_source','stored_fields','sort','track_scores','timeout','terminate_after','from','size','search_type'])) {
			throw new \InvalidArgumentException(sprintf('Parameter %s is not supported.', $name));
		} else {
			$this->uriParams[$name] = $value;
		}

		return $this;

	}



	public function getBuild() {

		$output = [];

		$mapping = [
			'from' => 'from',
			'size' => 'size',
			'explain' => 'explain',
			'version' => 'version',
			'source' => '_source'
		];


		foreach( $mapping as $key => $index ) {
			if($this->$key !== null) {
				$output[$index] = $this->$key;
			}
		}

		foreach( $this->builders as $builder ) {
			$output[ $builder::INDEX ] = $builder->getBuild();
		}

		return $output;
	}
}
