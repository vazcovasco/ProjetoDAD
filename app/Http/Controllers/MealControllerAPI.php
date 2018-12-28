<?php

namespace App\Http\Controllers;

use App\Meal;
use Illuminate\Http\Request;
use App\Http\Resources\Meal as MealResource;
use SebastianBergmann\Environment\Console;
use DB;

class MealControllerAPI extends Controller
{
    public function getMeals(Request $request)
    {
        return Meal::all();

    }
    public function add(Request $request)
    {
        $meal = new Meal();
        $meal->fill($request->all());
        $meal->state ="active";
        $mytime = Carbon\Carbon::now();
        $meal->start = $mytime->toDateTimeString();
        $meal->save();
        return response()->json($meal, 200);
    }
    public function showMeal(Request $request, $id){
        $meals = Meal::findOrFail($id);

        $meals = DB::table('orders')
            ->join('items', 'items.id', '=', 'orders.item_id')
            ->join('meals', 'meals.id', '=', 'orders.meal_id')
            ->select('meals.table_number', 'meals.total_price_preview', 'items.name', 'items.price')
            ->where('meals.id', $id)
            ->get();

        return $meals;

    }
    public function getMealWaiterPerDay(Request $request)
    {
        $waiter_meals=DB::table('meals')
            ->select(DB::raw('count(*) as count, HOUR(start) as hour'))
            ->whereDate('start', '=', Carbon::now()->toDateString())
            ->groupBy('hour')
            ->get();
        return $waiter_meals;

    }


    public function showInvoice(Request $request, $id){
        $meals = Meal::findOrFail($id);

        $meals = DB::table('invoice_items')
            ->join('items', 'invoice_items.item_id', '=', 'items.id')
            ->select('invoice_items.quantity', 'invoice_items.unit_price', 'invoice_items.sub_total_price', 'items.name')
            ->where('invoice_items.invoice_id', $id)
            ->get();

        return $meals;

    }

      
}