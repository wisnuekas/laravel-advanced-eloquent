<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Image;

class Mitra extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'phone_number', 'firebase_uid', 'max_fee', 'min_fee','avatar', 'about', 'sex', 'date_of_birth'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }

    public function skills()
    {
        return $this->belongsToMany('App\Skill');
    }

    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    public function reviews()
    {
        return $this->hasMany('App\Review');
    }

    public function saveAvatar($avatar)
    {
        $path = '/uploads/avatars/';
        $extentions = $avatar->getClientOriginalExtension();
        $filename = 'mitra'.$this->id.'_'.time().'.'.$extentions;

        // RESIZE IMAGE
        $resized_img = $this->resizeImage($avatar, 500);
        if (!file_exists(public_path($path))) {
            mkdir(public_path($path), 665, true);
        }
        $resized_img->save(public_path($path).$filename);

        return $path.$filename;
    }

    protected function resizeImage($img, int $row)
    {
        return Image::make($img)->fit($row,$row, function ($constraint) {
            $constraint->upsize();
        });
    }   
}
