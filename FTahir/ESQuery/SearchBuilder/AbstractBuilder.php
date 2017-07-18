<?php

namespace FTahir\ESQuery\SearchBuilder;

use FTahir\ESQuery\QueryInterface;
use FTahir\ESQuery\ParametersTrait;

abstract class AbstractBuilder {

  use ParametersTrait;

  private $queries = [];

  public function add( QueryInterface $query ) {
    $this->queries[] = $query;
    return $this;
  }

  public function getAll() {
    return $this->queries;
  }
}
