<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <title>Slow-High</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content=Type" content="text/html; charset=UTF-8"/>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/base.css') }}">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <link href="https://use.fontawesome.com/releases/v6.2.0/css/all.css" rel="stylesheet">
        <script src="{{ asset('/js/layout.js') }}"></script>
        
        
    </head>

    <body>
        <!--ヘッダ-->
        @include('login_header')
        <!--メイン-->
        <div class="wrapper">
            <div class = "mylist_mark">
            
            </div>
         
            <table class ="score">
                <tr>
                    <th class ="score_title"><span class='mark'>アーティスト名</span></th>
                    <th class ="linkword"> {{ $scorelink->artist_name }}</th>
                </tr>
                <tr>
                    <th class ="score_title"><span class='mark'>曲名</span></th>
                    <th class ="linkword">{{ $scorelink->song_name }}</th>
                </tr>
            </table>
        </div>
        <div class ="score_body">
        <pre> 
            <a class = "scorefile">
            </a>    
        </pre>
            <a class = "edit_scorefile">
                <form class ='edit_scorebody'method ='POST' action ="{{ route('user_score_edit')}}?id={{ $scorelink->id }}">
                @csrf

                    @foreach ($rows as $row)
                        <input type="text" name="memo" value=""><br>
                        {{ $row }}
                    @endforeach
                 
                    <input  type="submit" name="flag">
                </form>
            </a> 
            </div>
        </div>
        <?php $role = session('role'); ?> 
        <a class = 'return_login_search' href="{{ route('login.home') }}">HOME画面へ</a>
<!--
            @include('footer')
        -->
    </body>
</html>
