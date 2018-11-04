<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Appointment extends Model
{
    protected $dates = ['created_at', 'updated_at','start_date', 'end_date', 'checkin_datetime'];

	protected $fillable = ['title', 'team_id', 'detail', 'category_id', 'contact_id', 'organisation_id', 'start_date',
	 'end_date',  'all_day', 'attendees','address', 'send_sms', 'photo'];
    
    // Mutators

    public function setCategoryIdAttribute($value)
    {
        $this->attributes['category_id'] = $value ?: null;
    }
    public function setContactIdAttribute($value)
    {
        $this->attributes['contact_id'] = $value ?: null;
    }
    public function setOrganisationIdAttribute($value)
    {
        $this->attributes['organisation_id'] = $value ?: null;
    }
    public function setEndDateAttribute($value)
    {
        $this->attributes['end_date'] = $value ?: null;
    }

    //Accessor
    public function getSimpleDateAttribute()
    {
        return Carbon::parse($this->attributes['start_date'])->format('l,d/m/Y');
      // return substr(->format(), 0, 10); // or whatever you like to process dateTime field
    }

    /**
     * Get the team that owns the contact.
     */
    public function team()
    {
        return $this->belongsTo('App\Team');
    }

    /**
     * Get the Tasks for the appointment.
     */
    public function tasks()
    {
        return $this->hasMany('App\Task');
    }

    /**
     * Get the Notes for the appointment.
     */
    public function notes()
    {
        return $this->hasMany('App\Note');
    }

     /**
     * Get the Photos for the appointment.
     */
    public function photos()
    {
        return $this->hasMany('App\Photo');
    }

    /**
     * Get the contact that owns the appointment.
     */
    public function contact()
    {
        return $this->belongsTo('App\Contact');
    }

    /**
     * Get the organisation that owns the appointment.
     */
    public function organisation()
    {
        return $this->belongsTo('App\Organisation');
    }

    /**
     * Get the category that owns the appointment.
     */
    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public $sortable = ['title',
                        'address',
                        'start_date'];

    
}


