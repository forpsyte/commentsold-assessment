<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class InventoriesController extends Controller
{
    /**
     * @return \Inertia\Response
     */
    public function index()
    {
        $filter = Request::only(['search', 'quantity', 'threshold']);
        return Inertia::render('Inventories/Index',[
            'count' => Auth::user()->inventories()->filter($filter)->count(),
            'filters' => Request::all(['search', 'quantity', 'threshold']),
            'inventories' => Auth::user()->inventories()
                ->filter($filter)
                ->paginate(10)
                ->withQueryString()
                ->through(function($inventory){
                    return [
                        'id' => $inventory->id,
                        'name' => $inventory->product->product_name,
                        'sku' => $inventory->sku,
                        'quantity' => $inventory->quantity,
                        'color' => $inventory->color,
                        'size' => $inventory->size,
                        'price' => $inventory->price_cents,
                        'cost' => $inventory->cost_cents
                    ];
                })
        ]);
    }
}
