<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryArticle extends Model
{
    use HasFactory;
    protected $table = "category_articles";
    protected $fillable = ['id', 'name','created_at', 'updated_at'];

    public function articles()
    {
        return $this->hasMany(Article::class, 'category_article_id');
    }
}
