<?php

namespace App\Http\Controllers;

use App\Http\Resources\Order as OrderResource;

use App\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OrderControllerAPI extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getOrders()
    {
        return Order::all();
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
        $order->updated_at = $created_at;
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
            $order->state = 'in preperation';
        } else if ($order->state === 'in preperation') {
            $order->state = 'prepared';
        } else if ($order->state === 'prepared') {
            $order->state = 'delivered';
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
}
