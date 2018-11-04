<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Task;
use App\Photo;
use DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        // $this->middleware('subscribed');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function show(Request $request)
    {
        $user = $request->user();
        // dd($user);
        if ($user->currentTeam) {
            if ($user->roleOn($user->currentTeam) === 'pwd') {
                return redirect('mobile-home');
            } else {
                return view('home');
            }
        } else {
             return redirect('welcome');
        }
        
    }

    public function welcome()
    {
        return view('welcome');
    }

    /**
     * Show the categories.
     *
     * @return Response
     */
    public function category()
    {
        return view('category');
    }

    
    public function aboutme(Request $request)
    {
        $user = $request->user();
        return view('settings.profile.about-me')->with(compact('user'));
    }

    /**
     * Show the all tasks.
     *
     * @return Response
     */
    public function task()
    {
        $apts = \App\Task::with('contact','organisation')->get();
        return view('task_report')->with(compact('apts'));
       
    }

     /**
     * Show the all appointments.
     *
     * @return Response
     */
    public function appointment()
    {
        $apts = DB::table('appointments')
            ->select(DB::raw('photos.photo AS photos_photo,
                appointments.title AS appointments_title,
                contacts.name AS contact_title,
                UNIX_TIMESTAMP(appointments.start_date) AS appointments_start_date,
                UNIX_TIMESTAMP(appointments.end_date) AS appointments_end_date,
                appointments.send_sms AS appointments_send_sms,
                appointments.checkin AS appointments_checkin,
                UNIX_TIMESTAMP(appointments.checkin_datetime) AS appointments_checkin_datetime,
                UNIX_TIMESTAMP(appointments.created_at) AS appointments_created_at,
                appointments.pwd_count AS appointments_pwd_count,
                appointments.carer_count AS appointments_carer_count,
                teams.name AS teams_name'))
            ->leftJoin('contacts', 'appointments.contact_id', '=', 'contacts.id')
            ->leftJoin('organisations', 'appointments.organisation_id', '=', 'organisations.id')
            ->leftJoin('photos', 'appointments.id', '=', 'photos.id')
            ->leftJoin('teams', 'appointments.team_id', '=', 'teams.id')
            ->get();
        //dd($apts);
        //$apts = \App\Appointment::with('contact','organisation')->get();
        return view('appointment_report')->with(compact('apts'));
    }
 
}
