<?php

namespace App\Http\Controllers;

use App\Http\Resources\Order as OrderResource;
use App\Http\Resources\User as UserResource;
use Illuminate\Support\Facades\DB;

use App\Order;
use App\Meal;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class OrderControllerAPI extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getOrders(Request $request, $id)
    {
        $orders = DB::table('orders')
            ->select('orders.id', 'orders.state', 'orders.item_id', 'orders.responsible_cook_id' ,'orders.meal_id','orders.start','orders.end','orders.created_at','orders.updated_at')
            ->join('users', 'orders.responsible_cook_id', '=', 'users.id')
            ->where('orders.responsible_cook_id', $id)
            ->get();
        return $orders;
        /*$orders = DB::table('orders')
            ->select('orders.id', 'orders.state', 'orders.item_id', 'orders.responsible_cook_id' ,'orders.meal_id','orders.start','orders.end','orders.created_at','orders.updated_at')
            ->join('users', 'orders.responsible_cook_id', '=', 'users.id')
            ->where([
                ['orders.responsible_cook_id', null],
                ['orders.state', 'pending'],
            ])
            ->orWhere('orders.responsible_cook_id', $id)
            ->orderBy('state', 'DESC')
            ->orderBy('start', 'ASC')
            ->get();
        return $orders;*/
    }
    //para os waiters
    public function getOrdersWaiter(Request $request, $id)
    {
        $orders = DB::table('orders')
            ->select('orders.id', 'orders.state', 'orders.item_id', 'orders.responsible_cook_id' ,'orders.meal_id','orders.start','orders.end','orders.created_at','orders.updated_at')
            ->join('users', 'orders.responsible_cook_id', '=', 'users.id')
            ->join('meals', 'orders.meal_id', '=', 'meals.id')
            ->where([
                ['meals.responsible_waiter_id', $id],
                ['meals.state', 'active'],
                ['meals.id', '=', 'orders.meal_id'],
                ['orders.state', 'pending']
            ])
            ->orWhere([
                ['meals.responsible_waiter_id', $id],
                ['meals.state', 'active'],
                ['meals.id', '=', 'orders.meal_id'],
                ['orders.state', 'confirmed']
            ])
            ->orWhere([
                ['meals.responsible_waiter_id', $id],
                ['meals.state', 'active'],
                ['meals.id', '=', 'orders.meal_id'],
                ['orders.state', 'prepared']
            ])
            ->orderBy('state', 'DESC')
            ->orderBy('start', 'ASC')
            ->get();
        return $orders;
    }

    public function add(Request $request)
    {
        $current = Carbon::now();
        $order = new Order();
        $order->id = null;
        $order->state = 'pending';
        $order->item_id = null;
        $order->meal_id= null;
        $order->responsible_cook_id = null;
        $order->start = $current;
        $order->end = null;
        $order->created_at = $current;
        $order->updated_at = $current;
        $order->fill($request->all());
        $order->save();
        return response()->json($order, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function setState($id)
    {
        $order = order::findOrFail($id);
        if($order->state === 'confirmed'){
            $order->state = 'in preparation';
        } else if ($order->state === 'in preparation') {
            $order->state = 'prepared';
        } else if ($order->state === 'prepared') {
            $order->state = 'delivered';
        } else if ($order->state === 'delivered') {
            $order->state = 'confirmed';
        }
        $order->save();
        return response()->json($order,200);
    }
    public function confirmOrder($id)
    {
        $order = order::findOrFail($id);
        if($order->state === 'pending'){
            $order->state = 'confirmed';
        }
        $order->save();
        return response()->json($order,200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $order = Order::findOrFail($id);
        $order->update($request->all());
        return new OrderResource($order);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return response()->json(null, 204);
    }

    public function getOrdersByDay(User $user){

        $data['user']['id'] = $user->id;
        $data['user']['name'] = $user->name;
        $data['user']['type'] = $user->type;


        if($user->type == 'cook')
        {
            $data['data'] = Order::where('responsible_cook_id', $user->id)
                ->groupBy(DB::raw('DATE(start)'))
                ->select(DB::raw('DATE(start) as date'), DB::raw('count(*) as orders'))
                ->get();
        }
        else if($user->type == 'waiter'){

            $mealIds = Meal::where('responsible_waiter_id', $user->id)
                ->pluck('id');

            $data['data'] = Order::whereIn('meal_id', $mealIds)
                ->groupBy(DB::raw('DATE(start)'))
                ->select(DB::raw('DATE(start) as date'), DB::raw('count(*) as orders'))
                ->get();

        }

        $sum = 0;

        foreach ($data['data'] as $day)
        {
            $sum +=$day['orders'];
        }

        //days when the restaurant was open
        $daysOpen = Meal::select(DB::raw('count(distinct(DATE(start))) as days'))->first()->days;
        $data['user']['performance'] = $sum / $daysOpen;


        return $data;


    }
}
