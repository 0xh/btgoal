<?php

namespace App\Providers;

use Laravel\Spark\Spark;
use Laravel\Spark\Providers\AppServiceProvider as ServiceProvider;
use Carbon\Carbon;

class SparkServiceProvider extends ServiceProvider
{
    /**
     * Your application and company details.
     *
     * @var array
     */
    protected $details = [
        'vendor' => 'Dynamic4',
        'product' => 'Better Goals',
        'street' => 'PO Box 111',
        'location' => 'Your Town, NY 12345',
        'phone' => '555-555-5555',
    ];


    /**
     * The address where customer support e-mails should be sent.
     *
     * @var string
     */
    protected $sendSupportEmailsTo = null;

    /**
     * All of the application developer e-mail addresses.
     *
     * @var array
     */
    protected $developers = [
        'asim@dynamic4.com'
    ];

    /**
     * Indicates if the application will expose an API.
     *
     * @var bool
     */
    protected $usesApi = true;

    /**
     * Finish configuring Spark for the application.
     *
     * @return void
     */
    public function booted()
    {
       
        Spark::afterLoginRedirectTo('home');
       
       Spark::useStripe()->noCardUpFront()->trialDays(200);
       Spark::useRoles([
            'carer' => 'Carer',
            'pwd' => 'PWD',
        ]);

        Spark::freePlan()
         
            ->features([
                'First', 'Second', 'Third'
            ]);

        // Spark::Plan('Basic', 'provider-id-1')
        //     ->price(10)
            
        //     ->features([
        //         'First', 'Second', 'Third'
        //     ]);

        /*
        Spark::createUsersWith(function ($request) {
            $user = Spark::user();

            $data = $request->all();
            $user->forceFill([
                'name' => $data['name'],
                'email' => $data['email'],
                'pwd' => 1,
                'password' => bcrypt($data['password']),
                'last_read_announcements_at' => Carbon::now(),
                'trial_ends_at' => Carbon::now()->addDays(Spark::trialDays()),
            ])->save();

            return $user;
        });*/
    }
}
