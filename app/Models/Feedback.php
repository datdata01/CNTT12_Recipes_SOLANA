<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;


    protected $table = "feedbacks";

    protected $fillable = [
        'user_id',
        'parent_feedback_id',
        'rating',
        'comment',
        'file_path',
        'created_at',
        'order_item_id',
        'updated_at'
    ];
    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // phản hồi của Admin với feedback người dùng
    public function replies()
    {
        return $this->hasMany(Feedback::class, 'parent_feedback_id');
    }
}
