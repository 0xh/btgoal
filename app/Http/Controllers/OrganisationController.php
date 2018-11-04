<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Organisation;
class OrganisationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        // $this->middleware('subscribed');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $organisations =  $request->user()->currentTeam->organisations;
        // dd($organisations);
        return view('organisations')->with(compact('organisations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $organisation = new Organisation;
        // dd($contact);
        return view('add-organisation')->with(compact('organisation'));
        // return view('add-contact');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'name' => 'required|max:250',
            'address' => 'required|max:250',
            'email' => 'email',
            'website'  => ['regex:/^((?:https?\:\/\/|www\.)(?:[-a-z0-9]+\.)*[-a-z0-9]+.*)$/'],
        ]);

        if ($request->photolink == null) {
            $request->photolink = '/img/icon-with.svg';
        }

        // TO DO:: Fill with TEAM ID and then save whole contact
        // dd($request);
        Organisation::create([
            'team_id' => $request->user()->currentTeam->id,
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'website' => $request->website,
            'photo' => $request->photolink
        ]);
        if (isset($request->from_mobile)) {
            return  redirect('mobile/places');
        } else {
            return redirect('contacts');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $organisation = Organisation::find($id);
        // dd($organisation);
        return view('add-organisation')->with(compact('organisation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
         $this->validate($request, [
            'name' => 'required|max:250',
            'address' => 'required|max:250',
            'email' => 'email',
            'website'  => ['regex:/^((?:https?\:\/\/|www\.)(?:[-a-z0-9]+\.)*[-a-z0-9]+.*)$/'],
        ]);

        $team_id = $request->user()->currentTeam->id;
        $contact = Organisation::where([['id', $id], ['team_id', $team_id]])->first();
        $contact->name = $request->name;
        $contact->phone = $request->phone;
        $contact->email = $request->email;
        $contact->address = $request->address;
        $contact->website = $request->website;
        if ($request->photolink) {
            $contact->photo = $request->photolink;
        }
        $contact->save();
        if (isset($request->from_mobile)) {
            return  redirect('mobile/places');
        } else {
            return redirect('contacts');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //
        $team_id = $request->user()->currentTeam->id;
        $contact = Organisation::where([['id', $id], ['team_id', $team_id]])->first();
        $contact->delete();
        return redirect('contacts');
    }
}
