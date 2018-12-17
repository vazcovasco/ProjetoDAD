<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PhotoControllerAPI extends Controller
{
    public function upload(Request $request)
    {
        if($request->hasFile('photo')) {
            $filename = basename($request->file('file')->store('public/profiles'));
        }
        return false;
    }
}
