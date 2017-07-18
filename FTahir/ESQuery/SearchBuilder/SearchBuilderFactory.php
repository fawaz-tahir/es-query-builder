<?php

namespace FTahir\ESQuery\SearchBuilder;

class SearchBuilderFactory {

  private static $builders = [
    'sort' => 'FTahir\ESQuery\SearchBuilder\SortBuilder',
    'query' => 'FTahir\ESQuery\SearchBuilder\QueryBuilder',
  ];


  public static function make($type) {
    if(!array_key_exists($type,self::$builders)) {
      throw new \RuntimeException('Builder does not exist.');
    }

    return new self::$builders[$type]();
  }
}
