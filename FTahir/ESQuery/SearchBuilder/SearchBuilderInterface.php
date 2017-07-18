<?php

namespace FTahir\ESQuery\SearchBuilder;

use FTahir\ESQuery\QueryInterface;

interface SearchBuilderInterface {
  public function add( QueryInterface $query );
  public function addToBool( QueryInterface $query, $boolType = null );
  public function getAll( $boolType = null );
  public function bool();
}
