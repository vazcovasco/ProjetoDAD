<?php

namespace App\Http\Controllers;


use App\Invoice;
use App\Meals;
use Illuminate\Http\Request;
use App\Http\Resources\Invoice as InvoiceResource;
use DB;


class InvoiceControllerAPI extends Controller
{
    public function getInvoices(Request $request)
    {
        $invoices = DB::table('invoices')
            ->join('meals', 'invoices.meal_id', '=', 'meals.id')
            ->select('invoices.name', 'invoices.meal_id', 'invoices.total_price', 'meals.table_number','invoices.date','invoices.id')
            ->get();

        return $invoices;

    }
    public function showInvoice(Request $request, $id){
               $items = Invoice::findOrFail($id);

        $items = DB::table('invoice_items')
            ->join('items', 'invoice_items.item_id', '=', 'items.id')
            ->select('invoice_items.quantity', 'invoice_items.unit_price', 'invoice_items.sub_total_price', 'items.name')
            ->where('invoice_items.invoice_id', $id)
            ->get();

         return $items;

    }
}
