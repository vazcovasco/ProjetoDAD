<?php

namespace App\Http\Controllers;

use App\RestaurantTable;
use Illuminate\Http\Request;
use DB;

class RestaurantTableControllerAPI extends Controller
{
    public function getRestaurantTables(Request $request)
    {
        $tableNumbersNotAvailable = DB::table('meals')
            ->where('meals.state', '=', 'active')
            ->pluck('meals.table_number');

        $tableNumbersAvailable = DB::table('restaurant_tables')
            ->whereNotIn('restaurant_tables.table_number', $tableNumbersNotAvailable)
            ->pluck('restaurant_tables.table_number');

        return $tableNumbersAvailable;

    }
}
