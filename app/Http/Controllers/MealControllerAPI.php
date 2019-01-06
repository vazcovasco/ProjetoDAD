<?php

namespace App\Http\Controllers;

use App\Meal;
use App\User;
use Illuminate\Http\Request;
use App\Http\Resources\Meal as MealResource;
use SebastianBergmann\Environment\Console;
use DB;
use Carbon\Carbon;

class MealControllerAPI extends Controller
{
    public function get()
    {
        return Meal::all();

    }
    public function getMeals(Request $request, $id)
    {
        //return Meal::all();
        $meals = DB::table('meals')
            ->select('meals.*')
            ->where('meals.responsible_waiter_id', $id)
            ->get();
        return $meals;

    }
    public function getMyActiveMeals(Request $request, $id)
    {
       // $orderId = Order::where('order_id', $id);
        
        $meals = DB::table('meals')
            ->select('meals.*')
            ->where([
                ['meals.responsible_waiter_id', $id],
                ['meals.state', 'active'],
            ])
            ->get();
        return $meals;

    }
    public function add(Request $request)
    {
        /*
        $request->validate([
            'table_number' => 'unique',
        ]);*/

        $meal = new Meal();

        $meal->state = "active";
        $meal->start = Carbon::now();
        $meal->fill($request->all());
        $meal->save();

        return response()->json($meal, 200);
    }
    public function showMeal(Request $request, $id)
    {
        $meals = Meal::findOrFail($id);

        $meals = DB::table('orders')
            ->join('items', 'items.id', '=', 'orders.item_id')
            ->join('meals', 'meals.id', '=', 'orders.meal_id')
            ->select('meals.table_number', 'meals.total_price_preview', 'items.name', 'items.price')
            ->where('meals.id', $id)
            ->get();

        return $meals;

    }


    public function showInvoice(Request $request, $id)
    {
        $meals = Meal::findOrFail($id);


        return $meals;

    }

    public function getMeal(Request $request, $id)
    {
        //return Meal::all();
        $meals = DB::table('meals')
            ->join('restaurant_tables', 'meals.table_number', '=', 'restaurant_tables.table_number')
            ->select('meals.*')
            ->where('meals.table_number', $id)
            ->get();
        return $meals;

    }
    public function getMealsByDay(User $user)
    {

        $data['user']['id'] = $user->id;
        $data['user']['name'] = $user->name;
        $data['user']['type'] = $user->type;


        if ($user->type == 'waiter') {

            $mealIds = Meal::where('responsible_waiter_id', $user->id)
                ->pluck('id');

            $data['data'] = Meal::whereIn('id', $mealIds)
                ->groupBy(DB::raw('DATE(start)'))
                ->select(DB::raw('DATE(start) as date'), DB::raw('count(*) as meals'))
                ->get();

        }

        $sum = 0;

        foreach ($data['data'] as $day) {
            $sum += $day['meals'];
        }

    //days when the restaurant was open
        $daysOpen = Meal::select(DB::raw('count(distinct(DATE(start))) as days'))->first()->days;
        $data['user']['performance'] = $sum / $daysOpen;


        return $data;


    }

    public function getMealsByMonth()
    {
        $monthsOpen = Meal::select(DB::raw('count(distinct(EXTRACT(MONTH FROM start))) as months'))->first()->months;
        $cenas = Meal::all()->count() / $monthsOpen;
        $divisao = $cenas / $monthsOpen;

        return $divisao;

    }
    public function getMealAverageTime()
    {
        $meals = Meal::select(DB::raw('SEC_TO_TIME(AVG(TIME_TO_SEC(TIMEDIFF(meals.end,meals.start)))) as Meals'))
            ->get();



        return $meals;
    }

       /* $data['user']['id'] = $user->id;
        $data['user']['name'] = $user->name;
        $data['user']['type'] = $user->type;

        $data['data'] = Meal::groupBy(DB::raw('EXTRACT(MONTH FROM start)'))
                ->select(DB::raw('EXTRACT(MONTH FROM start) as date'), DB::raw('count(*) as meals'))
                ->get();



        $sum = 0;

        foreach ($data['data'] as $month)
        {
            $sum +=$month['meals'];
        }

        //days when the restaurant was open
        $monthsOpen = Meal::select(DB::raw('count(distinct(EXTRACT(MONTH FROM start))) as months'))->first()->months;
        $data['user']['performance'] = $sum / $monthsOpen;


        return $data;
     */






}