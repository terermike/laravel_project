<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     *  Display a listing of the orders for a particular user.
     * 
     * @return response
     */
    public function index()
    {
        if (auth()->check()) {
            $userOrders = auth()->user()->orders;
            if ($userOrders->isEmpty()) {
                return response()->json(['message' => "User has no pending orders"]);
            }
            return response()->json(['orders' => $userOrders]);
        } else {
            return response()->json(['message' => 'User is not authenticated'], 401);
        }
    }
    /**
     * Store a newly created order in storage.
     * 
     * @param $request
     * @return response
     */
    public function store(Request $request)
    {
        $cart = auth()->user()->cart;

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Create a new order
            $order = new Order([
                'status' => 'pending'
            ]);

            // Associate the order with the currently authenticated user
            auth()->user()->orders()->save($order);

            // Iterate over the items in the cart
            foreach ($cart->products as $product) {
                // Check product availability and decrease quantity
                if (!$product->checkAvailability($product->pivot->quantity)) {
                    throw new \Exception('Product is not available in the required quantity');
                }

                $product->decreaseQuantity($product->pivot->quantity);

                // Create an order line for the product
                $order->products()->attach($product->id, [
                    'quantity' => $product->pivot->quantity,
                    'total_price' => $product->price * $product->pivot->quantity
                ]);
            }

            // Clear the cart
            $cart->products()->detach();

            // Commit the transaction
            DB::commit();

            // Return a JSON response with the created order and a success message
            return response()->json(['order' => $order, 'message' => 'Order placed successfully']);
        } catch (\Exception $e) {
            // Rollback the transaction in case of errors
            DB::rollBack();

            // Return a JSON response for the error
            return response()->json(['message' => 'Failed to place order', 'error' => $e->getMessage()], 500);
        }
    }


    /**
     * Update the status of the specified order.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        try {
            // Validate the request
            $request->validate([
                'status' => 'required|in:pending,processing,completed'
            ]);

            // Update the order status
            $order->update([
                'status' => $request->input('status'),
            ]);

            // Return a JSON response with the updated order and a success message
            return response()->json(['order' => $order, 'message' => 'Order status updated successfully']);
        } catch (ValidationException $e) {
            // Return a JSON response with validation error messages
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            // Return a JSON response for other unexpected errors
            return response()->json(['message' => 'Failed to update order status', 'error' => $e->getMessage()], 500);
        }
    }
    /**
     * Remove the specified order from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        try {
            // Find the order or throw an exception if not found
            $order = Order::findOrFail($order->id);

            // Delete the order
            $order->delete();

            // Return a JSON response with a success message
            return response()->json(['message' => 'Order deleted successfully']);
        } catch (ModelNotFoundException $e) {
            // Return a JSON response indicating that the order was not found
            return response()->json(['message' => 'Order not found'], 404);
        } catch (\Exception $e) {
            // Return a JSON response for unexpected errors
            return response()->json(['message' => 'Failed to delete order', 'error' => $e->getMessage()], 500);
        }
    }
}
