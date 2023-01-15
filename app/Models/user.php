<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class user extends Authenticatable
{
  use Notifiable;

  protected $table = 'user';

  protected $guarded = array('id');

  public $timestamps = false;

  protected $fillable = [
    'name','email', 'password','role','created_at',
  ];

  public function sendPasswordResetNotification($token)
  {
      $this->notify(new ResetPasswordNotification($token));
  }

  // Relationship

  public function user_score() {
    return $this->hasMany(user_score::class);
                //->where('model',self::class);
  }

  public function score() {
    return $this->hasMany(score::class);
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
