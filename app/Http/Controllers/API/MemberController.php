<?php

namespace App\Http\Controllers\API;
use App\Team;
use App\User;
use Laravel\Spark\Spark;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;


class MemberController extends Controller
{
    /**
     * Get all of the contacts associated with current team.
     *
     * @return Response
     */
    public function all(Request $request)
    {
    	// If there is currentTeam selected then return all contacts for that team
        $id = $request->user()->currentTeam->id;
        
    	if ($request->user()->currentTeam) {
		    return Team::find($id)->users()->get();
		}
    }

    /**
     * Create a new Contact.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        if ($request->user()->currentTeam) {
            $this->validate($request, [
                'name' => 'required|max:255',
                'email' => 'required|max:255',
                'phone' => 'required|max:14',
                'password' => 'required|max:255',
            ]);
            if ($request->emergency_carer) {
                $team = Team::find($request->user()->currentTeam->id);
                $carer_id = $team->owner_id;
                $carer = User::find($carer_id);
                $request->emergency_name = $carer->name;
                $request->emergency_phone = $carer->phone;
            }

            // TO DO:: Fill with TEAM ID and then save whole contact
            $user = Spark::user(); 
            $user->forceFill([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'emergency_name' => $request->emergency_name,
                'emergency_phone' => $request->emergency_phone,
                'pwd' => 1,
                'password' => bcrypt($request->password),
                'last_read_announcements_at' => Carbon::now(),
                'trial_ends_at' => Carbon::now()->addDays(Spark::trialDays()),
            ])->save();
            //Attach newly created user to Current Team
            $user->teams()->attach($request->user()->currentTeam->id, ['role' => 'pwd']);

            return $user;
        }
   
    }

    public function smsTest(Request $request)
    {
        $phone = str_replace('-', '', $request->phone);
        $phone = '61' . $phone;
        $client = new Client([
            'headers' => [ 
                'Content-Type' => 'application/json; charset=UTF-8', 
                'Authorization' => 'Basic MDAwLTAwMC0xMTQtMjM3NTI6UDlnKldqeD8uVw==', ]
        ]);

        $body['mobileTerminate']['interaction'] = "one-way";
        $body['mobileTerminate']['source']['address'] = "bettergoals";
        $body['mobileTerminate']['source']['ton'] = "5";
        $body['mobileTerminate']['destination']['address'] = $phone;
        $body['mobileTerminate']['message']['content'] = 'Welcome to Better Goals https://app.bettergoals.com.au/login';
        $body['mobileTerminate']['message']['type'] = "text";

        $response = $client->post('https://smsc.openmarket.com:443/sms/v4/mt',
            ['body' => json_encode($body)]
        );
        $code = $response->getStatusCode();
        $request_id = $response->getHeader('Location');
        Log::debug($content);
        Log::debug($request_id);
    }

    /**
     * Detach the given Team Member.
     *
     * @param  Request  $request
     * @param  Category  $category
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        $user = \App\User::find($id);
        $abc = $user->teams()->detach($request->user()->currentTeam->id);
        $user->delete();
        return $abc;
    }
}
