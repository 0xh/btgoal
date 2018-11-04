<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;
use Intervention\Image\Facades\Image;

class ContactController extends Controller
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
        if (isset($request->user()->currentTeam)) {
            $person =  $request->user()->currentTeam->contacts;
            $org =  $request->user()->currentTeam->organisations;
            $contacts = collect([$person, $org])->collapse()->sortBy('name');
        } else {
            return redirect('welcome');
        }
        return view('contacts')->with(compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $contact = new Contact;
        // dd($contact);
        return view('add-contact')->with(compact('contact'));
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
        $this->validate($request, [
            'name' => 'required|max:250',
            'email' => 'email',
            'phone' => 'required'
        ]);

        if ($request->photolink == null) {
            $request->photolink = '/img/icon-with.svg';
        }
        // TO DO:: Fill with TEAM ID and then save whole contact
        // dd($request);
        Contact::create([
            'team_id' => $request->user()->currentTeam->id,
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'organisation' => $request->organisation,
            'photo' => $request->photolink
        ]);

        if (isset($request->from_mobile)) {
            return  redirect('mobile/people');
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
        $contact = Contact::find($id);
        // dd($contact);
        return view('add-contact')->with(compact('contact'));
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
            'email' => 'email',
        ]);
        $team_id = $request->user()->currentTeam->id;
        $contact = Contact::where([['id', $id], ['team_id', $team_id]])->first();
        $contact->name = $request->name;
        $contact->phone = $request->phone;
        $contact->email = $request->email;
        $contact->address = $request->address;
        $contact->organisation = $request->organisation;
        if ($request->photolink) {
            $contact->photo = $request->photolink;
        }
        $contact->save();
        if (isset($request->from_mobile)) {
            return  redirect('mobile/people');
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
        $contact = Contact::where([['id', $id], ['team_id', $team_id]])->first();
        $contact->delete();
        return redirect('contacts');
    }
}