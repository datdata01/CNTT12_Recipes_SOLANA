<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = "orders";

    protected $fillable = [
        'id',
        'user_id',
        'total_amount',
        'status',
        'cancel_reason',
        'cancel_reason_other',
        'payment_method',
        'confirm_status',
        'note',
        'discount_amount',
        'created_at',
        'updated_at',
        'code',
        'full_address',
        'phone',
        'customer_name'
    ];


    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function refund()
    {
        return $this->hasOne(Refund::class, 'order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'user_id');
    }
}
