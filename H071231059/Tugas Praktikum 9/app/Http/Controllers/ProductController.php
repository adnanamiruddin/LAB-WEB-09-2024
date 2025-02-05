<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categoryId = $request->get('category_id');
        $categories = Category::all();

        $products = $categoryId
            ? Product::where('category_id', $categoryId)->with('category')->get()
            : Product::with('category')->get();

        return view('product.index', [
            'products' => $products,
            'categories' => $categories,
            'selectedCategory' => $categoryId
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('product.createProduct', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Session::flash('name', $request->name);
        Session::flash('category_id', $request->category_id);
        Session::flash('description', $request->description);
        Session::flash('price', $request->price);
        Session::flash('stock', $request->stock);

        $request->validate([
            'name' => 'required',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ], [
            'name.required' => 'Name must be filled!',
            'category_id.required' => 'Category must be filled!',
            'category_id.exists:categories,id' => 'Category must be filled!',
            'description.required' => 'Description must be filled!',
            'price.required' => 'Price must be filled!',
            'stock.required' => 'Stock must be filled!',
        ]);

        $data = [
            'name' => $request->name,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
        ];

        Product::create($data);
        return redirect()->to('/product')->with('success', 'Product data is successfully created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::where('id', $id)->first();
        return view('product.detailproduct', [
            'product' => $product,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {

        $product = Product::where('id', $id)->first();
        // return view('product.editproduct', [
        //     'product' => $product,
        // ]);

        $categories = Category::all();
    
        return view('product.editProduct', [
            'product' => $product,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required',
            'price' => 'required',
            'stock' => 'required',
        ], [
            'name.required' => 'Name must be filled!',
            'category_id.required' => 'Category must be filled!',
            'category_id.exists:categories,id' => 'Category must be filled!',
            'description.required' => 'Description must be filled!',
            'price.required' => 'Price must be filled!',
            'stock.required' => 'Stock must be filled!',
        ]);

        $data = [
            'name' => $request->name,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
        ];

        Product::where('id', $id)->update($data);
        return redirect()->to('/product')->with('success', 'Product Data is successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Product::where('id', $id)->delete();
        return redirect()->to('/product')->with('success', 'Product Data is successfully deleted!');
    }
}
