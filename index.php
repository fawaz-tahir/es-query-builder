<?php

function pr( $var ) {
  echo '<pre>';
  print_r( $var );
  echo '</pre>';


}

include __DIR__.'/FTahir/ESQuery/Autoload.php';

FTahir\ESQuery\Autoload::register();

use FTahir\ESQuery\Search as Search;
use FTahir\ESQuery\Query\Compound\BoolQuery;
use FTahir\ESQuery\Query\TermLevel\RangeQuery as RangeQuery;
use FTahir\ESQuery\Sort\Sort as Sort;
use FTahir\ESQuery\Query\FullText\MatchQuery as MatchQuery;
use FTahir\ESQuery\Query\TermLevel\TermQuery as TermQuery;
use FTahir\ESQuery\Query\TermLevel\TermsQuery as TermsQuery;

$query = "fawaz | tahir | sharif";
$search = new Search();
$queryCount = count(explode(' ', $query));

// duration
$duration = new RangeQuery('duration');
$duration->setParameter( RangeQuery::GTE, 5 * 60 );
$duration->setParameter( RangeQuery::LTE, 20 * 60 );

$title = new MatchQuery( 'title', $query );
$shouldTitle = clone $title;

$shouldTitle->setParameter( 'type', 'phrase' );
$shouldTitle->setParameter( 'boost', 4 );

if($queryCount > 0) {
    $minCal = 100 / $queryCount;

    if($queryCount == 2)
        $cal__ = 100;
    else
        $cal__ = floor((($queryCount-1)*$minCal));

    $title->setParameter( 'minimum_should_match', "$cal__%" );
}

if(strstr($query, "|")) {
    $value_arr = explode('|',$query);
    if(!empty($value_arr)) {
        $value_arr = array_map('trim',$value_arr);

        foreach($value_arr as $value) {
            $search->addQuery( new MatchQuery('title', $value), BoolQuery::SHOULD );
        }
    }
}

$userQuery = new TermQuery( 'userid', 63, [ 'boost' => 8 ] );
$title->setParameter( 'boost', 6 );

$contentLevel = new RangeQuery( 'user_filter_level', [ RangeQuery::GTE => 1 ] );

$category = new TermQuery('category_id', 17);

$broadcast = new TermQuery( 'broadcast', 3 );
$status = new TermsQuery('status', [ 2, 4 ]);
$active = new TermQuery( 'active', 'yes' );

$isHD = new TermQuery( 'has_hd', 1, ['boost' => 3] );
$tags = new MatchQuery( 'tags', $query, ['boost' => 5] );

$search->addQuery($duration);
$search->addQuery($title);
$search->addQuery($category);

$search->addQuery($broadcast, BoolQuery::FILTER);
$search->addQuery($status, BoolQuery::FILTER);
$search->addQuery($isHD, BoolQuery::SHOULD);
$search->addQuery($tags, BoolQuery::SHOULD);
$search->addQuery($active, BoolQuery::FILTER);
$search->addQuery($contentLevel);

$search->addQuery($shouldTitle, BoolQuery::SHOULD);


$search->addQuery($userQuery);

$search->addSort(new Sort('version'));
$search->addSort(new Sort('_score'));
$search->addSort(new Sort('views'));
$search->addSort(new Sort('time_added'));
$search->addSort(new Sort('has_hd'));

$search
    ->setIndex('videos')
    ->setType('videos')
    ->setVersion(true)
    ->setSize(30)
    ->setFrom(130);

pr( ( ($search->getBuild()) ) );