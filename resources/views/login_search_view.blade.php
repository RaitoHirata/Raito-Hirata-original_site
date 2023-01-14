<p>キーワードで探す</p>
    <form method ='POST' action ="{{ route('login_search') }}">
        @csrf

        <input class = "search" type="text" name="search" placeholder = "キーワードを入力してください。(曲名・アーテイスト名)" 
            value="{{ session('search') }} ">
        <input class = "search_button" type="submit" name="send" value="検索">
    </form>
<div class = 'search_result'> 
    
    @if(!null == session('send'))
        <p><span> {{ '検索結果' }} </span></p>
        <table>
            <tr>
                <th class ="search_result_artist_title">アーティスト名</th>
                <th class ="search_result_song_title">曲名</th>
                <th class ="search_result_mylist_title_hidden"></th>
            </tr>
    @endif
    @if(isset($log_comment))
        @foreach($scores as $scores)
            <tr>
                <th class ="search_result_artist">{{ $scores['artist_name'] }}</th>
                <th class ="search_result_song">
                    <a href="{{ route('login_scorelink') }}?id={{ $scores->id }}">{{ $scores['song_name'] }}</a>
                </th>
                <th class ="search_result_mylist_title_hidden"> </th>
            </tr>
        @endforeach
       
    @endif
        </table>
  
</div>
<div class='search_result'>
    <p><span> 【マイリスト】</span> </p>
    <table>
        @if(isset($mylist))
            <tr>
                <th class ="search_result_artist_title">アーティスト名</th>
                <th class ="search_result_song_title">曲名</th>
                <th class ="search_result_song_title">オリジナルscore</th>
                <!--    <th class ="search_result_mylist_title">マイリスト登録</th>-->
            </tr>
      
            @foreach($mylist as $mylist)
            <tr>
                    <th class ="search_result_artist">{{ $mylist['artist_name'] }}</th>
                    <th class ="search_result_song">
                        <a href="{{ route('login_scorelink') }}?id={{ $mylist['id'] }}">{{ $mylist['song_name'] }}</a>
                    </th>
                <!--    <th class ="mylist_table">
                        @if(isset($mylist['list']))
                            <p class="favorite-marke">
                            <a class="js-like-toggle loved" href="" data-postid="{{ $mylist['list'] }} ">
                                    <i class="fa-solid fa-star fa-stack before"></i>
                            </a>
                            </p>           
                        @else
                            <p class="favorite-marke">
                            <a class="js-like-toggle" href="" data-postid="{{ $mylist['list'] }}">
                                <i class="fa-solid fa-star before"></i>
                            </a>
                            </p>
                        @endif
                    </th>-->
                    <th class ="search_result_song">
                        <a href="{{ route('user_score_edit_view') }}?id={{ $mylist['id'] }}">{{ $mylist['song_name'] }}</a>
                    </th>
                
            </tr>
            @endforeach
        @endif
        
    </table>
</div>