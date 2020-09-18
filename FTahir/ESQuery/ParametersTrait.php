<?php

namespace FTahir\ESQuery;

trait ParametersTrait {

  private $parameters = [];

	public function setParameter($name, $value) {
		$this->parameters[$name] = $value;
	}

	public function hasParameter($name) {
		return isset($this->parameters[$name]);
	}

	public function removeParameter($name) {
		if($this->hasParameter($name) === true ) {
			unset($this->parameters[$name]);
		}
	}

	public function getParameter($name) {
		return $this->parameters[$name];
	}

	public function getParameters() {
		return $this->parameters;
	}

	public function setParameters(array $parameters) {
		$this->parameters = $parameters;
	}

	public function parameters( array $parameters = [] ) {
		return array_merge( $parameters, $this->parameters );
	}
}