<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $table = "logs";

    protected $fillable = [
        'event',
        'user_id',
        'user_agent',
        'ip_address',
        'data',
        'created_at'
        ];

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
