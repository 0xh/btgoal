<?php

namespace App\Http\Controllers\API;
use App\Appointment;
use App\Contact;
use App\Organisation;
use App\Http\Controllers\Controller;
use App\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class AppointmentController extends Controller
{
    /**
     * Get all of the Appointments associated with current team.
     *
     * @return Response
     */
    public function all(Request $request, $start, $end)
    {
    	// If there is currentTeam selected then return all appointments for that team
        // dd($start);
    	if ($request->user()->currentTeam) {
		    // convert millisecond date into seconds by dividing 1000
            $start = Carbon::createFromTimestamp($start/1000);
            $end = Carbon::createFromTimestamp($end/1000);
            $team_id = $request->user()->currentTeam->id;
            return Appointment::where([
                ['team_id', $team_id],
                ['start_date', '>=', $start],
                ['start_date', '<=', $end],
                ])
               ->orderBy('id', 'asc')
               ->get(['id','title', 'start_date as start', 'all_day as allDay', 'end_date as end']);

		}
    }

    /**
     * Get all of the allTask associated with current team.
     *
     * @return Response
     */
    public function allTask(Request $request, $start, $end)
    {
        // If there is currentTeam selected then return all tasks for that team
        // dd($start);
        if ($request->user()->currentTeam) {
            // convert millisecond date into seconds by dividing 1000
            $start = Carbon::createFromTimestamp($start/1000);
            $end = Carbon::createFromTimestamp($end/1000);
            $team_id = $request->user()->currentTeam->id;
            return Task::where([
                ['team_id', $team_id],
                ['start_date', '>=', $start],
                ['start_date', '<=', $end],
                ])
               ->orderBy('id', 'asc')
               ->get(['id','title', 'start_date as start', 'end_date as end',  'appointment_id']);

        }
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
        ]);

        // $st = Carbon::parse($request->starttime)->toDateTimeString();
        // $et = Carbon::parse($request->endtime)->toDateTimeString();
        
        $appointment = Appointment::find($request->id);
        $appointment->category_id = $request->category_id;
        $appointment->contact_id = $request->contact_id;
        $appointment->organisation_id = $request->organisation_id;
        $appointment->title = $request->title;
        $appointment->startdate = $request->startdate;
        $appointment->enddate = $request->enddate;
        $appointment->allday = $request->allday;
        $appointment->address = $request->address;
        $appointment->attendees = $request->attendees;
        $appointment->save();
        return $appointment;
    }

    public function address(Request $request, $id) {
        return Organisation::find($id);
    }

    public function allOrganisations(Request $request)
    {
        // If there is currentTeam selected then return all orgcontacts for that team
        if ($request->user()->currentTeam) {
            return $request->user()->currentTeam->organisations;
        }
    }

    public function allContacts(Request $request)
    {
        // If there is currentTeam selected then return all contacts for that team
        if ($request->user()->currentTeam) {
            return $request->user()->currentTeam->contacts;
        }
    }

    public function createContact(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:250',
            'email' => 'email',
            'phone' => 'required',
        ]);
        // TO DO:: Fill with TEAM ID and then save whole contact
        // dd($request);
        return Contact::create([
            'team_id' => $request->user()->currentTeam->id,
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'photo' => $request->photolink
        ]);
    }

    public function createOrganisation(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:250',
            'address' => 'required|max:250',
            'email' => 'email',
            'website'  => ['regex:/^((?:https?\:\/\/|www\.)(?:[-a-z0-9]+\.)*[-a-z0-9]+.*)$/'],
        ]);
        // TO DO:: Fill with TEAM ID and then save whole contact
        // dd($request);
        return Organisation::create([
            'team_id' => $request->user()->currentTeam->id,
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'website' => $request->website,
            'photo' => $request->photolink
        ]);
    }

    public function eventUpdate(Request $request)
    {
        $appointment = Appointment::find($request->id);
        $appointment->start_date = $request->sdate;
        $appointment->end_date = $request->edate;
        $appointment->all_day = $request->allday;
        $appointment->save();
        return $appointment;
    }

    public function eventTaskUpdate(Request $request)
    {
        $task = Task::find($request->id);
        $task->start_date = $request->sdate;
        $task->end_date = $request->edate;
        $task->save();
        return $task;
    }
    
}
