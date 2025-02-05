<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index(): View
    {
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->product->name,
                    'price' => $item->product->price,
                    'quantity' => $item->quantity,
                    'image_url' => $item->product->image_url
                ];
            });

        $total = $cartItems->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);

        $existingCartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        $requestedQuantity = $request->quantity;
        $currentCartQuantity = $existingCartItem ? $existingCartItem->quantity : 0;

        // Cek apakah quantity yang diminta melebihi stok yang tersedia + quantity di cart
        if ($requestedQuantity > ($product->stock + $currentCartQuantity)) {
            return redirect()->back()
                ->with('error', 'Stok tidak mencukupi. Hanya tersedia ' . ($product->stock + $currentCartQuantity) . ' barang.');
        }

        if ($existingCartItem) {
            $existingCartItem->quantity += $requestedQuantity;
            $existingCartItem->save();
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $requestedQuantity
            ]);
        }

        // Update stok produk
        $product->stock -= $requestedQuantity;
        $product->save();

        return redirect()->route('cart.index')
            ->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function destroy($id): RedirectResponse
    {
        $cartItem = Cart::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $product = Product::findOrFail($cartItem->product_id);
        $product->stock += $cartItem->quantity;
        $product->save();

        $cartItem->delete();

        return redirect()->route('cart.index')
            ->with('success', 'Produk berhasil dihapus dari keranjang dan stok dikembalikan!');
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cartItem = Cart::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $product = Product::findOrFail($cartItem->product_id);
        $oldQuantity = $cartItem->quantity;
        $newQuantity = $request->quantity;
        $stockDifference = $oldQuantity - $newQuantity;

        if ($newQuantity > ($product->stock + $oldQuantity)) {
            return back()->with('error', 'Stok tidak mencukupi. Hanya tersedia ' . ($product->stock + $oldQuantity) . ' barang.');
        }

        $product->stock += $stockDifference;
        $product->save();

        $cartItem->quantity = $newQuantity;
        $cartItem->save();

        return redirect()->route('cart.index')
            ->with('success', 'Keranjang berhasil diperbarui!');
    }

    public function clear(): RedirectResponse
    {
        $cartItems = Cart::where('user_id', Auth::id())->get();

        foreach ($cartItems as $cartItem) {
            $product = Product::findOrFail($cartItem->product_id);
            $product->stock += $cartItem->quantity;
            $product->save();
        }

        Cart::where('user_id', Auth::id())->delete();

        return redirect()->route('cart.index')
            ->with('success', 'Keranjang berhasil dikosongkan dan stok dikembalikan!');
    }
}
