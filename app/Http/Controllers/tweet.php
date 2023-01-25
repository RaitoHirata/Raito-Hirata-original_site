<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Abraham\TwitterOAuth\TwitterOAuth;
/*
class tweet
{
    private const TWITTER_API_KEY="NLxNwcYvuGhhkbkNuxrtPLCBg";
    private const TWITTER_API_SECRET_KEY="XIBrJamwJALV4I1UkGEL6gKDqO9iQcaNfrKEwoS0UZ6K6QAPPN";
    private const TWITTER_CLIENT_ID_ACCESS_TOKEN="1616832551502647296-2Kg9qBbVfkSho710P0kmyPrJMpfu1G";
    private const TWITTER_CLIENT_ID_ACCESS_TOKEN_SECRET="kMkOrCRY5a0sN1HjuX59rVItmcM11uDC2NXWN0EWnjCrl";
    private $t;
    
    public function __construct()
    {
        $this->t = new TwitterOAuth(
            self::TWITTER_API_KEY,
            self::TWITTER_API_SECRET_KEY,
            self::TWITTER_CLIENT_ID_ACCESS_TOKEN,
            self::TWITTER_CLIENT_ID_ACCESS_TOKEN_SECRET
        );
    }
    
    // ツイート検索
    public function serachTweets(String $searchWord)
    {
        $d = $this->t->get("search/tweets", [
            'q' => $searchWord,
            'count' => 3,
         ]);
         dd($searchWord);
        return $d->statuses;
    }
}*/
/*
$connection = new TwitterOAuth($consumerKey, $consumerSecret, $accessToken ,$accessTokenSecret);
$connection->setApiVersion('2');
$response = $connection->get('tweets', ['ids' => '1616832551502647296']);
$result = $connection->post("statuses/update", array("status" => "hello world"));
var_dump($result);*/