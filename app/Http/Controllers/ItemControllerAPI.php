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
        $items = Item::withTrashed()->orderBy('id', 'DESC')->paginate(5);
        return response()->json($items);
    }
    public function getItemsAll(Request $request)
    {
        $items = Item::all();
        return $items;
       
    }
    public function add(Request $request)
    {
        $validation = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer',
            'description' => 'required|string',
        ]);

        $item = Item::create([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'photo_url' => $request->photo_url,
        ]);

        return new ItemResource($item);
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

    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $filename = $request->file->getClientOriginalName();

            return $request->file->storeAs('public/items', $filename);
        }
    }
}
