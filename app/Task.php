<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $dates = ['created_at', 'updated_at','start_date', 'end_date','checkin_datetime'];
    
	protected $fillable = ['title', 'team_id', 'order','appointment_id', 'category_id', 'contact_id', 'start_date',
	 'end_date',  'send_sms', 'attendees','address','detail'];

	// Mutators

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

    /**
     * Get the appointment that owns the task.
     */
    public function appointment()
    {
        return $this->belongsTo('App\Appointment');
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

      /**
     * Get the team that owns the task.
     */
    public function team()
    {
        return $this->belongsTo('App\Team');
    }
}
