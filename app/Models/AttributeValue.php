<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "attribute_values";
    protected $fillable = ['id', 'attribute_id', 'name'];
    
    public function attributeValue(){
          return $this->hasOne(Attribute::class, 'id','attribute_id' );
    }
    public function attribute(){
        return $this->belongsTo(Attribute::class,'attribute_id');
    }
    public function attributeValueProduct(){
        return $this->hasMany(AttributeValueProduct::class);
    }
    public function attributeValues()
    {
        return $this->belongsToMany(AttributeValue::class, 'product_attribute_values');
    }
}
