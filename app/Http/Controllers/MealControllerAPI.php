<?php

namespace App\Http\Controllers;

use App\Meal;
use Illuminate\Http\Request;
use App\Http\Resources\Meal as MealResource;

class MealControllerAPI extends Controller
{
    public function getMeals(Request $request)
    {
        return Meal::all();
        
    }
}
