<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    /**
     * Get the appointment that owns the note.
     */
    public function appointment()
    {
        return $this->belongsTo('App\Appointment');
    }
}
