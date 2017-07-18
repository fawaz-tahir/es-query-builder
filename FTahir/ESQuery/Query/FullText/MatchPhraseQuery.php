<?php

namespace FTahir\ESQuery\Query\FullText;

use FTahir\ESQuery\QueryInterface;
use FTahir\ESQuery\ParametersTrait;

class MatchPhraseQuery implements QueryInterface {
  use ParametersTrait;

  private $field;
  private $value;

  public function __construct( $field, $value, array $params = [] ) {
    $this->field = (string)$field;
    $this->value = $value;
    $this->setParameters( $params );
  }

  public function getType() {
    return 'match_phrase';
  }

  public function getBuild() {
    $query = [
      'query' => $this->value
    ];

    $query = $this->parameters( $query );

    return [
      $this->getType() => [
        $this->field => $query
      ]
    ];
  }
}
