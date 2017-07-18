<?php

namespace FTahir\ESQuery\Query\FullText;

use FTahir\ESQuery\QueryInterface;
use FTahir\ESQuery\ParametersTrait;

class QueryStringQuery implements QueryInterface {
  use ParametersTrait;

  private $query;

  public function __construct( $query, array $params = [] ) {
    $this->query = (string)$query;
    $this->setParameters( $params );
  }

  public function getType() {
    return 'query_string';
  }

  public function getBuild() {
    $query = [
      'query' => $this->query
    ];

    $query = $this->parameters( $query );

    return [
      $this->getType() => $query
    ];
  }
}
