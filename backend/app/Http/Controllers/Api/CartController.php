<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    /**
     * Display the cart for the authenticated user.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cart = auth()->user()->cart()->with('products')->first();
        return response()->json(['cart' => $cart]);
    }


    /**
     * Add a product to the cart.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $cart = auth()->user()->cart ?? Cart::create(['user_id' => auth()->user()->id]);

        // Check if the product is already in the cart
        if ($cart->products()->where('product_id', $request->product_id)->exists()) {
            return response()->json(['message' => 'Product is already in the cart']);
        }

        $cart->products()->attach($request->product_id, ['quantity' => $request->quantity]);

        return response()->json(['message' => 'Product added to cart successfully']);
    }


    /**
     * Update the quantity of a product in the cart.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function updateProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $cart = auth()->user()->cart;

        $productInCart = $cart->products()->where('product_id', $request->product_id)->first();
        if (!$productInCart) {
            return response()->json(['message' => 'Product not found in cart'], 404);
        }
        $cart->products()->updateExistingPivot($request->product_id, ['quantity' => $request->quantity]);

        return response()->json(['message' => 'Product quantity updated successfully']);
    }

    /**
     * Remove a product from the cart.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function removeProduct(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $cart = auth()->user()->cart;
        $cart->products()->detach($request->product_id);

        return response()->json(['message' => 'Product removed from cart successfully']);
    }
    /**
     * Empty the cart for the authenticated user.
     *
     * @return \Illuminate\Http\Response
     */
    public function emptyCart()
    {
        $cart = auth()->user()->cart;
        $cart->products()->detach();
        return response()->json(['message' => 'Cart emptied successfully']);
    }
}
