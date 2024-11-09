<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Ramsey\Uuid\Type\Integer;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Category::all();
        return view('category.index', [
            'categories' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('category.createCategory');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Session::flash('name', $request->name);
        Session::flash('description', $request->description);

        $request->validate([
            'name' => 'required|unique:categories,name',
            'description' => 'required',
        ], [
            'name.required' =>  'Name must filled!',
            'name.unique' => 'Name is already used!',
            'description.required' => 'Description must filled!',
        ]);

        $data = [
            'name' => $request->name,
            'description' => $request->description,
        ];

        Category::create($data);
        return redirect()->to('/category')->with('success', 'Category data is successfully created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $id)
    {
        $category = Category::where('id', $id)->first();
        return view('category.detailCategory', [
            'category' => $category,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $category = Category::where('id', $id)->first();
        return view('category.editCategory', [
            'category' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $request->validate([
            'name' => 'required|',
            'description' => 'required',
        ], [
            'name.required' =>  'Name must filled!',
            'name.unique' => 'Name is already used!',
            'description.required' => 'Description must filled!',
        ]);

        $data = [
            'name' => $request->name,
            'description' => $request->description,
        ];
        Category::where('id', $id) ->update($data);
        return redirect()->to('/category')->with('success', 'Category data is successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        Category::where('id', $id)->delete();
        return redirect()->to('/category')->with('success', 'Category data is successfully deleted!');
    }
}
