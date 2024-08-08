<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Conversation;
use App\Address;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email' , 'mobile' , 'profile_image', 'password','type','otp','login_type','google_id','facebook_id','token','referral_code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function createConversation($receiver_id)
    {
        // $conversation = new Conversation;
        // $conversation->unique = $this->makeUniqueId();
        // $conversation->user_one = $this->id;
        // $conversation->user_two = $receiver_id;
        // $conversation->save();
    }

    protected function makeUniqueId()
    {
        $uniqueId = $this->generateRandomString(17);

        while (!$this->checkUnique($uniqueId)) {
            $uniqueId = $this->generateRandomString(17);
        }

        return $uniqueId;
    }

    protected function checkUnique($string)
    {
        $existCount = Conversation::where('unique', $string)->count();

        if ($existCount == 0) {
            return true;
        }

        return false;
    }

    protected function generateRandomString($length = 17)
    {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }

    public function address()
    {
        return $this->hasOne('App\Address', 'user_id', 'id');
    }
}
