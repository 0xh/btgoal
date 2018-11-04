<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Note;
use App\Photo;
use Illuminate\Http\Request;

class DairyController extends Controller
{
    /**
     * Get all of the photos related to appointment.
     *
     * @return Response
     */
    public function getPhotos(Request $request, $id)
    {
        return Photo::where('appointment_id', $id)->get();
        
    }

    /**
     * Create a new Note.
     *
     * @return Response
     */
    public function postNote(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);
        return Category::create(['name' => $request->name]);
   
    }

    public function updateNote(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);
        $category = Category::find($request->id);
        $category->name = $request->name;
        $category->save();
        return $category;
    }

    /**
     * Destroy the given Category.
     *
     * @param  Request  $request
     * @param  Category  $category
     * @return Response
     */
    public function deleteNote(Request $request, $id)
    {
        return Note::destroy($id);
    }


    /**
     * Create a new Photo.
     *
     * @return Response

     */
    public function postPhoto(Request $request, $id)
    {
        

        $team_id = $request->user()->currentTeam->id;

        $imageData = $request->photo;
        list($type, $imageData) = explode(';', $imageData);
        list(,$extension) = explode('/',$type);
        list(,$imageData)      = explode(',', $imageData);
        $fileName = uniqid().'.'.$extension;
        $imageData = base64_decode($imageData);
        $filePath = storage_path('app/public/photo/'. $fileName);
        file_put_contents($filePath, $imageData);
    
        return Photo::create([
            'photo' => $fileName,
            'appointment_id' => $id,
            'team_id' => $team_id
            ]);
   
    }
}


