<?php

namespace App\Http\Controllers;

use App\Models\InventoryLog;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class InventoryLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = InventoryLog::with('product')->latest('date')->get();
        return view('inventory.index', [
            'logs' => $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();
        return view('inventory.create', [
            'products' => $products,
        ]);
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
            'product_id' => 'require d|exists:products,id',
            'type' => 'required|in:restock,sold',
            'quantity' => 'required|integer|min:1',
            'date' => 'required|date'
        ], [
            'product_id.required' => 'Produk harus dipilih!',
            'product_id.exists' => 'Produk tidak valid!',
            'type.required' => 'Tipe transaksi harus dipilih!',
            'type.in' => 'Tipe transaksi tidak valid!',
            'quantity.required' => 'Jumlah harus diisi!',
            'quantity.integer' => 'Jumlah harus berupa angka bulat!',
            'quantity.min' => 'Jumlah minimal 1!',
            'date.required' => 'Tanggal harus diisi!',
            'date.date' => 'Format tanggal tidak valid!',
        ]);

        $product = Product::findOrFail($request->product_id);
        

        if ($request->type === 'restock') {
            $newStock = $product->stock + $request->quantity;
        } else {
            $newStock = $product->stock - $request->quantity;
        }
        

        if ($newStock < 0) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi!')->withInput();
        }

    
        $data = [
            'product_id' => $request->product_id,
            'type' => $request->type,
            'quantity' => $request->quantity,
            'date' => $request->date,
        ];
        InventoryLog::create($data);
        
    
        $product->stock = $newStock;
        $product->save();
            
        return redirect()->to('/inventory')->with('success', 'Log inventori berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $log = InventoryLog::with('product')->where('id', $id)->first();
        return view('inventory.detail', [
            'log' => $log,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $log = InventoryLog::where('id', $id)->first();
        $products = Product::all();
        return view('inventory.edit', [
            'log' => $log,
            'products' => $products,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $log = InventoryLog::findOrFail($id);
        $product = $log->product;
        
        // Hitung stok setelah menghapus log
        if ($log->type === 'restock') {
            $newStock = $product->stock - $log->quantity;
        } else {
            $newStock = $product->stock + $log->quantity;
        }
        
        if ($newStock < 0) {
            return redirect()->back()
                ->with('error', 'Tidak dapat menghapus log: Akan mengakibatkan stok negatif!');
        }
        
        $product->stock = $newStock;
        $product->save();
        $log->delete();
            
        return redirect()->to('/inventory')->with('success', 'Log inventori berhasil dihapus!');
    }
}