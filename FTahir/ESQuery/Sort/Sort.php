<?php

namespace FTahir\ESQuery\Sort;

use FTahir\ESQuery\QueryInterface;
use FTahir\ESQuery\ParametersTrait;

class Sort implements QueryInterface {

  use ParametersTrait;

  CONST ASC = 'asc';
  CONST DESC = 'desc';

  private $field;
  private $order;
  private $nestedFilter;

  public function __construct( $field, $order = Sort::DESC, array $params = [] ) {
    $this->field = (string)$field;
    $this->order = (string)$order;
    $this->setParameters( $params );
  }

  public function getType() {
    return 'sort';
  }

  public function setNestedFilter( QueryInterface $sortQuery ) {
    if ( $sortQuery instanceof Sort ) {
      $this->nestedFilter = $sortQuery;
    }

    return $this;
  }

  public function getNestedFilter() {
    return $this->nestedFilter;
  }

  public function getBuild() {
    if($this->order) {
      $this->setParameter('order',$this->order);
    }

    if($this->getNestedFilter()) {
      $this->setParameter( 'nested_filter', $this->getNestedFilter()->getBuild() );
    }

    $sort = $this->parameters();

    return [
      $this->field => $sort
    ];
  }
}
