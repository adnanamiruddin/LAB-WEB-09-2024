<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProductController extends Controller
{
    use AuthorizesRequests;

    public function index(): View
    {
        $products = Product::with('category')
            ->orderBy('created_at', 'desc')
            ->paginate(9);
        return view('products.index', compact('products'));
    }

    public function create(): View
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        Session::flash('category_id', $request->category_id);
        Session::flash('name', $request->name);
        Session::flash('description', $request->description);
        Session::flash('price', $request->price);
        Session::flash('stock', $request->stock);

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0'
        ], [
            'category_id.required' => 'Kategori harus dipilih!',
            'category_id.exists' => 'Kategori tidak valid!',
            'name.required' => 'Nama produk harus diisi!',
            'name.max' => 'Nama produk maksimal 255 karakter!',
            'price.required' => 'Harga harus diisi!',
            'price.numeric' => 'Harga harus berupa angka!',
            'price.min' => 'Harga tidak boleh kurang dari 0!',
            'stock.required' => 'Stok harus diisi!',
            'stock.integer' => 'Stok harus berupa angka bulat!',
            'stock.min' => 'Stok tidak boleh kurang dari 0!'
        ]);

        Product::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock
        ]);

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    public function show(string $id): View
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }

    public function edit(string $id): View
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0'
        ]);

        $product = Product::findOrFail($id);
        $product->update($request->all());

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(string $id): RedirectResponse
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }

    public function addToCart(Request $request): RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu untuk menambahkan produk ke keranjang.');
        }

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
}
