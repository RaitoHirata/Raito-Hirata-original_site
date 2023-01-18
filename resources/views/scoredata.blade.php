<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <title>Slow-High</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/base.css') }}">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <link href="https://use.fontawesome.com/releases/v6.2.0/css/all.css" rel="stylesheet">
        <script src="{{ asset('/js/layout.js') }}"></script>
        
    </head>

    <body>
        <!--ヘッダ-->
        @include('login_header')
        <h1 class = 'mngtitle'>管理者ページ</h1>
        <h1 class = 'mngtitle'>楽譜データ一覧</h1>
        <!--メイン-->
        <div class="scoredata_wrapper">
            <table class = "scoretable">
                <tr>
                    <th class = "tabletitle tabletitle_id">id</th>
                    <th class = "tabletitle">アーティスト名</th>
                    <th class = "tabletitle">曲名</th>
                    <th class = "tabletitle">楽譜名</th>
                    <th class = "tabletitle tabletitle_button">詳細</th>
                    <th class = "tabletitle tabletitle_button">編集</th>
                    <th class = "tabletitle tabletitle_button">削除</th>
                    <th class = "tabletitle tabletitle_button">公開</th>
                    <th class = "tabletitle tabletitle_release">公開設定</th>
                </tr>
                
                @foreach($scoredata as $records)
                <tr>
                    <th>{{ $records->id }}</th>
                    <th>{{ $records->artist_name }}</th>
                    <th>{{ $records->song_name }}</th>
                    <th>{{ $records->score }}</th>
                    <th class = "tablebutton"><a href="{{ route('scoreDetail') }}?id={{ $records->id }}">詳細</a></th>
                    <th class = "tablebutton"><a href="{{ route('scoreedit') }}?id={{ $records->id }}">編集</a></th>
                    <th class = "tablebutton"><a href="{{ route('scoredelete') }}?id={{ $records->id }}" onclick='return confirm("削除しますか?")'>削除</a></th>
                    <th>
                    @if($records->role == 0)
                        <li class=no_release>未公開
                    @else
                        <li class=release>公開中
                    @endif
                    </th>
                    <th>
                    @if($records->role == 0)
                        <a class ="set_release" href="{{ route('release') }}?id={{ $records->id }}" onclick='return confirm("公開しますか?")'>
                           公開にする
                        </a>
                    @else
                        <a class ="set_no_release" href="{{ route('norelease') }}?id={{ $records->id }}" onclick='return confirm("非公開にしますか?")'>
                           非公開にする
                        </a>
                    @endif
                    </th>
                </tr>
                @endforeach
            </table>
        </div>
        <div class = "pagelinks">
            {{ $scoredata->links('vendor.pagination.default') }}
        </div>
            <a class = newscoretext href="{{ route('scoredata_register') }}">新規登録へ</a>
        <a class = return href="{{ route('home') }}">管理者画面トップへ</a>
        
<!--
            @include('footer')
-->

    </body>
</html>
