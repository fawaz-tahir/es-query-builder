<?php

namespace FTahir\ESQuery;

use FTahir\ESQuery\Query\Compound\BoolQuery;

class Search {

	private $from;
	private $size;
	private $explain = false;
	private $version = false;

	private $uriParams = [];

	public function __construct() {}

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

	public function setExplain() {
		$this->explain = true;
		return $this;
	}

	public function isExplain() {
		return $this->explain;
	}

	public function setVersion() {
		$this->version = true;
		return $this;
	}

	public function isVersion() {
		return $this->version;
	}

	public function addUriParam($name,$value) {

		if(!in_array($name,['q','df','analyzer','analyze_wildcard','batched_reduce_size','default_operator','lenient','explain','_source','stored_fields','sort','track_scores','timeout','terminate_after','from','size','search_type'])) {
			throw new \InvalidArgumentException(sprintf('Parameter %s is not supported.', $name));
		} else {
			$this->uriParams[$name] = $value;
		}

		return $this;

	}
}