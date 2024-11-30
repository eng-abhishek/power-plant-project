<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isSuperAdmin()
    {
        return ($this->is_admin == 'Y') ? true : false;
    }

    public function isModerator()
    {
        return ($this->role == 'moderator') ? true : false;
    }
    
    public function isUser()
    {
        return ($this->role == 'user') ? true : false;
    }

    /**
     * hasAnyRole
     * @param  [type]  $roles [description]
     * @return boolean        [description]
     */
    public function hasAnyRole($roles) {
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    return true;
                }
            }
        } else {
            if ($this->hasRole($roles)) {
                return true;
            }
        }
        return false;
    }

    /**
     * hasRole
     * @param  [type]  $role [description]
     * @return boolean       [description]
     */
    public function hasRole($role) {

        if (\Auth::user()->role == $role) {
            return true;
        }
    }

    public function getAvatarUrlAttribute()
    {
        $document_path = 'avatars';
        if($this->avatar != '' && \Storage::exists($document_path.'/'.$this->avatar)){
            return asset('storage/'.$document_path.'/'.$this->avatar);
        }else{
            return asset('assets/backend/images/default-avatar.jpg');
        }
    }
}
