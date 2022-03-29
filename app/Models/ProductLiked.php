<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductLiked extends Model
{
    use HasFactory;

    protected $table = "product_liked";

    protected $fillable = [
        'user_id',
        'product_id',
    ];
}
