<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefundItem extends Model
{
    use HasFactory;

    protected $table = "refund_items";

    protected $fillable = [
        'refund_id',
        'product_variant_id',
        'quantity',
        'reason',
        'description',
        'img',
        'status',
    ];
    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }
}
