<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductViewed extends Model
{
    use HasFactory;

    protected $table = "product_viewed";

    protected $fillable = [
        'user_id',
        'product_id'
    ];
}
