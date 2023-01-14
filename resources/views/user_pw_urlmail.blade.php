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
                <p>{{ '登録したメールアドレスが違います。' }}</p>
        @endif
        <div class="login color">
            <div class="background_color">
                <div class="login_wrapper">
                    <p class = "logintitle">パスワード再登録</p>
                    <p>以下に登録したメールアドレスを入力して、送信されたメールのURLよりパスワードの再設定を行ってください。</p>
                    <form method ='POST' action ="{{ route('user_pw_urlmail') }}">
                        @csrf
                        <div class='mailinput'>
                            <p>メールアドレス　<input class = "email" type="text" name="email" placeholder = "メールアドレスを入力してください。" ></p>
                        <br>
                        </div>
                        <input class = "button" type="submit" value="送信">
                    </form>
                </div>
            </div>
        </div>
  
<!--
            @include('footer')
-->

    </body>
</html>
