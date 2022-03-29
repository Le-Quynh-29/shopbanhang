<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    use HasFactory;

    public $table = "product_details";

    protected $fillable = [
        'product_id',
        'color',
        'size',
        'quantity',
        'price',
        'user_id'
    ];
}
