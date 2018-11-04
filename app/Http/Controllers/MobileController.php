<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Task;
use App\Team;
use App\User;
use Auth;
use App\Contact;
use App\Organisation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Spark\Contracts\Repositories\NotificationRepository;

class MobileController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(NotificationRepository $notifications)
    {
        $this->middleware('auth');
        $this->notifications = $notifications;
        // $this->middleware('subscribed');
    }

    public function add(Request $request)
    {
        $team_owner = $request->user()->currentTeam->owner_id;
        $carer = User::where('id', $team_owner)->first();
        $newcontact = new Contact;
        if (isset($request->user()->currentTeam)) {
            $contacts =  $request->user()->currentTeam->contacts;
            $organisations =  $request->user()->currentTeam->organisations;
        }
        return view('mobile/add-appointment', compact('carer', 'contacts', 'organisations', 'newcontact'));
    }

    public function edit(Request $request, $id)
    {
        $team_id = $request->user()->currentTeam->id;
        $apt = Appointment::where([['id', $id], ['team_id', $team_id]])->with('contact','organisation')->first();
        $team_owner = $request->user()->currentTeam->owner_id;
        $carer = User::where('id', $team_owner)->first();
        /* tack how many time appointment is viewed by carer or pwd */
        if ($request->user()->pwd == 1) {
            $apt->pwd_count = $apt->pwd_count + 1;
            $apt->save();
        } else {
            $apt->carer_count = $apt->carer_count + 1;
            $apt->save();
        }
        $get_task = Task::where(['appointment_id' => $id, 'order' => '10'])->with('contact','organisation')->first();
        if (!isset($get_task)) $get_task = new Task;
        $getting_task = Task::where(['appointment_id' => $id, 'order' => '20'])->with('contact','organisation')->first();
        if (!isset($getting_task)) $getting_task = new Task;
        $after_task = Task::where(['appointment_id' => $id, 'order' => '30'])->with('contact','organisation')->first();
        if (!isset($after_task)) $after_task = new Task;

        if (isset($request->user()->currentTeam)) {
            $contacts =  $request->user()->currentTeam->contacts;
            $organisations =  $request->user()->currentTeam->organisations;
        }
        $newcontact = new Contact;
        return view('mobile/edit-appointment', compact('apt', 'contacts', 'organisations', 'get_task', 'getting_task', 'after_task', 'newcontact', 'carer'));
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function calendar(Request $request)
    {
        $team_id = $request->user()->currentTeam->id;
    	$t_date = new Carbon();
        $user = User::where('id', Auth::id())->first();
        if ($user->emergency_phone == null) {
            $team = Team::find($request->user()->currentTeam->id);
            $carer_id = $team->owner_id;
            $carer = User::find($carer_id);
            $user->emergency_name = $carer->name;
            $user->emergency_phone = $carer->phone;
        }
    	$today = $t_date->format('d/m/Y');
    	// $appointments = Appointment::whereBetween('start_date', [Carbon::today(), Carbon::today()->addDays(10)])
        $appointments = Appointment::where('team_id',$team_id)->where('start_date', '>=', Carbon::today())
            ->orderBy('start_date', 'asc')->limit(10)->get();
        $appointments = $appointments->groupBy('simpleDate');
        return view('mobile/calendar', compact('today', 'appointments', 'user'));

    }

    public function home(Request $request)
    {
        $team_id = $request->user()->currentTeam->id;
        $user = User::where('id', Auth::id())->first();
        if ($user->emergency_phone == null) {
            $team = Team::find($request->user()->currentTeam->id);
            $carer_id = $team->owner_id;
            $carer = User::find($carer_id);
            $user->emergency_name = $carer->name;
            $user->emergency_phone = $carer->phone;
        }
        return view('mobile/home', compact('user'));

    }

    public function people(Request $request)
    {
        $people =  $request->user()->currentTeam->contacts;
        return view('mobile/people', compact('people'));
    }

    public function places(Request $request)
    {
        $map = '#';
        $address = '';
        $places =  $request->user()->currentTeam->organisations;
        foreach ($places as $place) {
            if (isset($place->address)) {
                $map = "http://maps.google.com/maps?daddr=". urlencode($place->address) . "&directionsmode=transit";
                $address = $place->address;
            }
            $split_address = explode(", ", $address);
            foreach ($split_address as $valueKey => $value) {
                if($value == 'Queensland' || $value == 'South Australia' || $value == 'Tasmania' || $value == 'New South Wales' || $value == 'Victoria' || $value == 'Western Australia' || (is_numeric($value) && strlen($value) == 4) || $value == 'Australia' || $value == 'NSW' || $value == 'ACT' || $value == 'VIC' || $value == 'QLD' || $value == 'SA' || $value == 'WA' || $value == 'TAS' || $value == 'NT'){
                    //delete this particular object from the $array
                    unset($split_address[$valueKey]);
                } 
                if ($valueKey > 0) {
                    $split_value = explode(" ", $value);
                    foreach ($split_value as $splitvalueKey => $singlevalue) {
                        if($singlevalue == 'Queensland' || $singlevalue == 'South Australia' || $singlevalue == 'Tasmania' || $singlevalue == 'New South Wales' || $singlevalue == 'Victoria' || $singlevalue == 'Western Australia' || (is_numeric($singlevalue) && strlen($singlevalue) == 4) || $singlevalue == 'Australia' || $singlevalue == 'NSW' || $singlevalue == 'ACT' || $singlevalue == 'VIC' || $singlevalue == 'QLD' || $singlevalue == 'SA' || $singlevalue == 'WA' || $singlevalue == 'TAS' || $singlevalue == 'NT'){
                            //dd($singlevalue);
                            unset($split_value[$splitvalueKey]);
                        }
                    }
                    $split_address[$valueKey] = implode(" ", $split_value);
                }
            }
            $address = implode(", ", $split_address);
            $address = str_replace(",,", ",", $address);
            if(substr($address, -2, 2) == ', ') {
              $address = substr($address, 0, -2);
            }
            if(substr($address, -1, 1) == ',') {
              $address = substr($address, 0, -1);
            }
            $place->address = $address;
            $place->map = $map;
        }
        return view('mobile/places', compact('places'));
    }

    public function editPeople($id)
    {
        $contact = Contact::find($id);
        return view('mobile/edit-people', compact('contact'));
    }

    public function addPeople()
    {
        $contact = new Contact;
        return view('mobile/edit-people', compact('contact'));
    }

    public function editPlace($id)
    {
        $organisation = Organisation::find($id);
        return view('mobile/edit-place', compact('organisation'));
    }

    public function addPlace()
    {
        $organisation = new Organisation;
        return view('mobile/edit-place', compact('organisation'));
    }

    // View Detail Appointment
    public function appointment(Request $request, $id)
    {
        $team_id = $request->user()->currentTeam->id;
        $appointment = Appointment::where([['id', $id], ['team_id', $team_id]])->with('contact','organisation')->first();
        // dd($appointment->organisation->address);
        /* tack how many time appointment is viewed by carer or pwd */
        if ($request->user()->pwd == 1) {
            $appointment->pwd_count = $appointment->pwd_count + 1;
            $appointment->save();
        } else {
            $appointment->carer_count = $appointment->carer_count + 1;
            $appointment->save();
        }
        $map = '#';
        $address = '';
        if (isset($appointment->organisation->address)) {
            $map = "http://maps.google.com/maps?daddr=". urlencode($appointment->organisation->address) . "&directionsmode=transit";
            $address = $appointment->organisation->address;
        }
        if ($appointment->address) {
            $map = "http://maps.google.com/maps?daddr=". urlencode($appointment->address) . "&directionsmode=transit";
            $address = $appointment->address;
        }
        $split_address = explode(", ", $address);
        foreach ($split_address as $valueKey => $value) {
            if($value == 'Queensland' || $value == 'South Australia' || $value == 'Tasmania' || $value == 'New South Wales' || $value == 'Victoria' || $value == 'Western Australia' || (is_numeric($value) && strlen($value) == 4) || $value == 'Australia' || $value == 'NSW' || $value == 'ACT' || $value == 'VIC' || $value == 'QLD' || $value == 'SA' || $value == 'WA' || $value == 'TAS' || $value == 'NT'){
                //delete this particular object from the $array
                unset($split_address[$valueKey]);
            } 
            if ($valueKey > 0) {
                $split_value = explode(" ", $value);
                foreach ($split_value as $splitvalueKey => $singlevalue) {
                    if($singlevalue == 'Queensland' || $singlevalue == 'South Australia' || $singlevalue == 'Tasmania' || $singlevalue == 'New South Wales' || $singlevalue == 'Victoria' || $singlevalue == 'Western Australia' || (is_numeric($singlevalue) && strlen($singlevalue) == 4) || $singlevalue == 'Australia' || $singlevalue == 'NSW' || $singlevalue == 'ACT' || $singlevalue == 'VIC' || $singlevalue == 'QLD' || $singlevalue == 'SA' || $singlevalue == 'WA' || $singlevalue == 'TAS' || $singlevalue == 'NT'){
                        //dd($singlevalue);
                        unset($split_value[$splitvalueKey]);
                    }
                }
                $split_address[$valueKey] = implode(" ", $split_value);
            }
        }
        $address = implode(", ", $split_address);
        $address = str_replace(",,", ",", $address);
        if(substr($address, -2, 2) == ', ') {
          $address = substr($address, 0, -2);
        }
        if(substr($address, -1, 1) == ',') {
          $address = substr($address, 0, -1);
        }
        $tasks = Task::where('appointment_id', $id)->orderBy('order', 'asc')->get();
        return view('mobile/detail-appointment', compact('appointment', 'tasks', 'map', 'address'));

    }

      // View Detail Task
    public function task(Request $request, $id)
    {
        $team_id = $request->user()->currentTeam->id;
        $task = Task::where([['id', $id], ['team_id', $team_id]])->with('contact','organisation')->first();
        // dd($task->organisation->address);
        if ($request->user()->pwd == 1) {
            $task->pwd_count = $task->pwd_count + 1;
            $task->save();
        } else {
            $task->carer_count = $task->carer_count + 1;
            $task->save();
        }
        $map = '#';
        $address = '';
        if (isset($task->organisation->address)) {
            $map = "http://maps.google.com/maps?daddr=". urlencode($task->organisation->address) . "&directionsmode=transit";
            $address = $task->organisation->address;
        }
        if ($task->address) {
            $map = "http://maps.google.com/maps?daddr=". urlencode($task->address) . "&directionsmode=transit";
            $address = $task->address;
        }
        $split_address = explode(", ", $address);
        foreach ($split_address as $valueKey => $value) {
            if($value == 'Queensland' || $value == 'South Australia' || $value == 'Tasmania' || $value == 'New South Wales' || $value == 'Victoria' || $value == 'Western Australia' || (is_numeric($value) && strlen($value) == 4) || $value == 'Australia' || $value == 'NSW' || $value == 'ACT' || $value == 'VIC' || $value == 'QLD' || $value == 'SA' || $value == 'WA' || $value == 'TAS' || $value == 'NT'){
                //delete this particular object from the $array
                unset($split_address[$valueKey]);
            } 
            if ($valueKey > 0) {
                $split_value = explode(" ", $value);
                foreach ($split_value as $splitvalueKey => $singlevalue) {
                    if($singlevalue == 'Queensland' || $singlevalue == 'South Australia' || $singlevalue == 'Tasmania' || $singlevalue == 'New South Wales' || $singlevalue == 'Victoria' || $singlevalue == 'Western Australia' || (is_numeric($singlevalue) && strlen($singlevalue) == 4) || $singlevalue == 'Australia' || $singlevalue == 'NSW' || $singlevalue == 'ACT' || $singlevalue == 'VIC' || $singlevalue == 'QLD' || $singlevalue == 'SA' || $singlevalue == 'WA' || $singlevalue == 'TAS' || $singlevalue == 'NT'){
                        //dd($singlevalue);
                        unset($split_value[$splitvalueKey]);
                    }
                }
                $split_address[$valueKey] = implode(" ", $split_value);
            }
        }
        $address = implode(", ", $split_address);
        $address = str_replace(",,", ",", $address);
        if(substr($address, -2, 2) == ', ') {
          $address = substr($address, 0, -2);
        }
        if(substr($address, -1, 1) == ',') {
          $address = substr($address, 0, -1);
        }
        return view('mobile/detail-task', compact('task', 'map', 'address'));

    }

    // Check in
    public function checkin(Request $request, $id)
    {
        $user = $request->user();
        $appointment = Appointment::where('id', $id)->with('contact','organisation')->first();

        if (!$appointment->checkin) {
            // dd($appointment->start_date->format('Y/m/d'));
            $appointment->checkin = true;
            $appointment->checkin_datetime = Carbon::now('Australia/Sydney');
            if ($appointment->checkin_datetime->format('Y/m/d') != ($appointment->start_date->format('Y/m/d'))) {

                return 2;
            }

            $appointment->save();
            //Send Notification
            if ($user->currentTeam) {
                $owner_id = DB::table('team_users')->select('user_id')
                    ->where([['team_id', '=', $user->currentTeam->id],['role', '=', 'owner'],])->first();
                $owner = \App\User::find($owner_id->user_id);
                $this->notifications->create($owner, [
                    'icon' => 'fa-users',
                    'body' => $user->name . ' checked in at ' . $appointment->title . ' | ' . $appointment->checkin_datetime->format('d/m/Y g:ia'),
                ]);
            }
        return "1";    
        } 
        return "0";
    }

    // Task Check in
    public function taskCheckin(Request $request, $id)
    {
        $user = $request->user();
        $task = Task::where('id', $id)->first();

        if (!$task->checkin) {
            // dd($task->start_date->format('Y/m/d'));
            $task->checkin = true;
            $task->checkin_datetime = Carbon::now('Australia/Sydney');
            if ($task->checkin_datetime->format('Y/m/d') != ($task->start_date->format('Y/m/d'))) {

                return 2;
            }

            $task->save();
            //Send Notification
            if ($user->currentTeam) {
                $owner_id = DB::table('team_users')->select('user_id')
                    ->where([['team_id', '=', $user->currentTeam->id],['role', '=', 'owner'],])->first();
                $owner = \App\User::find($owner_id->user_id);
                $this->notifications->create($owner, [
                    'icon' => 'fa-users',
                    'body' => $user->name . ' completed task ' . $task->title . ' | ' . $task->checkin_datetime->format('d/m/Y g:ia'),
                ]);
            }
        return "1";    
        } 
        return "0";
    }


       /**
     * Show the mobile settings.
     *
     * @return Response
     */
    public function settings()
    {
        
        // $user = $request->user();
        // $teams = $user->teams;
        return view('mobile/settings');

    }

    public function aboutMe()
    {
        $user = User::where('id', Auth::id())->first();
        return view('mobile/about-me', compact('user'));
    }
}
