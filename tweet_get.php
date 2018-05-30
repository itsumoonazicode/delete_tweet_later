<?php

// OAuthライブラリの読み込み
require "twitter/vendor/autoload.php";
require "common.php";  // アクセストークンなどを定義したファイルの読み込み
use Abraham\TwitterOAuth\TwitterOAuth;


if($_SERVER["REQUEST_METHOD"] === "POST") {

    // 接続
    $connect = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_SECRET);

    // ツイートのプログラム
    $tweet = $_POST['post_tweet'];
    $connect->post("statuses/update", array("status" => $tweet));
    // エラーハンドリング
    if($connect->getLastHttpCode() == 200) {
        echo 'Tweeted!';
    } else {
        echo 'Cannot tweet!!';
        exit;
    }

    // タイムラインの取得
    // $home = $connect->get('statuses/user_timeline', array('count' => 1));
    // if($home) {
    //     $tweet_id = $home[0]->id;
    // }
    // var_dump($home[0]->text);

    sleep(20);
    // ツイートの検索
    $search = $connect->get("search/tweets", array("q" => "#deでりーとtest"));
    if($connect->getLastHttpCode() == 200) {
        echo 'Search!';
    } else {
        echo 'Cannot search!!';
        exit;
    }
    sleep(10);
    $search_id = $search->statuses[0]->id;

    // var_dump($search_id);
    // echo '<pre>';
    // var_dump($search->statuses[0]->id);
    // echo '</pre>';

    if(isset($search_id)) {
        sleep(10); // 5分後にツイートを消す
        $connect->post('statuses/destroy', array('id' => $search_id));
        // 直前のリクエストが通ったかどうかのハンドリング
        if($connect->getLastHttpCode() == 200) {
            echo 'Deleted';
        } else {
            echo 'Cannot delete!!';
            exit;
        }

    }

}

?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>シャボン玉テスト</title>
</head>
<body>
    <h1>シャボン玉ツイート</h1>
    <form action="" method="post">
        <textarea name="post_tweet" id="" cols="30" rows="10" maxlength="140"></textarea>
        <input type="submit" value="TWEET NOW">
    </form>
</body>
</html>