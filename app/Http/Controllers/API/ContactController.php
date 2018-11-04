<?php

namespace App\Http\Controllers\API;
use App\Contact;
use App\Organisation;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ContactController extends Controller
{
    public function uploadPhoto(Request $request)
    {
        //
        $this->validate($request, [
            'photo' => 'image|max:5048',
        ]);

        $file = '/img/icon-with.svg';
        if ($request->file('photo')) {
            $file = $request->file('photo')->store('/public/contact');
            Image::make($file)->fit(300,300, function ($constraint) {
                $constraint->aspectRatio();
            })->save( public_path($file) );
            $file = '/'.$file;
        }
        return $file;
    }
}
