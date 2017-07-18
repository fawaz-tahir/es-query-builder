<?php

namespace FTahir\ESQuery\Query\FullText;

use FTahir\ESQuery\QueryInterface;
use FTahir\ESQuery\ParametersTrait;

class MultiMatchQuery implements QueryInterface {
  use ParametersTrait;

  private $fields;
  private $value;

  public function __construct( array $fields, $value, array $params = [] ) {
    $this->fields = $fields;
    $this->value = $value;
    $this->setParameters( $params );
  }

  public function getType() {
    return 'multi_match';
  }

  public function getBuild() {
    $query = [
      'query' => $this->value,
      'fields' => $this->fields
    ];

    if ($this->hasParameter('fields')) {
      $this->removeParameter('fields');
    }

    $query = $this->parameters( $query );

    return [
      $this->getType() => $query
    ];
  }
}
