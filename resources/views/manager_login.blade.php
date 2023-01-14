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
        @if(isset($login_error))
                <p>{{ 'ログイン失敗' }}</p>
                <p>{{ 'メールアドレスもしくはパスワードが違います。' }}</p>
        @endif
        <div class="login color">
            <div class="background_color">
                <div class="login_wrapper">
                    <p class = "logintitle">管理者専用ログイン</p>
                    <p></p>
                    <form method ='POST' action ="{{ route('mnglogin_home') }}">
                        @csrf
                        <p>メールアドレス　<input class = "email" type="text" name="email" placeholder = "メールアドレスを入力してください。" ></p>
                        <p>パスワード　<input class = "password" type="password" name="password" placeholder = "パスワードを入力してください。" ></p><br>
                        <input class = "button" type="submit" value="ログイン">
                    </form>
                </div>
            </div>
        </div>
  
<!--
            @include('footer')
-->

    </body>
</html>
