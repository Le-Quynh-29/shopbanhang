<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = "orders";

    protected $fillable = [
        'code',
        'user_id',
        'name',
        'number_phone',
        'address',
        'price',
        'status',
        'order_date',
        'received_date',
        'cancellation_date'
    ];

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function formatUserName()
    {
        $user = $this->user;

        return !is_null($user) ? $user['username'] : '';
    }
}
