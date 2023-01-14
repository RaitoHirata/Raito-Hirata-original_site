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
                    @if(isset($login_error))
                        <div class ='error_massage'>
                            <p>{{ 'ログイン失敗' }}</p>
                            <p>{{ 'メールアドレスもしくはパスワードが違います。' }}</p>
                        </div>
                    @endif
                    <p class = "logintitle">ログイン</p>
                    <p>新規登録は「会員登録」より行ってください。</p>
                    <form method ='POST' action ="{{ route('login.home') }}">
                        @csrf
                        <div class='mailinput'>
                            <span>メールアドレス</span>
                            <input type="text" name="email" placeholder = "メールアドレスを入力してください。" value = "{{ Session::get('email') }}" ></div>
                        <div class='passinput'>
                            <span>パスワード</span>
                            <input  type="password" name="password" placeholder = "パスワードを入力してください。"  ><br><br></div>
                        <input class = "button" type="submit" value="ログイン">
                    </form>
                    <a class = "pw_reset_info" href="{{ route('user_pw') }}">パスワードを忘れた方はこちら</a>
                </div>
              
            </div>
        </div>
  
<!--
            @include('footer')
-->

    </body>
</html>
