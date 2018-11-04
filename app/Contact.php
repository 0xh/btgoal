<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
	protected $fillable = ['name', 'team_id','phone', 'email', 'address', 'photo', 'organisation'];
    /**
     * Get the team that owns the contact.
     */
    public function team()
    {
        return $this->belongsTo('App\Team');
    }
}
