<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'quantity'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
    ];

    /**
     * Get the orders for the product.
     */
    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('quantity', 'total_price');
    }

    /**
     * Check if the requested quantity of the product is available.
     *
     * @param  int  $requestedQuantity
     * @return bool
     */
    public function checkAvailability($requestedQuantity)
    {
        return $this->quantity >= $requestedQuantity;
    }

    /**
     * Decrease the quantity of the product.
     *
     * @param  int  $quantity
     * @return bool
     */
    public function decreaseQuantity($quantity)
    {
        if ($this->quantity >= $quantity) {
            $this->quantity -= $quantity;
            $this->save();
            return true;
        }

        return false;
    }

    public function delete()
    {
        if ($this->orders()->exists()) {
            // Throw an exception or return a message
            return ['error' => 'Cannot delete product because it has associated orders'];
        }

        return parent::delete();
    }

    public function carts()
    {
        return $this->belongsToMany(Cart::class)->withPivot('quantity');
    }
}
