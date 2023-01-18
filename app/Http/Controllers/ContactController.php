<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Validator; 
use Illuminate\Support\Facades\DB;
use App\Item;
use App\Models\user;
use App\Models\score;
use App\Models\user_score;
use DateTime;
use URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;

//楽譜ファイル
use Illuminate\Support\Facades\Storage;
//use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;


//メール送信用に入れた
use App\Http\Requests\User\ForgotRequest;


class ContactController extends Controller
{
    //一般会員楽譜検索処理
    public function search(Request $request)
    {
        session()->forget('user_id');
        $request->session()->flash('send',$request->send);
        $request->session()->flash('massage',$request->search);
        $search = $request->input('search');
        session()->flash('search',$request->search);
        $searchtitle = $request->input('send');
        if(isset($search)){
            $spaceConversion = mb_convert_kana($search, 's');
            $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);
            foreach($wordArraySearched as $value){
                $scores = score::select('id','artist_name as artist_name','song_name as song_name')
                        ->where('role',1)
                        ->where(function($query) use($value) {
                            $query->where('artist_name','like', '%'. $value .'%')
                                ->orwhere('song_name','like', '%'. $value .'%');
                        })                        
                        ->get();
            }
                return view('index', ['scores'=>$scores] , ['log_comment'=>'1']);
        } else {
            return view('index');
        } 
     // dd($scores);
    }

    //一般会員楽譜表示
    public function scorelink(Request $request)
    {
        session()->forget('user_id');
        $id = $request->id;
        $scorelink = score::select
            ('artist_name as artist_name' , 'song_name as song_name' ,'score as score','path as path')
            ->where('id','=',$id)->first();
        $readcount = score::where('id','=',$id)->value('access_count');
    //    dd($readcount);
        if (isset($readcount)){
            $addcount = $readcount + 1;
        } else {
            $addcount = 1;
        }
        score::where('id','=',$id)->update(['access_count'=>$addcount]);
        return view('free_user_score',compact('scorelink'),['scorelink'=>$scorelink]);
    }

    //ログイン画面楽譜検索処理
    public function loginSearch(Request $request)
    {
       if(session('user_id')== null){
        return redirect()->back();
       }
        $request->session()->flash('send',$request->send);
        $id = session('user_id');
      //  dd(session('mylist'));
        session()->flash('search',$request->search);
        $search = $request->input('search');
        $mylist = user_score::
                  join('user','user_id', '=', 'user.id')
                ->join('score','list', '=', 'score.id' )
                ->where('user_id',$id)
                ->get();
        //dd($id);
        $url = url()->previous();
        $referer = '/login';
        if(isset($search)){
            $spaceConversion = mb_convert_kana($search, 's');
            $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);
            foreach($wordArraySearched as $value){
                $scores = score::select('id','artist_name as artist_name','song_name as song_name')
                        ->where('role',1)
                        ->where(function($query) use($value) {
                            $query->where('artist_name','like', '%'. $value .'%')
                                ->orwhere('song_name','like', '%'. $value .'%');
                        })                        
                        ->get();
            }
                if (!strstr($url,$referer)){
                    return view('manager_home',['log_comment'=>'1'],['scores'=>$scores ,'mylist'=>$mylist ] );
                } else {
                    return view('user_home',['log_comment'=>'1'],['scores'=>$scores ,'mylist'=>$mylist ]);
                }
        } else {
            // dd($scores);
            if (!strstr($url,$referer)){
                return view('manager_home' ,['mylist'=>$mylist ]);
            } else {
                return view('user_home',['mylist'=>$mylist ]);
            } 
        }
    }

    //ログイン画面楽譜表示処理
    public function loginScorelink(Request $request)
    {
        if(session('user_id')== null){
            return view( 'index');
        }
        $role = session('role');
        $id = $request->id;
        $mylisted = user_score::select('list')->where('list',$id)->first();
        $scorelink = score::select
            ('id' , 'artist_name as artist_name' , 'song_name as song_name' ,'score as score','path as path')
            ->where('id','=',$id)->first();
        return view('score',compact('scorelink'),['scorelink'=>$scorelink , 'mylisted'=>$mylisted ],$id,$role);
    }

    //ログインフォーム画面open
    /*
    public function login(Request $request)
    {
        session()->forget('user_id');
        $url = url()->previous();
        $referer = '/login';
        if (!strstr($url,$referer)){
            $request->session()->forget('email');
        }
        return view('login');
    }
    */
     //ログイン完了処理
    public function loginComplete(Request $request)
    {
                
        $id = $request->id;
   //     $mylisted = user_score::select('list')->where('list',$id)->first();
   /*     $scorelink = score::select
            ('id' , 'artist_name as artist_name' , 'song_name as song_name' ,'score as score','path as path')
            ->where('id','=',$id)->first();
        $request->session()->put('email', $request->email);
        $password = $request->password;
        if ($request->email === 'Adminster' && $request->password === 'Adminster1111') {
            $mylist = user_score::
                        join('user','user_id', '=', 'user.id')
                        ->join('score','list', '=', 'score.id' )
                        ->where('user_id','=',2)
                        ->get();
            session()->put(['mylist' =>$mylist]);
            //    dd($mylist);
            session()->flush('email');
            session()->forget('password');
            session()->put('user_id',2);
            return view('manager_home',['mylist'=>$mylist]);
        } */

        $email = $request->email;
        $password = $request->password;
        if (Auth::attempt(['email'=>$email,'password'=>$password])){
            return view('user_home');
        }else {
            return view('/login',['login_error'=>'1']);
        }
        /*
        $user = user::where('email',$request->email)->get();
        if (count($user) === 0 || empty($password)){
            return view('/login',['login_error'=>'1']);
        } 
        session(['email' => $user[0]->email]);
        $user_id = $user[0]->id;
        $role = $user[0]->role;
        session(['user_id' => $user_id]);
        session(['role' => $role]);
    //    dd($user[0]->password,$user[0]->id);dd($user[0]->id);
        if(Hash::check($password,$user[0]->password )){
            $role = $user[0]->role;
            $mylist = user_score::
                        join('user','user_id', '=', 'user.id')
                        ->join('score','list', '=', 'score.id' )
                        ->where('user_id','=',$user_id)
                        ->get();
            session()->put(['mylist' =>$mylist]);
            if ($role == 1){
                session()->forget('email');
                return view('manager_home',['scorelink'=>$scorelink , 'mylist'=>$mylist]);
            } else {
                session()->forget('email');
                return view('user_home',['scorelink'=>$scorelink , 'mylist'=>$mylist]);
            }
        } else {
            return view('/login',['login_error'=>'1']);
        }*/

   

    }

    //ログイン後会員ホーム画面open
    public function userHome(Request $request)
    {
        
        return view('user_home');
    }
    
    //会員新規登録画面open
    public function register(Request $request)
    {
        $url = url()->previous();
        $referer = '/register';
        if (!strstr($url,$referer)){
            $request->session()->forget('email');
        }
        return view('register');
    }

    //管理者新規登録画面open
    public function mngregister(Request $request)
    {
        if(session('user_id')== null){
            return view( 'index');
        }
        $url = url()->previous();
        $referer = '/mng_register';
        if (!strstr($url,$referer)){
            $request->session()->forget('email');
        }
        return view('manager_register');
    }

    //新規登録処理
    public function checkregister(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'email' => 'required|email:strict,dns|max:255|unique:user,email',
            'password'  => ['required',Password::min(8)->letters()->numbers()],
        ],
        [   
            'email.required' => 'メールアドレスは必須入力です。',
            'email.email' => 'メールアドレスは正しく入力してください。',
            'password.required' => 'パスワードは必須入力です。',
            'password.min' => 'パスワードは半角英数字を1つずつ含む8文字以上としてください。',
        ]);
        $request->session()->put('email', $request->email);
        $request->session()->put('password', $request->password);
        $user = user::where('email',$request->email)->get();
        if ($validator->fails()) {
            return redirect()->back()
            ->withInput()
            ->withErrors($validator);
        } else {
            $url = url()->previous();
            $referer = '/mng_register';
            if (strstr($url,$referer)){
                $role = 1;
            } else {
                $role = 0;
            }
            $user = new user([
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
                'role'=> $role,
                'created_at'=> now()
            ]);
            $user->save();
            if ($role === 0){
                return view('register_complete');
            } else {
                return view('mngregister_complete');
            }
        }
    }

     //未使用
    public function managerLogin(Request $request)
    {
        return view('manager_login');
    }

     //管理者会員ログインページ処理
    public function mngloginComplete(Request $request)
    {
        $user = user::whereRole(1)->where('email',$request->email)->get();
        if (count($user) === 0){
            return view('manager_login',['login_error'=>'1']);
        }
        if($request->password === $user[0]->password){
            session(['email' => $user[0]->email]);
            return view('manager_home');
        } else {
            return view('manager_login',['login_error'=>'1']);
        }
        if(Hash::check($request->password,$user[0]->password)){
            session(['email' => $user[0]->email]);
            return view('manager_home');
        } else {
            return view('manager_login',['login_error'=>'1']);
        }
    }

    //管理者画面homeopen
    public function managerHome(Request $request)
    {
        return view('manager_home');
    }

    //ログアウト画面open
    public function logout(Request $request)
      {
        $request->session()->flush();
        return redirect()->route('index');
     
    }

    
    //パスワードリセット依頼画面open
    public function userPw(Request $request)
    {
        return view('user_pw_urlmail');
    }

    //パスワードリセット処理
    public function pwresetMail(Request $request)
    {
        $email = $request->email;
        $request->session()->put('email',$request->email);
        $user = user::where('email',$email)->get();
        if (count($user) === 0){
            return view( route('user_pw') ,['login_error'=>'1']);
        } 

        $to = "$email";
        $subject = "Slow-High パスワード再設定メール";
        $url  = URL::temporarySignedRoute('user_newpassword', now()->addSeconds(600));
        $message = "$email 様\r\n
                    いつもSlow-Highをご利用頂きありがとうございます。\r\n
                    以下のURLをクリックしてパスワードの再設定を行ってください。\r\n
                    $url
                    このURLは10分間のみ有効です。
                    ";
        $headers = "From: raitohirata77@gmail.com";
        //dd($to, $subject, $message, $headers);
        if(mb_send_mail($to, $subject, $message, $headers)){
            return view( 'user_pw_sendcomplete',['send_complete'=>'1']);
        } else {
            return view( 'user_pw_sendcomplete',['send_false'=>'1']);
        }
        
    }
    //パスワード送信画面
    public function newpassword(Request $request)
    {
        if (!$request->hasValidSignature()) {
            return view('no_link');
        }
        return view( 'newpassword');
    }
    //パスワード更新画面
    public function update_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email:strict,dns|max:255|',
            'password'  => ['required',Password::min(8)->letters()->numbers()],
        ],
        [   
            'password.required' => 'パスワードは必須入力です。',
            'password.min' => 'パスワードは半角英数字を1つずつ含む8文字以上としてください。',
        ]);
        $request->session()->flash('email', $request->email);
        $request->session()->flash('password', $request->password);
        if ($validator->fails()) {
            return redirect()->back()
            ->withInput()
            ->withErrors($validator);
        } else {
            $user = user::where('email',$request->email)->update(['password' => $request->password]);
                return view('register_complete');
        }
    }

    //楽譜編集/アップロード画面open
    public function scoreData()
    {
        $scoredata = score::select()->paginate(env("PAGE_MAX_LIMIT"));
        return view('scoredata',compact('scoredata'),['scoredata' => $scoredata]);
    }

    //楽譜新規登録画面open
    public function scoredataRegister(Request $request)
    {
        return view('scoredata_register');
    }

    //楽譜新規登録処理
    public function uplode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'artist_name' => 'required|max:255|',
            'song_name' => 'required|max:255|',
            'file'=> 'required'
        ],
        [   'artist_name.required' => 'アーティスト名は必須入力です。',
            'song_name.required' => '曲名は必須入力です。',
            'file.required' => 'ファイルは必須入力です。'
        ]);
        $request->session()->put('artist_name', $request->artist_name);
        $request->session()->put('song_name', $request->song_name);
        if ($validator->fails()) {
            return redirect()->back()
            ->withInput()
            ->withErrors($validator);
        } else {
            $score = new score();
            $dir = 'Slow-high';
            $filename = $request->file('file')->getClientOriginalName();
            $file = $request->file('file')->storeAs('',$filename);
            $score->artist_name = $request->input('artist_name');
            $score->song_name = $request->input('song_name');
            $score->score = $filename;
            $path =  "../storage/app/" . $file;
            $score->path = $path;
            $score->role = '0';
            $score->created_at = now();
            $score->save();
            return view('scoredata_register',['uplode_error' => "1"]);
        }
    }
    
    //楽譜詳細画面open
    public function scoreDetail(Request $request)
    {
        if(session('user_id')== null){
            return view( 'index');
        }
        $id = $request->id;
        $scoredata_detail = score::select
            ('artist_name as artist_name' , 'song_name as song_name' ,'score as score','path as path')
            ->where('id','=',$id)->first();
      //      dd($scoredata_detail->path);
        return view('scoredata_detail',compact('scoredata_detail'),['scoredata_detail'=>$scoredata_detail]);
    }

    //楽譜編集画面open
    public function scoreedit(Request $request)
    {
        if(session('user_id')== null){
            return view( 'index');
        }
        $id = $request->id;
        session()->put('id',$id);
        $scoredata_detail = score::select
            ('artist_name as artist_name' , 'song_name as song_name' ,'score as score','path as path')
            ->where('id','=',$id)->first();
        return view('scoredata_edit',compact('scoredata_detail'),['scoredata_detail'=>$scoredata_detail],($scoredata_detail->path));
    }

    //楽譜編集
    public function update(Request $request)
    {
        if(session('user_id')== null){
            return view( 'index');
        }
        $id = session()->get('id');
        $validator = Validator::make($request->all(), [
            'artist_name' => 'required|max:255|',
            'song_name' => 'required|max:255|',
        ],
        [   'artist_name.required' => 'アーティスト名は必須入力です。',
            'song_name.required' => '曲名は必須入力です。',
        ]);
        $request->session()->put('artist_name', $request->artist_name);
        $request->session()->put('song_name', $request->song_name);
        if ($validator->fails()) {
            return redirect()->back()
            ->withInput()
            ->withErrors($validator);
        } else {
            $score = new score();
            $dir = 'Slow-high';
       //     $filename = $request->file('file')->getClientOriginalName();
        //    $file = $request->file('file')->storeAs('public/Slow-high/',$filename,'');
       //     $path = 'storage/' . $dir . '/' . $filename;
            $score->where('id','=',$id)->update([
                'artist_name' => $request->artist_name,
                'song_name' => $request->song_name,
       //         'score' => $filename,
         //      'path' => $path,
                'role' => 0,
                'created_at' => now()
                ]);
            if (isset($request->updatebutton))
                {   session()->flash('updatemsg',1); }
            return redirect()->back();
        }
    }

    //楽譜データの削除
    public function delete(Request $request)
    {
        $id = $request->id;
        score::where('id','=',$id)->delete();
        return redirect(route('scoredata'));
    }

    //楽譜未公開設定
    
    public function norelease(Request $request)
    {
        $id = $request->id;
        $score = new score();
        $score -> where('id','=',$id)->update([
            'role' => 0,
        ]);
        return redirect(route('scoredata'));
    }

    //楽譜公開設定
    public function release(Request $request)
    {
        $id = $request->id;
        score::where('id','=',$id)->update([
            'role' => '1',
        ]);
        return redirect(route('scoredata'));
    }

    //マイリスト        
    public function ajaxlike(Request $request)
    {
        $id = session('user_id');
        $post_id = $request->input('post_id');
        $like = new user_score;
        $list = $like->get();
   //     $post = Post::findOrFail($post_id);
    //    dd($id);
        // 空でない（既にいいねしている）なら
        if (strstr($list,$id) && strstr($list,$post_id)) {
            //likesテーブルのレコードを削除
            $like = user_score::where('user_id', $id)->where('list', $post_id)->delete();
        } else {
            //空（まだ「いいね」していない）ならlikesテーブルに新しいレコードを作成する
            $like = new user_score;
            $like->user_id = $id;
            $like->list = $post_id;
            $like->updated_at = now();
            $like->save();
        }
        
    }

    //会員楽譜追記画面表示
    public function userScoreeditview(Request $request)
    {
        $role = session('role');
        $id = $request->id;
        $mylisted = user_score::select('list')->where('list',$id)->first();
        $scorelink = score::select
            ('id' , 'artist_name as artist_name' , 'song_name as song_name' ,'score as score','path as path')
            ->where('id','=',$id)->first();
        $content = file_get_contents( $scorelink->path );
        $rows = explode("\n", $content);
        session()->put('rows',$rows);
       
        return view('user_score_edit',compact('scorelink'),['scorelink'=>$scorelink , 'mylisted'=>$mylisted ,'rows'=>$rows],$id,$role);
    }

    public function userScoreedit(Request $request)
    {
       
   
         foreach (session('rows') as  $key => $value ) {
       
                foreach ($request->memo as $value){
                    $memo = [
                    'memo' => $request->memo
                ];
                };
            
         
            }
      
        dd($memo);
        $request->session()->put('memo.key',"memo".$request->memo.$key);
      
        $flag = 1;
        session()->put('flag',$flag);
        $role = session('role');
        $id = $request->id;
    //    dd(session(
      //  ));
      
        $scorelink = score::select
        ('id' , 'artist_name as artist_name' , 'song_name as song_name' ,'score as score','path as path')
        ->where('id','=',$id)->first();
        
        $content = file_get_contents( $scorelink->path );
        $rows = explode("\n", $content);
        $rows = $request->memo;
        dd($request->memo);
        file_put_contents( "test.txt", $rows,FILE_APPEND);
             
        
        /*
        $file_path = dirname(__FILE__) . "/../../../storage/app/test.txt";
        $data_serialize = serialize($rows);
        
   //ファイルに保存
         file_put_contents($file_path, $data_serialize, LOCK_EX);
 
//保存したファイルのパーミッションを644にする
        chmod($file_path, 0644);

        $data_serialize = file_get_contents($file_path);
 */
        
        /*
        file_put_contents( $scorelink->path, implode("\n", $rows));
     //   $rows = explode("\n", $content);
    /*   $fp = fopen($content, "a+");
        fwrite($fp,$request->memo2);
        
       // rewind($fp);
       /* while (!feof($fp)) {
        echo fgets($fp).'<br>';
        }
        fclose($fp);*/

        /*foreach ($rows as $row) {
            $fp=fopen($content,"a+");
            fwrite($fp,$request->memo2);
            fclose($fp);
        }*/
        

        $mylisted = user_score::select('list')->where('list',$id)->first();
       
           // dd(session('flag'));
        return redirect()->back();
    }

    /*
    //公開設定/*
    public function ajaxrelease(Request $request)
    {
        $post_id = $request->input('post_id');
        $list = score::where('id',$post_id)->select('role')->first();
   //     $post = Post::findOrFail($post_id);
    //    dd($id);
        // 公開済ではない場合
   //     dd($list);
        if (($list['role'] == 0 )) {
            score::where('id',$post_id)->update([
                'role' => '1'
            ]);
        } 
        
    }

    public function ajaxnorelease(Request $request)
    {
        $post_id = $request->input('post_id');
        $list = score::where('id',$post_id)->select('role')->first();
   //     $post = Post::findOrFail($post_id);
    //    dd($id);
        // 公開済の場合
    //    dd($list->role);
        if (($list['role'] == 1 )) {
            score::where('id',$post_id)->update([
                'role' => '0'
            ]);
        } 
       
    }
*/



    /*
    public function favolite(Post $post, Request $request)
    {
        $user_score=New user_score();
        $user_score->post_id=$post->id;
        $user_score->user_id=Auth::user()->id;
        $user_score->save();
        return back();
    }*/


    

    /*
    public function like(Request $request)
    {
        $user_id = Auth::user()->id; //1.ログインユーザーのid取得
        $review_id = $request->review_id; //2.投稿idの取得
        $already_liked = Like::where('user_id', $user_id)->where('review_id', $review_id)->first(); //3.

        if (!$already_liked) { //もしこのユーザーがこの投稿にまだいいねしてなかったら
            $like = new Like; //4.Likeクラスのインスタンスを作成
            $like->review_id = $review_id; //Likeインスタンスにreview_id,user_idをセット
            $like->user_id = $user_id;
            $like->save();
        } else { //もしこのユーザーがこの投稿に既にいいねしてたらdelete
            Like::where('review_id', $review_id)->where('user_id', $user_id)->delete();
        }
        //5.この投稿の最新の総いいね数を取得
        $review_likes_count = Review::withCount('likes')->findOrFail($review_id)->likes_count;
        $param = [
            'review_likes_count' => $review_likes_count,
        ];
        return response()->json($param); //6.JSONデータをjQueryに返す
    }*/










}


    /**
     * 登録処理
    
    public function store(Request $request)
    {
        $registerBook = $this->book->InsertBook($request);←追加
        return redirect()->back();
    } */

    /*
    public function index(Request $request)
    {
        $items = DB::table('contacts')->get();// 全てのデータが取得できる
        return view('contact.contact',['items' => $items,]);
    }

    public function back(){
        $items = DB::table('contacts')->get();// 全てのデータが取得できる
        $name = session('name');
        $furigana = session('furigana');
        $phonenumber = session('phonenumber');
        $mail = session('mail');
        $content = session('content');
        return view('contact.contact',['items' => $items,]);
    }

    public function confirm(Request $request)
    {
        $rules = [
            'name' => 'required|max:10',
            'furigana' => 'required|max:10',
            'phonenumber' => 'nullable|regex:/^[0-9]+$/i',
            'mail' => 'required|email:strict,dns|max:255|',
            'content' => 'required',
        ];

        $message = [
            'name' => '氏名は必須入力です。10文字以内でご入力ください。',
            'furigana' => 'フリガナは必須入力です。10文字以内でご入力ください。',
            'phonenumber' => '電話番号は0-9の数字を入力してください。',
            'mail' => 'メールアドレスは必須入力です。メールアドレスは正しくご入力ください。',
            'content' => 'お問い合わせ内容は必須入力です。',
        ];

        $request->session()->put('name', $request->name);
        $request->session()->put('furigana', $request->furigana);
        $request->session()->put('phonenumber', $request->phonenumber);
        $request->session()->put('mail', $request->mail);
        $request->session()->put('content', $request->content);
        
        $inputs = $request->all();//フォームから受け取ったすべてのinputの値を取得
        $validator = Validator::make($request->all(),$rules,$message);

        if ($validator->fails()) {
            return back()
            ->withErrors($validator)
            ->withInput();
        } else {
            return view('contact.confirm',[
                'inputs' => $inputs,]);
            //入力内容確認ページのviewに変数を渡して表示
        }
    }

    public function complete(Request $request)
    {
        \DB::table('contacts')->insert([
           'name' => session('name'),
           'kana' => session('furigana'),
           'tel' => session('phonenumber'),
           'email' => session('mail'),
           'body' => session('content'),
           'created_at' => new DateTime()
        ]);// 全てのデータが取得できる
        session()->flush();
        return view('contact.complete');
    }

    public function update(Request $request)
    {
        $url = url()->previous();
        $referer = '/contact/contact_update_form';
        if (!strstr($url,$referer)){
            $items = \DB::table('contacts')->where('id', $request->id)->first();
            session()->put('id', $items->id);
            session()->put('name_update', $items->name);
            session()->put('furigana_update', $items->kana);
            session()->put('phonenumber_update', $items->tel);
            session()->put('mail_update', $items->email);
            session()->put('content_update', $items->body);
        }
        return view('contact.contact_update_form');
    }

    public function updatedata(Request $request)
    {
        $items = \DB::table('contacts')->find($request->id);
        $rules = [
            'name' => 'required|max:10',
            'furigana' => 'required|max:10',
            'phonenumber' => 'nullable|regex:/^[0-9]+$/i',
            'mail' => 'required|email:strict,dns|max:255|',
            'content' => 'required',
        ];

        $message = [
            'name' => '氏名は必須入力です。10文字以内でご入力ください。',
            'furigana' => 'フリガナは必須入力です。10文字以内でご入力ください。',
            'phonenumber' => '電話番号は0-9の数字を入力してください。',
            'mail' => 'メールアドレスは必須入力です。メールアドレスは正しくご入力ください。',
            'content' => 'お問い合わせ内容は必須入力です。',
        ];

        $request->session()->put('name_update', $request->name);
        $request->session()->put('furigana_update', $request->furigana);
        $request->session()->put('phonenumber_update', $request->phonenumber);
        $request->session()->put('mail_update', $request->mail);
        $request->session()->put('content_update', $request->content);
        
        $inputs = $request->all();//フォームから受け取ったすべてのinputの値を取得
        $validator = Validator::make($request->all(),$rules,$message);

        if ($validator->fails()) {
            return back()
            ->withErrors($validator)
            ->withInput();
        } else {
            $id = session('id');
            \DB::table('contacts')
            ->WHERE("id" , '=' , "$id")
            ->bindValue(':id',session('id'))
            ->update([
                'name' => $request->name,
                'kana' => $request->furigana,
                'tel' => $request->phonenumber,
                'email' => $request->mail,
                'body' => $request->content,
                'created_at' => new DateTime()
            ]);

            session()->flush();
            return view('contact.complete');
            //入力内容確認ページのviewに変数を渡して表示
        }
        
    }

    public function delete(Request $request)
    {
        \DB::table('contacts')->where('id', $request->id)->delete();
        return redirect('contact');
    }*/




