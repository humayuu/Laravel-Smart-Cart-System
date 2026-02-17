<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
    public function CartRemove(Request $request, $id)
    {
        try {
            $cart = session()->get('cart', []);

            if (! isset($cart[$id])) {
                return response()->json([
                    'message' => 'Item not found in cart.',
                ], 404);
            }

            unset($cart[$id]);
            session()->put('cart', $cart);

            return response()->json([
                'message' => 'Item removed from cart.',
            ], 200);

        } catch (Exception $e) {
            Log::error('CartRemove error: '.$e->getMessage());

            return response()->json([
                'message' => 'Something went wrong.',
            ], 500);
        }
    }
}
