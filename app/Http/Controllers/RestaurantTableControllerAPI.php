<?php

namespace App\Http\Controllers;

use App\RestaurantTable;
use Illuminate\Http\Request;
use DB;

class RestaurantTableControllerAPI extends Controller
{
    public function getRestaurantTables(Request $request)
    {
        $restaurant_tables = DB::table('restaurant_tables')

            ->select('restaurant_tables.table_number')
            ->join('meals', 'restaurant_tables.table_number', '=', 'meals.table_number')
            ->where('meals.state','=', 'active')
            ->orderBy('restaurant_tables.table_number', 'asc')
            ->distinct()
            ->get();

        return $restaurant_tables;

    }
}
