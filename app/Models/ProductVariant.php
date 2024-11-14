<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;
    protected $table = "product_variants";
    protected $fillable = [
        'product_id',
        'quantity',
        'sold',
        'price'
    ];
    public function attributeValues()
    {
        return $this->belongsToMany(AttributeValue::class, 'product_attribute_values');
    }
    public function orderItem()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function carts()
    {
        return  $this->hasMany(Cart::class,);
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'user_id');
    }
}
