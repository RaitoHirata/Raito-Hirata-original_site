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
        @include('header')
        <!--メイン-->
        <div class="wrapper">
            <p>キーワードで探す</p>
            <form method ='POST' action =''>
                @csrf
                <input class = "serch" type="text" name="serch" placeholder = "キーワードを入力してください。(曲名・アーテイスト名)"
                        value="{{ session(search) }}" >
                <input class = "button" type="submit" value="検索">
            </form>
        </div>
  
<!--
            @include('footer')
-->

    </body>
</html>
