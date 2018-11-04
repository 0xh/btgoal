<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organisation extends Model
{
    protected $fillable = ['name', 'team_id','phone', 'email', 'address', 'website', 'photo'];

    public function team()
    {
        return $this->belongsTo('App\Team');
    }
}
