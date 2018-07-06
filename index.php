<?php

function pr( $var ) {
  echo '<pre>';
  print_r( $var );
  echo '</pre>';
}

include __DIR__.'/FTahir/ESQuery/Autoload.php';

FTahir\ESQuery\Autoload::register();

use FTahir\ESQuery\Query\Compound\BoolQuery;

$matchQuery = new FTahir\ESQuery\Query\FullText\MatchQuery( 'title', 'barilla g.e.r. frate' );
$matchQuery->setParameter( 'operator', 'and' );
$termQuery = new FTahir\ESQuery\Query\TermLevel\TermQuery( 'status', 'successful' );
$termQuery2 = new FTahir\ESQuery\Query\TermLevel\TermQuery( 'active', 'yes' );

$queryStringQuery = new FTahir\ESQuery\Query\FullText\QueryStringQuery( '*marimo*', [ 'fields' => [ 'title', 'description', 'tags' ] ] );

use FTahir\ESQuery\Sort\Sort as FieldSort;

$sortings = [
  'version' => new FieldSort( 'version', FieldSort::DESC ),
  '_score' => new FieldSort( '_score', FieldSort::DESC ),
  'views' => new FieldSort( 'views', FieldSort::DESC ),
  'time_added' => new FieldSort( 'time_added', FieldSort::DESC ),
  'has_hd' => new FieldSort( 'has_hd', FieldSort::ASC ),
];

$search = new FTahir\ESQuery\Search();

$search->setFrom( 0 );
$search->setSize( 30 );
$search->setVersion( true );

$search->addQuery( $queryStringQuery );
$search->addQuery( $matchQuery, BoolQuery::SHOULD );
$search->addQuery( $termQuery, BoolQuery::FILTER );
$search->addQuery( $termQuery2, BoolQuery::FILTER );

foreach( $sortings as $sort ) {
  $search->addSort( $sort );
}

pr( $search->getBuild() );
