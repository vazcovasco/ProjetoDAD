<?php

namespace App\Http\Controllers;

use App\RestaurantTable;
use Illuminate\Http\Request;
use DB;
use App\Http\Resources\RestaurantTable as RestaurantTableResource;
use Carbon\Carbon;

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
    public function getAllTables(Request $request)
    {
        $restaurant_tables = DB::table('restaurant_tables')
            ->select('restaurant_tables.table_number')
            ->orderBy('restaurant_tables.table_number', 'asc')
            ->get();

        return $restaurant_tables;

    }
    public function destroy(Request $request)
    {
        $tableNumber = $request->query('tableDelete');

        $table = RestaurantTable::withTrashed()->findOrFail($tableNumber);

        $meals = DB::table('meals')
            ->where('meals.responsible_waiter_id', $tableNumber)
            ->count();

        if($meals!=0){
            $table->delete();
        }else{
            $table->forceDelete();
        }

        return response()->json(null, 204);

    }

    public function restoreDestroy($table_number)
    {
        RestaurantTable::withTrashed()->findOrFail($table_number)->restore();

        return response()->json(null, 204);;
    }

    public function update(Request $request, RestaurantTable $table)
    {

        //validator a ver se se o novo numero não existe
        $request->validate([
            'table_number' => 'unique:restaurant_tables',
        ]);
        $table->table_number = $request->newTableNumber;
        $table->save();

        return response()->json($table,200);
    }

    public function showTable(Request $request, $id){
        $items = Invoice::findOrFail($id);

        $items = DB::table('invoice_items')
            ->join('items', 'invoice_items.item_id', '=', 'items.id')
            ->select('invoice_items.quantity', 'invoice_items.unit_price', 'invoice_items.sub_total_price', 'items.name')
            ->where('invoice_items.invoice_id', $id)
            ->get();

        return $items;
    }

    public function add(Request $request)
    {
        
        $restaurant_table = new RestaurantTable();
        $current = Carbon::now();
        $restaurant_table->created_at = $current;
        $restaurant_table->fill($request->all());
        $restaurant_table->save();
        return response()->json($restaurant_table, 200);
    }
}