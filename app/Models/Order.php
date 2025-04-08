<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Define fillable fields to prevent MassAssignmentException
    protected $fillable = [
        'user_id',        // Foreign key for the user who placed the order
        'status',         // Order status (pending, completed, canceled, etc.)
        'total_price',    // Total price of the order
        'payment_status', // Payment status (paid, unpaid, refunded)
        'created_at',     // Order creation timestamp
        'updated_at'      // Order update timestamp
    ];

    // Relationship: An order belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship: An order has many ordered products
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }
}
