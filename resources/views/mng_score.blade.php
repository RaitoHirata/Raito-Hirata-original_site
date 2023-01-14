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
                <p>マイリスト登録</p>
                @if(isset($mylisted['list']))
                <p class="favorite-marke">
                <a class="js-like-toggle loved" href="" data-postid="{{ $scorelink->id }} ">
                        <i class="fa-solid fa-star fa-stack before"></i>
                </a>
                </p>           
                @else
                <p class="favorite-marke">
                <a class="js-like-toggle" href="" data-postid="{{ $scorelink->id }}">
                    <i class="fa-solid fa-star before"></i>
                </a>
                </p>
                @endif
            
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
            <div class ='speed'>
                <li >スクロール速度調整 </li>
                     <span class = 'speedadj' >遅い << 
                <input type="radio" name="speed" value="100000" id="speed1" >
                <input type="radio" name="speed" value="80000" id="speed2">
                <input type="radio" name="speed" value="70000" id="speed3" checked>
                <input type="radio" name="speed" value="60000" id="speed4">
                <input type="radio" name="speed" value="50000" id="speed5">
                    >> 速い </span>
            </div>
        </div>
        <div class ="score_body">
            <pre> 
                <a class = "scorefile">
                    <?php 
                    echo Storage::get($scorelink->score) ;
                    ?>
                
                </a>
            </pre>
            <div class = 'start scrollbtn' >スクロール開始</div>
            <div class = 'stop scrollbtn' >スクロール停止</div>
            <div class='scorefile_stop'>
                <button class='stopfile_viewbtn view_btn'><span class = 'vertical'>固定楽譜表示</span></button>
                <button class='stopfile_viewbtn hidden_btn' ><span class = 'vertical'>非表示</span></button>
            <pre>
                <a class = "stopfile">
                  
                   {{ Storage::get($scorelink->score,FILE_IGNORE_NEW_LINES) }}
                </a>
            </pre> 
            </div>
        </div>
        <?php $role = session('role'); ?> 
       
            <a class = 'return_login_search' href="{{ route('manager_home') }}">HOME画面へ</a>
      
        
    </body>
</html>
