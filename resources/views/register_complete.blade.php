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
        <div class="login color">
            <div class="background_color">
                <div class="login_wrapper">
                    <p class = "logintitle">登録完了</p>
                    <p>登録が完了しました。</p>
                        <p>メールアドレス   {{ Session::get('email') }}</p>
                        <p>パスワード   {{ "********" }}</p><br>
                        <a href="{{ route('user_home') }}">HOME画面へ</a>
                </div>
            </div>
        </div>
        @Session::forget('email');
<!--
            @include('footer')
-->

    </body>
</html>
