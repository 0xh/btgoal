<?php

namespace App\Console;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];
    
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $tz = env('BG_TIMEZONE', 'Australia/Sydney');
            $appointments = \App\Appointment::whereBetween('start_date', 
                [Carbon::now($tz)->subMinutes(5), Carbon::now($tz)])->get();
            foreach ($appointments as $appointment) {
                // Get first PWD from Team, if there are more PWDs in a team then they are ignored. 
                $pwd = $this->get_pwd($appointment->team_id);
                $this->send_sms($appointment, $pwd, 'A');
            }
            // Repeat same for Tasks
            $tasks = \App\Task::whereBetween('start_date', 
                [Carbon::now($tz)->subMinutes(5), Carbon::now($tz)])->get();
            foreach ($tasks as $task) {
                // Get first PWD from Team, if there are more PWDs in a team then they are ignored. 
                $pwd = $this->get_pwd($task->team_id);
                $this->send_sms($task, $pwd, 'T');
            }
            
        })->everyFiveMinutes();

        //Perform daily backup
        $schedule->command('backup:clean')->daily()->at('01:00');
        $schedule->command('backup:run')->daily()->at('02:00');

    }

    // GET PWD from Team ID

    private function get_pwd($team_id) {
        $pwd_id = DB::table('team_users')->select('user_id')
            ->where([['team_id', '=', $team_id],['role', '=', 'pwd'],])->first();
        return \App\User::find($pwd_id->user_id);
    }

    /**** 
        Send SMS using OpenMarket API
    ***/
    private function send_sms($appointment, $pwd, $type) {
        if ($appointment->send_sms) {
            $client = new Client([
                'headers' => [ 
                    'Content-Type' => 'application/json; charset=UTF-8', 
                    'Authorization' => 'Basic MDAwLTAwMC0xMTQtMjM3NTI6UDlnKldqeD8uVw==', ]
            ]);
            if ($type == 'A') {
                $content = $appointment->start_date->format('g:ia '). " " . substr($appointment->title, 0, 113) . ".. " . url('apt/' . $appointment->id);
            } else {
                $content = $appointment->start_date->format('g:ia '). " " . substr($appointment->title, 0, 113) . ".. " . url('tsk/' . $appointment->id);
            }
            
            $body['mobileTerminate']['interaction'] = "one-way";
            $body['mobileTerminate']['source']['address'] = "bettergoals";
            $body['mobileTerminate']['source']['ton'] = "5";
            $body['mobileTerminate']['destination']['address'] = $pwd->phone;
            $body['mobileTerminate']['message']['content'] = $content;
            $body['mobileTerminate']['message']['type'] = "text";

            $response = $client->post('https://smsc.openmarket.com:443/sms/v4/mt',
                ['body' => json_encode($body)]
            );
            $code = $response->getStatusCode();
            $request_id = $response->getHeader('Location');
            Log::debug($content);
            Log::debug($request_id);
        }
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
