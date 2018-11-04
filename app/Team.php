<?php

namespace App;

use Laravel\Spark\Team as SparkTeam;

class Team extends SparkTeam
{	
	/**
     * Get the contacts for the team.
     */
    public function contacts()
    {
        return $this->hasMany('App\Contact');
    }

    /**
     * Get the Organisations for the team.
     */
    public function organisations()
    {
        return $this->hasMany('App\Organisation');
    }

    /**
     * Get the Appointments for the team.
     */
    public function appointments()
    {
        return $this->hasMany('App\Appointment');
    }
}
