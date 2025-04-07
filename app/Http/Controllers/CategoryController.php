<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|in:necklaces,watches,earrings,bracelets,rings,other'
        ]);

        Category::create($request->all());

        return redirect()->route('categories.index')->with('success', 'Category added successfully');
    }
}

