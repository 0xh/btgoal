<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileDetailsController extends Controller
{

    /**
     * Update the user's profile details.
     *
     * @return Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,'.$request->user()->id,
            'phone' => 'required',
        ]);

        $request->user()->forceFill([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone
        ])->save();
    }

    public function updateAboutMe(Request $request)
    {
        var_dump($request);
    }
}