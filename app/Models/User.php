<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    //模型初始化时加载
    public static function boot()
    {
        parent::boot();
        //监听数据库的创建前事件
        static::creating(function ($user) {
            $user->activation_token = str_random(30);
        });
    }

    protected $table = 'users';

    public function gravatar($size = '100')
    {
        $hash = md5(trim($this -> attributes['email']));
        return "http://www.gravatar.com/avatar/$hash?s=$size";
    }
}
