<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

class BgLoginController extends \Laravel\Spark\Http\Controllers\Auth\LoginController
 {
   public function authenticated(Request $request, $user)
   {
    /**
     * @var $user User
     * Set some logic here of your own for new redirect location
     */
    if ($user->currentTeam) {
        if ($user->roleOn($user->currentTeam) === 'pwd') {
            $this->redirectTo = '/mobile-home';
        } else {
            $this->redirectTo = '/settings';
        }
    } else {
         $this->redirectTo = '/welcome';
    }
    
    return parent::authenticated($request, $user);
  }
}