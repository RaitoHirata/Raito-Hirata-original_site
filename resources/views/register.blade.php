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
                    @if($errors->has('email') or $errors->has('password')) 
                    <div class='error_massage'>
                        @if($errors->has('email'))
                            @foreach($errors->get('email') as $error)
                                {{ $error }}<br>
                            @endforeach
                        @endif
                        @if($errors->has('password'))
                            {{($errors->first('password'))}}
                        @endif
                    </div>
                    @endif
                    <p class = "logintitle">新規登録</p>
                    <p>メールアドレス、パスワードを入力し、新規登録を行ってください。</p>
                    <form method ='POST' action ="{{ route('checkregister') }}">
                        @csrf
                        <div class='mailinput'><p>メールアドレス　<input class = "email" type="text" name="email" placeholder = "メールアドレスを入力してください。" value = "{{ Session::get('email') }}"></p></div>
                        <div class='passinput'><p>パスワード　<input class = "password" type="password" name="password" placeholder = "パスワードを入力してください。" ></p><br></div>
                        <input class = "button" type="submit" value="新規登録">
                    </form>
                </div>
            </div>
        </div>
  
<!--
            @include('footer')
-->

    </body>
</html>
