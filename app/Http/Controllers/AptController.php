<?php

namespace App\Http\Controllers;
use App\Appointment;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use App\Task;
use Carbon\Carbon;
use App\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image;

class AptController extends Controller
{
    private $a_start, $a_end, $a_ready_start, $a_ready_end, $a_getting_start, $a_getting_end,
        $a_after_start, $a_after_end, $a_re_occurance;

    public function __construct()
    {
        $this->middleware('auth');

        // $this->middleware('subscribed');
    }
    /**
     * Create a new Appointment.
     *
     * @return Response
     */

    public function showAllAppointment()
    {
        $team = DB::table('teams')
            ->select(DB::raw('teams.id AS team_id'))
            ->where('owner_id', Auth::id())
            ->first();
        /*$apts = DB::table('appointments')
            ->select(DB::raw())
            ->where('appointments.team_id', $team->team_id)
            ->leftJoin('contacts', 'appointments.contact_id', '=', 'contacts.id')
            ->get();*/
        //$apts = Appointment::with('contact')->where('team_id', $team->team_id)->get();
        $apts = Appointment::select('appointments.*')
            ->addSelect(DB::raw("contacts.name AS contact_name"))
            ->leftJoin('contacts', 'appointments.contact_id', '=', 'contacts.id')
            ->where('appointments.team_id', $team->team_id)
            ->paginate(15);
            $order = 'dsc';
        return view('appointment_list', compact('apts', 'order'));
    }

    public function bulkDeleteAppointment(Request $request)
    {
        $this->validate($request, [
            'checked' => 'required',
        ]);

        $checked = $request->input('checked');
        foreach ($checked as $key => $value) {
            Task::where('appointment_id', $value)->delete();
        }
        Appointment::destroy($checked);

        return redirect('/appointment/list');
    }

    public function store(Request $request)
    {   
        $this->validate($request, [
            'title' => 'required|max:255',
            'main_photo' => 'image|max:5048',
            'start_date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        if (isset($request->from_mobile)) {
            $this->a_start = Carbon::createFromTimestamp(strtotime($request->start_date . " " . $request->start_time));
        
            $this->a_end = Carbon::createFromTimestamp(strtotime($request->start_date . " " . $request->end_time));
        } else {
            $this->a_start = Carbon::createFromTimestamp(strtotime($request->start_date . " " . $request->start_time));
        
            $this->a_end = Carbon::createFromTimestamp(strtotime($request->end_date . " " . $request->end_time));
        }
    
        $this->a_re_occurance = Carbon::createFromTimestamp(strtotime($request->re_occurance_end_date));
        if ($this->a_end->lt($this->a_start)) {
            $this->a_end = clone $this->a_start;
        }

        $this->a_ready_start= Carbon::createFromTimestamp(strtotime($request->start_date . " " . $request->get_ready_start_time));
        $this->a_ready_end= Carbon::createFromTimestamp(strtotime($request->start_date . " " . $request->get_ready_end_time));
        if ($this->a_ready_end <  $this->a_ready_start) {
            $this->a_ready_end = clone $this->a_ready_start;
        }

         $this->a_getting_start= Carbon::createFromTimestamp(strtotime($request->start_date . " " . $request->getting_there_start_time));
        $this->a_getting_end= Carbon::createFromTimestamp(strtotime($request->start_date . " " . $request->getting_there_end_time));
        if ($this->a_getting_end <  $this->a_getting_start) {
            $this->a_getting_end = clone $this->a_getting_start;
        }
        
         $this->a_after_start= Carbon::createFromTimestamp(strtotime($request->start_date . " " . $request->after_appointment_start_time));
        $this->a_after_end = Carbon::createFromTimestamp(strtotime($request->start_date . " " . $request->after_appointment_end_time));
        if ($this->a_after_end <  $this->a_after_start) {
            $this->a_after_end = clone $this->a_after_start;
        }

        $repeat = $request->repeat_appointment;
        // Save Photo... and use Same photo for all repeated appointments
        $file = '/img/default.png';
        if ($request->file('main_photo')) {
            $file = $request->file('main_photo')->store('public/appointment');

            Image::make($file)->fit(500,500, function ($constraint) {
                $constraint->aspectRatio();
            })->save( public_path($file) );
            $file = '/'.$file;
        }

        if (isset($request->from_mobile)) {
            $req = $this->create_appointment_with_tasks($request, $file);
            $request->session()->flash('alert-success', 'Appointment / Tasks successfully created!');
            return  redirect('mobile-calendar');
        } else {
            if ($repeat == 'none') {
            $req = $this->create_appointment_with_tasks($request, $file);
            } else  {
                $req = $this->repeat_appointment($request, $file);
            }
            $request->session()->flash('alert-success', 'Appointment / Tasks successfully created!');
            return  redirect('appointment');
        }
    }


    private function repeat_appointment(Request $request, $file) {

        $repeat = $request->repeat_appointment;
        while ($this->a_start <= $this->a_re_occurance) {
           // var_dump($start);
            $this->create_appointment_with_tasks($request, $file);
            
            switch ($repeat) {
                case 'daily':
                    $this->a_start->addDay();
                    $this->a_end->addDay();
                    $this->a_ready_start->addDay();
                    $this->a_ready_end->addDay();
                    $this->a_getting_start->addDay();
                    $this->a_getting_end->addDay();
                    $this->a_after_start->addDay();
                    $this->a_after_end ->addDay();
                    break;
                case 'weekly':
                    $this->a_start = $this->a_start->addWeek();
                    $this->a_end = $this->a_end->addWeek();
                    $this->a_ready_start= $this->a_ready_start->addWeek();
                    $this->a_ready_end= $this->a_ready_end->addWeek();
                    $this->a_getting_start= $this->a_getting_start->addWeek();
                    $this->a_getting_end= $this->a_getting_end->addWeek();
                    $this->a_after_start= $this->a_after_start->addWeek();
                    $this->a_after_end = $this->a_after_end ->addWeek();
                    break;
                case 'monthly':
                    $this->a_start = $this->a_start->addMonth();
                    $this->a_end = $this->a_end->addMonth();
                    $this->a_ready_start= $this->a_ready_start->addMonth();
                    $this->a_ready_end= $this->a_ready_end->addMonth();
                    $this->a_getting_start= $this->a_getting_start->addMonth();
                    $this->a_getting_end= $this->a_getting_end->addMonth();
                    $this->a_after_start= $this->a_after_start->addMonth();
                    $this->a_after_end = $this->a_after_end ->addMonth();
                    break;
                case 'yearly':
                    $this->a_start = $this->a_start->addYear();
                    $this->a_end = $this->a_end->addYear();
                    $this->a_ready_start= $this->a_ready_start->addYear();
                    $this->a_ready_end= $this->a_ready_end->addYear();
                    $this->a_getting_start= $this->a_getting_start->addYear();
                    $this->a_getting_end= $this->a_getting_end->addYear();
                    $this->a_after_start= $this->a_after_start->addYear();
                    $this->a_after_end = $this->a_after_end ->addYear();
                    break;
            }
        }
    }

    private function create_appointment_with_tasks(Request $request, $file) {
        $team_id = $request->user()->currentTeam->id;
       
        $appointment = Appointment::create([
            'team_id' => $team_id,
            'category_id' => $request->category_id,
            'contact_id' => $request->contact_id,
            'photo' => $file,
            'detail' => $request->detail,
            'organisation_id' => $request->organisation_id,
            'title' => $request->title,
            'start_date' => $this->a_start,
            'end_date' => $this->a_end,
            'send_sms' => ($request->send_sms == "on") ? true : false,
            'address' => $request->address
        ]);
        // Create Get ready task
        if ($request->get_ready_title) {
            Task::create([
                'team_id' => $team_id,
                'contact_id' => $request->get_ready_contact_id,
                'appointment_id' => $appointment->id,
                'organisation_id' => $request->get_ready_organisation_id,
                'title' => $request->get_ready_title,
                'start_date' => $this->a_ready_start,
                'end_date' => $this->a_ready_end,
                'send_sms' => ($request->get_ready_send_sms == "on") ? true : false,
                'address' => $request->get_ready_address,
                'order' => 10,
                'detail' => $request->get_ready_detail
            ]);
        }
        
        if ($request->getting_there_title) {
            Task::create([
                'team_id' => $team_id,
                'contact_id' => $request->getting_there_contact_id,
                'appointment_id' => $appointment->id,
                'organisation_id' => $request->getting_there_organisation_id,
                'title' => $request->getting_there_title,
                'start_date' => $this->a_getting_start,
                'end_date' => $this->a_getting_end,
                'send_sms' => ($request->getting_there_send_sms == "on") ? true : false,
                'address' => $request->getting_there_address,
                'order' => 20,
                'detail' => $request->getting_there_detail
            ]);
        }

        if ($request->after_appointment_title) {
            Task::create([
                'team_id' => $team_id,
                'contact_id' => $request->after_appointment_contact_id,
                'appointment_id' => $appointment->id,
                'organisation_id' => $request->after_appointment_organisation_id,
                'title' => $request->after_appointment_title,
                'start_date' => $this->a_after_start,
                'end_date' => $this->a_after_end ,
                'send_sms' => ($request->after_appointment_send_sms == "on") ? true : false,
                'address' => $request->after_appointment_address,
                'order' => 30,
                'detail' => $request->after_appointment_detail
            ]);
        }
        return $appointment;
    }

    public function updateAppointment(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'main_photo' => 'image|max:5048',
            'start_date' => 'required_with:title',
            'get_ready_title' => 'required_with:get_ready_start_time|max:255',
            'get_ready_start_time' => 'required_with:get_ready_title',
            'getting_there_title' => 'required_with:getting_there_start_time|max:255',
            'getting_there_start_time' => 'required_with:getting_there_title',
            'after_appointment_title' => 'required_with:after_appointment_start_time|max:255',
            'after_appointment_start_time' => 'required_with:after_appointment_title'
        ]);

        if (isset($request->from_mobile)) {
            $this->a_start = Carbon::createFromTimestamp(strtotime($request->start_date . " " . $request->start_time));
            $this->a_end = Carbon::createFromTimestamp(strtotime($request->start_date . " " . $request->end_time));
        } else {
            $this->a_start = Carbon::createFromTimestamp(strtotime($request->start_date . " " . $request->start_time));
            $this->a_end = Carbon::createFromTimestamp(strtotime($request->end_date . " " . $request->end_time));
        }
       
        $this->a_re_occurance = Carbon::createFromTimestamp(strtotime($request->re_occurance_end_date));
        if ($this->a_end->lt($this->a_start)) {
            $this->a_end = clone $this->a_start;
        }

        $this->a_ready_start= Carbon::createFromTimestamp(strtotime($request->start_date . " " . $request->get_ready_start_time));
        $this->a_ready_end= Carbon::createFromTimestamp(strtotime($request->start_date . " " . $request->get_ready_end_time));
        if ($this->a_ready_end <  $this->a_ready_start) {
            $this->a_ready_end = clone $this->a_ready_start;
        }

         $this->a_getting_start= Carbon::createFromTimestamp(strtotime($request->start_date . " " . $request->getting_there_start_time));
        $this->a_getting_end= Carbon::createFromTimestamp(strtotime($request->start_date . " " . $request->getting_there_end_time));
        if ($this->a_getting_end <  $this->a_getting_start) {
            $this->a_getting_end = clone $this->a_getting_start;
        }
        
         $this->a_after_start= Carbon::createFromTimestamp(strtotime($request->start_date . " " . $request->after_appointment_start_time));
        $this->a_after_end = Carbon::createFromTimestamp(strtotime($request->start_date . " " . $request->after_appointment_end_time));
        if ($this->a_after_end <  $this->a_after_start) {
            $this->a_after_end = clone $this->a_after_start;
        }

        $appointment = Appointment::find($id);
        // Update photo
        $file = '/img/default.png';
        if ($request->file('main_photo')) {
            $file = $request->file('main_photo')->store('public/appointment');

            Image::make($file)->fit(500,500, function ($constraint) {
                $constraint->aspectRatio();
            })->save( public_path($file) );
            $file = '/'.$file;
            $appointment->photo = $file;
        }
        
        $appointment->category_id = $request->category_id;
        $appointment->contact_id = $request->contact_id;
        $appointment->organisation_id = $request->organisation_id;
        $appointment->title = $request->title;
        $appointment->start_date = $this->a_start;
        $appointment->end_date = $this->a_end;
        $appointment->address = $request->address;
        $appointment->detail = $request->detail;
        $appointment->send_sms = ($request->send_sms == "on") ? true : false;
        $appointment->save();

        // Update tasks

        //Get ready
        $task = Task::firstOrNew(['id' => $request->get_ready_id]);
        if (!empty($request->get_ready_title)) {
            $task->appointment_id = $request->apt_id;
            $task->team_id = $request->team_id;
            $task->order = 10;
            $task->title = $request->get_ready_title;
            $task->contact_id = $request->get_ready_contact_id;
            $task->organisation_id = $request->get_ready_organisation_id;
            $task->start_date = $this->a_ready_start;
            $task->end_date = $this->a_ready_end;
            $task->send_sms = ($request->get_ready_send_sms == "on") ? true : false;
            $task->address = $request->get_ready_address;
            $task->detail = $request->get_ready_detail;
            $task->save();
        }
        

        $task = Task::firstOrNew(['id' => $request->getting_there_id]);
        if (!empty($request->getting_there_title)) {
            $task->appointment_id = $request->apt_id;
            $task->team_id = $request->team_id;
            $task->order = 20;
            $task->title = $request->getting_there_title;
            $task->contact_id = $request->getting_there_contact_id;
            $task->organisation_id = $request->getting_there_organisation_id;
            $task->start_date = $this->a_getting_start;
            $task->end_date = $this->a_getting_end;
            $task->send_sms = ($request->getting_there_send_sms == "on") ? true : false;
            $task->address = $request->getting_there_address;
            $task->detail = $request->getting_there_detail;
            $task->save();
        }

        $task = Task::firstOrNew(['id' => $request->after_appointment_id]);
        if (!empty($request->after_appointment_title)) {
            $task->appointment_id = $request->apt_id;
            $task->team_id = $request->team_id;
            $task->order = 30;
            $task->title = $request->after_appointment_title;
            $task->contact_id = $request->after_appointment_contact_id;
            $task->organisation_id = $request->after_appointment_organisation_id;
            $task->start_date = $this->a_after_start;
            $task->end_date = $this->a_after_end;
            $task->send_sms = ($request->after_appointment_send_sms == "on") ? true : false;
            $task->address = $request->after_appointment_address;
            $task->detail = $request->after_appointment_detail;
            $task->save();
        }
        $request->session()->flash('alert-success', 'Appointment / Tasks successfully updated!');
        if (isset($request->from_mobile)) {
            return  redirect('mobile-calendar');
        } else {
            return redirect('home');
        }
    }

        /**
     * View the Appointment.
     *
     * @return Response
     */
    public function viewAppointment(Request $request, $id)
    {
        $apt = Appointment::where('id', $id)->first();

        /* tack how many time appointment is viewed by carer or pwd */
        if ($request->user()->pwd == 1) {
            $apt->pwd_count = $apt->pwd_count + 1;
            $apt->save();
        } else {
            $apt->carer_count = $apt->carer_count + 1;
            $apt->save();
        }
        $get_task = Task::where(['appointment_id' => $id, 'order' => '10'])->first();
        if (!isset($get_task)) $get_task = new Task;
        $getting_task = Task::where(['appointment_id' => $id, 'order' => '20'])->first();
        if (!isset($getting_task)) $getting_task = new Task;
        $after_task = Task::where(['appointment_id' => $id, 'order' => '30'])->first();
        if (!isset($after_task)) $after_task = new Task;

        if (isset($request->user()->currentTeam)) {
            $contacts =  $request->user()->currentTeam->contacts;
            $organisations =  $request->user()->currentTeam->organisations;
        }
        $newcontact = new Contact;
        // dd($appointment);
        return view('view-appointment', compact('apt', 'contacts', 'organisations', 'get_task', 'getting_task', 'after_task', 'newcontact'));
    }

    public function viewTask(Request $request, $id)
    {
        $task = Task::where('id', $id)->first();
        if (isset($request->user()->currentTeam)) {
            $contacts =  $request->user()->currentTeam->contacts;
            $organisations =  $request->user()->currentTeam->organisations;
        }
        return view('view-task', compact('task', 'contacts', 'organisations'));
    }

    /**
     * Add the Appointment.
     *
     * @return Response
     */
    public function addAppointment(Request $request)
    {
      
        // dd($date);
        $newcontact = new Contact;
        if (isset($request->user()->currentTeam)) {
            $contacts =  $request->user()->currentTeam->contacts;
            $organisations =  $request->user()->currentTeam->organisations;
        }

        return view('appointment')->with(compact('contacts', 'organisations', 'newcontact'));
    }

     /**
     * Destroy the given appointment.
     *
     * @param  Request  $request
     * @param  contact  $contact
     * @return Response
     */
    public function deleteAppointment(Request $request)
    {
        // dd($request->all());
        Appointment::destroy($request->id);
        return redirect('/home');
    }


    public function updateTask(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'start_date' => 'required_with:title',
        ]);
        $this->a_start = Carbon::createFromTimestamp(strtotime($request->start_date . " " . $request->start_time));
        $this->a_end = Carbon::createFromTimestamp(strtotime($request->end_date . " " . $request->end_time));
        // dd($this->a_start);
        if ($this->a_end->lt($this->a_start)) {
            $this->a_end = clone $this->a_start;
        }
        $task = Task::find($id);
        $task->title = $request->title;
        $task->contact_id = $request->contact_id;
        $task->organisation_id = $request->organisation_id;
        $task->start_date = $this->a_start;
        $task->end_date = $this->a_end;
        $task->send_sms = ($request->send_sms == "on") ? true : false;
        $task->address = $request->address;
        $task->detail = $request->detail;
        $task->save();
        $request->session()->flash('alert-success', 'Task successfully updated!');
        return  redirect('home');
    }
    public function deleteTask(Request $request)
    {
        // dd($request->all());
        Task::destroy($request->id);
        return redirect('/home');
    }

}
