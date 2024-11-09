<?php

namespace App\Http\Controllers;

use App\Models\InventoryLog;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class InventoryLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inventoryLogs = InventoryLog::all();
        return view('inventoryLog.index', [
            'inventoryLogs' => $inventoryLogs,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();
        return view('inventoryLog.createInventoryLog', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Session::flash('product_id', $request->product_id);
        Session::flash('type', $request->type);
        Session::flash('quantity', $request->quantity);
        Session::flash('date', $request->date);

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:sold,restock',
            'quantity' => 'required|integer|min:1',
            'date' => 'required',
        ], [
            'product_id.required' => 'Product ID must be filled!',
            'product_id.exists:products,id' => 'Product ID is not exist!',
            'type.required' => 'Type must be filled!',
            'type.in:sold,restock' => 'Type is not correct!',
            'quantity.required' => 'Quantity must be filled!',
            'quantity.min:1' => 'Quantity minimal is 1!',
            'date.required' => 'Date must be filled!',
        ]);

        $date = Carbon::createFromFormat('m/d/Y', $request->date)->format('Y-m-d');

        $product = Product::find($request->product_id);

        if($request->type === 'sold') {
            $product->stock -= $request->quantity;
        } elseif ($request->type === 'restock') {
            $product->stock += $request->quantity;
        }

        $product->save();

        $data = [
            'product_id' => $request->product_id,
            'type' => $request->type,
            'quantity' => $request->quantity,
            'date' => $date,
        ];
        InventoryLog::create($data);
        return redirect()->to('/inventorylog')->with('success', 'Inventory Log data is successfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        InventoryLog::where('id', $id)->delete();
        return redirect()->to('/inventorylog')->with('success', 'Inventory Log data is successfully deleted!');
    }
}
