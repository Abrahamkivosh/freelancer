<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobProposal extends Model
{
    protected $fillable = ['proposal_text','job_id','bid','delivery_date','delivery_file','delivery_comments','status','accepted'];

    public function user()
    {
       return $this->belongsTo(User::class);
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->whereNull('parent_id');
    }
}
