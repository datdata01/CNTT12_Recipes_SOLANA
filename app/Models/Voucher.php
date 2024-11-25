<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;
    protected $table = 'vouchers';
    protected $fillable = [
        'name',
        'code',
        'description',
        'limit',
        'discount_type',
        'discount_value', 
        'min_order_value',
        'max_order_value',
        'status',
        'voucher_used',
        'start_date',
        'end_date',
        'type',
        'limited_uses'
    ];
    public $timestamps = false; 

    // một Vourcher có nhiều VourcherUsage
    public function voucherUsages()
    {
        return $this->hasMany(VoucherUsage::class);
    }
}
