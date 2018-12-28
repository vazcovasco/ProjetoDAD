<?php

namespace App\Http\Controllers;

use App\Meal;
use Illuminate\Http\Request;
use App\Http\Resources\Meal as MealResource;
use SebastianBergmann\Environment\Console;

class MealControllerAPI extends Controller
{
    public function getMeals(Request $request)
    {
        return Meal::all();
        
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
