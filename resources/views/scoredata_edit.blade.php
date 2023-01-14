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
        <h1 class = 'mngtitle'>楽譜データ編集</h1>
        <!--メイン-->
        <div class="wrapper">
            <table class ="scoredetail">
                <form method="post" action="{{ route('update') }}" enctype="multipart/form-data">
                    @csrf
                    <table>
                        <tr>
                            <th class ="scoredetail_title">アーティスト名</th>
                            <th><input type="text" name="artist_name" placeholder="アーティスト名を入力してください" value="{{ $scoredata_detail->artist_name }}"> </th>
                        </tr>
                        <tr>
                            <th class ="scoredetail_title">曲名</th>
                            <th><input type="text" name="song_name" placeholder="曲名を入力してください" value="{{ $scoredata_detail->song_name }}"> </th>
                        </tr>
                        <tr>
                            <th class ="scoredetail_title">ファイル</th>
                            <th><input type="file" name="file" class="form-control"  value="{{ Session::get('file') }}"></th>
                            
                        </tr>
                    </table>
                    <input type="submit" name="updatebutton" value="更新" >
                </form>
                @if(!null == (session('updatemsg')))
                 <p>{{ '更新しました。'}}</p>
                @endif
        </div>
        
        <pre> <div class = "scorefile">{{ readfile($scoredata_detail->path) }}</div> </pre>
        <a class = return href="{{ route('scoredata') }}">楽譜データ編集画面へ</a>
<!--
            @include('footer')
-->

    </body>
</html>
