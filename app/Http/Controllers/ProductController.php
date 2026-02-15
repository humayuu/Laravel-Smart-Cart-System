<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'description' => 'required|min:20',
            'image' => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'price' => 'required|numeric|min:0',
        ]);

        $fileName = null;

        try {
            DB::beginTransaction();

            // Handle image upload
            if ($request->hasFile('image')) {
                $img = $request->file('image');
                $extension = $img->extension();
                $fileName = uniqid('image_').time().'.'.$extension;
                $img->move(public_path('images'), $fileName);
            }

            // Create product
            Product::create([
                'product_name' => $request->name,
                'description' => $request->description,
                'product_image' => $fileName,
                'price' => $request->price,
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Product Created Successfully');

        } catch (Exception $e) {
            DB::rollBack();

            // Delete uploaded image if it exists
            if ($fileName && file_exists(public_path('images/'.$fileName))) {
                unlink(public_path('images/'.$fileName));
            }

            Log::error('Error in product creation: '.$e->getMessage());

            return redirect()->back()->with('error', 'Product creation failed');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('admin.product_edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|max:100',
            'description' => 'required|min:20',
            'image' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'price' => 'required|numeric|min:0',
        ]);

        $existingImage = $product->product_image;
        $fileName = null;
        $newImage = $existingImage;

        try {
            DB::beginTransaction();

            // Handle image upload
            if ($request->hasFile('image')) {
                $img = $request->file('image');
                $extension = $img->extension();
                $fileName = uniqid('image_').time().'.'.$extension;
                $img->move(public_path('images'), $fileName);
                $newImage = $fileName;
            }

            // Update product
            $product->update([
                'product_name' => $request->name,
                'description' => $request->description,
                'product_image' => $newImage,
                'price' => $request->price,
            ]);

            // Delete old image if a new one was uploaded
            if ($fileName && $existingImage && file_exists(public_path($existingImage))) {
                unlink(public_path($existingImage));
            }

            DB::commit();

            return redirect()->route('admin.dashboard')->with('success', 'Product Updated Successfully');

        } catch (Exception $e) {
            DB::rollBack();

            // Delete uploaded image if it exists
            if ($fileName && file_exists(public_path('images/'.$fileName))) {
                unlink(public_path('images/'.$fileName));
            }

            Log::error('Error in product update: '.$e->getMessage());

            return redirect()->back()->with('error', 'Product update failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            $imagePath = public_path('images/'.$product->product_image);
            $product->delete();

            if (file_exists($imagePath)) {
                unlink($imagePath);

            }

            return redirect()->back()->with('success', 'Product Deleted Successfully');

        } catch (Exception $e) {
            Log::error('Error Product deletion '.$e->getMessage());

            return redirect()->back()->with('error', 'Error Product deletion');
        }
    }
}
