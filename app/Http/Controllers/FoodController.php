<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Http\Requests\StoreFoodRequest;
use App\Http\Requests\UpdateFoodRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Factories\FoodFactory;

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFoodRequest $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'category' => 'nullable|string',
            'image' => 'nullable|image|max:5120',
        ]);

        $image = $request->file('image');

        FoodFactory::create($data, $image);

        return redirect()->route('admin');
    }

    /**
     * Display the specified resource.
     */
    public function show(Food $food)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Food $food)
    {
        return view('admin.product.edit', compact('food'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFoodRequest $request, Food $food)
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'category' => 'nullable|string',
            'image' => 'nullable|image|max:5120',
        ]);

        $food->name = $request->name;
        $food->price = $request->price;
        $food->category = $request->category;
        $food->description = $request->description;

        if ($request->hasFile('image')) {
            $imagePath = public_path($food->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            $extension = $request->file('image')->getClientOriginalExtension();
            $filename = $food->id . '.' . $extension;
            $food->image = 'storage/images/products/' . $filename;

            $uploadSuccess = $request->file('image')->move('storage/images/products', $filename);
        }

        $food->save();

        return redirect()->route('admin');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Food $food)
    {

        $imagePath = public_path($food->image);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }


        $food->delete();

        return redirect()->route('admin')->with('success', 'Product deleted successfully!');
    }
}
