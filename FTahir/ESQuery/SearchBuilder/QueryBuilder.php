<?php

namespace FTahir\ESQuery\SearchBuilder;

use FTahir\ESQuery\QueryInterface;
use FTahir\ESQuery\Query\Compound\BoolQuery;
use FTahir\ESQuery\SearchBuilder\SearchBuilderInterface;

class QueryBuilder extends AbstractBuilder implements SearchBuilderInterface {

  const INDEX = 'query';

  private $bool;

  public function bool() {
    return $this->bool;
  }

  public function add( QueryInterface $query ) {
      return $this->addToBool( $query, BoolQuery::MUST );
  }

  public function addToBool( QueryInterface $query, $boolType = null ) {

    if ( !$this->bool ) {
      $this->bool = new BoolQuery();
    }

    return $this->bool->addQuery( $query, $boolType );
  }

  public function getAll( $boolType = null ) {
    if ( !$this->bool ) {
      return [];
    }

    return $this->bool->getQueries( $boolType );
  }

  public function getBuild() {

    if(!$this->bool) {
      return [];
    }

    return $this->bool->getBuild();
  }
}
