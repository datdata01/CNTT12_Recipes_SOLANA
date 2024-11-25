<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    use HasFactory;

    protected $table = "refunds";

    protected $fillable = ['order_id', 'status', 'code'];
    public $timestamps = false;

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
    public function refundItem()
    {
        return $this->hasMany(RefundItem::class, 'refund_id');
    }
}
