<?php

namespace FTahir\ESQuery\SearchBuilder;

class SortBuilder extends AbstractBuilder {

  const INDEX = 'sort';

  public function getBuild() {

    $output = [];

    if (!empty($this->getAll())) {
      foreach($this->getAll() as $sort) {
        $output[] = $sort->getBuild();
      }
    }

    return $output;
  }
}
