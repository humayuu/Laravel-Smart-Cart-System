<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * For Add product in Cart
     */
    public function CartAdd(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'name' => $product->product_name,
                'quantity' => 1,
                'price' => $product->price,
                'image' => $product->product_image,
            ];
        }

        $count = count($cart);
        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Product added successfully!', compact('count'));
    }

    /**
     * For Show All Cart Product
     */
    public function CartProducts()
    {
        $carts = session()->get('cart', []);

        return view('cart', compact('carts'));
    }

    /**
     * For Remove Cart
     */
    public function CartRemove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);

            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart successfully',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Item not found',
        ], 404);
    }
}
