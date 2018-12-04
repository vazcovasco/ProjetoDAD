<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;
use App\Http\Resources\Item as ItemResource;

class ItemControllerAPI extends Controller
{
    public function getItems(Request $request)
    {
        return Item::all();
        
    }
}
