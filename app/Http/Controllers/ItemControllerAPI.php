<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;
use App\Http\Resources\Item as ItemResource;

use Illuminate\Support\Facades\DB;


class ItemControllerAPI extends Controller
{
    public function getItems(Request $request)
    {
        return Item::withTrashed()->get();

    }
    public function add(Request $request)
    {
        $item = new Item();
        $item->fill($request->all());
        $item->photo_url= "dsfds";
        $item->save();

        return response()->json($item,200);
    }

    public function edit(Request $request)
    {
        $id = $request->query('id');
        $item = Item::findOrFail($id);
        $item->update($request->all());
        return response()->json($item,200);
    }
    public function destroy(Request $request)
    {
        $id = $request->query('id');

        $item = Item::withTrashed()->findOrFail($id);

        $orders = DB::table('orders')
            ->where('orders.item_id', $id)
            ->count();


        $invoice_items = DB::table('invoice_items')
            ->where('invoice_items.item_id', $id)
            ->count();

        if($orders != 0 or $invoice_items!=0){
            $item->delete();
        }else{
            $item->forceDelete();
        }

        return response()->json(null, 204);

    }
    public function restoreDestroy($id)
    {
        Item::withTrashed()->find($id)->restore();

        return response()->json(null, 204);;
    }
}
