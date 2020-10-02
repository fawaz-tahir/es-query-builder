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


$query = ["AD1456", "fawaz"];
$search = new Search;

if(is_array($query)) {
  $boolQuery = new BoolQuery;
  $fields = ['title', 'description', 'tags', 'group_name', 'group_description', 'group_tags', 'username', 'fullname', 'first_name', 'last_name'];

  foreach($fields as $field) {
    $mustBool = new BoolQuery;
    foreach($query as $keyword) {
      $matchQuery = new MatchQuery($field, $keyword);
      $mustBool->addQuery($matchQuery);
    }

    $boolQuery->addQuery($mustBool, BoolQuery::SHOULD);
  }

  $categoryName = new MatchQuery('category.name', $keyword);
  $boolQuery->addQuery($categoryName, BoolQuery::SHOULD);

  $search->addQuery($boolQuery);
} else {
  $title = new MatchQuery('title', $query);
  $description = new MatchQuery('description', $query);
  $categoryName = new MatchQuery('category.name', $query);
  $tags = new MatchQuery('tags', $query);
  $username = new MatchQuery('username', $query);
  $fullname = new MatchQuery('fullname', $query);
  $first_name = new MatchQuery('first_name', $query);
  $last_name = new MatchQuery('last_name', $query);
  
  $group_name = new MatchQuery('group_name', $query);
  $group_description = new MatchQuery('group_description', $query);
  
  $boolQuery = new  BoolQuery;
  $boolQuery->addQuery($title, BoolQuery::SHOULD);
  $boolQuery->addQuery($description, BoolQuery::SHOULD);
  $boolQuery->addQuery($categoryName, BoolQuery::SHOULD);
  $boolQuery->addQuery($tags, BoolQuery::SHOULD);
  $boolQuery->addQuery($username, BoolQuery::SHOULD);
  $boolQuery->addQuery($fullname, BoolQuery::SHOULD);
  $boolQuery->addQuery($first_name, BoolQuery::SHOULD);
  $boolQuery->addQuery($last_name, BoolQuery::SHOULD);
  $boolQuery->addQuery($group_name, BoolQuery::SHOULD);
  $boolQuery->addQuery($group_description, BoolQuery::SHOULD);
  $boolQuery->addQuery($group_tags, BoolQuery::SHOULD);
  
  $search->addQuery($boolQuery, BoolQuery::MUST);
}

$userid = new MatchQuery('userid', 14);
$search->addQuery($userid, BoolQuery::MUST);

// $query = "fawaz | tahir | sharif";
// $search = new Search();
// $queryCount = count(explode(' ', $query));

// // duration
// $duration = new RangeQuery('duration');
// $duration->setParameter( RangeQuery::GTE, 5 * 60 );
// $duration->setParameter( RangeQuery::LTE, 20 * 60 );

// $title = new MatchQuery( 'title', $query );
// $shouldTitle = clone $title;

// $shouldTitle->setParameter( 'type', 'phrase' );
// $shouldTitle->setParameter( 'boost', 4 );

// if($queryCount > 0) {
//     $minCal = 100 / $queryCount;

//     if($queryCount == 2)
//         $cal__ = 100;
//     else
//         $cal__ = floor((($queryCount-1)*$minCal));

//     $title->setParameter( 'minimum_should_match', "$cal__%" );
// }

// if(strstr($query, "|")) {
//     $value_arr = explode('|',$query);
//     if(!empty($value_arr)) {
//         $value_arr = array_map('trim',$value_arr);

//         foreach($value_arr as $value) {
//             $search->addQuery( new MatchQuery('title', $value), BoolQuery::SHOULD );
//         }
//     }
// }

// $userQuery = new TermQuery( 'userid', 63, [ 'boost' => 8 ] );
// $title->setParameter( 'boost', 6 );

// $contentLevel = new RangeQuery( 'user_filter_level', [ RangeQuery::GTE => 1 ] );

// $category = new TermQuery('category_id', 17);

// $broadcast = new TermQuery( 'broadcast', 3 );
// $status = new TermsQuery('status', [ 2, 4 ]);
// $active = new TermQuery( 'active', 'yes' );

// $isHD = new TermQuery( 'has_hd', 1, ['boost' => 3] );
// $tags = new MatchQuery( 'tags', $query, ['boost' => 5] );

// $search->addQuery($duration);
// $search->addQuery($title);
// $search->addQuery($category);

// $search->addQuery($broadcast, BoolQuery::FILTER);
// $search->addQuery($status, BoolQuery::FILTER);
// $search->addQuery($isHD, BoolQuery::SHOULD);
// $search->addQuery($tags, BoolQuery::SHOULD);
// $search->addQuery($active, BoolQuery::FILTER);
// $search->addQuery($contentLevel);

// $search->addQuery($shouldTitle, BoolQuery::SHOULD);
// $search->addQuery($userQuery);

// $boolQuery = new BoolQuery();
// $boolQuery->addQuery($userQuery, BoolQuery::SHOULD);
// $search->addQuery($boolQuery);

// $search->addSort(new Sort('version'));
$search->addSort(new Sort('_score'));
// $search->addSort(new Sort('views'));
// $search->addSort(new Sort('time_added'));
// $search->addSort(new Sort('has_hd'));

$search->setIndex('videos')->setType('videos')->setSize(20)->setFrom(0);

pr( ( ($search->getQuery()) ) );