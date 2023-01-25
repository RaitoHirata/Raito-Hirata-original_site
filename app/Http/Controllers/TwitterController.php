<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\tweet\callTwitterApi;
use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterController extends Controller
{
    public function tweet(Request $request)
    {
        $twitter = new TwitterOAuth(env('TWITTER_CLIENT_ID'),
        env('TWITTER_CLIENT_SECRET'),
        env('TWITTER_CLIENT_ID_ACCESS_TOKEN'),
        env('TWITTER_CLIENT_ID_ACCESS_TOKEN_SECRET'));
        $twitter->post(
            "statuses/update", [
                "status" =>
                    'New Photo Post!' . PHP_EOL .
                    '新しい聖地の写真が投稿されました!' . PHP_EOL .
                    'タイトル「' .'test'. '」' . PHP_EOL .
                    '#photo #anime #photography #アニメ #聖地 #写真 #HolyPlacePhoto' . PHP_EOL .
                    'https://www.holy-place-photo.com/photos/' . PHP_EOL 
            ]);
        return view('tweet', ['tweet' => $twitter]);

    }
    /* //ツイッター文字検索読み出し
    public function tweet(Request $request)
    {
        $t = new tweet();
        $d = $t->serachTweets("あ");
        return view('tweet', ['tweet' => $d]);
    }*/
    
}
/*
$connection = new TwitterOAuth($consumerKey, $consumerSecret, $accessToken ,$accessTokenSecret);
$connection->setApiVersion('2');
$response = $connection->get('tweets', ['ids' => '1616832551502647296']);
$result = $connection->post("statuses/update", array("status" => "hello world"));
var_dump($result);*/