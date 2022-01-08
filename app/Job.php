<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    // protected $fillable = ['status'];
    protected $guarded = [];

    protected $dates = [
        'delivery_date',
        'start_date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function proposals()
    {
        return $this->hasMany(JobProposal::class);
    }
}
