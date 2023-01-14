<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <title>Slow-High</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/base.css') }}">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <link href="https://use.fontawesome.com/releases/v6.2.0/css/all.css" rel="stylesheet">
        <script src="{{ asset('/js/layout.js') }}"></script>
        
    </head>

    <body>
        <!--ヘッダ-->
        @include('login_header')
        <h1 class = 'mngtitle'>管理者ページ</h1>
        <h1 class = 'mngtitle'>楽譜詳細</h1>
        <!--メイン-->
        <div class="wrapper">
            <table class ="scoredetail">
                <tr>
                    <th class ="scoredetail_title"><span class='mark'>アーティスト名</span></th>
                    <th> {{ $scoredata_detail->artist_name }}</th>
                </tr>
                <tr>
                    <th class ="scoredetail_title"><span class='mark'>曲名</span></th>
                    <th>{{ $scoredata_detail->song_name }}</th>
                </tr>
                <tr>
                    <th class ="scoredetail_title"><span class='mark'>ファイル名</span></th>
                    <th>{{ $scoredata_detail->score }}</th>
                </tr>
            </table>
        </div>
        <pre> <div class = "scorefile">{{ Storage::get($scoredata_detail->score) }}</div> </pre>
        <a class = return href="{{ route('scoredata') }}">楽譜データ編集画面へ</a>
<!--
            @include('footer')
-->

    </body>
</html>
