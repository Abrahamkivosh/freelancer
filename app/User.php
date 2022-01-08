<?php

namespace App;

use Bavix\Wallet\Interfaces\Wallet;
use Bavix\Wallet\Traits\HasWallet;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use willvincent\Rateable\Rateable;


class User extends Authenticatable implements Wallet
{
    use Notifiable, HasWallet, Rateable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','username','country','role_id'
    ];

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

    public function jobs()
    {
        return $this -> hasMany(Job::class);
    }
    public function proposals()
    {
        return $this -> hasMany(JobProposal::class);
    }
    public function is_admin(){
        $result = ($this->role_id == 1) ? true : false ;
        return $result;
    }

    public function getRoleAttribute()
    {
        if($this->role_id == 1)
        {
            return 'admin';
        }elseif($this->role_id == 2)
        {
            return 'freelancer';
        }else {
            return 'client';
        }
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->whereNull('parent_id');
    }

    public function activeJobs()
    {
        $jobs = Job::where('user_id', $this->id)->where('status','active')->get();
        return $jobs;
    }
    /**
     * Get all of the mpesa for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mpesa()
    {
        return $this->hasMany(Mpesa::class, 'user_id', 'id');
    }
}
