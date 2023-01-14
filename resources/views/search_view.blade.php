<p>キーワードで探す</p>
    <form method ='POST' action ="{{ route('search') }}">
        @csrf
        <input class = "search" type="text" name="search" placeholder = "キーワードを入力してください。(曲名・アーテイスト名)" 
                value="{{ session('search') }}">
        <input class = "search_button" type="submit" name="send" value="検索">
    </form>
<div class = 'search_result'> 
               
    @if(!null == session('send'))
        <p><span> {{ '検索結果' }}</span> </p>
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
                    <a href="{{ route('scorelink') }}?id={{ $scores->id }}">{{ $scores['song_name'] }}</a>
                </th>
            </tr>
        @endforeach
        
    @endif
        </table>
</div>
