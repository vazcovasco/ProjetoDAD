<?php

namespace App\Http\Controllers;

use App\Meal;
use App\User;
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


    public function showInvoice(Request $request, $id){
        $meals = Meal::findOrFail($id);


        $meals = DB::table('orders')
            ->join('items', 'items.id', '=', 'orders.item_id')
            ->join('meals', 'meals.id', '=', 'orders.meal_id')
            ->select('meals.table_number', 'meals.total_price_preview', 'items.name', 'items.price')
            ->where('meals.id', $id)
            ->get();

       return $meals;

    }
    public function getMealsByDay(User $user){

        $data['user']['id'] = $user->id;
        $data['user']['name'] = $user->name;
            $data['user']['type'] = $user->type;


        if($user->type == 'waiter'){

            $mealIds = Meal::where('responsible_waiter_id', $user->id)
                ->pluck('id');

            $data['data'] = Meal::whereIn('id', $mealIds)
                ->groupBy(DB::raw('DATE(start)'))
                ->select(DB::raw('DATE(start) as date'), DB::raw('count(*) as meals'))
                ->get();

        }

        $sum = 0;

        foreach ($data['data'] as $day)
        {
            $sum +=$day['meals'];
        }

        //days when the restaurant was open
        $daysOpen = Meal::select(DB::raw('count(distinct(DATE(start))) as days'))->first()->days;
        $data['user']['performance'] = $sum / $daysOpen;


        return $data;


    }



}