<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class score extends Model
{
  use HasFactory;
  protected $table = 'score';

  protected $guarded = array('id');

  public $timestamps = false;

  protected $fillable = [
    'artist_name', 'song_name','score','path','role','created_at','access_count',
  ];/*
  public function role()
  {
      return $this::select('role')->get();
  }*/

  public function user() {
    return $this->belongTo('App\Models\user');
  }

  public function user_score() {
      return $this->hasMany(user_score::class,'foreign_key');
  }
/*
  public function checkData()
  {
    $data = DB::table($this->table)->WHERE("email" , '=' , "$email");
    return $data;
  }

  public function register_Data()
  {
    $data = DB::table($this->table)->WHERE("email" , '=' , "$email");
    return $data;
  }*/

}
/*

class contact extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'kana', 'tel' ,'email' , 'body'];

    public function readItems()
    {
        return $this::get();// 全てのデータが取得できる
    }
}
*/
