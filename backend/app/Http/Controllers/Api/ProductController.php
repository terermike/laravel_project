<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     * @return ../Response
     */
    public function index()
    {
        $products = Product::all();
        return response()->json(['products' => $products]);
    }

    /**
     * Store a newly created product in storage
     * 
     * @param $request
     * @return response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'nullable',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['Error' => $validator->errors()], 400);
        }

        $product = Product::create($request->all());

        return response()->json(['product' => $product, 'message' => 'Product created successfully']);
    }

    /**
     * Display specified product.
     * 
     * @param $product
     * @return response
     */
    public function show(Product $product)
    {
        return response()->json(['product' => $product]);
    }

    /**
     * Update specified product in storage
     * 
     * @param $request
     * @param $product
     * @return response
     */
    public function update(Request $request, Product $product)
    {

        $request->validate([
            'name' => 'sometimes',
            'description' => 'nullable',
            'price' => 'sometimes|numeric',
            'quantity' => 'sometimes|integer',
        ]);

        $product->update($request->all());

        return response()->json(['product' => $product, 'message' => 'Product updated successfully']);
    }

    /**
     * Remove the specified product from storage
     * 
     * @param $product
     * @return response
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        if ($product) {
            $result = $product->delete();

            if (isset($result['error'])) {
                // Return a response with an error message
                return response()->json(['error' => $result['error']], 400);
            }

            return response()->json(["message" => "Product deleted successfully"]);
        } else {
            return response()->json(["error" => "Product not found"], 404);
        }
    }

    // /**
    //  * Check the availability of a product based on its ID and requested quantity.

    //  *
    //  * @param int $productId The ID of the product to check availability for.
    //  * @param int $requestedQuantity The quantity of the product requested.
    //  *
    //  * @return bool Returns true if the product is available in the requested quantity,
    //  *              otherwise returns false.
    //  */

    // public function checkAvailability($id, $requestedQuantity)
    // {
    //     // Find the product by its ID
    //     $product = Product::find($id);

    //     // If the product exists and its quantity is greater than or equal to the requested quantity
    //     if ($product && $product->quantity >= $requestedQuantity) {
    //         return true;
    //     }

    //     // If the product does not exist or its quantity is less than the requested quantity
    //     return false;
    // }

    // public function decreaseQuantity($id, $quantity)
    // {
    //     // Find the product by its ID
    //     $product = Product::find($id);

    //     // If the product exists and its quantity is greater than or equal to the requested quantity
    //     if ($product && $product->quantity >= $quantity) {
    //         // Decrease the quantity of the product
    //         $product->quantity -= $quantity;
    //         $product->save();
    //         return true;
    //     }

    //     // If the product does not exist or its quantity is less than the requested quantity
    //     return false;
    // }
}
