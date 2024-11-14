<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = "products";
    protected $fillable = [
        'category_product_id',
        'name',
        'code',
        'description',
        'image',
        'status',
        'love',
    ];
    public $attributes = [
        'love' => 0
    ];
    public function attributeValueProduct()
    {
        return $this->hasMany(AttributeValueProduct::class);
    }
    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }
    public function categoryProduct()
    {
        return $this->belongsTo(CategoryProduct::class, 'category_product_id');
    }
    public function productVariants()
    {
        return $this->hasMany(ProductVariant::class);
    }
    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorites', 'product_id', 'user_id');
    }
}
