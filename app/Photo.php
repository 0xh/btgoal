<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{

	protected $fillable = ['appointment_id', 'team_id','photo'];

    /**
     * Get the appointment that owns the photo.
     */
    public function appointment()
    {
        return $this->belongsTo('App\Appointment');
    }
}
