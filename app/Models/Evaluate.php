<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluate extends Model
{
    use HasFactory;

    protected $table = "evaluates";

    protected $fillable = [
        'level',
        'description',
        'product_id',
        'user_id',
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
