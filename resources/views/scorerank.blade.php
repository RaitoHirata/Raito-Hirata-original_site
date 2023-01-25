<div class = 'scorerank'>
    <p>人気曲ランキング</p>
        <table class='ranktable'>
            <tr>
                <th>順位</th>
                <th>アーティスト名</th>
                <th>曲名</th>
            </tr>
       
            @foreach($scorerank as $scorerank )
                <tr>
                    <th>{{ $loop->iteration }}</th>
                    <th>{{ $scorerank ->artist_name}}</th>
                    <th>{{ $scorerank ->song_name}}</th>
                </tr>
            @endforeach
    
        </table>
</div>