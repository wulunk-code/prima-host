<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();

        return view(
            'admin.categories.index',
            compact('categories')
        );
    }

    public function create()
    {
        return view(
            'admin.categories.create'
        );
    }

    public function store(Request $request)
    {
        Category::create([

            'name' => $request->name,

            'slug' => \Str::slug(
                $request->name
            ),

            'description' =>
                $request->description,

            'is_active' => true

        ]);

        return redirect()
            ->route('categories.index');
    }

    public function destroy($id)
    {
        Category::findOrFail($id)
            ->delete();

        return back();
    }
}